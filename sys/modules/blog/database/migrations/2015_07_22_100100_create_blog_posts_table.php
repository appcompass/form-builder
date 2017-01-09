<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->string('slug');
            $table->text('excerpt');
            $table->longText('content');
            $table->string('status');
            $table->string('comments_allowed');


            $table->integer('author_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('website_id')->unsigned();
            $table->timestamp('published_at');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('blog_categories')
                ->onDelete('cascade');

            $table->foreign('website_id')
                    ->references('id')
                    ->on('websites')
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
        Schema::drop('blog_posts');
    }
}
