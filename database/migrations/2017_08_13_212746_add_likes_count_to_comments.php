<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLikesCountToComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedInteger('like_count')->default(0);
            $table->foreign('user_id', 'user_cascade')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id', 'post_cascade')->references('id')->on('posts')->onDelete('cascade');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('like_count')->default(0);
            $table->dropForeign('posts_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('comment_likes', function (Blueprint $table) {
            $table->foreign('user_id', 'cl_user_cascade')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('comment_id', 'cl_comment_cascade')->references('id')->on('comments')->onDelete('cascade');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->foreign('user_id', 'likes_user_cascade')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id', 'likes_post_cascade')->references('id')->on('posts')->onDelete('cascade');
        });

        foreach (App\Post::all() as $post) {
            $post->like_count = $post->likes()->count();
            $post->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign('likes_user_cascade');
            $table->dropForeign('likes_post_cascade');
        });

        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropForeign('cl_user_cascade');
            $table->dropForeign('cl_comment_cascade');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('like_count');
            $table->dropForeign('posts_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('like_count');
            $table->dropForeign('user_cascade');
            $table->dropForeign('post_cascade');
        });
    }
}
