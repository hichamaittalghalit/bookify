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
        Schema::create('paypals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('email');
            $table->string('test_client_id')->nullable();
            $table->string('test_secret_key')->nullable();
            $table->string('live_client_id')->nullable();
            $table->string('live_secret_key')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('transactions_count')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paypals');
    }
};

