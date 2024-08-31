<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoCallController extends Controller
{
    public function  index($id)
    {
        return Inertia::render('VideoCall', [
            'user' => User::query()->find($id),
        ]);
    }
}
