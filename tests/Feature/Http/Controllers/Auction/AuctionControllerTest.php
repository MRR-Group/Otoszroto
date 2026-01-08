<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auction;

use App\Actions\Auction\AddImageToAuctionAction;
use App\Actions\Auction\CancelAuctionAction;
use App\Actions\Auction\CreateAuctionAction;
use App\Actions\Auction\FinishAuctionAction;
use App\Actions\Auction\GetAuctionImageAction;
use App\Actions\Auction\GetDefaultAuctionImageAction;
use App\Actions\Auction\UpdateAuctionAction;
use App\Enums\AuctionState;
use App\Enums\Condition;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AuctionControllerTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $email, string $phone): User
    {
        return User::query()->create([
            'firstname' => 'Jan',
            'surname' => 'Kowalski',
            'phone' => $phone,
            'email' => $email,
            'password' => 'password123',
        ]);
    }

    private function makeBrandModelCategory(): array
    {
        $brand = Brand::query()->create(['name' => 'FSO']);
        $model = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);
        $category = Category::query()->create(['name' => 'Wnętrze']);

        return [$brand, $model, $category];
    }

    private function makeAuction(User $owner, CarModel $model, Category $category, array $overrides = []): Auction
    {
        return Auction::query()->create(array_merge([
            'name' => 'A1',
            'description' => 'D1',
            'city' => 'C1',
            'price' => 10.00,
            'owner_id' => $owner->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ], $overrides));
    }

    public function test_create_page_requires_auth(): void
    {
        $response = $this->get(route('auctions.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_create_page_renders_for_authenticated_user(): void
    {
        $user = $this->makeUser('u1@example.com', '111111111');
        [$brand, $model, $category] = $this->makeBrandModelCategory();

        $response = $this->actingAs($user)->get(route('auctions.create'));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auction/CreateAuction')
            ->has('categories')
            ->has('models')
            ->has('brands')
        );
    }

    public function test_show_page_renders_for_anyone(): void
    {
        $user = $this->makeUser('u1@example.com', '111111111');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($user, $model, $category);

        $response = $this->get(route('auctions.show', ['auction' => $auction->id]));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auction/ShowAuction')
            ->where('auction.id', $auction->id)
        );
    }

    public function test_edit_requires_auth(): void
    {
        $user = $this->makeUser('u1@example.com', '111111111');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($user, $model, $category);

        $response = $this->get(route('auctions.edit', ['auction' => $auction->id]));

        $response->assertRedirect(route('login'));
    }

    public function test_owner_can_open_edit_page(): void
    {
        $user = $this->makeUser('u1@example.com', '111111111');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($user, $model, $category);

        $response = $this->actingAs($user)->get(route('auctions.edit', ['auction' => $auction->id]));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auction/EditAuction')
            ->where('auction.id', $auction->id)
            ->has('categories')
            ->has('models')
            ->has('brands')
        );
    }

    public function test_non_owner_cannot_open_edit_page(): void
    {
        $owner = $this->makeUser('u1@example.com', '111111111');
        $other = $this->makeUser('u2@example.com', '222222222');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($owner, $model, $category);

        $response = $this->actingAs($other)->get(route('auctions.edit', ['auction' => $auction->id]));

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Nie możesz edytować cudzych aukcji');
    }

    public function test_update_requires_owner(): void
    {
        $owner = $this->makeUser('u1@example.com', '111111111');
        $other = $this->makeUser('u2@example.com', '222222222');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($owner, $model, $category);

        $payload = [
            'name' => 'Zmieniona',
        ];

        $response = $this->actingAs($other)->patch(route('auctions.update', ['auction' => $auction->id]), $payload);

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Nie możesz edytować cudzych aukcji');
    }

    public function test_update_calls_action_and_redirects_to_show(): void
    {
        $owner = $this->makeUser('u1@example.com', '111111111');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($owner, $model, $category);

        $this->mock(UpdateAuctionAction::class, function ($mock) use ($auction): void {
            $mock->shouldReceive('execute')->once()->andReturn($auction);
        });

        $payload = [
            'name' => 'Zmieniona',
        ];

        $response = $this->actingAs($owner)->patch(route('auctions.update', ['auction' => $auction->id]), $payload);

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Aukcja została edytowana.');
    }

    public function test_finish_requires_owner(): void
    {
        $owner = $this->makeUser('u1@example.com', '111111111');
        $other = $this->makeUser('u2@example.com', '222222222');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($owner, $model, $category);

        $response = $this->actingAs($other)->patch(route('auctions.finish', ['auction' => $auction->id]));

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Nie możesz edytować cudzych aukcji');
    }

    public function test_finish_calls_action_and_redirects_to_show(): void
    {
        $owner = $this->makeUser('u1@example.com', '111111111');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($owner, $model, $category);

        $this->mock(FinishAuctionAction::class, function ($mock) use ($auction): void {
            $mock->shouldReceive('execute')->once()->andReturn($auction);
        });

        $response = $this->actingAs($owner)->patch(route('auctions.finish', ['auction' => $auction->id]));

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Aukcja została zakończona.');
    }

    public function test_cancel_requires_owner(): void
    {
        $owner = $this->makeUser('u1@example.com', '111111111');
        $other = $this->makeUser('u2@example.com', '222222222');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($owner, $model, $category);

        $response = $this->actingAs($other)->patch(route('auctions.cancel', ['auction' => $auction->id]));

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Nie możesz edytować cudzych aukcji');
    }

    public function test_cancel_calls_action_and_redirects_to_show(): void
    {
        $owner = $this->makeUser('u1@example.com', '111111111');
        [, $model, $category] = $this->makeBrandModelCategory();
        $auction = $this->makeAuction($owner, $model, $category);

        $this->mock(CancelAuctionAction::class, function ($mock) use ($auction): void {
            $mock->shouldReceive('execute')->once()->andReturn($auction);
        });

        $response = $this->actingAs($owner)->patch(route('auctions.cancel', ['auction' => $auction->id]));

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Aukcja została anulowana.');
    }

    public function test_index_shows_only_active_auctions_and_can_filter_by_category_brand_model_condition_and_price(): void
    {
        $owner = $this->makeUser('u1@example.com', '111111111');
        $otherOwner = $this->makeUser('u2@example.com', '222222222');

        $brand1 = Brand::query()->create(['name' => 'FSO']);
        $brand2 = Brand::query()->create(['name' => 'Fiat']);

        $model1 = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand1->id]);
        $model2 = CarModel::query()->create(['name' => 'Punto', 'brand_id' => $brand2->id]);

        $cat1 = Category::query()->create(['name' => 'Wnętrze']);
        $cat2 = Category::query()->create(['name' => 'Silnik']);

        $target = Auction::query()->create([
            'name' => 'Target',
            'description' => 'D',
            'city' => 'C',
            'price' => 50.00,
            'owner_id' => $owner->id,
            'model_id' => $model1->id,
            'category_id' => $cat1->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'WrongCategory',
            'description' => 'D',
            'city' => 'C',
            'price' => 50.00,
            'owner_id' => $owner->id,
            'model_id' => $model1->id,
            'category_id' => $cat2->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'WrongBrand',
            'description' => 'D',
            'city' => 'C',
            'price' => 50.00,
            'owner_id' => $owner->id,
            'model_id' => $model2->id,
            'category_id' => $cat1->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'WrongCondition',
            'description' => 'D',
            'city' => 'C',
            'price' => 50.00,
            'owner_id' => $otherOwner->id,
            'model_id' => $model1->id,
            'category_id' => $cat1->id,
            'condition' => Condition::BRAND_NEW,
            'auction_state' => AuctionState::ACTIVE,
        ]);

        Auction::query()->create([
            'name' => 'Inactive',
            'description' => 'D',
            'city' => 'C',
            'price' => 50.00,
            'owner_id' => $owner->id,
            'model_id' => $model1->id,
            'category_id' => $cat1->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::CANCELLED,
        ]);

        $response = $this->get(route('auctions.index', [
            'category' => $cat1->id,
            'brand' => $brand1->id,
            'model' => $model1->id,
            'condition' => Condition::FAIR_CONDITION->value,
            'price_min' => 10,
            'price_max' => 100,
            'per_page' => 10,
        ]));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auction/Auctions')
            ->has('auctions.data', 1)
            ->where('auctions.data.0.id', $target->id)
            ->has('categories')
            ->has('models')
            ->has('brands')
        );
    }

    public function test_get_image_returns_default_when_auction_image_is_missing(): void
    {
        $default = "\x89PNG\r\n\x1a\n" . 'default';

        $this->mock(GetAuctionImageAction::class, function ($mock): void {
            $mock->shouldReceive('execute')->once()->andReturn(null);
        });

        $this->mock(GetDefaultAuctionImageAction::class, function ($mock) use ($default): void {
            $mock->shouldReceive('execute')->once()->andReturn($default);
        });

        $response = $this->get(route('auction.image.show', ['id' => 999]));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/png');
        $response->assertHeader('Cache-Control', 'max-age=31536000, public');
        $this->assertSame($default, $response->getContent());
    }
}
