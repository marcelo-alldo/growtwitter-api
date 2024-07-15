<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('userId')->nullable(false)->change();
            $table->unsignedBigInteger('postId')->nullable(false)->change();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign('likes_userid_foreign');
            $table->dropColumn('userId');
            $table->dropForeign('likes_postid_foreign');
            $table->dropColumn('postId');
        });
    }
};
