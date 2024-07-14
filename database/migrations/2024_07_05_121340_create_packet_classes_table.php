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
        Schema::create('packet_classes', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_packet_class', ['individu', 'bareng-besti']);
            $table->string('name_packet_class');
            $table->string('price_packet_class'); //  per pertemuan
            $table->string('count_packet_class'); // jumlah pertemuan
            $table->string('limit_participant_packet_class')->nullable(); // jumlah limit peserta
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
        Schema::dropIfExists('packet_classes');
    }
};
