<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Form\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

/**
 * Determine the final TCA type value
 */
class DatabaseRecordEasyContentAware implements FormDataProviderInterface
{
    /**
     * Add override values to the databaseRow fields. As those values are not meant to
     * be overwritten by the user, the TCA of the field is set to type hidden.
     *
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        if ($result['databaseRow']['easy_content'] !== '') {
            try {
                $easyFields = \GuzzleHttp\json_decode($result['databaseRow']['easy_content']);
                if (json_last_error() === JSON_ERROR_NONE) {
                    foreach ($easyFields as $tcaFieldName => $value) {
                        $result['databaseRow'][$tcaFieldName] = $value;
                    }
                }
            } catch (\Exception $e) {
            }
        }
        return $result;
    }
}
