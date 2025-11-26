<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        // On retourne juste une structure vide ou par défaut valide
        // Plus de Faker, plus de random.
        return [
            'question' => 'Question par défaut',
            'points' => 1,
            'category' => 'password',
            'answers' => [], // Tableau vide ou structure de base
        ];
    }
}
