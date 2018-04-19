<?php

/*
 * This file is part of the package bk2k/easy-content.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\EasyContent\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class UnserializeViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'string', 'Value to unserialize');
    }

    public function render()
    {
        try {
            $value = $this->arguments['value'];
            if ($value === null) {
                $value = $this->renderChildren();
            }
            $array = \GuzzleHttp\json_decode($value);
            if (json_last_error() === JSON_ERROR_NONE) {
                foreach ($array as $key => $value) {
                    $this->templateVariableContainer->add($key, $value);
                }
            }
        } catch (\Exception $e) {
        }
    }
}
