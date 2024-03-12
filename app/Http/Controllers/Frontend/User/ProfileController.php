<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Services\UserService;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;

/**
 * Class ProfileController.
 */
class ProfileController
{
    /**
     * @param  UpdateProfileRequest  $request
     * @param  UserService  $userService
     * @return mixed
     */
    public function update(UpdateProfileRequest $request, UserService $userService)
    {
        // Validate request data
        $validatedData = $request->validated();
    
        // Extract only the fields that are allowed to be updated
        $userData = array_intersect_key($validatedData, array_flip(['email', 'name']));
    
        // Check if image is present in the request
        if ($request->hasFile('image')) {
            // Validate image file
            $request->validate(['image' => 'image']);
    
            // Store the image
            $imagePath = $request->file('image')->store('images', 'public');
    
            // Add image path to the data to be updated
            $userData['image'] = $imagePath;
        }
    
        // Update the user profile
        $userService->updateProfile($request->user(), $userData);
    
        // Check if email verification resent
        if (session()->has('resent')) {
            return redirect()->route('frontend.auth.verification.notice')->withFlashInfo(__('You must confirm your new e-mail address before you can go any further.'));
        }
    
        // Redirect with success message
        return redirect()->route('frontend.user.account', ['#information'])->withFlashSuccess(__('Profile successfully updated.'));
    }
}
