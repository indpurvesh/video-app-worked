<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function authCandidate($userId)
    {
        if (null === $userId) {
            throw new \Exception("no candidate id provided");
        }
        $userModel = User::where('wp_id', $userId)->first();
        if (null === $userModel) {
            $userData = ['type' => 'candidate', 'wp_id' => $userId];
            $userModel = User::create($userData);
        }

        Auth::login($userModel);
    }

    public function authEmployer($userId)
    {
        if (null === $userId) {
            throw new \Exception("no employer id provided");
        }
        $userModel = User::where('wp_id', $userId)->first();
        if (null === $userModel) {
            $userData = ['type' => 'employer', 'wp_id' => $userId];
            $userModel = User::create($userData);
        }

        Auth::login($userModel);
    }
}