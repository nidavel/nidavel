<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->enum('post_type', ['post', 'page'])->default('post');
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->string('link')->nullable();
            $table->smallInteger('user_id')->unsigned();
            $table->smallInteger('category_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
