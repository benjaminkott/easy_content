<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\DataProcessing;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class EasyFieldsProcessor implements DataProcessorInterface
{
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
        if ($processedData['data']['easy_content'] !== '') {
            try {
                $easyFields = \GuzzleHttp\json_decode($processedData['data']['easy_content']);
                if (json_last_error() === JSON_ERROR_NONE) {
                    foreach ($easyFields as $tcaFieldName => $value) {
                        $processedData['data'][$tcaFieldName] = $value;
                    }
                    unset($processedData['data']['easy_content']);
                }
            } catch (\Exception $e) {
            }
        }
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration, 'data');
        $processedData[$targetVariableName] = $processedData['data'];
        return $processedData;
    }
}
