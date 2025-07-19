<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Models\Category;
use App\Services\Ticket\CreateTicketDTO;
use App\Services\Ticket\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function create(Request $request): Response
    {
        return Inertia::render('TicketForm', [
            'categories' => Category::all(),
        ]);
    }

    public function store(CreateTicketRequest $request, TicketService $service): RedirectResponse
    {
        $service->create(CreateTicketDTO::fromRequest($request));
        $request->session()->flash('ticket.created');

        return to_route('home');
    }
}
