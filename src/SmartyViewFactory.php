<?php

declare(strict_types=1);

namespace Bogosoft\Http\Mvc\Smarty;

use Bogosoft\Http\Mvc\IView;
use Bogosoft\Http\Mvc\IViewFactory;

/**
 * An implementation of the {@see IViewFactory} contract responsible for
 * creating Smarty views.
 *
 * @package Bogosoft\Http\Mvc\Smarty
 */
class SmartyViewFactory implements IViewFactory
{
    private ISmartyFactory $factory;

    /**
     * Create a new Smarty view factory.
     *
     * @param ISmartyFactory $factory A strategy for creating Smarty objects.
     */
    function __construct(ISmartyFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @inheritDoc
     */
    function createView(string $name, $model, array $parameters): ?IView
    {
        $path = trim($name, '/') . '.tpl';

        $smarty = $this->factory->create();

        $parameters['model'] = $model;

        $smarty->assign($parameters);

        return new SmartyView($smarty, $path);
    }
}
