<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Otoszroto\Models\Auction;
use Otoszroto\Models\User;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("reports", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class, "reporter_id")->constrained("users")->cascadeOnDelete();
            $table->foreignIdFor(Auction::class, "auction_id")->constrained("auctions")->cascadeOnDelete();
            $table->text("reason")->nullable();
            $table->timestamp("resolved_at")->nullable();
            $table->timestamps();
            $table->unique(["reporter_id", "auction_id"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("reports");
    }
};
