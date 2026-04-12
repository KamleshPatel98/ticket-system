<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TestController extends Controller
{
    public function test(Request $request) {
        if (!Gate::allows('assign-ticket')) {
            abort(403);
        }
    }
}
