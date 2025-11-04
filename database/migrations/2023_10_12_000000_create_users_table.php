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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('password');
            $table->string('cedula')->unique();
            $table->string('expedicion');
            $table->string('nacimiento');
            $table->unsignedBigInteger('id_unidad');
            $table->unsignedBigInteger('id_rol');
            $table->string('foto')->nullable();
            $table->integer('ingreso'); // 0 primera vez, 1 ya ha ingresado
            $table->timestamps();

            $table->foreign('id_unidad')->references('id')->on('unidad');
            $table->foreign('id_rol')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
