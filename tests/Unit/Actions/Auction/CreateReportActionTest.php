<?php

declare(strict_types=1);

namespace Tests\Unit\Auction;

use App\Actions\Auction\CreateReportAction;
use App\Enums\AuctionState;
use App\Enums\Condition;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateReportActionTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesReportAndAssociatesUserAndAuction(): void
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

        $auction = Auction::query()->create([
            "name" => "A1",
            "description" => "D1",
            "city" => "C1",
            "price" => 10.00,
            "owner_id" => $user->id,
            "model_id" => $model->id,
            "category_id" => $category->id,
            "condition" => Condition::FAIR_CONDITION,
            "auction_state" => AuctionState::ACTIVE,
        ]);

        $action = new CreateReportAction();
        $report = $action->execute($user, $auction, ["reason" => "Test reason"]);

        $this->assertInstanceOf(Report::class, $report);
        $this->assertSame($user->id, $report->reporter_id);
        $this->assertSame($auction->id, $report->auction_id);

        $this->assertDatabaseHas("reports", [
            "id" => $report->id,
            "reporter_id" => $user->id,
            "auction_id" => $auction->id,
            "reason" => "Test reason",
        ]);
    }
}
