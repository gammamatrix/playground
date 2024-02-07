<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            // IDs
            $table->uuid('id')->primary();

            $table->uuid('created_id')->nullable()->index();
            $table->uuid('modified_id')->nullable()->index();

            // Date columns

            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();

            // Status

            $table->softDeletes();

            $table->tinyInteger('active')->unsigned()->index()->default(0);
            $table->tinyInteger('banned')->unsigned()->index()->default(0);
            $table->tinyInteger('closed')->unsigned()->index()->default(0);
            $table->tinyInteger('flagged')->unsigned()->index()->default(0);
            $table->tinyInteger('internal')->unsigned()->index()->default(0);
            $table->tinyInteger('locked')->unsigned()->index()->default(0);

            // UI

            $table->string('style', 128)->default('');
            $table->string('klass', 128)->default('');
            $table->string('icon', 128)->default('');

            // Entity columns

            $table->string('name')->default('');
            $table->string('email')->unique();
            $table->string('password')->default('');
            $table->string('phone')->default('');
            $table->string('locale')->default('');
            $table->string('timezone')->default('');

            $table->rememberToken();

            $table->string('role')->default('');

            // A link to the external source of the page.
            $table->string('url', 512)->default('');

            // Description is an internal field.
            $table->string('description', 512)->default('');

            $table->string('image', 512)->default('');
            $table->string('avatar', 512)->default('');

            // The introduction should be the first 255 characters or less of the content.
            // The introduction is visible to the client. No HTML.
            $table->string('introduction', 512)->default('');

            // The HTML content of the page.
            $table->mediumText('content')->nullable();

            // The summary of the content, HTML allowed, to be shown to the client.
            $table->mediumText('summary')->nullable();

            $table->json('accounts')
                ->default(new Expression('(JSON_OBJECT())'))
                ->comment('Versioned JSON object');
            $table->json('address')
                ->default(new Expression('(JSON_OBJECT())'))
                ->comment('Versioned JSON object');
            $table->json('meta')
                ->default(new Expression('(JSON_OBJECT())'))
                ->comment('Versioned JSON object');
            $table->json('notes')
                ->default(new Expression('(JSON_ARRAY())'))
                ->comment('JSON array of strings');
            $table->json('options')
                ->default(new Expression('(JSON_OBJECT())'))
                ->comment('Versioned JSON object');
            $table->json('registration')
                ->default(new Expression('(JSON_ARRAY())'))
                ->comment('JSON array of strings');
            $table->json('roles')
                ->default(new Expression('(JSON_ARRAY())'))
                ->comment('JSON array of strings');
            $table->json('permissions')
                ->default(new Expression('(JSON_ARRAY())'))
                ->comment('JSON array of strings');
            $table->json('privileges')
                ->default(new Expression('(JSON_ARRAY())'))
                ->comment('JSON array of strings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
