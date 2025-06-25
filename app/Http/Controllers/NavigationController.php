<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\KyorugiTournamentMatch;
use App\Models\KyorugiTournamentPlayer;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function dashboard()
    {
        return view('player.dashboard');
    }

    public function chapter()
    {
        $player = auth()->user()->player;

        if (!$player) {
            abort(404, 'Player not found.');
        }

        $chapter = Chapter::where('coach_id', $player->coach_id)->first();

        return view('player.chapter', compact('chapter'));
    }

    public function viewPlayer($playerID)
    {
        $player = Player::with('user')->findOrFail($playerID);
        return view('coach.player_view', compact('player'));
    }

    public function viewSchedule()
    {
        $matches = KyorugiTournamentPlayer::where('player_id', auth()->id())
            ->with([
                'tournament',
                'player',
                'matches' => function ($query) {
                    $query->orderByRaw("FIELD(match_status, 'Scheduled', 'Ongoing', 'Completed', 'Cancelled', 'Forfeit')");
                }
            ])
            ->get();

        return view('player.player_schedule', compact('matches'));
    }

    public function viewPlayerMatches($playerId, $tournamentId)
    {
        $matches = KyorugiTournamentMatch::where('tournament_id', $tournamentId)->where(function ($q) use ($playerId) {
            $q->where('player_red_id', $playerId)
                ->orWhere('player_blue_id', $playerId);
        })->get();

        $wins = $matches->where('winner_id', $playerId)->count();
        $total = $matches->count();
        $player = User::find($playerId);

        if (request()->wantsJson() || request()->ajax()) {
            return view('reports.player_performance', compact('matches', 'wins', 'total', 'player', 'playerId'))->render();
        }
    }

    public function playerProfile()
    {
        $player = auth()->user()->player;

        if (!$player) {
            abort(404, 'Player not found.');
        }

        return view('player.profile', compact('player'));
    }
}
