<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Registry;

use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentElementRegistry implements SingletonInterface
{
    protected $elements = [];

    public function registerElement($configurationFile)
    {
        $fileLoader = GeneralUtility::makeInstance(YamlFileLoader::class);
        if (file_exists(GeneralUtility::getFileAbsFileName($configurationFile))) {
            $configuration = $fileLoader->load($configurationFile);
            $configuration['categories'] = GeneralUtility::trimExplode(',', $configuration['categories']);
            $this->elements[] = $configuration;
        }
    }

    public function getElements()
    {
        return $this->elements;
    }
}
