<?php

namespace App\Http\Controllers;

use App\Http\Traits\responseTrait;
use App\Jobs\ActiveUsersJob;
use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller
{
    use responseTrait ;

    public function index()
    {
        $users = User::with('documents')->get();
        return $this->customeResponse($users, 'users',200);
        // return response()->json(['message' => 'users with documents', 'data'=>$users], 200);
    }
}
