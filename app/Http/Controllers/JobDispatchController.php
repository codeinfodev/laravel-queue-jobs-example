<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\EventMailJob;

class JobDispatchController extends Controller
{
    public function dispatchPostJob(Request $request){
        EventMailJob::dispatch()->onQueue('high');
        return redirect()->route('home')->withMessage('Job dispatched successfully');
    }
}
