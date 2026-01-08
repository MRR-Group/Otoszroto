<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auction;

use App\Actions\Auction\ResolveReportAction;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResolveReportActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sets_resolved_at_and_persists(): void
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
            'condition' => \App\Enums\Condition::FAIR_CONDITION,
            'auction_state' => \App\Enums\AuctionState::ACTIVE,
        ]);

        $report = Report::query()->create([
            'reporter_id' => $user->id,
            'auction_id' => $auction->id,
            'reason' => 'x',
            'resolved_at' => null,
        ]);

        $action = new ResolveReportAction();
        $result = $action->execute($report);

        $this->assertNotNull($result->resolved_at);
        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
        ]);
    }
}
