<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auction;

use App\Actions\Auction\CreateAuctionAction;
use App\Enums\AuctionState;
use App\Enums\Condition;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAuctionActionTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesAuctionForUserSetsActiveStateAndPersists(): void
    {
        $user = User::query()->create([
            "firstname" => "Jan",
            "surname" => "Kowalski",
            "phone" => "123123123",
            "email" => "jan@example.com",
            "password" => "password123",
        ]);

        $brand = Brand::query()->create(["name" => "FSO"]);
        $model = CarModel::query()->create(["name" => "Polonez", "brand_id" => $brand->id]);
        $category = Category::query()->create(["name" => "Wnętrze"]);

        $data = [
            "name" => "A1",
            "description" => "D1",
            "city" => "C1",
            "price" => 10.00,
            "model_id" => $model->id,
            "category_id" => $category->id,
            "condition" => Condition::FAIR_CONDITION,
        ];

        $action = new CreateAuctionAction();
        $auction = $action->execute($user, $data);

        $this->assertInstanceOf(Auction::class, $auction);
        $this->assertSame($user->id, $auction->owner_id);
        $this->assertSame(AuctionState::ACTIVE, $auction->auction_state);

        $this->assertDatabaseHas("auctions", [
            "id" => $auction->id,
            "owner_id" => $user->id,
            "name" => "A1",
            "city" => "C1",
            "model_id" => $model->id,
            "category_id" => $category->id,
            "condition" => Condition::FAIR_CONDITION->value,
            "auction_state" => AuctionState::ACTIVE->value,
        ]);
    }
}
