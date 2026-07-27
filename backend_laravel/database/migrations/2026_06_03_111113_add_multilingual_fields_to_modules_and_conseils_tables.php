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
            $table->string('title_fr')->nullable()->after('title');
            $table->string('title_mg')->nullable()->after('title_fr');

            $table->text('description_fr')->nullable()->after('description');
            $table->text('description_mg')->nullable()->after('description_fr');

            $table->longText('content_fr')->nullable()->after('content');
            $table->longText('content_mg')->nullable()->after('content_fr');
        });

        DB::table('module_educatifs')->update([
            'title_fr' => DB::raw('title'),
            'description_fr' => DB::raw('description'),
            'content_fr' => DB::raw('content'),
        ]);

        Schema::table('conseils', function (Blueprint $table) {
            $table->string('title_fr')->nullable()->after('title');
            $table->string('title_mg')->nullable()->after('title_fr');

            $table->string('theme_fr')->nullable()->after('theme');
            $table->string('theme_mg')->nullable()->after('theme_fr');

            $table->longText('content_fr')->nullable()->after('content');
            $table->longText('content_mg')->nullable()->after('content_fr');
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
