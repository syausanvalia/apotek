<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function dashboard()
    {
        $medicines = Medicine::where('status', 'available')
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return view('pelanggan.dashboard', compact('medicines'));
    }

    public function medicines()
    {
        $medicines = Medicine::where('status', 'available')
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return view('pelanggan.medicines.index', compact('medicines'));
    }

    public function searchMedicines(Request $request)
    {
        $query = $request->input('search');
        $medicines = Medicine::where('status', 'available')
            ->where('stock', '>', 0)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(12);

        return view('pelanggan.medicines.index', compact('medicines', 'query'));
    }

    public function showMedicine($id)
    {
        $medicine = Medicine::with('supplier')->findOrFail($id);
        return view('pelanggan.medicines.show', compact('medicine'));
    }

    public function purchase($id)
    {
        $medicine = Medicine::findOrFail($id);

        if ($medicine->status !== 'available' || $medicine->stock <= 0) {
            return back()->with('error', 'Obat tidak tersedia untuk dibeli.');
        }

        return view('pelanggan.sales.create', compact('medicine'));
    }

    public function storePurchase(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $medicine->stock,
            'notes' => 'nullable|string',
        ]);

        if ($medicine->stock < $validated['quantity']) {
            return back()->with('error', 'Stok obat tidak mencukupi.');
        }

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'medicine_id' => $id,
            'quantity' => $validated['quantity'],
            'unit_price' => $medicine->price,
            'total_price' => $medicine->price * $validated['quantity'],
            'sale_date' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        $medicine->decrement('stock', $validated['quantity']);

        return redirect()->route('pelanggan.purchase-history')->with('success', 'Pembelian berhasil dilakukan.');
    }

    public function purchaseHistory()
    {
        $sales = Sale::where('user_id', auth()->id())
            ->with('medicine')
            ->latest()
            ->paginate(15);

        return view('pelanggan.sales.history', compact('sales'));
    }

    public function viewSale($id)
    {
        $sale = Sale::where('user_id', auth()->id())->with('medicine')->findOrFail($id);
        return view('pelanggan.sales.show', compact('sale'));
    }
}
