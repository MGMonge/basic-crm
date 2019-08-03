<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Concerns\UsersAware;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use UsersAware;
}
