<?php

namespace Tests\Feature;

use App\Models\Route;
use App\Models\Stop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StopsTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_it_can_get_all_stops()
    {
        $response = $this->getJson(route('api.stops'));

        $response->assertJson(
            Stop::all()->toArray()
        );
    }

    public function test_it_can_get_available_route_stops_for_this_stop()
    {
        $stop = Stop::find(1);

        $response = $this->getJson(route('api.stops', $stop));

        $route_ids = DB::table('route_stop')->where(['stop_id' => $stop->id])->pluck('route_id');
        $route_stops = Route::whereIn('id', $route_ids)->with('stops')->get();

        $available_routes = [];

        foreach ($route_stops as $route) {
            $available_routes[] = [
                'route_name' => $route->name,
                'stops' => $route->stops->sortBy('sort_order')->toArray(),
            ];
        }

        $response->assertJson($available_routes);
    }
}
