<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Inertia\Inertia;
use Inertia\Response;

class AgendaController extends Controller
{
    /**
     * Display the public agenda listing page.
     */
    public function index(): Response
    {
        // Get upcoming published agendas
        $upcomingAgendas = Agenda::published()
            ->upcoming()
            ->orderByDate()
            ->get();

        // Get past agendas (last 10)
        $pastAgendas = Agenda::published()
            ->past()
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        // Get unique categories
        $categories = Agenda::published()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return Inertia::render('Agenda', [
            'upcomingAgendas' => $upcomingAgendas,
            'pastAgendas' => $pastAgendas,
            'categories' => $categories,
        ]);
    }

    /**
     * Display a single agenda.
     */
    public function show(string $slug): Response
    {
        $agenda = Agenda::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Get related agendas from same category
        $relatedAgendas = Agenda::published()
            ->where('id', '!=', $agenda->id)
            ->where('category', $agenda->category)
            ->upcoming()
            ->orderByDate()
            ->take(4)
            ->get();

        return Inertia::render('AgendaShow', [
            'agenda' => $agenda,
            'relatedAgendas' => $relatedAgendas,
        ]);
    }
}
