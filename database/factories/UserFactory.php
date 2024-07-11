<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'birthdate' => fake()->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'email_verified_at' => now(),
            'password' => Hash::make(static::$password ??= 'password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function configure(): Factory|UserFactory
    {
        return $this->afterCreating(function (User $user) {
            if(!$user->hasAnyRole(Role::values())) {
                $user->assignRole(Role::CUSTOMER->value);
            }
            $user->syncRoles(Role::MODERATOR->value);
        });
    }

    public function admin()
    {
        return $this->state(fn (array $attributes) => ['email' => 'admin@admin.com'])->afterCreating(function (User $user) {
            $user->syncRoles(Role::ADMIN->value);
        });
    }

    public function moderator(): Factory|UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->syncRoles(Role::MODERATOR->value);
        });
    }

    public function withEmail(string $email): Factory|UserFactory
    {
        return $this->state(fn (array $attributes) => ['email' => $email]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
