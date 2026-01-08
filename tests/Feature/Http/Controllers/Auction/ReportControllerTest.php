<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auction;

use App\Actions\Auction\CreateReportAction;
use App\Actions\Auction\ResolveReportAction;
use App\Enums\AuctionState;
use App\Enums\Condition;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ReportControllerTest extends TestCase
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

    private function makeAuction(User $owner): Auction
    {
        $brand = Brand::query()->create(['name' => 'FSO']);
        $model = CarModel::query()->create(['name' => 'Polonez', 'brand_id' => $brand->id]);
        $category = Category::query()->create(['name' => 'Wnętrze']);

        return Auction::query()->create([
            'name' => 'A1',
            'description' => 'D1',
            'city' => 'C1',
            'price' => 10.00,
            'owner_id' => $owner->id,
            'model_id' => $model->id,
            'category_id' => $category->id,
            'condition' => Condition::FAIR_CONDITION,
            'auction_state' => AuctionState::ACTIVE,
        ]);
    }

    public function test_report_create_requires_auth(): void
    {
        $owner = $this->makeUser('o@example.com', '111111111');
        $auction = $this->makeAuction($owner);

        $response = $this->get(route('auctions.report.create', ['auction' => $auction->id]));

        $response->assertRedirect(route('login'));
    }

    public function test_report_create_renders_for_authenticated_user(): void
    {
        $owner = $this->makeUser('o@example.com', '111111111');
        $reporter = $this->makeUser('r@example.com', '222222222');
        $auction = $this->makeAuction($owner);

        $response = $this->actingAs($reporter)->get(route('auctions.report.create', ['auction' => $auction->id]));

        $response->assertOk();

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Auction/ReportAuction')
            ->where('auction.id', $auction->id)
        );
    }

    public function test_user_cannot_report_own_auction(): void
    {
        $owner = $this->makeUser('o@example.com', '111111111');
        $auction = $this->makeAuction($owner);

        $response = $this->actingAs($owner)->post(route('auctions.report.store', ['auction' => $auction->id]), [
            'reason' => 'x',
        ]);

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Nie można zgłosić własnej aukcji.');
    }

    public function test_user_cannot_report_same_auction_twice(): void
    {
        $owner = $this->makeUser('o@example.com', '111111111');
        $reporter = $this->makeUser('r@example.com', '222222222');
        $auction = $this->makeAuction($owner);

        Report::query()->create([
            'reporter_id' => $reporter->id,
            'auction_id' => $auction->id,
            'reason' => 'x',
            'resolved_at' => null,
        ]);

        $response = $this->actingAs($reporter)->post(route('auctions.report.store', ['auction' => $auction->id]), [
            'reason' => 'y',
        ]);

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Aukcja została już przez Ciebie zgłoszona.');
    }

    public function test_store_creates_report_via_action(): void
    {
        $owner = $this->makeUser('o@example.com', '111111111');
        $reporter = $this->makeUser('r@example.com', '222222222');
        $auction = $this->makeAuction($owner);

        $this->mock(CreateReportAction::class, function ($mock): void {
            $mock->shouldReceive('execute')->once();
        });

        $response = $this->actingAs($reporter)->post(route('auctions.report.store', ['auction' => $auction->id]), [
            'reason' => 'x',
        ]);

        $response->assertRedirect(route('auctions.show', ['auction' => $auction->id]));
        $response->assertSessionHas('message', 'Aukcja została zgłoszona.');
    }

    public function test_reports_index_requires_auth(): void
    {
        $response = $this->get(route('reports.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_reports_show_requires_auth(): void
    {
        $owner = $this->makeUser('o@example.com', '111111111');
        $reporter = $this->makeUser('r@example.com', '222222222');
        $auction = $this->makeAuction($owner);

        $report = Report::query()->create([
            'reporter_id' => $reporter->id,
            'auction_id' => $auction->id,
            'reason' => 'x',
            'resolved_at' => null,
        ]);

        $response = $this->get(route('reports.show', ['report' => $report->id]));

        $response->assertRedirect(route('login'));
    }

    public function test_reports_resolve_requires_auth(): void
    {
        $owner = $this->makeUser('o@example.com', '111111111');
        $reporter = $this->makeUser('r@example.com', '222222222');
        $auction = $this->makeAuction($owner);

        $report = Report::query()->create([
            'reporter_id' => $reporter->id,
            'auction_id' => $auction->id,
            'reason' => 'x',
            'resolved_at' => null,
        ]);

        $response = $this->get(route('reports.resolve', ['report' => $report->id]));

        $response->assertRedirect(route('login'));
    }

    public function test_reports_resolve_calls_action_and_redirects_to_show(): void
    {
        $owner = $this->makeUser('o@example.com', '111111111');
        $reporter = $this->makeUser('r@example.com', '222222222');
        $auction = $this->makeAuction($owner);

        $report = Report::query()->create([
            'reporter_id' => $reporter->id,
            'auction_id' => $auction->id,
            'reason' => 'x',
            'resolved_at' => null,
        ]);

        $this->mock(ResolveReportAction::class, function ($mock) use ($report): void {
            $mock->shouldReceive('execute')->once()->andReturn($report);
        });

        $response = $this->actingAs($reporter)->get(route('reports.resolve', ['report' => $report->id]));

        $response->assertRedirect(route('reports.show', ['report' => $report->id]));
        $response->assertSessionHas('message', 'Zgłoszenie zostało rozwiązane.');
    }
}
