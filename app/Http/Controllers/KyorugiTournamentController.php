<?php

namespace App\Http\Controllers;

use App\Enums\TournamentStatus;
use App\Http\Requests\KyorugiTournamentStoreRequest;
use App\Http\Requests\KyorugiTournamentUpdateRequest;
use App\Models\EventCategory;
use App\Models\KyorugiTournament;
use App\Models\Province;
use Illuminate\Http\JsonResponse;

class KyorugiTournamentController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->respond(function () {
            $tournaments = KyorugiTournament::with(['eventCategory', 'creator'])->get();
            return $this->success($tournaments, 'Tournaments retrieved successfully.');
        });
    }

    public function store(KyorugiTournamentStoreRequest $request): JsonResponse
    {
        return $this->respond(function () use ($request) {
            $validated = $request->validated();

            $tournament = KyorugiTournament::create($validated);

            if ($request->has('banner')) {
                $tournament->addMedia($request->file('banner'))
                    ->toMediaCollection('banner');
            }

            return $this->success($tournament, 'Tournament created successfully.', 201);
        });
    }

    public function show($id)
    {
        $eventCategories = EventCategory::all();
        $tournament = KyorugiTournament::findOrFail($id);
        $provinces = Province::where('region_code', 8)->get();

        return view('tm.edit_kyorugi', compact('tournament', 'eventCategories', 'provinces'));
    }

    public function update(KyorugiTournamentUpdateRequest $request, $tournament_id): JsonResponse
    {
        return $this->respond(function () use ($request, $tournament_id) {
            $validated = $request->validated();

            $tournament = KyorugiTournament::findOrFail($tournament_id);

            if ($request->has('banner')) {
                $tournament->addMedia($request->file('banner'))
                    ->toMediaCollection('banner');
            }

            $tournament->update($validated);

            // dd($tournament);

            return $this->success($tournament, 'Tournament updated successfully.');
        }, 'Tournament not found.');
    }

    public function destroy($id): JsonResponse
    {
        return $this->respond(function () use ($id) {
            $tournament = KyorugiTournament::findOrFail($id);

            if ($tournament->status == TournamentStatus::DRAFT) {
                $tournament->delete();
                return $this->success(null, 'Tournament deleted successfully.');
            }

            return $this->fail('You cannot delete a tournament that is not in draft status.');
        }, 'Tournament not found.');
    }
}
