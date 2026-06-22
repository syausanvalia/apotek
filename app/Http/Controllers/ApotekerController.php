<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use Illuminate\Http\Request;

class ApotekerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || auth()->user()->role !== 'apoteker') {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalMedicines = Medicine::count();
        $todaySales = Sale::whereDate('sale_date', today())->count();
        $lowStockMedicines = Medicine::where('stock', '<', 10)->count();
        $recentSales = Sale::with(['medicine', 'user'])->orderBy('created_at', 'desc')->limit(5)->get();

        return view('apoteker.dashboard', compact(
            'totalMedicines',
            'todaySales',
            'lowStockMedicines',
            'recentSales'
        ));
    }

    public function medicines()
    {
        $medicines = Medicine::with('supplier')->latest()->paginate(10);
        return view('apoteker.medicines.index', compact('medicines'));
    }

    public function searchMedicines(Request $request)
    {
        $query = $request->input('search');
        $medicines = Medicine::where('name', 'like', "%{$query}%")
            ->orWhere('category', 'like', "%{$query}%")
            ->with('supplier')
            ->latest()
            ->paginate(10);

        return view('apoteker.medicines.index', compact('medicines', 'query'));
    }

    public function createMedicine()
    {
        $suppliers = \App\Models\Supplier::all();
        return view('apoteker.medicines.create', compact('suppliers'));
    }

    public function storeMedicine(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'expiry_date' => 'required|date',
            'status' => 'required|in:available,expired,out_of_stock',
        ]);

        Medicine::create($validated);

        return redirect()->route('apoteker.medicines')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function editMedicine($id)
    {
        $medicine = Medicine::findOrFail($id);
        $suppliers = \App\Models\Supplier::all();
        return view('apoteker.medicines.edit', compact('medicine', 'suppliers'));
    }

    public function updateMedicine(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'expiry_date' => 'required|date',
            'status' => 'required|in:available,expired,out_of_stock',
        ]);

        $medicine->update($validated);

        return redirect()->route('apoteker.medicines')->with('success', 'Obat berhasil diupdate.');
    }

    public function deleteMedicine($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('apoteker.medicines')->with('success', 'Obat berhasil dihapus.');
    }

    public function expiredMedicines()
    {
        $medicines = Medicine::where('expiry_date', '<=', now())
            ->orWhere('status', 'expired')
            ->with('supplier')
            ->latest()
            ->paginate(10);

        return view('apoteker.medicines.expired', compact('medicines'));
    }

    public function deleteExpiredMedicine($id)
    {
        $medicine = Medicine::findOrFail($id);
        
        if ($medicine->isExpired() || $medicine->status === 'expired') {
            $medicine->delete();
            return redirect()->route('apoteker.expired-medicines')->with('success', 'Obat kadaluarsa berhasil dihapus.');
        }

        return redirect()->route('apoteker.expired-medicines')->with('error', 'Obat ini belum kadaluarsa.');
    }

    public function salesHistory()
    {
        $sales = Sale::with(['medicine', 'user'])
            ->latest()
            ->paginate(15);

        return view('apoteker.sales.index', compact('sales'));
    }

    public function createSale()
    {
        $medicines = Medicine::where('status', 'available')->where('stock', '>', 0)->get();
        return view('apoteker.sales.create', compact('medicines'));
    }

    public function storeSale(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $medicine = Medicine::findOrFail($validated['medicine_id']);

        if ($medicine->stock < $validated['quantity']) {
            return back()->with('error', 'Stok obat tidak mencukupi.');
        }

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'medicine_id' => $validated['medicine_id'],
            'quantity' => $validated['quantity'],
            'unit_price' => $medicine->price,
            'total_price' => $medicine->price * $validated['quantity'],
            'sale_date' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        $medicine->decrement('stock', $validated['quantity']);

        return redirect()->route('apoteker.sales-history')->with('success', 'Penjualan berhasil dicatat.');
    }

    public function viewSale($id)
    {
        $sale = Sale::with(['medicine', 'user'])->findOrFail($id);
        return view('apoteker.sales.show', compact('sale'));
    }
}
