<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Controller;

use BK2K\EasyContent\Registry\ContentElementRegistry;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

class ConfigurationController extends ActionController
{
    protected $defaultViewObjectName = BackendTemplateView::class;

    public function showAction()
    {
        $contentElementRegistry = GeneralUtility::makeInstance(ContentElementRegistry::class);
        $this->view->assign('elements', $contentElementRegistry->getElements());
        $this->view->assign('failedElements', $contentElementRegistry->getFailedElements());
    }

    protected function initializeView(ViewInterface $view)
    {
        parent::initializeView($view);
        $this->view->getModuleTemplate()->setFlashMessageQueue($this->controllerContext->getFlashMessageQueue());
    }
}
