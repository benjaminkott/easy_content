<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Slot;

use BK2K\EasyContent\Registry\ContentElementRegistry;
use TYPO3\CMS\Backend\Configuration\TsConfigParser;
use TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GetPagesTSconfigPreIncludeSlot
{
    public function registerContentElements($TSdataArray, $pageUid, $rootLine)
    {
        $contentElementRegistry = GeneralUtility::makeInstance(ContentElementRegistry::class);
        $contentElements = $contentElementRegistry->getElements();
        $TSdataArray['defaultPageTSconfig'] .= '
mod.wizards.newContentElement.wizardItems.easycontent.header = LLL:EXT:easy_content/Resources/Private/Language/locallang.xlf:wizard.easycontent
        ';

        foreach ($contentElements as $contentElement) {
            $categories = $contentElement->getCategories();
            if (is_array($categories)) {
                foreach ($contentElement->getCategories() as $category) {
                    if (isset($category['label'])) {
                        $TSdataArray['defaultPageTSconfig'] .= '
mod.wizards.newContentElement.wizardItems.' . $category['key'] . '.header = ' . $category['label'] . '
                        ';
                    }
                    $TSdataArray['defaultPageTSconfig'] .= '
mod.wizards.newContentElement.wizardItems.' . $category['key'] . ' {
    elements {
        ' . $contentElement->getIdentifier() . ' {
            iconIdentifier = ' . $contentElement->getIcon() . '
            title = ' . $contentElement->getName() . '
            description = ' . $contentElement->getDescription() . '
            tt_content_defValues {
                CType = ' . $contentElement->getIdentifier() . '
            }
        }
    }
    show := addToList(' . $contentElement->getIdentifier() . ')
}
                    ';
                }
            }
        }

        // For each wizard item category a header must be set, if no
        // header is set, the new content element wizard fails to load.
        $tsConfigParser = GeneralUtility::makeInstance(TsConfigParser::class);
        $tmpTSdataArray = TypoScriptParser::checkIncludeLines_array($TSdataArray);
        $result = $tsConfigParser->parseTSconfig($tmpTSdataArray['defaultPageTSconfig'], 'PAGES');
        if (isset($result['TSconfig']['mod.']['wizards.']['newContentElement.']['wizardItems.'])) {
            foreach($result['TSconfig']['mod.']['wizards.']['newContentElement.']['wizardItems.'] as $key => $category) {
                if (!isset($category['header'])) {
                    $category = rtrim($key, '.');
                    $TSdataArray['defaultPageTSconfig'] .= '
mod.wizards.newContentElement.wizardItems.' . $category . '.header = ' . $category . '
                    ';
                }
            }
        }

        return [
            $TSdataArray,
            $pageUid,
            $rootLine,
            false
        ];
    }
}
