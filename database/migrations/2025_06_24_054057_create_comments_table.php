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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment_content');
            $table->timestamp('comment_date')->comment('Date and time when the comment was made.');
            $table->string('reviewer_name')->nullable()->comment('Name of the person who made the comment.');
            $table->string('reviewer_email')->nullable()->comment('Email of the person who made the comment.');
            $table->boolean('is_hidden')->default(false)->comment('Indicates if the comment is hidden (true) or visible (false).');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
