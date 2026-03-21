<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Services\SawService;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index(SawService $saw)
    {
        $kriteriaList = Kriteria::orderBy('urutan')->get();
        $bobotCheck   = $saw->validateBobotSum();

        return view('admin.kriteria.index', compact('kriteriaList', 'bobotCheck'));
    }

    public function create()
    {
        $nextUrutan = Kriteria::max('urutan') + 1;
        // Auto-suggest next code C1, C2...
        $nextCode   = 'C' . (Kriteria::count() + 1);
        return view('admin.kriteria.create', compact('nextUrutan', 'nextCode'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kriteria' => ['required', 'string', 'max:100'],
            'kode_kriteria' => ['required', 'string', 'max:10', 'unique:kriteria,kode_kriteria'],
            'jenis'         => ['required', 'in:benefit,cost'],
            'bobot'         => ['required', 'numeric', 'min:0', 'max:1'],
            'deskripsi'     => ['nullable', 'string'],
            'urutan'        => ['required', 'integer', 'min:1'],
        ]);

        $data['is_active'] = true;
        Kriteria::create($data);

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan. Pastikan total bobot = 1.0');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $data = $request->validate([
            'nama_kriteria' => ['required', 'string', 'max:100'],
            'kode_kriteria' => ['required', 'string', 'max:10', 'unique:kriteria,kode_kriteria,' . $kriteria->id],
            'jenis'         => ['required', 'in:benefit,cost'],
            'bobot'         => ['required', 'numeric', 'min:0', 'max:1'],
            'deskripsi'     => ['nullable', 'string'],
            'urutan'        => ['required', 'integer', 'min:1'],
            'is_active'     => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $kriteria->update($data);

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }

    /**
     * Bulk update all bobot at once so admin can ensure they sum to 1.
     */
    public function updateBobot(Request $request)
    {
        $data = $request->validate([
            'bobot'   => ['required', 'array'],
            'bobot.*' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        $sum = array_sum($data['bobot']);
        if (abs($sum - 1.0) > 0.001) {
            return back()->withErrors(['bobot' => "Total bobot harus 1.0. Saat ini: {$sum}"]);
        }

        foreach ($data['bobot'] as $id => $bobot) {
            Kriteria::where('id', $id)->update(['bobot' => $bobot]);
        }

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Bobot kriteria berhasil disimpan. Total: 1.0 ✓');
    }
}