<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Welcome;

use App\Enums\AuctionState;
use App\Enums\Condition;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class WelcomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_renders_with_three_latest_active_auctions(): void
    {
        $owner = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '123123123',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $brand = Brand::query()->create(['name' => 'FSO']);
        $model = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);
        $category = Category::query()->create(['name' => 'Wnętrze']);

        $activeOld = Auction::query()->create([
            'name' => 'Old Active',
            'description' => 'D',
            'city' => 'C',
            'price' => 10.00,
            'owner_id' => $owner->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        $activeMid = Auction::query()->create([
            'name' => 'Mid Active',
            'description' => 'D',
            'city' => 'C',
            'price' => 20.00,
            'owner_id' => $owner->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        $activeNew = Auction::query()->create([
            'name' => 'New Active',
            'description' => 'D',
            'city' => 'C',
            'price' => 30.00,
            'owner_id' => $owner->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'Inactive',
            'description' => 'D',
            'city' => 'C',
            'price' => 999.00,
            'owner_id' => $owner->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::CANCELLED,
        ]);

        Auction::query()->whereKey($activeOld->id)->update([
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(3),
        ]);

        Auction::query()->whereKey($activeMid->id)->update([
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        Auction::query()->whereKey($activeNew->id)->update([
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('auctions', 3)
            ->where('auctions.0.id', $activeNew->id)
            ->where('auctions.1.id', $activeMid->id)
            ->where('auctions.2.id', $activeOld->id)
        );
    }
}
