<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

/***************
 * Register content elements
 */
$contentElementRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\BK2K\EasyContent\Registry\ContentElementRegistry::class);
$contentElementRegistry->registerElement('EXT:easy_content/Configuration/ContentElement/DoesNotExist.yaml');
$contentElementRegistry->registerElement('EXT:easy_content/Configuration/ContentElement/Empty.yaml');
$contentElementRegistry->registerElement('EXT:easy_content/Configuration/ContentElement/Invalid.yaml');
$contentElementRegistry->registerElement('EXT:easy_content/Configuration/ContentElement/Minimal.yaml');
$contentElementRegistry->registerElement('EXT:easy_content/Configuration/ContentElement/FirstExample.yaml');
$contentElementRegistry->registerElement('EXT:easy_content/Configuration/ContentElement/SecondExample.yaml');

/***************
 * Create dispatcher for signals
 */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);

/***************
 * Register slot to build TCA for content elements
 */
$signalSlotDispatcher->connect(
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::class,
    'tcaIsBeingBuilt',
    \BK2K\EasyContent\Slot\TcaIsBeingBuiltSlot::class,
    'registerContentElements'
);

/***************
 * Register slot to build PageTS for content elements
 */
$signalSlotDispatcher->connect(
    \TYPO3\CMS\Backend\Utility\BackendUtility::class,
    'getPagesTSconfigPreInclude',
    \BK2K\EasyContent\Slot\GetPagesTSconfigPreIncludeSlot::class,
    'registerContentElements'
);

/***************
 * Register hook to build typoscript for content elements
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Core/TypoScript/TemplateService']['runThroughTemplatesPostProcessing'][] =
    \BK2K\EasyContent\Hooks\TypoScriptHook::class . '->registerContentElements';
