<?php

use App\Models\Product;
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
        Schema::create('tablets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class);
            $table->string('name');
            $table->string('model');
            $table->string('color');
            $table->string('processor');
            $table->integer('ram');
            $table->integer('storage');
            $table->float('display_size');
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tablets');
    }
};
