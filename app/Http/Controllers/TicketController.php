<?php

namespace App\Http\Controllers;

use App\Helpers\TicketHelper;
use App\Services\TicketService;
use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = Ticket::select('id','user_id','subject','description','priority','status','assigned_to')
            ->with(['user:id,name,email', 'assignedAgent:id,name,email'])
            ->withCount('comments')

            ->when($request->status, fn($q) => $q->status($request->status))
            ->when($request->priority, fn($q) => $q->priority($request->priority))
            ->when($request->search, function ($q) use ($request) {
                $q->where('subject', 'like', "%{$request->search}%");
            })
            ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date))

            ->latest()
            ->paginate(1);
        // $records = TicketResource::collection($tickets); //resource for api

        $records = $tickets->through(function ($ticket) {
            return TicketHelper::format($ticket); //helper for web
        });

        return view('tickets.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    { 
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $this->ticketService->create($data);

        return back()->with('success', 'Ticket created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $this->ticketService->update($ticket, $request->validated());
        return back()->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $this->ticketService->delete($ticket);
        return back()->with('success', 'Deleted');
    }
}
