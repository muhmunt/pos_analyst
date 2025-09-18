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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // admin, manager, cashier
            $table->string('display_name');
            $table->text('permissions')->nullable(); // JSON encoded permissions
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'permissions' => json_encode(['*']), // All permissions
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'permissions' => json_encode([
                    'view_reports', 'generate_reports', 'view_products',
                    'create_products', 'view_transactions', 'create_transactions',
                    'view_users'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'cashier',
                'display_name' => 'Cashier',
                'permissions' => json_encode([
                    'view_products', 'create_transactions', 'view_own_transactions'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
