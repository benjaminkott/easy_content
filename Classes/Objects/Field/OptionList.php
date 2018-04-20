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

class OptionList extends CommonField implements FieldInterface
{
    public function factorizeTca(): array
    {
        $fieldTca = [
            'l10n_mode' => 'prefixLangTitle',
            'label' => $this->getLabel(),
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [],
                // TODO
            ],
        ];

        $configuration = $this->getConfiguration();
        $options = [];
        foreach ((array)$configuration['options'] as $value => $label) {
            $options[] = [
                $label,
                $value,
            ];
        }
        $fieldTca['config']['items'] = $options;

        return $fieldTca;
    }
}
