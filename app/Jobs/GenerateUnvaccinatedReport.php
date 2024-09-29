<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;

/**
 * Class GenerateUnvaccinatedReport
 *
 * Job responsible for generating reports of unvaccinated employees.
 *
 * @author Alberto Aguiar Neto
 * @since 09/2024
 * 
 */
class GenerateUnvaccinatedReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $unvaccinatedEmployees = Employee::whereNull('vaccine_id')->get(['cpf_prefix', 'name']);

        $filename = 'unvaccinated_report_' . date('Ymd_His') . '.csv';
        $handle = fopen(storage_path("app/reports/$filename"), 'w');

        fputcsv($handle, ['CPF (3 digitos)', 'Name']);

        foreach ($unvaccinatedEmployees as $employee) {
            fputcsv($handle, [$employee->cpf_prefix, $employee->name]);
        }

        fclose($handle);
    }
}
