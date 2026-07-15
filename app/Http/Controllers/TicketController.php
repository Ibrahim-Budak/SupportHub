<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'agent' || $user->role === 'admin') {
            $tickets = Ticket::with('customer', 'agent')->latest()->get();
        } else {
            $tickets = Ticket::where('customer_id', $user->id)->latest()->get();
        }

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $this->authorize('create', Ticket::class);

        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Ticket::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'priority' => 'required|in:low,medium,high',
        ]);

        $validated['customer_id'] = $request->user()->id;

        $ticket = Ticket::create($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Talebiniz oluşturuldu.');
    }

    public function show(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load('messages.user', 'customer', 'agent');

        return view('tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,answered,closed',
            'agent_id' => 'nullable|exists:users,id',
        ]);

        
        if (!$ticket->first_response_at && $validated['status'] !== 'open') {
            $validated['first_response_at'] = now();
        }

        $ticket->update($validated);

        return back()->with('success', 'Talep güncellendi.');
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $this->authorize('reply', $ticket);

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
        ]);

        
        if (!$ticket->first_response_at && $request->user()->role === 'agent') {
            $ticket->update(['first_response_at' => now()]);
        }

        

        return back();
    }
}