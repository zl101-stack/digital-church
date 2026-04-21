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
        Schema::create('counselings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('pastor_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->boolean('is_anonymous')->default(false);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unique(['pastor_id', 'date', 'time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselings');
    }
};
