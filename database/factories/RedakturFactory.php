<?php

namespace Database\Factories;

use App\Models\Redaktur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class RedakturFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Redaktur::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'redakturNama' => $this->faker->name(),
            'redakturEmail' => $this->faker->unique()->safeEmail(),
            'redakturNomor' => $this->faker->phoneNumber(),
            'redakturAlamat' => $this->faker->address(),
            'redakturUniv' =>  Arr::random(['Universitas Peradaban', 'STAIB', 'STIMIK MPB', 'UNU Winduaji']),
            'redakturFakultas' => Arr::random(['FKIP', 'FEB', 'FISIP', 'FST']),
            'redakturProdi' => Arr::random(['Informatika', 'PMAT', 'Agribisnis', 'Farmasi', 'Manajemen']),
            'redakturKuliah' => $this->faker->year(),
            'redakturMapaba' => $this->faker->year(),
            'redakturFoto' => 'default.png',
        ];
    }
}