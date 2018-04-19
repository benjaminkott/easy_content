<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Registry\DataModifier;

class ExemplaricJsonModifier implements DataModifierInterface
{
    public function modifyBeforeBackendFormRendering(array $data): array
    {
        if ($data['easy_content'] !== '') {
            try {
                $easyFields = \GuzzleHttp\json_decode($data['easy_content']);
                if (json_last_error() === JSON_ERROR_NONE) {
                    foreach ($easyFields as $tcaFieldName => $value) {
                        $data[$tcaFieldName] = $value;
                    }
                }
            } catch (\Exception $e) {
            }
        }
        return $data;
    }

    public function modifyBeforePersistence(array $data): array
    {
        $easyFields = [];
        foreach ($data as $key => $value) {
            if (strpos($key, 'easy_') === 0 && $key !== 'easy_content') {
                $easyFields[$key] = $value;
                unset($data[$key]);
            }
        }
        $data['easy_content'] = \GuzzleHttp\json_encode($easyFields);
        return $data;
    }

    public function modifyBeforeFrontendOutput(array $data): array
    {
        if ($data['easy_content'] !== '') {
            try {
                $easyFields = \GuzzleHttp\json_decode($data['easy_content']);
                if (json_last_error() === JSON_ERROR_NONE) {
                    foreach ($easyFields as $tcaFieldName => $value) {
                        $data[$tcaFieldName] = $value;
                    }
                    unset($data['easy_content']);
                }
            } catch (\Exception $e) {
            }
        }
        return $data;
    }
}
