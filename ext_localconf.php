<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

/***************
 * Register Icons
 */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'easycontent-default',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:easy_content/Resources/Public/Icons/ContentElements/default.svg']
);

/***************
 * Register content elements
 */
$contentElementRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\BK2K\EasyContent\Registry\ContentElementRegistry::class);
$contentElementRegistry->registerElements();

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
 * Register slot to build sql for content elements
 */
$signalSlotDispatcher->connect(
    \TYPO3\CMS\Install\Service\SqlExpectedSchemaService::class,
    'tablesDefinitionIsBeingBuilt',
    \BK2K\EasyContent\Slot\TablesDefinitionIsBeingBuiltSlot::class,
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
