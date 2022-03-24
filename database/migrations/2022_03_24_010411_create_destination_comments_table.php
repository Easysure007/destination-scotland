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
        Schema::create('destination_comments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')
                ->references('id')
                ->on('destinations')
                ->onDelete('CASCADE');

            $table->string('name', 150)->index();
            $table->text('comment');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('responder_id')->nullable();

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
        Schema::dropIfExists('destination_comments');
    }
};
