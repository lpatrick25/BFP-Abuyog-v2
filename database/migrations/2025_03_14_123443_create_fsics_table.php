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
        Schema::create('fsics', function (Blueprint $table) {
            $table->id();
            $table->string('fsic_no', 10);
            $table->foreignId('application_id')->constrained('applications')->onDelete('restrict');
            $table->date('issue_date');
            $table->date('expiration_date');
            $table->decimal('amount', 10,2);
            $table->string('or_number', 10);
            $table->date('payment_date');
            $table->foreignId('inspector_id')->constrained('inspectors')->onDelete('restrict');
            $table->foreignId('marshall_id')->constrained('marshalls')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsics');
    }
};
