<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Registry;

use BK2K\EasyContent\Error\ContentElementRegistrationFailedException;
use BK2K\EasyContent\Factory\ContentElementFactory;
use BK2K\EasyContent\Objects\ContentElement;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ContentElementRegistry implements SingletonInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager = null;

    /**
     * @var ConfigurationProviderInterface
     */
    protected $configurationProvider = null;

    /**
     * @var $contentElement[]
     */
    protected $elements = [];

    /**
     * @var $contentElement[]
     */
    protected $failedElements = [];

    /**
     * @var ContentElementFactory
     */
    private $contentElementFactory;

    public function __construct(
        ConfigurationProviderInterface $configurationProvider = null,
        ObjectManager $objectManager = null,
        ContentElementFactory $contentElementFactory = null
    ) {
        $this->objectManager = $objectManager ?: GeneralUtility::makeInstance(ObjectManager::class);
        $this->configurationProvider = $configurationProvider ?: $this->objectManager->get(ConfigurationProviderInterface::class);
        $this->contentElementFactory = $contentElementFactory ?: $this->objectManager->get(ContentElementFactory::class);
    }

    public function registerElements()
    {
        $configurationCollection = $this->configurationProvider->fetch();
        foreach ($configurationCollection as $configurationKey => $configuration) {
            try {
                $contentElement = $this->objectManager->get(ContentElement::class);
                $contentElement->setConfigurationFile($configurationKey);
                $this->contentElementFactory->create($contentElement, $configuration);
                $contentElement->validate();
                if ($contentElement->getViolations()->count() > 0) {
                    $this->failedElements[] = $contentElement;
                    throw new ContentElementRegistrationFailedException('Content element registration failed', 1523998213);
                }
                $this->elements[] = $contentElement;
            } catch (\Exception $e) {
                // fail silently
            }
        }
    }

    /**
     * @return $contentElement[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @return $contentElement[]
     */
    public function getFailedElements()
    {
        return $this->failedElements;
    }

    /**
     * @return $contentElement[]
     */
    public function getAllElements()
    {
        return array_merge($this->failedElements, $this->elements);
    }
}
