<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Registry;

use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class FolderBasedYamlConfigurationProvider implements ConfigurationProviderInterface
{
    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var ObjectManager
     */
    protected $objectManager = null;

    /**
     * @var YamlFileLoader
     */
    protected $fileLoader = null;

    public function __construct(
        $path = '',
        ObjectManager $objectManager = null,
        YamlFileLoader $fileLoader = null
    ) {
        $this->path = $path;
        $this->objectManager = $objectManager ?: GeneralUtility::makeInstance(ObjectManager::class);
        $this->fileLoader = $fileLoader ?: $this->objectManager->get(YamlFileLoader::class);
    }

    public function fetch(): array
    {
        $configurationFiles = GeneralUtility::getAllFilesAndFoldersInPath([], $this->path, 'yaml,yml', false, 1, '^.');
        $configurationCollection = [];
        foreach ($configurationFiles as $configurationFilePath) {
            $configurationCollection[$configurationFilePath] = $this->fileLoader->load($configurationFilePath);
        }
        return $configurationCollection;
    }
}
