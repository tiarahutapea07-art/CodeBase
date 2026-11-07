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
        //Tambahkan identitas kedua pengguna
        Schema::table('conversations', function (Blueprint $table) {
            $table->foreignId('user_one_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('user_two_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
        });

        // Pindahkan data percakapan lama
        $conversations = DB::table('conversations')->get();

        foreach ($conversations as $conversation) {
            DB::table('conversations')
                ->where('id', $conversation->id)
                ->update([
                    'user_one_id' => min(
                        $conversation->buyer_id,
                        $conversation->seller_id
                    ),
                    'user_two_id' => max(
                        $conversation->buyer_id,
                        $conversation->seller_id
                    ),
                ]);
        }

        // Satu pasangan pengguna hanya boleh memiliki satu chat
        Schema::table('conversations', function (Blueprint $table) {
            $table->unique(
                ['user_one_id', 'user_two_id'],
                'unique_user_conversation'
            );
        });

        // Hubungkan pesan dengan produk yang sedang dibicarakan
        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropUnique('unique_user_conversation');

            $table->dropForeign(['user_one_id']);
            $table->dropForeign(['user_two_id']);

            $table->dropColumn([
                'user_one_id',
                'user_two_id',
            ]);
        });
    }
};