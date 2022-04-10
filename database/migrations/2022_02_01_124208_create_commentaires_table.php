<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->string('contenu', 500);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ressource_id');
            $table->unsignedBigInteger('parent_id')->unsigned()->nullable();
            $table->boolean('publiee')->default(0);

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('ressource_id')
                ->references('id')->on('ressources')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('parent_id')
                ->references('id')
                ->on('commentaires')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('commentaires');
    }
}
