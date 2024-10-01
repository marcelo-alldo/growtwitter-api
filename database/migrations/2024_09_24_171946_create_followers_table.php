<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('followingId'); // esse cara aqui tá sendo seguido
            $table->integer('followerId'); // esse cara aqui tá seguindo
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
