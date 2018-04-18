<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Factory;

use BK2K\EasyContent\Error\FieldRegistrationFailedException;
use BK2K\EasyContent\Objects\Field\CommonField;
use BK2K\EasyContent\Objects\Field\FieldInterface;
use BK2K\EasyContent\Objects\Field\InvalidField;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class FieldFactory
{
    /**
     * @var ObjectManager
     */
    protected $objectManager = null;

    public function __construct(
        ObjectManager $objectManager = null
    ) {
        $this->objectManager = $objectManager ?: GeneralUtility::makeInstance(ObjectManager::class);
    }

    public function create($fieldConfiguration)
    {
        try {
            $fullyQualifiedClassName = $fieldConfiguration['fcqn'] ?: 'BK2K\\EasyContent\\Objects\Field\\' . ucfirst($fieldConfiguration['type']);
            if (!class_exists($fullyQualifiedClassName)) {
                throw new FieldRegistrationFailedException('Could not register field ' . $fullyQualifiedClassName, 1523998555);
            }

            /** @var CommonField|FieldInterface $field */
            $field = $this->objectManager->get($fullyQualifiedClassName);
            $field->setFactoryError('');
        } catch (\Exception $e) {
            $field = $this->objectManager->get(InvalidField::class);
            $field->setFactoryError($e->getMessage());
        }

        $field->setProperty($fieldConfiguration['property']);
        $field->setLabel($fieldConfiguration['label']);
        $field->setType($fieldConfiguration['fcqn'] ?: $fieldConfiguration['type']);
        $field->setValidation($fieldConfiguration['validation']);
        $field->setConfiguration($fieldConfiguration['configuration']);
        $field->validate();
        return $field;
    }
}
