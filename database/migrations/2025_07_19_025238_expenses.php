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
        schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable(false);
            $table->string('category')->nullable(true);
            $table->decimal('amount', 15, 2);
            $table->date('date')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::drop('expenses');
    }
};
