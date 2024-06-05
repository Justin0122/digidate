<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class)->constrained();

            $table->string('phone_number', 15)->unique();
            $table->string('city', 64);
            $table->date('date_of_birth');
            // 0 = woman, 1 = man
            $table->boolean('gender');
            $table->boolean('straight')->nullable();
            $table->string('bio', 100)->nullable();
            $table->boolean('opt_out')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
