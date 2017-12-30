<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Registry;

use BK2K\EasyContent\Objects\ContentElement;
use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentElementRegistry implements SingletonInterface
{
    protected $elements = [];
    protected $failedElements = [];

    public function registerElement($configurationFile)
    {
        $contentElement = new ContentElement();
        $contentElement->setConfigurationFile($configurationFile);

        if (trim($configurationFile) !== '') {
            try {
                $absoluteConfigurationFile = GeneralUtility::getFileAbsFileName($configurationFile);
                $fileLoader = GeneralUtility::makeInstance(YamlFileLoader::class);
                $configuration = $fileLoader->load($configurationFile);
                $contentElement->setIdentifier(($configuration['identifier'] ?: ''));
                $contentElement->setName(($configuration['name'] ?: $contentElement->getIdentifier()));
                $contentElement->setDescription(($configuration['description'] ?: ''));
                $contentElement->setIcon(($configuration['icon'] ?: ''));
                $contentElement->setCategories(($configuration['categories'] ?: []));
                $contentElement->setFields(($configuration['fields'] ?: []));
            } catch (\Exception $e) {
                // Catch exceptions, otherwise we cannot show validations
            }
        }

        $contentElement->validate();
        if (count($contentElement->getViolations()) > 0) {
            $this->failedElements[] = $contentElement;
        } else {
            $this->elements[] = $contentElement;
        }
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function getFailedElements()
    {
        return $this->failedElements;
    }

    public function getAllElements()
    {
        return array_merge($this->failedElements, $this->elements);
    }
}
