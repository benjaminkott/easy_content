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
$folderBasedYamlConfigurationProvider = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \BK2K\EasyContent\Registry\FolderBasedYamlConfigurationProvider::class,
    PATH_site . 'typo3conf/ext/easy_content/Configuration/ContentElement/'
    );
$contentElementRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \BK2K\EasyContent\Registry\ContentElementRegistry::class,
    $folderBasedYamlConfigurationProvider
);
$contentElementRegistry->registerElements();

$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['easy_content']['dataModifier'] = \BK2K\EasyContent\Registry\DataModifier\ExemplaricJsonModifier::class;

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

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\BK2K\EasyContent\Form\FormDataProvider\DatabaseRecordEasyContentAware::class] = [
    'depends' => [
        \TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseEditRow::class,
    ]
];
