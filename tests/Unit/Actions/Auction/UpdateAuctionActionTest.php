<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auction;

use App\Actions\Auction\UpdateAuctionAction;
use App\Enums\AuctionState;
use App\Enums\Condition;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateAuctionActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_auction_fields_and_persists(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $brand = Brand::query()->create(['name' => 'FSO']);
        $model1 = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);
        $model2 = CarModel::query()->create(['name' => '125p', 'brand_id' => $brand->id]);
        $category1 = Category::query()->create(['name' => 'Wnętrze']);
        $category2 = Category::query()->create(['name' => 'Silnik']);

        $auction = Auction::query()->create([
            'name' => 'Old',
            'description' => 'Old desc',
            'city' => 'Old city',
            'price' => 10.00,
            'owner_id' => $user->id,
            'model_id' => $model1->id,
            'category_id' => $category1->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        $data = [
            'name' => 'New',
            'description' => 'New desc',
            'price' => 99.99,
            'model_id' => $model2->id,
            'category_id' => $category2->id,
            'condition' => Condition::BRAND_NEW,
        ];

        $action = new UpdateAuctionAction();
        $result = $action->execute($auction, $data);

        $this->assertSame('New', $result->name);
        $this->assertSame('New desc', $result->description);
        $this->assertSame(99.99, $result->price);
        $this->assertSame($model2->id, $result->model_id);
        $this->assertSame($category2->id, $result->category_id);
        $this->assertSame(Condition::BRAND_NEW, $result->condition);

        $this->assertDatabaseHas('auctions', [
            'id' => $auction->id,
            'name' => 'New',
            'description' => 'New desc',
            'price' => 99.99,
            'model_id' => $model2->id,
            'category_id' => $category2->id,
            'condition' => Condition::BRAND_NEW->value,
        ]);
    }
}
