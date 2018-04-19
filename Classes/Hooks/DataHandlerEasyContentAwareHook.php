<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Hooks;

class DataHandlerEasyContentAwareHook
{
    public function processDatamap_preProcessFieldArray(
        array &$fieldArray,
        string $table,
        string $id,
        \TYPO3\CMS\Core\DataHandling\DataHandler &$dataHandler
    ) {
        $easyFields = [];
        foreach ($fieldArray as $key => $value) {
            if (strpos($key, 'easy_') === 0 && $key !== 'easy_content') {
                $easyFields[$key] = $value;
                unset($fieldArray[$key]);
            }
        }
        $fieldArray['easy_content'] = serialize($easyFields);
    }
}
