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
        Schema::create('alamat_tokos', function (Blueprint $table) {
            $table->id();
            $table->integer('tokoId')->unsigned();
            $table->string('alamat');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan')->nullable();
            $table->string('kodepost');
            $table->integer('provinsiId')->nullable();
            $table->integer('kotaId')->nullable();
            $table->integer('kecamatanId')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_tokos');
    }
};
