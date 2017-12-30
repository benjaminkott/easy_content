<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Symfony\Component\Validator\Constraints as Assert;


class ContentElement
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    protected $configurationFile = null;

    protected $identifier = null;
    protected $name = null;
    protected $description = null;
    protected $icon = null;
    protected $categories = [];
    protected $fields = [];
    protected $errors = [];

    public function setConfigurationFile($configurationFile)
    {
        $this->configurationFile = $configurationFile;
    }

    public function getConfigurationFile()
    {
        return $this->configurationFile;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setCategories($categories)
    {
        $this->categories = $categoriesArray;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function addError($message)
    {
        $this->errors[] = $message;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors()
    {
        return (count($this->errors) > 0) ? true : false;
    }
}
