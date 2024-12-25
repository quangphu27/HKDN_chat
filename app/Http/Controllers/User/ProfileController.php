<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = Auth::user();

        return view('User.profile', ['user' => $user]);
    }

    public function update(UpdateRequest $request)
    {
        $params = $request->validated();

        $result = $this->userService->update($params);

        if ($result) {

            return redirect()->back()->with('success', 'User profile updated successfully.');
        }

        return redirect()->back()->withErrors(['error' => 'Failed to update profile.']);
    }
    
    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $this->userService->updatePassword($request->validated());

            return redirect()->back()->with('success', 'User password updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
