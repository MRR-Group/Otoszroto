<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auction;

use App\Actions\Auction\CancelAuctionAction;
use App\Enums\AuctionState;
use App\Enums\Condition;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancelAuctionActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sets_auction_state_to_cancelled_and_persists(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $brand = Brand::query()->create(['name' => 'FSO']);
        $model = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);
        $category = Category::query()->create(['name' => 'Wnętrze']);

        $auction = Auction::query()->create([
            'name' => 'A1',
            'description' => 'D1',
            'city' => 'C1',
            'price' => 10.00,
            'owner_id' => $user->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        $action = new CancelAuctionAction();
        $result = $action->execute($auction);

        $this->assertSame(AuctionState::CANCELLED, $result->auction_state);
        $this->assertDatabaseHas('auctions', [
            'id' => $auction->id,
            'auction_state' => AuctionState::CANCELLED->value,
        ]);
    }
}
