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
        Schema::create('personal_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('userId')->default(0);
            $table->string('token')->nullable();
            $table->string('abilities')->nullable();
            $table->timestamp('lastUsedAt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_tokens');
    }
};
