<?php

namespace App\Http\Controllers;

use App\Http\Requests\StopsRequest;
use App\Models\Stop;
use Illuminate\Http\Request;

class StopController extends Controller
{
    public function stops(StopsRequest $request, Stop $stop = null)
    {
        return $request->handle($stop);
    }
}
