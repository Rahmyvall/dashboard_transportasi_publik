<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    /**
     * 📌 LIST + SEARCH + FILTER + PAGINATION
     */
    public function index(Request $request)
    {
        $query = Operator::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('operator_name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $operators = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $title = 'Data Operator';

        return view('admin.operators.index', compact('operators', 'title'));
    }

    /**
     * 📌 CREATE
     */
    public function create()
    {
        $title = 'Tambah Operator';

        return view('admin.operators.create', compact('title'));
    }

    /**
     * 📌 STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'operator_name' => 'required|max:100',
            'phone'         => 'nullable|max:20',
            'email'         => 'nullable|email|max:100',
            'address'       => 'nullable',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        Operator::create($validated);

        return redirect()->route('admin.operators.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * 📌 SHOW DETAIL
     */
    public function show($id)
    {
        $operator = Operator::findOrFail($id);

        $title = 'Detail Operator';

        return view('admin.operators.show', compact('operator', 'title'));
    }

    /**
     * 📌 EDIT
     */
    public function edit($id)
    {
        $operator = Operator::findOrFail($id);

        $title = 'Edit Operator';

        return view('admin.operators.edit', compact('operator', 'title'));
    }

    /**
     * 📌 UPDATE
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'operator_name' => 'required|max:100',
            'phone'         => 'nullable|max:20',
            'email'         => 'nullable|email|max:100',
            'address'       => 'nullable',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $operator = Operator::findOrFail($id);
        $operator->update($validated);

        return redirect()->route('admin.operators.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * 📌 DELETE
     */
    public function destroy($id)
    {
        Operator::findOrFail($id)->delete();

        return redirect()->route('admin.operators.index')
            ->with('success', 'Data berhasil dihapus');
    }

    /**
     * 📌 PRINT DETAIL
     */
    public function printDetail($id)
    {
        $operator = Operator::findOrFail($id);

        return view('admin.operators.print-detail', compact('operator'));
    }
}