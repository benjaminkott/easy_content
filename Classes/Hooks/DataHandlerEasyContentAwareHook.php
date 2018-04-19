<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Hooks;

use BK2K\EasyContent\Registry\DataModifier\DataModifierInterface;
use BK2K\EasyContent\Registry\DataModifier\DataModifierResolver;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DataHandlerEasyContentAwareHook
{
    /**
     * @var DataModifierInterface
     */
    private $dataModifier = null;

    public function __construct(
        DataModifierResolver $dataModifierResolver = null
    ) {
        $dataModifierResolver = $dataModifierResolver ?: GeneralUtility::makeInstance(DataModifierResolver::class);
        $this->dataModifier = $dataModifierResolver->getModifier();
    }

    public function processDatamap_preProcessFieldArray(
        array &$fieldArray,
        string $table,
        string $id,
        \TYPO3\CMS\Core\DataHandling\DataHandler &$dataHandler
    ) {
        $fieldArray = $this->dataModifier->modifyBeforePersistence($fieldArray);
    }
}
