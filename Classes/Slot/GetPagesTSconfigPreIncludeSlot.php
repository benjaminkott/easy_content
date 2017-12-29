<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Slot;

use BK2K\EasyContent\Registry\ContentElementRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GetPagesTSconfigPreIncludeSlot
{
    public function registerContentElements($TSdataArray, $pageUid, $rootLine)
    {
        $contentElementRegistry = GeneralUtility::makeInstance(ContentElementRegistry::class);
        $contentElements = $contentElementRegistry->getElements();

        foreach ($contentElements as $contentElement) {
            foreach ($contentElement['categories'] as $category) {
                $TSdataArray['defaultPageTSconfig'] .= '
                    mod.wizards.newContentElement.wizardItems.' . $category . ' {
                        elements {
                            ' . $contentElement['key'] . ' {
                                iconIdentifier = ' . $contentElement['icon'] . '
                                title = ' . $contentElement['name'] . '
                                description = ' . $contentElement['description'] . '
                                tt_content_defValues {
                                    CType = ' . $contentElement['key'] . '
                                }
                            }
                        }
                        show := addToList(' . $contentElement['key'] . ')
                    }
                ';
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
