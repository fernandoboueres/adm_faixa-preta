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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('cep', 8);
            $table->string('rua');
            $table->string('bairro');
            $table->string('quadra');
            $table->string('numero');

            $table->foreignUuid('student_uuid')->constrained('students', 'uuid')->cascadeOnDelete();
            
            $table->unique('student_uuid');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
