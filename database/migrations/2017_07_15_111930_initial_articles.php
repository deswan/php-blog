<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title',100);
            $table->text('body');
            $table->boolean('if_draft');
            $table->string('outline',200);
        });
        Schema::create('categories', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
            $table->string('name',30);
            $table->tinyInteger('type');
        });
        Schema::create('comments', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
            $table->text('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            //
        });
    }
}
