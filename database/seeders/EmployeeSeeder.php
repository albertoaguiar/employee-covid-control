<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 30; $i++) {
            $cpf = $this->generateValidCpf();
            $cpf_prefix = substr($cpf, 0, 3);
            $cpf_hash = hash('sha256', $cpf);

            $comorbidity = $faker->boolean;

            DB::table('employees')->insert([
                'cpf_prefix' => $cpf_prefix,
                'cpf_hash' => $cpf_hash,
                'name' => $faker->name,
                'birth_date' => $faker->date('Y-m-d', '2004-01-01'),
                'date_first_dose' => $faker->dateTimeBetween('-2 years', 'now'),
                'date_second_dose' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'date_third_dose' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                'vaccine_id' => $faker->numberBetween(1, 30),
                'comorbidity' => $comorbidity,
                'comorbidity_desc' => $comorbidity ? $faker->sentence(5) : null,
                'is_active' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateValidCpf()
    {
        $cpf = '';
        for ($i = 0; $i < 9; $i++) {
            $cpf .= rand(0, 9);
        }

        $cpf .= $this->calculateCpfDigits($cpf);
        return $cpf;
    }

    private function calculateCpfDigits($cpf)
    {
        $sum1 = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum1 += $cpf[$i] * (10 - $i);
        }
        $digit1 = 11 - ($sum1 % 11);
        if ($digit1 >= 10) $digit1 = 0;

        $sum2 = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum2 += $cpf[$i] * (11 - $i);
        }
        $sum2 += $digit1 * 2;
        $digit2 = 11 - ($sum2 % 11);
        if ($digit2 >= 10) $digit2 = 0;

        return $digit1 . $digit2;
    }
}
