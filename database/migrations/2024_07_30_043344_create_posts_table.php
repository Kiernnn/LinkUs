<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PostStatus;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
<<<<<<< HEAD
            $table->enum('status', [
                PostStatus::PUBLIC->value, 
                PostStatus::FRIENDS->value, 
                PostStatus::ME->value
            ]);
            $table->text('content')->nullable();
            $table->string('image')->nullable();
=======
            $table->enum('status', [PostStatus::PUBLIC, PostStatus::FRIENDS, PostStatus::ME]);
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('love');
>>>>>>> ed30af3091e2c22f989fc419b1d6f56ce9483b97
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
        Schema::dropIfExists('posts');
    }
}
