<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

if (TYPO3_MODE === 'BE') {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'BK2K.EasyContent',
        'system',
        'easy_content',
        '',
        [
            'Configuration' => 'show'
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:easy_content/Resources/Public/Icons/module.svg',
            'labels' => 'LLL:EXT:easy_content/Resources/Private/Language/locallang_easy_content.xlf',
        ]
    );
}
