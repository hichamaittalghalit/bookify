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
        Schema::create('smtps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('host');
            $table->integer('port')->default(993);
            $table->string('username');
            $table->text('password'); // Encrypted
            $table->enum('encryption', ['ssl', 'tls', 'none'])->default('ssl');
            $table->string('mailbox')->default('INBOX');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_fetched_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtps');
    }
};
