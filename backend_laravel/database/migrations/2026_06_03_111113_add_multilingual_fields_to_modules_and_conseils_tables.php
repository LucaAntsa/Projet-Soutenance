<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('module_educatifs', function (Blueprint $table) {
            $table->string('title_fr')->nullable();
            $table->string('title_mg')->nullable();

            $table->text('description_fr')->nullable();
            $table->text('description_mg')->nullable();

            $table->longText('content_fr')->nullable();
            $table->longText('content_mg')->nullable();
        });

        DB::table('module_educatifs')->update([
            'title_fr' => DB::raw('title'),
            'description_fr' => DB::raw('description'),
            'content_fr' => DB::raw('content'),
        ]);

        Schema::table('conseils', function (Blueprint $table) {
            $table->string('title_fr')->nullable();
            $table->string('title_mg')->nullable();

            $table->string('theme_fr')->nullable();
            $table->string('theme_mg')->nullable();

            $table->longText('content_fr')->nullable();
            $table->longText('content_mg')->nullable();
        });

        DB::table('conseils')->update([
            'title_fr' => DB::raw('title'),
            'theme_fr' => DB::raw('theme'),
            'content_fr' => DB::raw('content'),
        ]);
    }

    public function down(): void
    {
        Schema::table('module_educatifs', function (Blueprint $table) {
            $table->dropColumn([
                'title_fr',
                'title_mg',
                'description_fr',
                'description_mg',
                'content_fr',
                'content_mg',
            ]);
        });

        Schema::table('conseils', function (Blueprint $table) {
            $table->dropColumn([
                'title_fr',
                'title_mg',
                'theme_fr',
                'theme_mg',
                'content_fr',
                'content_mg',
            ]);
        });
    }
};
