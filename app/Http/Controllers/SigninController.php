<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\Committee;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SigninController extends Controller
{
    public function signin(Request $request): JsonResponse
    {
        // Validate input
        $validated = $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);

        // Find user by email
        $user = User::where("email", $validated["email"])->first();

        if (!$user || !Hash::check($validated["password"], $user->password)) {
            return response()->json([
                "success" => false,
                "message" => "Invalid email or password."
            ], 401);
        }

        Auth::login($user);

        return response()->json([
            "success" => true,
            "message" => "Login successful.",
            "user" => $user,
        ]);
    }

    public function isUsingDefaultPassword()
    {
        $user = auth()->user();

        // Early exit if user is missing for safety
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $defaultPassword = null;

        switch ($user->user_type) {
            case UserType::PLAYER:
                $player = Player::where('user_id', $user->id)->first();
                $defaultPassword = $player?->member_id;
                break;

            case UserType::ADMIN:
                return redirect()->route('adminDashboard');

            default:
                $committee = Committee::where('user_id', $user->id)->first();
                $defaultPassword = $committee?->member_id;
                break;
        }

        // If default password exists and matches, show change password view
        if ($defaultPassword && Hash::check($defaultPassword, $user->password)) {
            return view('change_password');
        }

        return redirect()->route('userDashboard');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "success" => true,
            "message" => "Password changed successfully!",
            "user" => $user,
        ]);
    }

    public function userDashboard()
    {
        $user = auth()->user();
        switch ($user->user_type) {
            case UserType::COACH:
                return redirect()->route('coachDashboard');
            case UserType::PLAYER:
                return redirect()->route('playerDashboard');
            case UserType::TOURNAMENT_MANAGER:
                return redirect()->route('tmDashboard');
            case UserType::CHAIRMAN:
                return redirect()->route('chairmanDashboard');
            default:
                return redirect()->route('adminDashboard');
        }
    }

    public function profile()
    {
        $user = auth()->user();
        switch ($user->user_type) {
            case UserType::COACH:
                return redirect()->route('coachProfile');
            case UserType::PLAYER:
                return redirect()->route('playerProfile');
            case UserType::TOURNAMENT_MANAGER:
                return redirect()->route('tmProfile');
            case UserType::CHAIRMAN:
                return redirect()->route('chairmanProfile');
            default:
                return redirect()->route('adminProfile');
        }
    }
}
