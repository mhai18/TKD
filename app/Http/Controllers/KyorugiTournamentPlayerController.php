<?php

namespace App\Http\Controllers;

use App\Enums\Division;
use App\Enums\PlayerStatus;
use App\Enums\WeightCategory;
use App\Http\Requests\KyorugiTournamentPlayerRequest;
use App\Models\KyorugiTournamentPlayer;
use App\Models\Player;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class KyorugiTournamentPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->respond(function () {
            $tournaments = KyorugiTournamentPlayer::all();
            return $this->success($tournaments, 'Tournament Players retrieved successfully.');
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KyorugiTournamentPlayerRequest $request)
    {
        return $this->respond(function () use ($request) {
            $validated = $request->validated();

            $player = Player::where('user_id', $validated['player_id'])->first();
            $gender = $player->gender == 'Male' ? 'Men' : 'Women';

            // Loop through weight classes to find matching one
            $weightRanges = WeightCategory::getAllWeightRanges();
            $division = $validated['division'];
            $weight = $validated['weight'];

            $weightClass = null;

            foreach (WeightCategory::cases() as $category) {
                [$min, $max] = $weightRanges[$division][$gender][$category->value];
                if ($weight >= $min && $weight < $max) {
                    $weightClass = $category;
                    break;
                }
            }

            if (!$weightClass) {
                return $this->fail('No weight class found for this player.', 422);
            }

            $eventCategory = KyorugiTournamentPlayer::create([
                'tournament_id' => $validated['tournament_id'],
                'player_id' => $validated['player_id'],
                'division' => $validated['division'],
                'weight_class' => $weightClass,
                'belt_level' => $player->belt_level,
                'gender' => $player->gender,
                'status' => PlayerStatus::APPROVED,
                'registered_by' => auth()->user()->id,
            ]);

            return $this->success($eventCategory, 'Player registered successfully.', 201);
        });
    }

    public function destroy(KyorugiTournamentPlayer $kyorugiTournamentPlayer): JsonResponse
    {
        return $this->respond(function () use ($kyorugiTournamentPlayer) {

            $kyorugiTournamentPlayer->delete();

            return $this->success(null, 'Player removed successfully.');
        }, 'Player not found.');
    }
}
