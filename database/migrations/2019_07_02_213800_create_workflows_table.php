<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icon');
            $table->string('image');
            $table->string('banner');
            $table->string('title');
            $table->string('slug');
            $table->string('blurb');
            $table->text('description');
            $table->text('description_markdown');
            $table->text('installation');
            $table->text('installation_markdown');
            $table->string('youtube')->nullable();
            $table->string('repository');
            $table->integer('votes')->default(0);
            $table->integer('stars')->default(0);
            $table->integer('issues')->default(0);
            $table->string('outcome')->nullable();
            $table->json('options')->nullable();
            $table->integer('app_id');
            $table->timestamps();
            $table->timestamp('staged_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('og_twitter_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflows');
    }
}
