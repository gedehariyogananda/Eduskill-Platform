<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name_course');
            $table->string('slug_course');
            $table->string('banner_course');
            $table->string('instructor_course')->nullable();
            $table->text('experiences_instructor_course')->nullable();
            $table->string('description_course');
            $table->string('category_course');
            $table->string('price_course')->nullable();
            $table->string('price_discount_course')->nullable();
            $table->boolean('is_free_course')->default(false);
            $table->enum('status_course', ['published', 'unpublished', 'archived'])->default('unpublished');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
