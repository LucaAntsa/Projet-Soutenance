<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate([
            'name' => 'Éducation des enfants',
        ], [
            'description' => 'Modules liés à l’accompagnement éducatif des enfants.',
        ]);

        Category::firstOrCreate([
            'name' => 'Communication familiale',
        ], [
            'description' => 'Modules sur le dialogue entre parents et enfants.',
        ]);

        Category::firstOrCreate([
            'name' => 'Discipline positive',
        ], [
            'description' => 'Modules sur les méthodes éducatives positives.',
        ]);

        Category::firstOrCreate([
            'name' => 'Gestion des conflits',
        ], [
            'description' => 'Modules sur la résolution des conflits familiaux.',
        ]);

        Category::firstOrCreate([
            'name' => 'Santé et bien-être familial',
        ], [
            'description' => 'Modules liés au bien-être physique et mental de la famille.',
        ]);

        Category::firstOrCreate([
            'name' => 'Planification familiale',
        ], [
            'description' => 'Modules liés à l’organisation et à la planification familiale.',
        ]);
    }
}
