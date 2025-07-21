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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Title of the post.');
            $table->text('content')->comment('Content of the post.');
            $table->string('slug')->comment('URL descriptor of the post.');
            $table->dateTime('publication_date')->comment('Date of publication.')->nullable();
            $table->dateTime('last_modified_date')->comment('Date where post was last modified.')->nullable();
            $table->string('status')->comment('D - Draft, P - Published, I - Inactive.')->max(1);
            $table->text('featured_image_url')->comment('URL for the featured image of the post.');
            $table->integer('views_count')->comment('Total views of post.')->default(0);
            $table->boolean('is_featured')->default(false);
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
