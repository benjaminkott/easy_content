<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects\Field;

use BK2K\EasyContent\Objects\Field\Generic\FieldInterface;

class Rte extends Text implements FieldInterface
{
    public function factorizeTca(): array
    {
        $fieldTca = [
            'l10n_mode' => 'prefixLangTitle',
            'label' => $this->getLabel(),
            'config' => [
                'cols' => 50,
                'enableRichtext' => 1,
                'richtextConfiguration' => 'default',
                'rows' => 15,
                'type' => 'text',
            ],
        ];
        return $fieldTca;
    }
}
