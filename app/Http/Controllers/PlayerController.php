<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Province;

class PlayerController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->respond(function () {
            $players = Player::with('user')->get();
            return $this->success($players, 'Players retrieved successfully.');
        });
    }

    public function store(StorePlayerRequest $request): JsonResponse
    {
        return $this->respond(function () use ($request) {
            $validated = $request->validated();

            // Create User
            $user = $this->createUserFromRequest($validated);

            if ($request->has('avatar')) {
                $user->addMedia($request->file('avatar'))
                    ->toMediaCollection('avatar');
            }

            // Add the 'user_id' to validated data for player creation
            $validated['user_id'] = $user->id;

            // Create Player
            $player = Player::create($validated);

            return $this->success($player, 'Player created successfully.', 201);
        });
    }

    public function show($id)
    {
        $player = Player::with('user')->findOrFail($id);
        $provinces = Province::where('region_code', 8)->get();
        return view('coach.edit_player', compact('player', 'provinces'));
    }

    public function update(UpdatePlayerRequest $request, Player $player): JsonResponse
    {
        return $this->respond(function () use ($request, $player) {
            $validated = $request->validated();

            // Update related User
            $player->user->update([
                'first_name'     => $validated['first_name'],
                'middle_name'    => $validated['middle_name'] ?? null,
                'last_name'      => $validated['last_name'],
                'extension_name' => $validated['extension_name'] ?? null,
                'email'          => $validated['email'],
                'contact_number' => $validated['contact_number'],
                'user_type'      => $validated['user_type'],
            ]);

            if ($request->has('avatar')) {
                $player->user->addMedia($request->file('avatar'))
                    ->toMediaCollection('avatar');
            }

            // Format birth_date if needed
            if (isset($validated['birth_date'])) {
                $validated['birth_date'] = \Carbon\Carbon::parse($validated['birth_date'])->format('Y-m-d');
            }

            // Update Player
            $player->update([
                'member_id'         => $validated['member_id'],
                'pta_id'            => $validated['pta_id'] ?? null,
                'ncc_id'            => $validated['ncc_id'] ?? null,
                'birth_date'        => $validated['birth_date'],
                'gender'            => $validated['gender'],
                'civil_status'      => $validated['civil_status'],
                'belt_level'        => $validated['belt_level'],
                'religion'          => $validated['religion'],
                'province_code'     => $validated['province_code'],
                'municipality_code' => $validated['municipality_code'],
                'brgy_code'         => $validated['brgy_code'],
            ]);

            return $this->success($player, 'Player updated successfully.');
        }, 'Player not found.');
    }

    public function destroy($id): JsonResponse
    {
        return $this->respond(function () use ($id) {
            $player = Player::findOrFail($id);

            // Soft delete the player first
            $player->delete();

            // Then soft delete the user
            $player->user()->delete();

            return $this->success(null, 'Player deleted successfully.');
        }, 'Player not found.');
    }
}
