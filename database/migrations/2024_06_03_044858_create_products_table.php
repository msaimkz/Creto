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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->text('shipping');
            $table->integer('price');
            $table->enum('gender',['men','women','kid']);
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->string('model');
            $table->enum('is_featured',['Yes','No',]);
            $table->string('sku');
            $table->integer('qty');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
