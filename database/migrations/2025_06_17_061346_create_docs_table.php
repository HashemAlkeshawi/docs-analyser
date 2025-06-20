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
        Schema::create('docs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->string('generated_name'); 
            $table->string('file_path');
            $table->text('content')->nullable();
            $table->string('classification')->nullable();
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->timestamp('uploaded_at')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docs');
    }
};
