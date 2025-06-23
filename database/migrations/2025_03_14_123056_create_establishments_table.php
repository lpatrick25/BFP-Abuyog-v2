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
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignId('client_id')->constrained('clients')->onDelete('restrict')->onUpdate('cascade');
            $table->string('representative_name', 100)->nullable();
            $table->string('trade_name', 100)->nullable();
            $table->string('total_building_area', 20);
            $table->string('number_of_occupant', 11);
            $table->string('type_of_occupancy', 100);
            $table->string('type_of_building', 100);
            $table->string('nature_of_business', 100);
            $table->string('BIN', 20);
            $table->string('TIN', 20)->nullable();
            $table->string('DTI', 20);
            $table->string('SEC', 20)->nullable();
            $table->boolean('high_rise')->default(0);
            $table->boolean('eminent_danger')->default(0);
            $table->string('address_brgy', 100);
            $table->string('address_ex', 100)->nullable();
            $table->string('location_latitude', 15);
            $table->string('location_longitude', 15);
            $table->string('email', 255);
            $table->string('landline', 20)->nullable();
            $table->string('contact_number', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishments');
    }
};
