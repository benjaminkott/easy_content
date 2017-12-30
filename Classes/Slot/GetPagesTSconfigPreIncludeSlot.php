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
            $categories = $contentElement->getCategories();
            if (is_array($categories)) {
                foreach ($contentElement->getCategories() as $category) {
                    $TSdataArray['defaultPageTSconfig'] .= '
                        mod.wizards.newContentElement.wizardItems.' . $category . ' {
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

        return [
            $TSdataArray,
            $pageUid,
            $rootLine,
            false
        ];
    }
}
