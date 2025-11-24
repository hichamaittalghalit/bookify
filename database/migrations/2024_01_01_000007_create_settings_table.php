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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        \DB::table('settings')
            ->insert([
                [
                    'key'        => 'google_analytics',
                    'value'      => "",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key'        => 'page_header',
                    'value'      => "",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key'        => 'page_footer',
                    'value'      => "",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key'        => 'page_payment',
                    'value'      => "",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

