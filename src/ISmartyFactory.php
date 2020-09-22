<?php

namespace Bogosoft\Http\Mvc\Smarty;

use Smarty;

/**
 * Represents a strategy for creating fully configured Smarty objects.
 *
 * @package Bogosoft\Http\Mvc\Smarty
 */
interface ISmartyFactory
{
    /**
     * Create a new Smarty object.
     *
     * @return Smarty A fully configured Smarty object.
     */
    function create(): Smarty;
}
