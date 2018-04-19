<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Registry\DataModifier;

interface DataModifierInterface
{
    public function modifyBeforeBackendFormRendering(array $data): array;
    public function modifyBeforePersistence(array $data): array;
    public function modifyBeforeFrontendOutput(array $data): array;
}
