<?php

declare(strict_types=1);

namespace Bogosoft\Http\Mvc\Smarty;

use Bogosoft\Http\Mvc\IView;
use Smarty;
use SmartyException;

/**
 * An implementation of the {@see IView} contract that utilizes a Smarty
 * template to project a model onto an HTTP response.
 *
 * @package Bogosoft\Http\Mvc\Smarty
 */
class SmartyView implements IView
{
    private Smarty $smartyObject;
    private string $templateFile;

    /**
     * Create a new Smarty view.
     *
     * @param Smarty $smartyObject A Smarty configuration object.
     * @param string $templateFile A Smarty template filename.
     */
    function __construct(Smarty $smartyObject, string $templateFile)
    {
        $this->smartyObject = $smartyObject;
        $this->templateFile = $templateFile;
    }

    /**
     * @inheritDoc
     *
     * @throws SmartyException
     */
    function render($target): void
    {
        $rendered = $this->smartyObject->fetch($this->templateFile);

        fwrite($target, $rendered);
    }
}
