<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Redaktur;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Nova Adi Saputra',
            'email' => 'admin@pmiibumiayu.com',
        ]);
        User::factory(9)->create();
        Category::factory()->create([
            'categoryName' => 'Politik',
        ]);
        Category::factory(9)->create();
        Tag::factory()->create([
            'tagName' => 'Peradaban',
        ]);
        Tag::factory(9)->create();
        Redaktur::factory()->create([
            'redakturNama' => 'Nova Adi Saputra',
            'redakturEmail' => 'novaadisaputra.nasss@gmail.com',
            'redakturNomor' => '082241198283',
            'redakturAlamat' => 'Jl. Purwa Rt 02 Rw 12 Desa Suradadi Kecamatan Suradadi Kabupaten Tegal Jawa Tengah',
            'redakturUniv' =>  'Universitas Peradaban',
            'redakturFakultas' => 'FST',
            'redakturProdi' => 'Informatika',
            'redakturKuliah' => 2019,
            'redakturMapaba' => 2019,
        ]);
        Redaktur::factory(9)->create();
        Employee::factory(15)->create();
    }
}