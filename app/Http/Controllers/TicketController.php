<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Ticket;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    /**
     * Metode pembayaran sesuai enum tabel tickets.
     */
    private const PAYMENT_METHODS = [
        'cash',
        'emoney',
        'qris',
        'card',
        'other',
    ];

    /**
     * Status tiket sesuai enum tabel tickets.
     */
    private const TICKET_STATUSES = [
        'paid',
        'refunded',
        'failed',
    ];

    /**
     * Menampilkan daftar tiket.
     */
    public function index(): View
    {
        $tickets = Ticket::query()
            ->with([
                'trip',
                'route',
                'vehicle',
            ])
            ->orderByDesc('issued_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tickets.index', [
            'title' => 'Manajemen Tiket',
            'tickets' => $tickets,
        ]);
    }

    /**
     * Menampilkan formulir tambah tiket.
     */
    public function create(): View
    {
        return view('admin.tickets.create', [
            'title' => 'Tambah Tiket',

            'trips' => Trip::query()
                ->orderByDesc('id')
                ->get(),

            'routes' => Route::query()
                ->orderByDesc('id')
                ->get(),

            'vehicles' => Vehicle::query()
                ->orderByDesc('id')
                ->get(),

            'paymentMethods' => self::PAYMENT_METHODS,
            'ticketStatuses' => self::TICKET_STATUSES,
        ]);
    }

    /**
     * Menyimpan tiket baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        /*
         * Ticket code tidak berasal dari input pengguna.
         * Kode dibuat otomatis sebelum data disimpan.
         */
        $validated['ticket_code'] = $this->generateTicketCode();

        $ticket = Ticket::query()->create($validated);

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with(
                'success',
                "Tiket {$ticket->ticket_code} berhasil ditambahkan."
            );
    }

    /**
     * Menampilkan detail tiket.
     */
    public function show(Ticket $ticket): View
    {
        $ticket->loadMissing([
            'trip',
            'route',
            'vehicle',
        ]);

        return view('admin.tickets.show', [
            'title' => 'Detail Tiket',
            'ticket' => $ticket,
        ]);
    }

    /**
     * Menampilkan formulir edit tiket.
     */
    public function edit(Ticket $ticket): View
    {
        $ticket->loadMissing([
            'trip',
            'route',
            'vehicle',
        ]);

        return view('admin.tickets.edit', [
            'title' => 'Edit Tiket',
            'ticket' => $ticket,

            'trips' => Trip::query()
                ->orderByDesc('id')
                ->get(),

            'routes' => Route::query()
                ->orderByDesc('id')
                ->get(),

            'vehicles' => Vehicle::query()
                ->orderByDesc('id')
                ->get(),

            'paymentMethods' => self::PAYMENT_METHODS,
            'ticketStatuses' => self::TICKET_STATUSES,
        ]);
    }

    /**
     * Memperbarui tiket.
     */
    public function update(
        Request $request,
        Ticket $ticket
    ): RedirectResponse {
        $validated = $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        /*
         * Ticket code tidak diperbarui agar kode yang dibuat
         * otomatis tetap sama.
         */
        $ticket->update($validated);

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with(
                'success',
                "Tiket {$ticket->ticket_code} berhasil diperbarui."
            );
    }

    /**
     * Menghapus tiket.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticketCode = $ticket->ticket_code;

        $ticket->delete();

        return redirect()
            ->route('admin.tickets.index')
            ->with(
                'success',
                "Tiket {$ticketCode} berhasil dihapus."
            );
    }

    /**
     * Membuat ticket code unik secara otomatis.
     *
     * Contoh:
     * TKT-20260714-A8K2PL
     */
    private function generateTicketCode(): string
    {
        do {
            $ticketCode = sprintf(
                'TKT-%s-%s',
                now()->format('Ymd'),
                Str::upper(Str::random(6))
            );
        } while (
            Ticket::query()
            ->where('ticket_code', $ticketCode)
            ->exists()
        );

        return $ticketCode;
    }

    /**
     * Aturan validasi tambah dan edit tiket.
     *
     * Ticket code tidak divalidasi dari request karena
     * dibuat otomatis oleh sistem.
     */
    private function validationRules(): array
    {
        return [
            'trip_id' => [
                'nullable',
                'integer',
                'exists:trips,id',
            ],

            'route_id' => [
                'nullable',
                'integer',
                'exists:routes,id',
            ],

            'vehicle_id' => [
                'nullable',
                'integer',
                'exists:vehicles,id',
            ],

            'payment_method' => [
                'required',
                Rule::in(self::PAYMENT_METHODS),
            ],

            'fare' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],

            'ticket_status' => [
                'required',
                Rule::in(self::TICKET_STATUSES),
            ],

            'issued_at' => [
                'required',
                'date',
            ],
        ];
    }

    /**
     * Pesan validasi berbahasa Indonesia.
     */
    private function validationMessages(): array
    {
        return [
            'trip_id.integer' =>
            'Perjalanan yang dipilih tidak valid.',

            'trip_id.exists' =>
            'Data perjalanan tidak ditemukan.',

            'route_id.integer' =>
            'Rute yang dipilih tidak valid.',

            'route_id.exists' =>
            'Data rute tidak ditemukan.',

            'vehicle_id.integer' =>
            'Kendaraan yang dipilih tidak valid.',

            'vehicle_id.exists' =>
            'Data kendaraan tidak ditemukan.',

            'payment_method.required' =>
            'Metode pembayaran wajib dipilih.',

            'payment_method.in' =>
            'Metode pembayaran tidak valid.',

            'fare.required' =>
            'Tarif tiket wajib diisi.',

            'fare.numeric' =>
            'Tarif tiket harus berupa angka.',

            'fare.min' =>
            'Tarif tiket tidak boleh kurang dari nol.',

            'fare.max' =>
            'Tarif tiket melebihi batas maksimal.',

            'ticket_status.required' =>
            'Status tiket wajib dipilih.',

            'ticket_status.in' =>
            'Status tiket tidak valid.',

            'issued_at.required' =>
            'Waktu penerbitan tiket wajib diisi.',

            'issued_at.date' =>
            'Waktu penerbitan tiket tidak valid.',
        ];
    }
}
