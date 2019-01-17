<?php

namespace Signifly\Addresses\Test;

use Signifly\Addresses\Test\Models\User;

class AddressableTest extends TestCase
{
    /** @test */
    function it_creates_an_address()
    {
        $user = User::first();

        $address = $user->addresses()->create([
            'street' => 'Some Road 123',
            'street2' => '1st floor',
            'postal_code' => 'DK-1234',
            'city' => 'Copenhagen',
            'region' => null,
            'country_code' => 'DK',
            'is_primary' => true,
        ]);

        $this->assertCount(1, $user->addresses);
        $this->assertTrue($address->is_primary);
    }
}
