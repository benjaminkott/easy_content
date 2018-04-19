<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Form\FormDataProvider;

use BK2K\EasyContent\Registry\DataModifier\DataModifierInterface;
use BK2K\EasyContent\Registry\DataModifier\DataModifierResolver;
use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DatabaseRecordEasyContentAware implements FormDataProviderInterface
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

    /**
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        $result['databaseRow'] = $this->dataModifier->modifyBeforeBackendFormRendering($result['databaseRow']);
        return $result;
    }
}
