<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeRessourcesRessourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_ressources_ressources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type-ressource_id');
            $table->unsignedBigInteger('ressource_id');

            $table->foreign('type-ressource_id')->references('id')->on('type_ressources')->onDelete('cascade');
            $table->foreign('ressource_id')->references('id')->on('ressources')->onDelete('cascade');

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
        Schema::dropIfExists('type_ressources_ressources');
    }
}
