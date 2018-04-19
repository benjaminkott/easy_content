<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Utility;

use BK2K\EasyContent\Objects\ContentElement;
use BK2K\EasyContent\Objects\Field\CommonField;
use BK2K\EasyContent\Objects\Field\FieldInterface;

class TcaUtility
{
    const SHOW_ITEM_BEFORE = '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
    ';

    const SHOW_ITEM_AFTER = '
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ';

    public static function getTypeConfigurationForElement(ContentElement $contentElement, array $tca)
    {
        $data['tt_content']['columns']['CType']['config']['items'][] = [
            $contentElement->getName(),
            $contentElement->getIdentifier(),
            $contentElement->getIcon()
        ];

        /** @var FieldInterface|CommonField $field */
        foreach ($contentElement->getFields() as $field) {
            if ($field->getViolations()->count() === 0) {
                // skip if field exists in tt_content
                if (!empty($tca['tt_content']['columns'][$field->getProperty()])) {
                    continue;
                }
                $data['tt_content']['columns'][$field->getProperty()] = $field->factorizeTca();
            }
        }

        $data['tt_content']['ctrl']['typeicon_classes'][$contentElement->getIdentifier()] = $contentElement->getIcon();
        $data['tt_content']['types'][$contentElement->getIdentifier()] = [
            'showitem' => self::SHOW_ITEM_BEFORE . ' ' . implode(',', $contentElement->getFieldsAsPlainArray()) . ', easy_content, ' . self::SHOW_ITEM_AFTER,
        ];

        return $data;
    }
}
