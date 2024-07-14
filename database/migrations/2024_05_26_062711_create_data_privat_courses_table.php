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
        Schema::create('data_privat_courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('major');
            $table->string('institusi');
            $table->text('description_private_course');
            $table->text('teaching_private_course');
            $table->text('description_teaching_private_course');
            $table->string('deal_price_private_course'); // harga deal2an customer
            $table->string('salary_teaching'); // harga pengajar
            $table->string('net_funds_course'); // hasil bersih
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
        Schema::dropIfExists('data_privat_courses');
    }
};
