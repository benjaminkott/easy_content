<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Factory;

use BK2K\EasyContent\Objects\ContentElement;
use BK2K\EasyContent\Objects\Field\Generic\CommonField;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ContentElementFactory
{
    /**
     * @var ObjectManager
     */
    protected $objectManager = null;

    /**
     * @var FieldFactory
     */
    private $fieldFactory;

    public function __construct(
        ObjectManager $objectManager = null,
        FieldFactory $fieldFactory = null
    ) {
        $this->objectManager = $objectManager ?: GeneralUtility::makeInstance(ObjectManager::class);
        $this->fieldFactory = $fieldFactory ?: $this->objectManager->get(FieldFactory::class);
    }

    public function create(ContentElement $contentElement, array $configuration): ContentElement
    {
        try {
            $elementConfiguration = $configuration['typo3-easy-content'];
            $contentElement->setIdentifier(($elementConfiguration['identifier'] ?: ''));
            $contentElement->setName(($elementConfiguration['name'] ?: ''));
            $contentElement->setDescription(($elementConfiguration['description'] ?: ''));
            $contentElement->setIcon(($elementConfiguration['icon'] ?: 'typo3-easy-content-default'));
            $contentElement->setCategories(($elementConfiguration['categories'] ?: [['key' => 'typo3-easy-content']]));

            $fields = [];
            foreach ((array) $elementConfiguration['fields'] as $fieldConfiguration) {
                $field = $this->fieldFactory->create($fieldConfiguration);
                if ($field instanceof CommonField) {
                    $fields[] = $field;
                }
            }
            $contentElement->setFields($fields);
            return $contentElement;
        } catch (\Exception $e) {
            return $contentElement;
        }
    }
}
