<?php

namespace Pro\Support\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_support_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('status', 50)->nullable();
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->integer('display_order')->nullable()->default(0);
            $table->integer('image_id')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->unsignedInteger('views')->nullable()->default(0);
            $table->unsignedBigInteger('author_id')->nullable();
            $table->softDeletes();

            $table->index(['cat_id']);
            $table->timestamps();
        });
        Schema::create('bc_support_topic_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_id');
            $table->string('locale');

            $table->string('title')->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });

        Schema::create('bc_support_topic_cats', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('status', 50)->nullable();
            $table->integer('display_order')->nullable()->default(0);
            $table->bigInteger('image_id')->nullable();
            $table->softDeletes();

            $table->nestedSet();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });
        Schema::create('bc_support_topic_cat_translations', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('origin_id');
            $table->string('locale');
            $table->string('name', 255)->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });

        Schema::create('bc_support_topic_tags', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('status', 50)->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });

        Schema::create('bc_support_topic_tag_relation', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('target_id');
            $table->unsignedBigInteger('tag_id');

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });

        Schema::create('bc_support_tickets', function (Blueprint $table) {
            $table->id('id');
            $table->string('title', 255)->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->string('status', 255)->nullable();
            $table->unsignedBigInteger('last_reply_by')->nullable();
            $table->timestamp('last_reply_at')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamp('closed_at')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bc_support_ticket_categories', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('status', 50)->nullable();
            $table->integer('display_order')->nullable()->default(0);
            $table->nestedSet();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('bc_support_ticket_category_translation', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('origin_id');
            $table->string('locale');
            $table->string('name')->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });

        Schema::create('bc_support_ticket_replies', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content')->nullable();
            $table->string('status')->nullable()->default('publish');

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });


        if (!Schema::hasTable('support_user_notes')) {
            Schema::create('support_user_notes', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->text('content')->nullable();
                $table->bigInteger('user_id')->nullable();

                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bc_support_topics');
        Schema::dropIfExists('bc_support_topic_translations');
        Schema::dropIfExists('bc_support_topic_cats');
        Schema::dropIfExists('bc_support_topic_translations');
        Schema::dropIfExists('bc_support_topic_tags');
        Schema::dropIfExists('bc_support_topic_tag_relation');
        Schema::dropIfExists('bc_support_tickets');
        Schema::dropIfExists('bc_support_ticket_replies');
        Schema::dropIfExists('bc_support_ticket_categories');
        Schema::dropIfExists('support_user_notes');

    }
};
