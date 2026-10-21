<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_the_filament_name_attribute_maps_to_the_first_name_column(): void
    {
        $user = new User();
        $user->fill(['name' => 'Root']);

        $this->assertSame('Root', $user->firstName);
    }
}
