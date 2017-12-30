<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Registry;

use BK2K\EasyContent\Objects\ContentElement;
use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentElementRegistry implements SingletonInterface
{
    protected $elements = [];
    protected $failedElements = [];

    public function registerElement($configurationFile = '')
    {
        $contentElement = GeneralUtility::makeInstance(ContentElement::class);
        $contentElement->setConfigurationFile($configurationFile);

        if (trim($configurationFile) === '') {
            $contentElement->addError('Configuration file must be set.');
        } else {
            $absoluteConfigurationFile = GeneralUtility::getFileAbsFileName($configurationFile);
            $configurationFileExists = true;
            if (!file_exists(GeneralUtility::getFileAbsFileName($configurationFile))) {
                $configurationFileExists = false;
                $contentElement->addError('Configuration file does not exist.');
            }
        }


        if ($configurationFileExists) {
            $fileLoader = GeneralUtility::makeInstance(YamlFileLoader::class);
            try {
                $configuration = $fileLoader->load($configurationFile);
            } catch (\Exception $e) {
                $contentElement->addError($e->getMessage());
            }
        }

        if (isset($configuration) && is_array($configuration)) {
            try {
                if (isset($configuration['identifier'])) {
                    $contentElement->setIdentifier($configuration['identifier']);
                }
                if (isset($configuration['name'])) {
                    $contentElement->setName($configuration['name']);
                }
                if (isset($configuration['description'])) {
                    $contentElement->setDescription($configuration['description']);
                }
                if (isset($configuration['icon'])) {
                    $contentElement->setIcon($configuration['icon']);
                }
                if (isset($configuration['categories'])) {
                    $contentElement->setCategories(GeneralUtility::trimExplode(',', $configuration['categories']));
                }
                if (isset($configuration['fields'])) {
                    $contentElement->setFields($configuration['fields']);
                }
            } catch (Exception $e) {
                $contentElement->addError($e);
            }
        }

        if ($contentElement->hasErrors()) {
            $this->failedElements[] = $contentElement;
        } else {
            $this->elements[] = $contentElement;
        }
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function getFailedElements()
    {
        return $this->failedElements;
    }

    public function getAllElements()
    {
        return array_merge($this->failedElements, $this->elements);
    }
}
