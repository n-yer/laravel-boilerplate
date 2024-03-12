<?php

namespace App\Http\Controllers\Frontend\User;
use App\Domains\Auth\Services\UserService;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(UserService $userService)
    {
        // Count of all users
        $userCount = $userService->getCount();
        $userCountByType = $userService->getCountByType();
        $usersByDate = $userService->getUsersByDate();
        return view('frontend.user.dashboard', compact('userCount','userCountByType','usersByDate'));
        // return view('frontend.user.dashboard');
    }
}
