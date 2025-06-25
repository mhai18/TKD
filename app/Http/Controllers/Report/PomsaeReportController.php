<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\PomsaeMatch;
use App\Models\PomsaeTournament;
use App\Models\PomsaeTournamentPlayer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PomsaeReportController extends Controller
{
    public function exportMatchResultsPDF($tournamentId)
    {
        $matches = PomsaeMatch::where('tournament_id', $tournamentId)
            ->where('status', 'Completed')
            ->with('player:id,first_name,last_name')
            ->get();

        $pdf = Pdf::loadView('reports.pomsae_results', compact('matches', 'tournamentId'));
        return $pdf->download("pomsae_results_{$tournamentId}.pdf");
    }

    public function exportParticipantListPDF($tournamentId)
    {
        $players = PomsaeTournamentPlayer::where('tournament_id', $tournamentId)
            ->with('player:id,first_name,last_name')
            ->get();

        $pdf = Pdf::loadView('reports.pomsae_participants', compact('players', 'tournamentId'));
        return $pdf->download("pomsae_participants_{$tournamentId}.pdf");
    }

    public function exportDivisionSummaryPDF($tournamentId)
    {
        $summary = PomsaeTournamentPlayer::where('tournament_id', $tournamentId)
            ->select('division', 'belt_level', 'gender', 'category')
            ->selectRaw('count(*) as total')
            ->groupBy('division', 'belt_level', 'gender', 'category')
            ->get();

        $pdf = Pdf::loadView('reports.pomsae_division_summary', compact('summary', 'tournamentId'));
        return $pdf->download("pomsae_division_summary_{$tournamentId}.pdf");
    }
}
