<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Seller;

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

class SellerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('seller.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_it_renders_seller_page_with_only_authenticated_users_auctions(): void
    {
        $user1 = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '111111111',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $user2 = User::query()->create([
            'firstname' => 'Ola',
            'surname' => 'Nowak',
            'phone' => '222222222',
            'email' => 'ola@example.com',
            'password' => 'password123',
        ]);

        $brand = Brand::query()->create(['name' => 'FSO']);
        $model = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);
        $category = Category::query()->create(['name' => 'Wnętrze']);

        $a1 = Auction::query()->create([
            'name' => 'A1',
            'description' => 'D1',
            'city' => 'C1',
            'price' => 10.00,
            'owner_id' => $user1->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'A2',
            'description' => 'D2',
            'city' => 'C2',
            'price' => 20.00,
            'owner_id' => $user2->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        $response = $this->actingAs($user1)->get(route('seller.index'));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auction/Seller')
            ->has('auctions.data', 1)
            ->where('auctions.data.0.id', $a1->id)
            ->has('categories')
            ->has('models')
            ->has('brands')
        );
    }

    public function test_it_filters_by_category(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '111111111',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $brand = Brand::query()->create(['name' => 'FSO']);
        $model = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);

        $cat1 = Category::query()->create(['name' => 'Wnętrze']);
        $cat2 = Category::query()->create(['name' => 'Silnik']);

        $a1 = Auction::query()->create([
            'name' => 'A1',
            'description' => 'D1',
            'city' => 'C1',
            'price' => 10.00,
            'owner_id' => $user->id,
            'model_id' => $model->id,
            'category_id' => $cat1->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'A2',
            'description' => 'D2',
            'city' => 'C2',
            'price' => 20.00,
            'owner_id' => $user->id,
            'model_id' => $model->id,
            'category_id' => $cat2->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        $response = $this->actingAs($user)->get(route('seller.index', ['category' => $cat1->id]));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->has('auctions.data', 1)
            ->where('auctions.data.0.id', $a1->id)
        );
    }

    public function test_it_filters_by_brand(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '111111111',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $brand1 = Brand::query()->create(['name' => 'FSO']);
        $brand2 = Brand::query()->create(['name' => 'Fiat']);

        $model1 = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand1->id]);
        $model2 = CarModel::query()->create(['name' => 'Punto', 'brand_id' => $brand2->id]);

        $category = Category::query()->create(['name' => 'Wnętrze']);

        $a1 = Auction::query()->create([
            'name' => 'A1',
            'description' => 'D1',
            'city' => 'C1',
            'price' => 10.00,
            'owner_id' => $user->id,
            'model_id' => $model1->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'A2',
            'description' => 'D2',
            'city' => 'C2',
            'price' => 20.00,
            'owner_id' => $user->id,
            'model_id' => $model2->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        $response = $this->actingAs($user)->get(route('seller.index', ['brand' => $brand1->id]));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->has('auctions.data', 1)
            ->where('auctions.data.0.id', $a1->id)
        );
    }

    public function test_it_filters_by_model(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '111111111',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $brand = Brand::query()->create(['name' => 'FSO']);
        $model1 = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);
        $model2 = CarModel::query()->create(['name' => '125p', 'brand_id' => $brand->id]);

        $category = Category::query()->create(['name' => 'Wnętrze']);

        $a1 = Auction::query()->create([
            'name' => 'A1',
            'description' => 'D1',
            'city' => 'C1',
            'price' => 10.00,
            'owner_id' => $user->id,
            'model_id' => $model1->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'A2',
            'description' => 'D2',
            'city' => 'C2',
            'price' => 20.00,
            'owner_id' => $user->id,
            'model_id' => $model2->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        $response = $this->actingAs($user)->get(route('seller.index', ['model' => $model1->id]));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->has('auctions.data', 1)
            ->where('auctions.data.0.id', $a1->id)
        );
    }

    public function test_it_filters_by_condition_status_and_price_range(): void
    {
        $user = User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => '111111111',
            'email' => 'jan@example.com',
            'password' => 'password123',
        ]);

        $brand = Brand::query()->create(['name' => 'FSO']);
        $model = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);
        $category = Category::query()->create(['name' => 'Wnętrze']);

        $a1 = Auction::query()->create([
            'name' => 'A1',
            'description' => 'D1',
            'city' => 'C1',
            'price' => 50.00,
            'owner_id' => $user->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'A2',
            'description' => 'D2',
            'city' => 'C2',
            'price' => 5.00,
            'owner_id' => $user->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::BRAND_NEW,
            'auction_state' => AuctionState::CANCELLED,
        ]);

        $response = $this->actingAs($user)->get(route('seller.index', [
            'condition' => Condition::FAIR_CONDITION->value,
            'status' => AuctionState::ACTIVE->value,
            'price_min' => 10,
            'price_max' => 100,
        ]));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->has('auctions.data', 1)
            ->where('auctions.data.0.id', $a1->id)
        );
    }
}
