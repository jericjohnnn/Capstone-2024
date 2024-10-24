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
        Schema::create('tutor_work_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained()->onDelete('cascade');;
            $table->enum('monday', ['True', 'False'])->default('False');
            $table->enum('tuesday', ['True', 'False'])->default('False');
            $table->enum('wednesday', ['True', 'False'])->default('False');
            $table->enum('thursday', ['True', 'False'])->default('False');
            $table->enum('friday', ['True', 'False'])->default('False');
            $table->enum('saturday', ['True', 'False'])->default('False');
            $table->enum('sunday', ['True', 'False'])->default('False');
            $table->integer('start_time'); // prone to change to date instead of int
            $table->integer('end_time'); // prone to change to date instead of int
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor_work_days');
    }
};
