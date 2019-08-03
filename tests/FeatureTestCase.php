<?php

namespace Tests;

use Laravel\BrowserKitTesting\TestCase;
use PHPUnit\Framework\Assert;
use Tests\Concerns\UsersAware;

class FeatureTestCase extends TestCase
{
    use CreatesApplication;
    use UsersAware;

    protected $baseUrl = '/';

    public function assertNumberOfElements($expectedCount, $selector)
    {
        $elements = $this->crawler->filter($selector);

        Assert::assertCount($expectedCount, $elements, "Failed asserting the number of [{$selector}] elements");

        return $this;
    }

    public function clickElement($selector)
    {
        $elements = $this->crawler->filter($selector);

        $this->assertCount(1, $elements, sprintf('Found %s elements with selector [%s] expected 1', count($elements), $selector));

        return $this->click(trim($elements->first()->text()));
    }
}