<?php

namespace App\Http\Controllers;

use App\Enums\MatchStatus;
use App\Enums\TournamentStatus;
use App\Models\KyorugiTournament;
use Illuminate\Http\Request;
use App\Models\KyorugiTournamentMatch;
use App\Models\KyorugiTournamentPlayer;
use Illuminate\Http\JsonResponse;

class KyorugiTournamentMatchController extends Controller
{
    public function index()
    {
        // Display the list of tournament matches or other relevant info
    }

    public function store(Request $request)
    {
        return $this->respond(function () use ($request) {
            $validated = $request->validate([
                "tournament_id" => "required|exists:kyorugi_tournaments,id",
            ]);

            // Generate initial matches
            $this->generateInitialMatches($validated['tournament_id']);

            // Update tournament status
            $tournament = KyorugiTournament::findOrFail($validated['tournament_id']);
            $tournament->update([
                'status' => TournamentStatus::ONGOING,
            ]);
            $tournament->save();

            return $this->success($tournament, 'Tournament Match created successfully.', 201);
        });
    }

    public function update(Request $request, $matchesID): JsonResponse
    {
        return $this->respond(function () use ($request, $matchesID) {
            $validated = $request->validate([
                'winner_id' => 'required|exists:users,id',
            ]);

            $tournamentMatch = KyorugiTournamentMatch::findOrFail($matchesID);

            // Update EventCategory
            $tournamentMatch->update([
                'match_status' => MatchStatus::COMPLETED,
                'winner_id' => $validated['winner_id'],
            ]);

            return $this->success($tournamentMatch, 'Tournament Matches updated successfully.');
        }, 'Tournament not found.');
    }

    // Method to generate initial matches
    public function generateInitialMatches(int $tournamentId): void
    {
        $players = KyorugiTournamentPlayer::where('tournament_id', $tournamentId)
            ->get()
            ->groupBy(
                fn($player) =>
                $player->division->value . '-' .
                    $player->weight_class->value . '-' .
                    $player->belt_level->value . '-' .
                    $player->gender
            );

        foreach ($players as $groupedPlayers) {
            $shuffled = $groupedPlayers->shuffle();
            $round = 1;

            while ($shuffled->count() > 1) {
                $player1 = $shuffled->pop();
                $player2 = $shuffled->pop();

                KyorugiTournamentMatch::create([
                    'tournament_id' => $tournamentId,
                    'round' => $round,
                    'player_red_id' => $player1->player_id,
                    'player_blue_id' => $player2->player_id,
                    'division' => $player1->division,
                    'weight_class' => $player1->weight_class,
                    'belt_level' => $player1->belt_level,
                    'gender' => $player1->gender,
                ]);
            }

            // Bye player (if odd number)
            if ($shuffled->count() === 1) {
                $byePlayer = $shuffled->pop();

                KyorugiTournamentMatch::create([
                    'tournament_id' => $tournamentId,
                    'round' => $round,
                    'match_status' => MatchStatus::COMPLETED,
                    'player_red_id' => $byePlayer->player_id,
                    'player_blue_id' => null,
                    'winner_id' => $byePlayer->player_id,
                    'division' => $byePlayer->division,
                    'weight_class' => $byePlayer->weight_class,
                    'belt_level' => $byePlayer->belt_level,
                    'gender' => $byePlayer->gender,
                ]);
            }
        }
    }

    // Method to generate next round of matches
    public function generateNextRound(int $tournamentId)
    {
        return $this->respond(function () use ($tournamentId) {
            $groupedMatches = KyorugiTournamentMatch::where('tournament_id', $tournamentId)
                ->get()
                ->groupBy(fn($match) => $match->getGroupKey());

            $createdMatchCount = 0;

            foreach ($groupedMatches as $key => $matches) {
                $latestRound = $matches->max('round');
                $currentRoundMatches = $matches->where('round', $latestRound);

                // Ensure all current round matches have a winner before generating the next round
                if ($currentRoundMatches->contains(fn($match) => is_null($match->winner_id))) {
                    continue;
                }

                $winners = $currentRoundMatches->pluck('winner_id')->filter()->values();
                if ($winners->count() < 2) {
                    continue; // No need to generate a new round if less than 2 winners
                }

                $nextRound = $latestRound + 1;
                $winners = $winners->shuffle();

                while ($winners->count() > 1) {
                    $p1 = $winners->pop();
                    $p2 = $winners->pop();

                    $sampleMatch = $currentRoundMatches->first();

                    KyorugiTournamentMatch::create([
                        'tournament_id' => $tournamentId,
                        'round' => $nextRound,
                        'player_red_id' => $p1,
                        'player_blue_id' => $p2,
                        'division' => $sampleMatch->division,
                        'weight_class' => $sampleMatch->weight_class,
                        'belt_level' => $sampleMatch->belt_level,
                        'gender' => $sampleMatch->gender,
                    ]);

                    $createdMatchCount++;
                }

                // Auto-advance if there's only 1 winner left
                if ($winners->count() === 1) {
                    $autoAdvance = $winners->pop();
                    $sampleMatch = $currentRoundMatches->first();

                    KyorugiTournamentMatch::create([
                        'tournament_id' => $tournamentId,
                        'round' => $nextRound,
                        'match_status' => MatchStatus::COMPLETED,
                        'player_red_id' => $autoAdvance,
                        'player_blue_id' => null,
                        'winner_id' => $autoAdvance,
                        'division' => $sampleMatch->division,
                        'weight_class' => $sampleMatch->weight_class,
                        'belt_level' => $sampleMatch->belt_level,
                        'gender' => $sampleMatch->gender,
                    ]);

                    $createdMatchCount++;
                }
            }

            if ($createdMatchCount === 0) {
                $tournament = KyorugiTournament::findOrFail($tournamentId);
                $tournament->update([
                    'status' => TournamentStatus::FINISHED,
                ]);
                $tournament->save();
                return $this->success([], 'Matches are already concluded. No next round generated.', 200);
            }

            return $this->success($groupedMatches, 'Next round matches generated successfully.', 201);
        });
    }
}
