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

class TablesDefinitionIsBeingBuiltSlot
{
    public function registerContentElements($sqlString)
    {
        $contentElementRegistry = GeneralUtility::makeInstance(ContentElementRegistry::class);
        $contentElements = $contentElementRegistry->getElements();

        foreach ($contentElements as $contentElement) {
            // @TODO Generate SQL
            // $sqlString[] = '
            //     CREATE TABLE tt_content (
            //         easycontent text
            //     );
            // ';
        }

        return [
            $sqlString
        ];
    }
}
