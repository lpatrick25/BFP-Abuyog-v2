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
        Schema::create('marshalls', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 20);
            $table->string('middle_name', 15)->nullable();
            $table->string('last_name', 20);
            $table->string('extension_name', 5)->nullable();
            $table->string('contact_number', 20)->unique();
            $table->string('email', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marshalls');
    }
};
