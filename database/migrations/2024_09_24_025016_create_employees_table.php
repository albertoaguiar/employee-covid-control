<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('cpf_prefix', 3);
            $table->string('cpf_hash', 64)->unique()->index();
            $table->string('name', 255);
            $table->date('birth_date');
            $table->date('date_first_dose')->nullable();
            $table->date('date_second_dose')->nullable();
            $table->date('date_third_dose')->nullable();
            $table->foreignId('vaccine_id')->nullable()->constrained('vaccines');
            $table->boolean('comorbidity')->default(false);
            $table->string('comorbidity_desc', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
