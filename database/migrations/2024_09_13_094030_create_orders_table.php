<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tables = ['orders_twd', 'orders_usd', 'orders_jpy', 'orders_rmb', 'orders_myr'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('currency_type'); // 存儲貨幣類型，例如 'orders_twd', 'orders_usd'
            $table->timestamps();
        });

        foreach ($this->tables as $table) {
            Schema::create($table, function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->json('address');
                $table->decimal('price', 8, 2);
                $table->string('currency', 3);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::dropIfExists($table);
        }
        Schema::dropIfExists('orders');
    }
};
