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
        // Si la tabla NO existe, se crea completa
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable'); // notifiable_type, notifiable_id
                $table->json('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
            return;
        }

        // Si la tabla existe, verificar columnas faltantes
        Schema::table('notifications', function (Blueprint $table) {
            
            if (!Schema::hasColumn('notifications', 'type')) {
                $table->string('type')->after('id');
            }

            if (!Schema::hasColumn('notifications', 'notifiable_type')) {
                $table->string('notifiable_type')->after('type');
            }

            if (!Schema::hasColumn('notifications', 'notifiable_id')) {
                // Si tus usuarios son int, deja unsignedBigInteger
                $table->unsignedBigInteger('notifiable_id')->after('notifiable_type');
            }

            if (!Schema::hasColumn('notifications', 'data')) {
                $table->json('data')->after('notifiable_id');
            }

            if (!Schema::hasColumn('notifications', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('data');
            }

            if (!Schema::hasColumn('notifications', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('read_at');
            }

            if (!Schema::hasColumn('notifications', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
