<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Otoszroto\Models\Brand;
use Otoszroto\Models\CarModel;
use Otoszroto\Models\Category;
use Otoszroto\Models\Condition;
use Otoszroto\Models\User;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("brands", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("categories", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("conditions", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("auction_states", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("car_models", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create("auctions", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->string("photo_url");
            $table->float("price");
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(CarModel::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Condition::class)->constrained()->cascadeOnDelete();
            $table->string("auction_state");
            $table->foreign("auction_state")->references("name")->on("auction_states")->cascadeOnDelete();
            $table->timestamps();
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
