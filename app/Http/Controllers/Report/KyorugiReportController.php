<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\KyorugiTournamentMatch;
use App\Models\KyorugiTournamentPlayer;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KyorugiReportController extends Controller
{
    public function exportTournamentPlayersPDF(Request $request, $tournamentId)
    {
        $players = KyorugiTournamentPlayer::where('tournament_id', $tournamentId)
            ->when($request->division, fn($q) => $q->where('division', $request->division))
            ->when($request->weight_class, fn($q) => $q->where('weight_class', $request->weight_class))
            ->when($request->belt_level, fn($q) => $q->where('belt_level', $request->belt_level))
            ->when($request->gender, fn($q) => $q->where('gender', $request->gender))
            ->get()
            ->sortBy([
                ['division', 'asc'],
                ['weight_class', 'asc'],
                ['belt_level', 'asc'],
                ['gender', 'asc'],
                [fn($p) => $p->player->full_name ?? '', 'asc']
            ]);

        $pdf = Pdf::loadView('reports.tournament_players', compact('players', 'tournamentId'));
        return $pdf->download("tournament_players_{$tournamentId}.pdf");
    }

    public function exportMatchSchedulePDF($tournamentId)
    {
        $matches = KyorugiTournamentMatch::where('tournament_id', $tournamentId)
            // ->where('match_status', 'Scheduled')
            ->orderBy('match_datetime')
            ->get();

        // return view('reports.match_schedule', compact('matches', 'tournamentId'));
        $pdf = Pdf::loadView('reports.match_schedule', compact('matches', 'tournamentId'));
        return $pdf->download("match_schedule_{$tournamentId}.pdf");
    }

    public function exportMatchResultsPDF($tournamentId)
    {
        $matches = KyorugiTournamentMatch::where('tournament_id', $tournamentId)
            ->where('match_status', 'Completed')
            ->get();

        // dd($matches);

        return view('reports.match_results', compact('matches', 'tournamentId'));
        // $pdf = Pdf::loadView('reports.match_results', compact('matches', 'tournamentId'));
        // return $pdf->download("match_results_{$tournamentId}.pdf");
    }

    public function exportPlayerPerformancePDF($playerId)
    {
        $matches = KyorugiTournamentMatch::where(function ($q) use ($playerId) {
            $q->where('player_red_id', $playerId)
                ->orWhere('player_blue_id', $playerId);
        })->get();

        $wins = $matches->where('winner_id', $playerId)->count();
        $total = $matches->count();
        $player = User::find($playerId);

        if (request()->wantsJson() || request()->ajax()) {
            return view('reports.player_performance', compact('matches', 'wins', 'total', 'player', 'playerId'))->render();
        }

        $pdf = Pdf::loadView('reports.player_performance', compact('matches', 'wins', 'total', 'player', 'playerId'));
        return $pdf->download("player_{$playerId}_performance.pdf");
    }

    public function exportDivisionSummaryPDF($tournamentId)
    {
        $summary = KyorugiTournamentPlayer::select('division', 'belt_level', 'weight_class', 'gender')
            ->where('tournament_id', $tournamentId)
            ->selectRaw('count(*) as total_players')
            ->groupBy('division', 'belt_level', 'weight_class', 'gender')
            ->get();

        $pdf = Pdf::loadView('reports.division_summary', compact('summary', 'tournamentId'));
        return $pdf->download("division_summary_{$tournamentId}.pdf");
    }

    public function exportNoShowMatchesPDF($tournamentId)
    {
        $matches = KyorugiTournamentMatch::where('tournament_id', $tournamentId)
            ->where(function ($q) {
                $q->whereNull('player_red_id')->orWhereNull('player_blue_id');
            })
            ->whereNotNull('winner_id')
            ->get();

        // dd($matches);

        // return view('reports.no_show_matches', compact('matches', 'tournamentId'));
        $pdf = Pdf::loadView('reports.no_show_matches', compact('matches', 'tournamentId'));
        return $pdf->download("no_show_matches_{$tournamentId}.pdf");
    }
}
