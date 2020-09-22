<?php

declare(strict_types=1);

namespace Bogosoft\Http\Mvc\Smarty\Tests;

use Bogosoft\Http\Mvc\Smarty\SmartyView;
use PHPUnit\Framework\TestCase;
use Smarty;

class SmartyViewTest extends TestCase
{
    function testCanRenderSmartyTemplate(): void
    {
        $name = 'Andrew Jackson';

        $template = 'Hello, {$name}!';

        $expected = str_replace('{$name}', $name, $template);

        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '.tpl';

        file_put_contents($path, $template);

        $smarty = new Smarty();

        $smarty->assign('name', $name);

        $smarty->setTemplateDir(pathinfo($path, PATHINFO_DIRNAME));

        $view = new SmartyView($smarty, pathinfo($path, PATHINFO_BASENAME));

        /** @var string $actual */
        $actual = null;

        /** @var resource $stream */
        $stream = null;

        try
        {
            $stream = fopen('php://memory', 'r+');

            /** @noinspection PhpUnhandledExceptionInspection */
            $view->render($stream);

            fseek($stream, 0);

            $actual = stream_get_contents($stream);
        }
        finally
        {
            if (is_resource($stream))
                fclose($stream);
        }

        $this->assertEquals($expected, $actual);
    }
}
