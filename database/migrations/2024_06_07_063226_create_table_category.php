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
            Schema::create('customers', function (Blueprint $table) {
                $table->id('customers_id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email');
                $table->string('phone');
                $table->dateTime('date_created')->useCurrent();
                $table->timestamps();
            });
       
            Schema::create('categories', function (Blueprint $table) {
                $table->id('categories_id');
                $table->string('categories_name');
                $table->longText('description');
                $table->timestamps();
            });
            Schema::create('products', function (Blueprint $table) {
                $table->id('products_id');
                $table->string('product_name');
                $table->text('description');
                $table->float('price');
                $table->integer('category_id');
                $table->integer('stock_quantity');
                $table->timestamps();
            });
            Schema::create('product_images', function (Blueprint $table) {
                $table->id('image_id');
                $table->integer('product_id');
                $table->string('image_url');
                $table->timestamps();
            });
            Schema::create('employees', function (Blueprint $table) {
                $table->id('employees_id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('position');
                $table->string('email');
                $table->timestamps();
            });

            Schema::create('orders', function (Blueprint $table) {
                $table->id('orders_id');
                $table->integer('customers_id');
                $table->integer('orders_status_id');
                $table->dateTime('order_date')->useCurrent();
                $table->float('total');
                $table->timestamps();
            });
            Schema::create('order_details', function (Blueprint $table) {
                $table->id('order_details_id');
                $table->integer('orders_id');
                $table->integer('products_id');
                $table->integer('quantity');
                $table->float('price');
                $table->timestamps();
            });
            Schema::create('order_statuses', function (Blueprint $table) {
                $table->id('order_statuses_id');
                $table->string('status');
                $table->timestamps();
            });

            Schema::create('payment_methods', function (Blueprint $table) {
                $table->id('payment_methods_id');
                $table->string('method_name');
                $table->timestamps();
            });
            Schema::create('provinces', function (Blueprint $table) {
                $table->id('provinces_id');
                $table->string('provinces_name');
                $table->string('country');
                $table->timestamps();
            });
            Schema::create('roles', function (Blueprint $table) {
                $table->id('roles_id');
                $table->string('role_name');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_category');
    }
};