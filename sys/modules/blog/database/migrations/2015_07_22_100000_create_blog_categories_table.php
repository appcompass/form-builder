<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('description');

            $table->integer('website_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('has_depth')->default(0);
            $table->integer('at_depth')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('website_id')
                    ->references('id')
                    ->on('websites')
                    ->onDelete('cascade');
            $table->foreign('parent_id')
                ->references('id')
                ->on('blog_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blog_categories');
    }
}
