<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects\Field;

use BK2K\EasyContent\Objects\Field\Generic\CommonField;
use BK2K\EasyContent\Objects\Field\Generic\FieldInterface;

class LabeledToggle extends CommonField implements FieldInterface
{
    public function factorizeTca(): array
    {
        $fieldTca = [
            'l10n_mode' => 'prefixLangTitle',
            'label' => $this->getLabel(),
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        0 => 'on',
                        1 => 'off',
                        'labelChecked' => 'Enabled',
                        'labelUnchecked' => 'Disabled',
                    ]
                ],
            ],
        ];
        return $fieldTca;
    }
}
