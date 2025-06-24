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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->comment('Name of the media file.');
            $table->string('file_type')->max(10)->comment('Type of the media file, e.g., image, video, audio.');
            $table->integer('file_size')->default(0)->comment('Size of the media file in bytes.');
            $table->text('url')->comment('URL where the media file is stored.');
            $table->timestamp('upload_date')->comment('Date and time when the media file was uploaded.');
            $table->string('description')->nullable()->comment('Description of the media file.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
