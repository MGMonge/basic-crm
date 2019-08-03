<?php

namespace Tests\Concerns;

use App\User;

trait UsersAware
{
    public function actingAsUser()
    {
        return $this->actingAs(factory(User::class)->create());
    }
}