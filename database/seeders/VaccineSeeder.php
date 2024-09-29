<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vaccines = [
            ['name' => 'Pfizer/BioNTech', 'batch' => 'AB12345', 'expiration_date' => '2025-08-15'],
            ['name' => 'Moderna', 'batch' => 'CD67890', 'expiration_date' => '2025-09-20'],
            ['name' => 'AstraZeneca', 'batch' => 'EF23456', 'expiration_date' => '2025-10-10'],
            ['name' => 'Janssen', 'batch' => 'GH78901', 'expiration_date' => '2025-07-05'],
            ['name' => 'Coronavac', 'batch' => 'IJ34567', 'expiration_date' => '2025-11-25'],
            ['name' => 'Sputnik V', 'batch' => 'KL89012', 'expiration_date' => '2025-12-30'],
            ['name' => 'Covaxin', 'batch' => 'MN45678', 'expiration_date' => '2025-06-15'],
            ['name' => 'Novavax', 'batch' => 'OP12345', 'expiration_date' => '2025-05-20'],
            ['name' => 'CanSino', 'batch' => 'QR67890', 'expiration_date' => '2025-04-22'],
            ['name' => 'Zydus Cadila', 'batch' => 'ST23456', 'expiration_date' => '2025-03-30'],
            ['name' => 'Covovax', 'batch' => 'UV78901', 'expiration_date' => '2025-02-18'],
            ['name' => 'Vaxzevria', 'batch' => 'WX34567', 'expiration_date' => '2025-01-10'],
            ['name' => 'Medicago', 'batch' => 'YZ89012', 'expiration_date' => '2024-12-01'],
            ['name' => 'Clover Biopharmaceuticals', 'batch' => 'A12345', 'expiration_date' => '2024-11-15'],
            ['name' => 'Sinovac', 'batch' => 'B67890', 'expiration_date' => '2024-10-30'],
            ['name' => 'Valneva', 'batch' => 'C23456', 'expiration_date' => '2024-09-25'],
            ['name' => 'ImmunityBio', 'batch' => 'D78901', 'expiration_date' => '2024-08-18'],
            ['name' => 'BioNTech/Pfizer', 'batch' => 'E34567', 'expiration_date' => '2024-07-22'],
            ['name' => 'GSK/Vir Biotechnology', 'batch' => 'F89012', 'expiration_date' => '2024-06-05'],
            ['name' => 'Medigen', 'batch' => 'G12345', 'expiration_date' => '2024-05-17'],
            ['name' => 'Inovio', 'batch' => 'H67890', 'expiration_date' => '2024-04-25'],
            ['name' => 'Genexine', 'batch' => 'I23456', 'expiration_date' => '2024-03-30'],
            ['name' => 'Arcturus Therapeutics', 'batch' => 'J78901', 'expiration_date' => '2024-02-18'],
            ['name' => 'Bharat Biotech', 'batch' => 'K34567', 'expiration_date' => '2024-01-05'],
            ['name' => 'Vaxart', 'batch' => 'L89012', 'expiration_date' => '2023-12-15'],
            ['name' => 'CureVac', 'batch' => 'M12345', 'expiration_date' => '2023-11-20'],
            ['name' => 'AIBio', 'batch' => 'N67890', 'expiration_date' => '2023-10-30'],
            ['name' => 'Seqirus', 'batch' => 'O23456', 'expiration_date' => '2023-09-22'],
            ['name' => 'BiondVax', 'batch' => 'P78901', 'expiration_date' => '2023-08-15'],
            ['name' => 'Western University', 'batch' => 'Q34567', 'expiration_date' => '2023-07-10'],
            ['name' => 'Imvamune', 'batch' => 'R89012', 'expiration_date' => '2023-06-01'],
            ['name' => 'Vaxin', 'batch' => 'S12345', 'expiration_date' => '2023-05-12'],
        ];

        DB::table('vaccines')->insert($vaccines);
    }
}
