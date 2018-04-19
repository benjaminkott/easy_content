<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\Objects\Field\Generic;

class InvalidField extends CommonField implements FieldInterface
{
    public function factorizeTca(): array
    {
        return [];
    }
}
