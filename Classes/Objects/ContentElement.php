<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects;

use BK2K\EasyContent\Objects\Field\CommonField;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;
use TYPO3\CMS\Core\Resource\FileInterface;

class ContentElement
{
    /**
     * @var string
     */
    protected $configurationFile = '';

    /**
     * @var string
     */
    protected $identifier = '';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

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
     * @var FileInterface[]
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
            'pattern' => '/^[a-z0-9_]+$/',
            'message' => 'Only lowercase letters, numbers and underscores are allowed.'
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
                            'pattern' => '/^[a-z0-9_]+$/',
                            'message' => 'Only lowercase letters, numbers and underscores are allowed.'
                        ])
                    ]
                ],
                'allowExtraFields' => true
            ])
        ]));

        $metadata->addPropertyConstraint('fields', new Assert\Type(['type' => 'array']));
        $metadata->addPropertyConstraint('fields', new Assert\NotBlank());
        $metadata->addPropertyConstraint('fields', new Assert\Valid());
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

    /**
     * @return string
     */
    public function getConfigurationFile(): string
    {
        return $this->configurationFile;
    }

    /**
     * @param string $configurationFile
     */
    public function setConfigurationFile(string $configurationFile): void
    {
        $this->configurationFile = $configurationFile;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return CommonField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function getFieldsAsPlainArray(): array
    {
        return array_map(
            function (CommonField $field) {
                return $field->getProperty();
            },
            $this->getFields()
        );
    }

    /**
     * @param FileInterface[] $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }
}
