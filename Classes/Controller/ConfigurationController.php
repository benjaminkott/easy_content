<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Controller;

use BK2K\EasyContent\Registry\ContentElementRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ConfigurationController extends ActionController
{
    public function showAction()
    {
        $contentElementRegistry = GeneralUtility::makeInstance(ContentElementRegistry::class);
        $contentElements = $contentElementRegistry->getElements();
        $this->view->assign('elements', $contentElements);
    }
}
