<?php

namespace App\Http\Controllers\Navigation;

use App\Enums\TournamentStatus;
use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\KyorugiTournament;
use App\Models\KyorugiTournamentMatch;
use App\Models\KyorugiTournamentPlayer;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChairmanController extends Controller
{
    public function dashboard()
    {
        return view("chairman.dashboard");
    }

    public function chapter()
    {
        $chapters = Chapter::all();
        return view("chairman.chapter", compact("chapters"));
    }

    public function viewChapter(int $chapterID)
    {
        $chapter = Chapter::findOrFail($chapterID);
        return view("chairman.chapter_view", compact("chapter"));
    }

    public function player()
    {
        $players = Player::with(['user', 'chapter'])->get();

        return view('chairman.player', compact('players'));
    }

    public function viewPlayer($playerID)
    {
        $player = Player::with('user')->findOrFail($playerID);
        return view('chairman.player_view', compact('player'));
    }

    public function kyorugi()
    {
        $kyorugis = KyorugiTournament::where('status', '!=', TournamentStatus::DRAFT)->get();
        return view('chairman.kyorugi', compact('kyorugis'));
    }

    public function kyorugiPlayer($tournament_id)
    {
        $coachId = auth()->id();

        // Get all player IDs under this coach
        $playerIds = Player::where('coach_id', $coachId)->pluck('user_id');

        // Get IDs of players already registered to this tournament
        $registeredPlayerIds = DB::table('kyorugi_tournament_player')
            ->where('tournament_id', $tournament_id)
            ->pluck('player_id')
            ->toArray();

        // Get players of this coach NOT in the registered list
        $unregisteredPlayers = Player::where('coach_id', $coachId)
            ->whereNotIn('user_id', $registeredPlayerIds)
            ->get();

        // Optionally still load the tournament for other data
        $tournament = KyorugiTournament::findOrFail($tournament_id);

        $registeredPlayers = KyorugiTournamentPlayer::with(['tournament', 'player'])
            ->whereIn('player_id', $playerIds)
            ->get();

        return view('chairman.kyorugi_player', compact('tournament', 'unregisteredPlayers', 'registeredPlayers'));
    }

    public function kyorugiTournament()
    {
        $kyorugis = KyorugiTournament::where('status', '!=', TournamentStatus::DRAFT)->get();
        return view('chairman.kyorugi_tournament', compact('kyorugis'));
    }

    public function kyorugiViewPlayer($tournamentID)
    {
        $kyorugis = KyorugiTournamentPlayer::where('tournament_id', $tournamentID)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('chairman.kyorugi_view_tournament', compact('kyorugis'));
    }

    public function kyorugiMatches()
    {
        $kyorugis = KyorugiTournament::where('status', '!=', TournamentStatus::DRAFT)->get();

        $roundsByTournament = KyorugiTournamentMatch::select('tournament_id', 'round')
            ->distinct()
            ->get()
            ->groupBy('tournament_id');

        $showSummaryButton = [];

        foreach ($kyorugis as $tournament) {
            $matches = KyorugiTournamentMatch::where('tournament_id', $tournament->id)->get();

            if ($matches->isNotEmpty()) {
                $maxRound = $matches->max('round');
                $lastRoundMatches = $matches->where('round', $maxRound);

                $allCompleted = $lastRoundMatches->every(fn($match) => $match->match_status === \App\Enums\MatchStatus::COMPLETED);

                $showSummaryButton[$tournament->id] = $allCompleted;
            } else {
                $showSummaryButton[$tournament->id] = false;
            }
        }

        return view('chairman.kyorugi_matches', compact('kyorugis', 'roundsByTournament', 'showSummaryButton'));
    }

    public function kyorugiBracket(Request $request, $tournamentID)
    {
        $round = $request->query('round'); // Current round

        $matchesQuery = KyorugiTournamentMatch::with(['redPlayer', 'bluePlayer', 'winner'])
            ->where('tournament_id', $tournamentID);

        if ($round !== null) {
            $matchesQuery->where('round', $round);
        }

        $matchesCollection = $matchesQuery->get();

        // Grouping matches for view
        $matches = $matchesCollection
            ->groupBy(fn($match) => $match->division->value)
            ->map(
                fn($divisionMatches) =>
                $divisionMatches->groupBy(fn($match) => $match->weight_class->value)
                    ->map(fn($weightMatches) => $weightMatches->groupBy('round'))
            );

        return view('chairman.bracket', [
            'matches' => $matches,
            'tournament' => KyorugiTournament::findOrFail($tournamentID),
        ]);
    }

    public function kyorugiSummary($tournamentID)
    {
        $tournament = KyorugiTournament::findOrFail($tournamentID);

        $winners = KyorugiTournamentMatch::with(['winner'])
            ->where('tournament_id', $tournamentID)
            ->where('match_status', \App\Enums\MatchStatus::COMPLETED)
            ->get()
            ->groupBy('division')
            ->map(function ($matchesByDivision) {
                return $matchesByDivision->groupBy('belt_level')
                    ->map(function ($matchesByBelt) {
                        return $matchesByBelt->groupBy('weight_class')
                            ->map(function ($matchesByWeightClass) {
                                return $matchesByWeightClass->groupBy('gender')
                                    ->map(function ($matchesByGender) {
                                        $match = $matchesByGender->first();
                                        return Player::whereHas('user', function ($query) use ($match) {
                                            $query->where('id', $match->winner_id);
                                        })
                                            ->with(['user', 'coach', 'chapter', 'tournaments'])
                                            ->first();
                                    });
                            });
                    });
            });

        return view('chairman.summary', compact('tournament', 'winners'));
    }

    public function chairmanProfile()
    {
        $committee = auth()->user()->committee;

        if (!$committee) {
            abort(404, 'Committee not found.');
        }

        return view('chairman.profile', compact('committee'));
    }
}
