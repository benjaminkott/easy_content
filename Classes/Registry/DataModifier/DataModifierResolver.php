<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Registry\DataModifier;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class DataModifierResolver
{
    /**
     * @var DataModifierInterface
     */
    private $dataModifier = null;

    public function __construct(
        DataModifierInterface $dataModifier = null,
        ObjectManager $objectManager = null
    ) {
        $objectManager = $objectManager ?: GeneralUtility::makeInstance(ObjectManager::class);
        if ($dataModifier === null) {
            $fullyQualifiedClassName = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['easy_content']['dataModifier'];
            if (class_exists($fullyQualifiedClassName)) {
                $this->dataModifier = $objectManager->get($fullyQualifiedClassName);
            }
        }
    }

    public function getModifier()
    {
        return $this->dataModifier;
    }
}
