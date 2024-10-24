<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('contact_number')->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('tutor_rate')->nullable();
            $table->text('biography')->nullable();
            $table->string('school_id_number');
            $table->enum('course', ['BSED', 'BEED', 'BSIT', 'BSHM', 'BSENTREP']);
            $table->enum('year', ['1', '2', '3', '4']);
            $table->enum('contacted_status', ['True', 'False'])->default('False');
            $table->enum('offense_status', ['Unflagged', 'Warned', 'Penalized', 'Banned'])
                ->default('Unflagged');
            $table->enum('approval_status', ['Pending', 'Accepted', 'Rejected'])
                ->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutors');
    }
};
