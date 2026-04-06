<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['posts', 'products', 'projects', 'categories'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->string('meta_title')->nullable();
                $blueprint->text('meta_description')->nullable();
                $blueprint->string('meta_keywords')->nullable();
            });
        }
    }

    public function down(): void
    {
        $tables = ['posts', 'products', 'projects', 'categories'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn(['meta_title', 'meta_description', 'meta_keywords']);
            });
        }
    }
};
