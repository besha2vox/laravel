<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->words(rand(1,3), true);
        $slug = Str::slug($title);
        return [
            'title' => $title,
            'slug' => $slug,
            'SKU' => fake()->unique()->ean13(),
            'description' => fake()->boolean() ? fake()->sentences(rand(1,5), true) : null,
            'price' => fake()->randomFloat(2, 10, 100),
            'discount' => fake()->boolean() ? rand(5, 90) : null,
            'quantity' => rand(0, 100),
            'thumbnail' => '',
        ];
    }

    public function withThumbnail(): static
    {
        return $this->state(fn (array $attributes): array => ['thumbnail' => $this->generateImageUrl($attributes['slug'])]);
    }

    protected function generateImageUrl(string $slug): string
    {
        $dirName = "faker/products/$slug";
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        if (!Storage::exists($dirName)) {
            Storage::createDirectory($dirName);
        }


        /**
         * @var \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider $faker
         */

        return $dirName . '/' . $faker->image(Storage::path($dirName), isFullPath: false);
    }
}
