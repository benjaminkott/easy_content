<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects\Field;

use BK2K\EasyContent\Objects\Field\Generic\FieldInterface;

class Number extends Text implements FieldInterface
{
    public function factorizeTca(): array
    {
        $fieldTca = [
            'l10n_mode' => 'prefixLangTitle',
            'label' => $this->getLabel(),
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval '=> 'int'
            ],
        ];

        $configuration = $this->getConfiguration();
        if ($configuration['eval'] === 'numeric') {
            $fieldTca['config']['eval'] = 'num';
        }
        if ($configuration['eval'] === 'decimal') {
            $fieldTca['config']['eval'] = 'double2';
        }

        if ($configuration['min']) {
            $fieldTca['config']['range']['lower'] = $configuration['min'];
        }
        if ($configuration['max']) {
            $fieldTca['config']['range']['upper'] = $configuration['max'];
        }

        return $fieldTca;
    }
}
