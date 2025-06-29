<?php

namespace App\Http\Controllers;

use App\Enums\TournamentStatus;
use App\Models\Chapter;
use App\Models\KyorugiTournament;
use App\Models\KyorugiTournamentMatch;
use App\Models\KyorugiTournamentPlayer;
use App\Models\Player;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoachController extends Controller
{
    public function dashboard()
    {
        $chapter = auth()->user()->chapter;
        $chapters = \App\Models\Chapter::where('coach_id', auth()->user()->id)->get();
        $selectedChapter = $chapters->find(request()->query('chapter_id'));
        return view('coach.dashboard', compact('chapters', 'selectedChapter'));
    }

    public function player()
    {
        $players = auth()->user()->chapter->players ?? [];
        return view('coach.player', compact('players'));
    }

    public function addPlayer()
    {
        // Fetch provinces for the coach's region (as in your code, assuming region code 8)
        $provinces = Province::where('region_code', 8)->get();

        return view('coach.add_player', compact('provinces'));
    }

    public function viewPlayer($playerID)
    {
        $player = Player::with('user')->findOrFail($playerID);
        return view('coach.player_view', compact('player'));
    }

    public function chapter()
    {
        $chapters = Chapter::where('coach_id', auth()->user()->id)->get();

        if ($chapters->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'You do not have a chapter assigned.']);
        }

        $chapterId = request()->query('chapter_id');
        $selectedChapter = $chapterId ? $chapters->find($chapterId) : $chapters->first();

        if (!$selectedChapter) {
            return redirect()->back()->withErrors(['error' => 'Selected chapter not found.']);
        }

        return view('coach.chapter', compact('chapters', 'selectedChapter'));
    }

    public function coachProfile()
    {
        $committee = auth()->user()->committee;

        if (!$committee) {
            abort(404, 'Committee not found.');
        }

        return view('coach.profile', compact('committee'));
    }

    public function kyorugi()
    {
        $kyorugis = KyorugiTournament::where('status', '!=', TournamentStatus::DRAFT)->get();
        return view('coach.kyorugi', compact('kyorugis'));
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
            ->where('tournament_id', $tournament_id)
            ->get();

        return view('coach.kyorugi_player', compact('tournament', 'unregisteredPlayers', 'registeredPlayers'));
    }

    public function kyorugiTournament()
    {
        $kyorugis = KyorugiTournament::where('status', '!=', TournamentStatus::DRAFT)->get();
        return view('coach.kyorugi_tournament', compact('kyorugis'));
    }

    public function kyorugiViewPlayer($tournamentID)
    {
        $kyorugis = KyorugiTournamentPlayer::where('tournament_id', $tournamentID)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('coach.kyorugi_view_tournament', compact('kyorugis'));
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

        return view('coach.kyorugi_matches', compact('kyorugis', 'roundsByTournament', 'showSummaryButton'));
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

        return view('coach.bracket', [
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

        return view('coach.summary', compact('tournament', 'winners'));
    }
}
