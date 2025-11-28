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
        Schema::create('received_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('smtp_id')->constrained('smtps')->onDelete('cascade');
            $table->string('message_id')->unique();
            $table->string('from_email');
            $table->string('from_name')->nullable();
            $table->string('to_email');
            $table->string('to_name')->nullable();
            $table->string('subject');
            $table->text('body');
            $table->text('body_html')->nullable();
            $table->timestamp('received_at');
            $table->json('attachments')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->index('smtp_id');
            $table->index('from_email');
            $table->index('received_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_emails');
    }
};
