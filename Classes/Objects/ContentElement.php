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
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;

class ContentElement
{
    /**
     * @var string
     */
    protected $configurationFile;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $icon = 'easycontent-default';

    /**
     * @var array
     */
    protected $categories = [
        ['key' => 'easycontent']
    ];

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var ConstraintViolationList
     */
    protected $violations;

    /**
     * @var ClassMetadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('configurationFile', new Assert\Type(['type' => 'string']));
        $metadata->addPropertyConstraint('configurationFile', new Assert\NotBlank());

        $metadata->addPropertyConstraint('identifier', new Assert\Type(['type' => 'string']));
        $metadata->addPropertyConstraint('identifier', new Assert\NotBlank());
        $metadata->addPropertyConstraint('identifier', new Assert\Length(['min' => 5]));
        $metadata->addPropertyConstraint('identifier', new Assert\Regex([
            'pattern' => "/^[a-z0-9_]+$/",
            'message' => "Only lowercase letters, numbers and underscores are allowed."
        ]));

        $metadata->addPropertyConstraint('name', new Assert\Type(['type' => 'string']));
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());

        $metadata->addPropertyConstraint('description', new Assert\Type(['type' => 'string']));

        $metadata->addPropertyConstraint('icon', new Assert\Type(['type' => 'string']));
        $metadata->addPropertyConstraint('icon', new Assert\NotBlank());

        $metadata->addPropertyConstraint('categories', new Assert\Type(['type' => 'array']));
        $metadata->addPropertyConstraint('categories', new Assert\Count(['min' => 1]));
        $metadata->addPropertyConstraint('categories', new Assert\All([
            new Assert\Collection([
                'fields' => [
                    'key' => [
                        new Assert\NotBlank(),
                        new Assert\Regex([
                            'pattern' => "/^[a-z0-9_]+$/",
                            'message' => "Only lowercase letters, numbers and underscores are allowed."
                        ])
                    ]
                ],
                'allowExtraFields' => true
            ])
        ]));

        $metadata->addPropertyConstraint('fields', new Assert\Type(['type' => 'array']));
    }

    public function validate()
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
        $this->violations = $validator->validate($this);
    }

    public function getViolations()
    {
        return $this->violations;
    }

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
        $this->categories = $categories;
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
}
