<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Trip;
use App\Models\Route;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class TicketController extends Controller
{


    public function index()
    {

        $tickets = Ticket::with([
            'trip',
            'route',
            'vehicle'
        ])
            ->latest()
            ->paginate(10);


        return view(
            'admin.tickets.index',
            compact('tickets')
        );
    }





    public function create()
    {

        $trips = Trip::all();

        $routes = Route::all();

        $vehicles = Vehicle::all();



        return view(
            'admin.tickets.create',
            compact(
                'trips',
                'routes',
                'vehicles'
            )
        );
    }





    public function store(Request $request)
    {


        $validated = $request->validate([

            'trip_id'
            => 'nullable|exists:trips,id',

            'route_id'
            => 'nullable|exists:routes,id',

            'vehicle_id'
            => 'nullable|exists:vehicles,id',

            'ticket_code'
            => 'required|unique:tickets,ticket_code',

            'payment_method'
            => 'required',

            'fare'
            => 'required|numeric',

            'ticket_status'
            => 'required',

            'issued_at'
            => 'required|date',

        ]);



        Ticket::create($validated);



        return redirect()
            ->route('admin.tickets.index')
            ->with(
                'success',
                'Tiket berhasil dibuat'
            );
    }





    public function show(Ticket $ticket)
    {

        return view(
            'admin.tickets.show',
            compact('ticket')
        );
    }





    public function edit(Ticket $ticket)
    {

        $trips = Trip::all();

        $routes = Route::all();

        $vehicles = Vehicle::all();


        return view(
            'admin.tickets.edit',
            compact(
                'ticket',
                'trips',
                'routes',
                'vehicles'
            )
        );
    }





    public function update(
        Request $request,
        Ticket $ticket
    ) {


        $ticket->update(
            $request->validate([

                'payment_method' => 'required',

                'fare' => 'required|numeric',

                'ticket_status' => 'required',

                'issued_at' => 'required|date'

            ])
        );



        return redirect()
            ->route('admin.tickets.index')
            ->with(
                'success',
                'Tiket berhasil diperbarui'
            );
    }





    public function destroy(Ticket $ticket)
    {

        $ticket->delete();


        return redirect()
            ->route('admin.tickets.index')
            ->with(
                'success',
                'Tiket berhasil dihapus'
            );
    }
}
