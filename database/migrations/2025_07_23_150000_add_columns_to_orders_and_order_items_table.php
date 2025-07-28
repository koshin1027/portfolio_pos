<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'number')) {
                $table->string('number')->nullable()->after('id');
            }

            // ステータスはコメントアウト中なので無視
            // if (!Schema::hasColumn('orders', 'status')) {
            //     $table->string('status')->nullable()->after('number');
            // }
        });

        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('order_items', 'menu_id')) {
                $table->unsignedBigInteger('menu_id')->nullable()->after('order_id');
            }
            if (!Schema::hasColumn('order_items', 'quantity')) {
                $table->integer('quantity')->nullable()->after('menu_id');
            }
            if (!Schema::hasColumn('order_items', 'price')) {
                $table->integer('price')->nullable()->after('quantity');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // カラムが存在するか確認してから削除（エラー防止）
            if (Schema::hasColumn('orders', 'number')) {
                $table->dropColumn('number');
            }
            if (Schema::hasColumn('orders', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'order_id')) {
                $table->dropColumn('order_id');
            }
            if (Schema::hasColumn('order_items', 'menu_id')) {
                $table->dropColumn('menu_id');
            }
            if (Schema::hasColumn('order_items', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('order_items', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};
