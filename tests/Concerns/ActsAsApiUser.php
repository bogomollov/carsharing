<?php

namespace Tests\Concerns;

use App\Models\User;

trait ActsAsApiUser
{
    protected function actingAsApiUser(): User
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        return $user;
    }
}
