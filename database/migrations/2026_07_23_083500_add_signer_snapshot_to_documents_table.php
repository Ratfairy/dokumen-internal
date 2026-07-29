<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan snapshot data penandatangan.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('signer_name', 150)
                ->nullable()
                ->after('signer_id');

            $table->string('signer_employee_number', 50)
                ->nullable()
                ->after('signer_name');

            $table->string('signer_position', 150)
                ->nullable()
                ->after('signer_employee_number');

            $table->string('signer_work_unit', 150)
                ->nullable()
                ->after('signer_position');

            $table->string('signer_institution', 200)
                ->nullable()
                ->after('signer_work_unit');
        });
    }

    /**
     * Menghapus snapshot data penandatangan.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn([
                'signer_name',
                'signer_employee_number',
                'signer_position',
                'signer_work_unit',
                'signer_institution',
            ]);
        });
    }
};