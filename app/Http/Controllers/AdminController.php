<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalMedicines = Medicine::count();
        $totalSales = Sale::count();
        $totalRevenue = Sale::sum('total_price');
        $expiredMedicines = Medicine::where('expiry_date', '<', now())->count();
        $recentSales = Sale::with(['medicine', 'user'])->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalMedicines',
            'totalSales',
            'totalRevenue',
            'expiredMedicines',
            'recentSales'
        ));
    }

    public function medicines()
    {
        $medicines = Medicine::with('supplier')->latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function createMedicine()
    {
        $suppliers = \App\Models\Supplier::all();
        return view('admin.medicines.create', compact('suppliers'));
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

        return redirect()->route('admin.medicines')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function editMedicine($id)
    {
        $medicine = Medicine::findOrFail($id);
        $suppliers = \App\Models\Supplier::all();
        return view('admin.medicines.edit', compact('medicine', 'suppliers'));
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

        return redirect()->route('admin.medicines')->with('success', 'Obat berhasil diupdate.');
    }

    public function deleteMedicine($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('admin.medicines')->with('success', 'Obat berhasil dihapus.');
    }

    public function expiredMedicines()
    {
        $medicines = Medicine::where('expiry_date', '<=', now())
            ->orWhere('status', 'expired')
            ->with('supplier')
            ->latest()
            ->paginate(10);

        return view('admin.medicines.expired', compact('medicines'));
    }

    public function apotekers()
    {
        $apotekers = User::where('role', 'apoteker')->latest()->paginate(10);
        return view('admin.apotekers.index', compact('apotekers'));
    }

    public function createApoteker()
    {
        return view('admin.apotekers.create');
    }

    public function storeApoteker(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'apoteker',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('admin.apotekers')->with('success', 'Apoteker berhasil didaftarkan.');
    }

    public function editApoteker($id)
    {
        $apoteker = User::findOrFail($id);
        return view('admin.apotekers.edit', compact('apoteker'));
    }

    public function updateApoteker(Request $request, $id)
    {
        $apoteker = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }

        $apoteker->update($data);

        return redirect()->route('admin.apotekers')->with('success', 'Data apoteker berhasil diupdate.');
    }

    public function deleteApoteker($id)
    {
        $apoteker = User::findOrFail($id);
        $apoteker->delete();

        return redirect()->route('admin.apotekers')->with('success', 'Apoteker berhasil dihapus.');
    }

    public function suppliers()
    {
        $suppliers = \App\Models\Supplier::latest()->paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function purchases()
    {
        $purchases = \App\Models\Purchase::with(['medicine', 'supplier'])
            ->latest()
            ->paginate(10);
        return view('admin.purchases.index', compact('purchases'));
    }

    public function salesReport()
    {
        $sales = Sale::with(['medicine', 'user'])
            ->selectRaw('DATE(sale_date) as date, SUM(total_price) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('admin.sales.report', compact('sales'));
    }
}
