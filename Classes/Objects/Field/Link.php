<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects\Field;

use BK2K\EasyContent\Objects\Field\Generic\FieldInterface;

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
        // $fieldTca['config']['fieldControl']['linkPopup']['options']['blindLinkOptions'] = $this->generateDisallow($configuration['allow']);

        if ($configuration['filter']) {
            $fieldTca['config']['fieldControl']['linkPopup']['options']['allowedExtensions'] = $configuration['filter'];
        }
        return $fieldTca;
    }

    private function generateDisallow($allow) {
        // possible TCA default settings:
        $possibleAllowed = ['files', 'mail', 'spec', 'folder', 'page', 'url'];

        // explode and trim:
        $allowConfig = array_map('trim', explode(',', $allow));

        $disallowed = array_diff($possibleAllowed, $allowConfig);

        return implode(',', $disallowed);
    }

}
