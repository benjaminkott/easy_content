<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\DataProcessing;

use BK2K\EasyContent\Registry\DataModifier\DataModifierInterface;
use BK2K\EasyContent\Registry\DataModifier\DataModifierResolver;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class EasyFieldsProcessor implements DataProcessorInterface
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
     * Fetches records from the database as an array
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     *
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $processedData['data'] = $this->dataModifier->modifyBeforeFrontendOutput($processedData['data']);
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration, 'data');
        $processedData[$targetVariableName] = $processedData['data'];
        return $processedData;
    }
}
