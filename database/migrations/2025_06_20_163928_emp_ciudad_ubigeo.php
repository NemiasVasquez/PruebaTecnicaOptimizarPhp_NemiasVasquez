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
       Schema::create('emp_ciudad_ubigeo', function (Blueprint $table) {
            $table->smallInteger('ubi_id')->unsigned()->autoIncrement();
            $table->string('ubi_departamento',100)->nullable();
            $table->tinyInteger('ubi_depid')->unsigned()->nullable();

            
            $table->smallInteger('idPlantilla')->unsigned();
            $table->smallInteger('idPermiso')->unsigned();
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 150)->nullable();
            $table->string('slug', 50)->unique();
            $table->boolean('vigente')->default(True);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('emp_ciudad_ubigeo');
    }
};
