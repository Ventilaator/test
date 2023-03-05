<?php

namespace App\Http\Requests;

use App\Models\Stop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class StopsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function handle(Stop $stop = null): Collection|array
    {
        if ($stop) {
            $routes = $stop->routes()->with('stops')->whereHas('stops', function ($query) use (&$stop) {
                $query->where('route_stop.stop_id', $stop->id);
                $query->orderBy('sort_order');
            })->get();

            return collect($routes)->map(function ($route) {
                return [
                    'route_name' => $route->name,
                    'stops' => $route->stops->toArray()
                ];
            })->values()->all();
        }

        return Stop::all();
    }
}
