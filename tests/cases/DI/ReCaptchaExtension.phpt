<?php

namespace Tests\DI;

/**
 * Test: ReCaptchaExtension
 */

use Minetro\ReCaptcha\DI\ReCaptchaExtension;
use Minetro\ReCaptcha\ReCaptchaProvider;
use Nette\DI\Compiler;
use Nette\DI\ContainerLoader;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

test(function () {
    $loader = new ContainerLoader(TEMP_DIR);
    $class = $loader->load(function (Compiler $compiler) {
        $compiler->addExtension('captcha', new ReCaptchaExtension());

        $compiler->addConfig([
            'captcha' => [
                'siteKey' => 'foobar',
                'secretKey' => 'foobar2',
            ],
        ]);
    }, 'SC' . time());

    $container = new $class;
    Assert::type(ReCaptchaProvider::class, $container->getByType(ReCaptchaProvider::class));
    Assert::equal('foobar', $container->getByType(ReCaptchaProvider::class)->getSiteKey());
});
