<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SekolahInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahInfoController extends Controller
{
    public function edit()
    {
        $sekolah = SekolahInfo::getInstance();
        return view('admin.sekolah-info.edit', compact('sekolah'));
    }

    public function update(Request $request)
    {
        $sekolah = SekolahInfo::getInstance();

        $data = $request->validate([
            'nama_sekolah'  => ['required', 'string', 'max:255'],
            'singkatan'     => ['required', 'string', 'max:20'],
            'visi'          => ['nullable', 'string'],
            'misi'          => ['nullable', 'string'],
            'sejarah'       => ['nullable', 'string'],
            'kepala_sekolah'=> ['nullable', 'string', 'max:255'],
            'npsn'          => ['nullable', 'string', 'max:20'],
            'nss'           => ['nullable', 'string', 'max:30'],
            'alamat'        => ['required', 'string'],
            'kota'          => ['nullable', 'string', 'max:100'],
            'provinsi'      => ['nullable', 'string', 'max:100'],
            'kode_pos'      => ['nullable', 'string', 'max:10'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'email'         => ['nullable', 'email'],
            'website'       => ['nullable', 'url'],
            'akreditasi'    => ['required', 'in:A,B,C,Belum'],
            'fasilitas'     => ['nullable', 'array'],
            'logo'          => ['nullable', 'image', 'max:1024'],
            'foto_sekolah'  => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($sekolah->logo) Storage::disk('public')->delete($sekolah->logo);
            $data['logo'] = $request->file('logo')->store('sekolah-info', 'public');
        }

        if ($request->hasFile('foto_sekolah')) {
            if ($sekolah->foto_sekolah) Storage::disk('public')->delete($sekolah->foto_sekolah);
            $data['foto_sekolah'] = $request->file('foto_sekolah')->store('sekolah-info', 'public');
        }

        $sekolah->update($data);

        return redirect()->route('admin.sekolah-info.edit')
            ->with('success', 'Informasi sekolah berhasil diperbarui.');
    }
}