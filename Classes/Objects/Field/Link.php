<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects\Field;

class Link extends Text implements FieldInterface
{
    public function factorizeTca(): array
    {
        $fieldTca = [
            'l10n_mode' => 'prefixLangTitle',
            'label' => $this->getLabel(),
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 30,
                'max' => 1024,
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'title' => $this->getLabel(),
                        ],
                    ],
                ],
                'softref' => 'typolink'
            ],
        ];

        $configuration = $this->getConfiguration();
        if ($configuration['allow'] === 'files') {
            $fieldTca['config']['fieldControl']['linkPopup']['options']['blindLinkOptions'] = 'mail,spec,folder,page,url';
        }
        if ($configuration['filter'] === 'pdf') {
            $fieldTca['config']['fieldControl']['linkPopup']['options']['allowedExtensions'] = 'pdf';
        }
        return $fieldTca;
    }
}
