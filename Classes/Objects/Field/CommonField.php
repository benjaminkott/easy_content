<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects\Field;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;

class CommonField
{
    protected $property = '';
    protected $label = '';
    protected $type = '';
    protected $validation = [];
    protected $configuration = [];

    /**
     * We define this as static variable because we have to access it
     * in static validation.
     *
     * @var string
     */
    protected static $factoryError = '';

    /**
     * @var ConstraintViolationList
     */
    protected $violations = null;

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param string $property
     */
    public function setProperty(string $property): void
    {
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getValidation(): array
    {
        return $this->validation;
    }

    /**
     * @param array $validation
     */
    public function setValidation(array $validation = null): void
    {
        $this->validation = (array)$validation;
    }

    /**
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration = null): void
    {
        $this->configuration = (array)$configuration;
    }

    /**
     * @return string
     */
    public function getFactoryError(): string
    {
        return $this->factoryError;
    }

    /**
     * @param string $factoryError
     */
    public function setFactoryError(string $factoryError): void
    {
        self::$factoryError = $factoryError;
    }

    /**
     * @return null|ConstraintViolationList
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * @var ClassMetadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('property', new Assert\NotBlank());
        $metadata->addPropertyConstraint('property', new Assert\Length(['min' => 5]));
        $metadata->addPropertyConstraint('property', new Assert\Regex([
            'pattern' => '/^[a-z0-9_]+$/',
            'message' => 'Only lowercase letters, numbers and underscores are allowed.'
        ]));

        $metadata->addPropertyConstraint('label', new Assert\Type(['type' => 'string']));
        $metadata->addPropertyConstraint('label', new Assert\NotBlank());

        $metadata->addPropertyConstraint('type', new Assert\Type(['type' => 'string']));
        $metadata->addPropertyConstraint('type', new Assert\NotBlank());

        // @todo Refactor error handling for FieldRegistrationFailedException
        // (thrown in \BK2K\EasyContent\Factory\FieldFactory::create)
        // As for now the validator of the parent ContentElement's field "fields"
        // returns faulty error messages
        $metadata->addPropertyConstraint('factoryError', new Assert\Blank([
            'message' => self::$factoryError
        ]));

        $metadata->addPropertyConstraint('validation', new Assert\Type(['type' => 'array']));
        $metadata->addPropertyConstraint('configuration', new Assert\Type(['type' => 'array']));
    }

    public function validate()
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
        $this->violations = $validator->validate($this);
    }
}
