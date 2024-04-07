<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'name'  => $this->faker->name(),
            'isbn'  => $this->faker->randomNumber(),
            'value' => $this->faker->randomNumber(),
        ];
    }
}
