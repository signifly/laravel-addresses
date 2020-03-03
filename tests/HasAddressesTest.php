<?php

namespace Signifly\Addresses\Test;

use Illuminate\Foundation\Testing\WithFaker;
use Signifly\Addresses\Test\Models\User;

class HasAddressesTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        if (! $this->faker) {
            $this->setUpFaker();
        }
    }

    /** @test */
    public function it_creates_an_address()
    {
        // Given a random user
        $user = User::inRandomOrder()->first();

        // Create a new address
        $address = $user->addresses()->create(
            $this->getAddressData([
                'is_primary' => true,
            ])
        );

        // Assert that:
        // 1. The user has 1 address
        // 2. The address is primary
        $this->assertCount(1, $user->addresses);
        $this->assertTrue($address->is_primary);
    }

    /** @test */
    public function it_deletes_associated_addresses()
    {
        // Given a user with an address
        $user = User::inRandomOrder()->first();
        $address = $user->addresses()->create(
            $this->getAddressData()
        );
        $this->assertCount(1, $user->addresses);

        // Delete the user
        $user->delete();

        // Assert that:
        // 1. The user has been deleted
        // 2. The address no longer exists
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
        $this->assertDatabaseMissing('addresses', [
            'id' => $address->id,
        ]);
    }

    /** @test */
    public function it_can_include_the_primary_address()
    {
        // Given a user with a primary address
        $user = User::inRandomOrder()->first();
        $address = $user->addresses()->create(
            $this->getAddressData(['is_primary' => true])
        );
        $this->assertNull($user->primaryAddress);

        // Fetch user with primary address loaded
        $user = User::withPrimaryAddress()->find($user->id);

        // Assert that:
        // 1. The primaryAddress relation is not null
        // 2. The primaryAddress is the same as the address
        $this->assertNotNull($user->primaryAddress);
        $this->assertTrue($user->primaryAddress->is($address));
    }

    /**
     * Get address data.
     *
     * @param  array  $overwrites
     * @return array
     */
    protected function getAddressData(array $overwrites = []): array
    {
        return array_merge([
            'street' => $this->faker->streetAddress,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'region' => $this->faker->state,
            'country_code' => $this->faker->countryCode,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'is_primary' => $this->faker->boolean(),
        ], $overwrites);
    }
}
