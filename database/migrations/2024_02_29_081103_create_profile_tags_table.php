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
        Schema::create('profile_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Profile::class)
                ->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Tag::class)
                ->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_tags');
    }
};
