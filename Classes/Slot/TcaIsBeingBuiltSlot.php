<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Slot;

use BK2K\EasyContent\Objects\ContentElement;
use BK2K\EasyContent\Registry\ContentElementRegistry;
use BK2K\EasyContent\Utility\TcaUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TcaIsBeingBuiltSlot
{
    public function registerContentElements(array $tca)
    {
        $contentElementRegistry = GeneralUtility::makeInstance(ContentElementRegistry::class);
        $contentElements = $contentElementRegistry->getElements();

        /** @var ContentElement $contentElement */
        foreach ($contentElements as $contentElement) {
            $typeConfiguration = TcaUtility::getTypeConfigurationForElement($contentElement, $tca);
            if ($typeConfiguration) {
                $tca = array_merge_recursive($tca, $typeConfiguration);
            }
        }

        return [$tca];
    }
}
