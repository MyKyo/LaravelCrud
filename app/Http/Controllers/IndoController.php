<?php

namespace App\Http\Controllers;

use App\Models\Indo;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndoController extends Controller
{
    /**
     * Menampilkan semua data (INDEX)
     */
    public function index(Request $request)
    {
        // Cek jika admin untuk menampilkan view berbeda
        if (session('is_admin')) {
            $indo = Indo::query();
            $pembelians = Pembelian::with('indo')
                         ->latest()
                         ->paginate(10);
            
            if ($request->has('search')) {
                $indo->where('namabarang', 'like', '%'.$request->search.'%')
                      ->orWhere('nama', 'like', '%'.$request->search.'%');
            }
            
            return view('indo.admin_index', [
                'indo' => $indo->paginate(10),
                'pembelians' => $pembelians
            ]);
        }

        // Untuk user biasa
        $query = Indo::where('jumlahbarang', '>', 0);
        
        if ($request->has('search')) {
            $query->where('namabarang', 'like', '%'.$request->search.'%')
                  ->orWhere('nama', 'like', '%'.$request->search.'%');
        }
        
        return view('indo.index', [
            'indo' => $query->paginate(10)
        ]);
    }

    /**
     * Menampilkan form tambah data (CREATE)
     */
    public function create()
    {
        $this->checkAdmin();
        return view('indo.create');
    }

    /**
     * Menyimpan data baru (STORE)
     */
    public function store(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'namabarang' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'jumlahbarang' => 'required|integer|min:0'
        ]);

        Indo::create($validated);
        return redirect()->route('indo.index')
                       ->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit (EDIT)
     */
    public function edit($id)
    {
        $this->checkAdmin();
        $indo = Indo::findOrFail($id);
        return view('indo.edit', compact('indo'));
    }

    /**
     * Mengupdate data (UPDATE)
     */
    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'namabarang' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'jumlahbarang' => 'required|integer|min:0'
        ]);

        $indo = Indo::findOrFail($id);
        $indo->update($validated);
        return redirect()->route('indo.index')
                       ->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Menghapus data (DESTROY)
     */
    public function destroy($id)
    {
        $this->checkAdmin();

        DB::transaction(function () use ($id) {
            Pembelian::where('indo_id', $id)->delete();
            Indo::destroy($id);
        });

        return redirect()->route('indo.index')
                       ->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Menampilkan form pembelian (SHOWBUY)
     */
    public function showBuy($id)
    {
        $barang = Indo::findOrFail($id);
        
        if ($barang->jumlahbarang <= 0) {
            return redirect()->route('indo.index')
                           ->with('error', 'Stok barang habis');
        }

        return view('indo.buy', compact('barang'));
    }

    /**
     * Memproses pembelian (PROCESSPURCHASE)
     */
    public function processPurchase(Request $request, $id)
    {
        $validated = $request->validate([
            'jumlah_beli' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($id) {
                    $barang = Indo::find($id);
                    if ($value > $barang->jumlahbarang) {
                        $fail('Jumlah beli melebihi stok tersedia');
                    }
                }
            ],
            'nama_pembeli' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|max:20',
            'metode_pembayaran' => 'required|in:transfer,cod,e-wallet'
        ]);

        DB::beginTransaction();

        try {
            $barang = Indo::lockForUpdate()->findOrFail($id);
            
            if ($validated['jumlah_beli'] > $barang->jumlahbarang) {
                throw new \Exception('Stok tidak mencukupi');
            }

            $barang->decrement('jumlahbarang', $validated['jumlah_beli']);

            Pembelian::create([
                'indo_id' => $id,
                'nama_pembeli' => $validated['nama_pembeli'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'jumlah_beli' => $validated['jumlah_beli'],
                'harga_satuan' => $barang->harga,
                'total_harga' => $validated['jumlah_beli'] * $barang->harga,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status' => $validated['metode_pembayaran'] == 'cod' ? 'pending' : 'paid'
            ]);

            DB::commit();

            return redirect()->route('indo.index')
                           ->with('success', 'Pembelian berhasil! Stok berkurang '.$validated['jumlah_beli'].' unit');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                       ->with('error', 'Pembelian gagal: '.$e->getMessage());
        }
    }

    /**
     * Menampilkan riwayat pembelian (HISTORY)
     */
    public function history(Request $request)
    {
        $query = Pembelian::with('indo')->latest();
        
        if ($request->has('search')) {
            $query->whereHas('indo', function($q) use ($request) {
                $q->where('namabarang', 'like', '%'.$request->search.'%')
                  ->orWhere('nama', 'like', '%'.$request->search.'%');
            })->orWhere('nama_pembeli', 'like', '%'.$request->search.'%');
        }
        
        return view('indo.history', [
            'pembelians' => $query->paginate(10)
        ]);
    }

    /**
     * Pengecekan akses admin
     */
    private function checkAdmin()
    {
        if (!session('is_admin')) {
            abort(403, 'Akses hanya untuk admin');
        }
    }
}