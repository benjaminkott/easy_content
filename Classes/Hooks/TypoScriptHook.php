<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Hooks;

use BK2K\EasyContent\Registry\ContentElementRegistry;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TypoScriptHook
{
    public function registerContentElements()
    {
        $contentElementRegistry = GeneralUtility::makeInstance(ContentElementRegistry::class);
        $contentElements = $contentElementRegistry->getElements();

        foreach ($contentElements as $contentElement) {
            ExtensionManagementUtility::addTypoScriptSetup(
                '
# Setting ' . $contentElement->getIdentifier() . ' Content Element TypoScript
tt_content.' . $contentElement->getIdentifier() . ' =< lib.contentElement
tt_content.' . $contentElement->getIdentifier() . ' {
    templateName = Generic
}
                '
            );
        }
    }
}
