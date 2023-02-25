<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// use Faker\Provider\ar_EG\Company;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Company;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Company::factory(10)->hasContacts(10)->create();
    }
}
