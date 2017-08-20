<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelatedIdToNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->text('related')->nullable();
        });

        // Generate comment notifications.
        $comments = \App\Comment::all();
        foreach ($comments as $comment) {
            if ($comment->parentComment) {
                // Has parent.
                $comment->parentComment->user->notifications()->create([
                    'content' => 'new-reply',
                    'type'    => \App\Notification::USER_TYPE,
                    'related' => json_encode(['user_id' => $comment->user->id, 'comment_id' => $comment->id])
                ]);
            } else {
                $comment->post->user->notifications()->create([
                    'content' => 'commented',
                    'type'    => \App\Notification::USER_TYPE,
                    'related' => json_encode(['user_id' => $comment->user_id, 'comment_id' => $comment->id])
                ]);
            }
        }

        // Generate like notifications.
        $likes = DB::table('likes')->select(['user_id', 'post_id'])->get();
        $commentLikes = DB::table('comment_likes')->select(['user_id', 'comment_id'])->get();
        foreach ($likes as $like) {
            $post = \App\Post::find($like->post_id);
            $post->user->notifications()->create([
                'content' => 'liked',
                'type'    => \App\Notification::USER_TYPE,
                'related' => json_encode(['user_id' => $like->user_id, 'post_id' => $post->id])
            ]);
        }

        foreach ($commentLikes as $commentLike) {
            $comment = \App\Comment::find($commentLike->comment_id);
            $comment->user->notifications()->create([
                'content' => 'liked-comment',
                'type'    => \App\Notification::USER_TYPE,
                'related' => json_encode(['user_id' => $commentLike->user_id, 'comment_id' => $comment->id])
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('related');
        });
    }
}
