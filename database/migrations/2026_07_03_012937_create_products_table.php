<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->string('tag')->nullable();
            $table->string('category'); // sublimacao, serigrafia, dtf, ecobag
            $table->string('type')->default('unissex'); // unissex, infantil
            $table->json('sizes'); // ['P','M','G','GG']
            $table->json('colors'); // ['black','white']
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->text('description');
            $table->json('bullets')->nullable(); // highlights list
            $table->json('specs')->nullable();   // material, gramatura etc.
            $table->json('cares')->nullable();   // care instructions
            $table->json('images')->nullable();  // array of image paths
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
