<?php

declare(strict_types=1);

namespace Bogosoft\Http\Mvc\Smarty\Tests;

use Bogosoft\Http\Mvc\Smarty\ISmartyFactory;
use Bogosoft\Http\Mvc\Smarty\SmartyViewFactory;
use PHPUnit\Framework\TestCase;
use Smarty;

class SmartyViewFactoryTest extends TestCase
{
    function testCanRenderSmartyTemplate(): void
    {
        $template = 'Hello! My name is, {$name}.';

        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '.tpl';

        file_put_contents($path, $template);

        $factory = new class(pathinfo($path, PATHINFO_DIRNAME)) implements ISmartyFactory
        {
            private string $dir;

            function __construct(string $dir)
            {
                $this->dir = $dir;
            }

            function create(): Smarty
            {
                $smarty = new Smarty();

                $smarty->setTemplateDir($this->dir);

                return $smarty;
            }
        };

        $views = new SmartyViewFactory($factory);

        $parameters = ['name' => 'James Garfield'];

        $view = $views->createView(pathinfo($path, PATHINFO_FILENAME), null, $parameters);

        /** @var string $actual */
        $actual = null;

        /** @var resource $stream */
        $stream = null;

        try
        {
            $stream = fopen('php://memory', 'r+');

            $view->render($stream);

            fseek($stream, 0);

            $actual = stream_get_contents($stream);
        }
        finally
        {
            if (is_resource($stream))
                fclose($stream);
        }

        $expected = str_replace('{$name}', $parameters['name'], $template);

        $this->assertEquals($expected, $actual);
    }
}
