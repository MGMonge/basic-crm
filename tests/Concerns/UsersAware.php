<?php

namespace Tests\Concerns;

use App\User;

trait UsersAware
{
    public function actingAsAdmin()
    {
        return $this->actingAs(factory(User::class)->states('admin')->create());
    }
}