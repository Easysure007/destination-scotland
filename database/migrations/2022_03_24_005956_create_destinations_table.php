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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('storyteller_id');
            $table->foreign('storyteller_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->string('name', 150)->index();
            $table->longText('description');
            $table->string('cover_image')->nullable();
            $table->text('images')->nullable();

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
        Schema::dropIfExists('destinations');
    }
};
