<?php

namespace App\Controllers\Client;

use App\Models\BlockedUser;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;

class UserController extends Controller
{
    public function blockUser(Request $request)
    {
        $blockedUserId = $request->input('user_id');
        $userId = session()->get('user')->id;
        BlockedUser::create([
            'blocked_by_user_id' => $userId,
            'blocked_user_id' => $blockedUserId
        ]);
    }
}
