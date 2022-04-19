<?php

namespace Database\Seeders;

use App\Models\InvoiceSerie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = new User([
            'name' => 'thor',
            'email' => 'thoribz@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('german1234'), // password
        ]);
        $user->save();

        $serie = new InvoiceSerie([
            'serie' => 'Z',
            'description' => 'Serie de prueba',
            'simplified' => false
        ]);
        $serie->save();
    }
}
