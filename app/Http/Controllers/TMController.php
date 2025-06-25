<?php

namespace App\Http\Controllers;

use App\Enums\TournamentStatus;
use App\Models\Chapter;
use App\Models\EventCategory;
use App\Models\KyorugiTournament;
use App\Models\KyorugiTournamentMatch;
use App\Models\KyorugiTournamentPlayer;
use App\Models\Player;
use App\Models\Province;
use Illuminate\Http\Request;

class TMController extends Controller
{
    public function dashboard()
    {
        return view("tm.dashboard");
    }

    public function chapter()
    {
        $chapters = Chapter::all();
        return view("tm.chapter", compact("chapters"));
    }

    public function viewChapter(int $chapterID)
    {
        $chapter = Chapter::findOrFail($chapterID);
        return view("tm.chapter_view", compact("chapter"));
    }

    public function player()
    {
        $players = Player::with(['user', 'chapter'])->get();

        return view('tm.player', compact('players'));
    }

    public function viewPlayer($playerID)
    {
        $player = Player::with('user')->findOrFail($playerID);
        return view('tm.player_view', compact('player'));
    }

    public function category()
    {
        $eventCategories = EventCategory::all();
        return view('tm.category', compact('eventCategories'));
    }

    public function kyorugi()
    {
        $kyorugis = KyorugiTournament::all();
        return view('tm.kyorugi', compact('kyorugis'));
    }

    public function addKyorugi()
    {
        $eventCategories = EventCategory::all();
        $provinces = Province::where('region_code', 8)->get();

        return view('tm.add_kyorugi', compact('provinces', 'eventCategories'));
    }

    public function kyorugiPlayer()
    {
        $kyorugis = KyorugiTournament::where('status', '!=', TournamentStatus::DRAFT)->get();
        return view('kyorugi.kyorugi_player', compact('kyorugis'));
    }

    public function kyorugiViewPlayer($tournamentID)
    {
        $kyorugis = KyorugiTournamentPlayer::where('tournament_id', $tournamentID)
            ->orderBy('created_at', 'desc')
            ->get();
        $hasMatches = KyorugiTournamentMatch::where('tournament_id', $tournamentID)->first();
        return view('kyorugi.kyorugi_view_player', compact('kyorugis', 'tournamentID', 'hasMatches'));
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

        return view('kyorugi.kyorugi_matches', compact('kyorugis', 'roundsByTournament', 'showSummaryButton'));
    }

    public function kyorugiMatchesPlayers($tournamentID)
    {
        $kyorugis = KyorugiTournamentMatch::where('tournament_id', $tournamentID)->get();
        return view('kyorugi.kyorugi_matches_players', compact('kyorugis'));
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

        // Check if all matches in this round are completed
        $allCompleted = $round !== null
            ? $matchesCollection->every(fn($match) => $match->match_status === \App\Enums\MatchStatus::COMPLETED)
            : false;

        // Check if next round already exists
        $nextRoundExists = false;
        if ($round !== null) {
            $nextRoundExists = KyorugiTournamentMatch::where('tournament_id', $tournamentID)
                ->where('round', $round + 1)
                ->exists();
        }

        $canGenerateNextRound = $allCompleted && !$nextRoundExists;

        // Grouping matches for view
        $matches = $matchesCollection
            ->groupBy(fn($match) => $match->division->value)
            ->map(
                fn($divisionMatches) =>
                $divisionMatches->groupBy(fn($match) => $match->weight_class->value)
                    ->map(fn($weightMatches) => $weightMatches->groupBy('round'))
            );

        return view('kyorugi.bracket', [
            'matches' => $matches,
            'tournament' => KyorugiTournament::findOrFail($tournamentID),
            'selectedRound' => $round,
            'canGenerateNextRound' => $canGenerateNextRound,
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

        return view('kyorugi.summary', compact('tournament', 'winners'));
    }

    public function kyorugiReport()
    {
        $kyorugis = KyorugiTournament::where('status', '!=', TournamentStatus::DRAFT)->get();
        return view('kyorugi.report', compact('kyorugis'));
    }

    public function tmProfile()
    {
        $committee = auth()->user()->committee;

        if (!$committee) {
            abort(404, 'Committee not found.');
        }

        return view('tm.profile', compact('committee'));
    }
}
