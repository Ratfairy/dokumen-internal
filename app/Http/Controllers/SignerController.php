<?php

namespace App\Http\Controllers;

use App\Models\Signer;
use Illuminate\Http\Request;

class SignerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $signers = Signer::query()
        ->orderBy('name')
        ->get();

        return view('signers.index', compact('signers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('signers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'employee_number' => ['nullable', 'string', 'max:50'],
            'position' => ['required', 'string', 'max:150'],
            'work_unit' => ['required', 'string', 'max:150'],
            'institution' => ['required', 'string', 'max:200'],
        ], [
            'name.required' => 'Nama penandatangan wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'work_unit.required' => 'Unit kerja wajib diisi.',
            'institution.required' => 'Instansi wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Signer::create($validated);

        return redirect()
            ->route('signers.index')
            ->with('success', 'Data penandatangan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Signer $signer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Signer $signer)
    {
        return view('signers.edit', compact('signer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Signer $signer)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'employee_number' => ['nullable', 'string', 'max:50'],
            'position' => ['required', 'string', 'max:150'],
            'work_unit' => ['required', 'string', 'max:150'],
            'institution' => ['required', 'string', 'max:200'],
        ], [
            'name.required' => 'Nama penandatangan wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'work_unit.required' => 'Unit kerja wajib diisi.',
            'institution.required' => 'Instansi wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $signer->update($validated);

        return redirect()
            ->route('signers.index')
            ->with('success', 'Data penandatangan berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Signer $signer)
    {
        //
    }

    public function toggleStatus(Signer $signer)
    {
        $signer->update([
            'is_active' => ! $signer->is_active,
        ]);

        $message = $signer->is_active
            ? 'Penandatangan berhasil diaktifkan.'
            : 'Penandatangan berhasil dinonaktifkan.';

        return redirect()
            ->route('signers.index')
            ->with('success', $message);
    }
}
