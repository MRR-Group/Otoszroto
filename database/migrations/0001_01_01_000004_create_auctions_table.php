<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("auctions", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->string("photo_url");
            $table->float("price");
            $table->foreignId("owner_id")->constrained("users","id");
            $table->foreignId("model_id")->constrained("car_models","id");
            $table->foreignId("category_id")->constrained("categories","id");
            $table->foreignId("condition_id")->constrained("conditions","id");
            $table->foreignId("auction_state_id")->constrained("auction_states","id");
        });

        Schema::create("car_models", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->foreignId("brand_id")->constrained("brands","id");
        });

        Schema::create("brands", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
        });

        Schema::create("categories", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
        });

        Schema::create("conditions", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
        });

        Schema::create("auction_states", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("auctions");
        Schema::dropIfExists("car_models");
        Schema::dropIfExists("brands");
        Schema::dropIfExists("categories");
        Schema::dropIfExists("conditions");
        Schema::dropIfExists("auction_states");
    }
};