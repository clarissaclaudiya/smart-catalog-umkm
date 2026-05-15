<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Merchant: List products available to order with filtering
    public function create(Request $request)
    {
        $categories = \App\Models\Category::all();
        $query = Product::where('stock', '>', 0);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $products = $query->get();
        return view('orders.create', compact('products', 'categories'));
    }

    // Merchant: Place an order
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Validasi stok Admin
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi! Sisa stok Admin: ' . $product->stock);
        }

        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

        return redirect('/my-stock')->with('success', 'Pesanan berhasil dikirim ke Admin!');
    }

    // Merchant: View their own approved stock
    public function myStock()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->with('product')
            ->get();
        return view('orders.my_stock', compact('orders'));
    }

    // Admin: List all pending orders for approval
    public function adminIndex()
    {
        $orders = Order::with(['user', 'product'])->where('status', 'pending')->get();
        return view('orders.admin_index', compact('orders'));
    }

    // Admin: Approve an order
    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $product = $order->product;

        // Cek kembali stok sebelum approve (antisipasi stok habis duluan)
        if ($order->quantity > $product->stock) {
            return back()->with('error', 'Gagal approve! Stok Admin sudah tidak mencukupi.');
        }

        // Potong stok Admin
        $product->decrement('stock', $order->quantity);

        // Update status order
        $order->update(['status' => 'approved']);

        return back()->with('success', 'Pesanan disetujui! Stok Admin telah berkurang.');
    }

    // Admin: Full order history (semua status, semua merchant)
    public function adminHistory(Request $request)
    {
        $query = Order::with(['user', 'product'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by merchant
        if ($request->filled('merchant')) {
            $query->where('user_id', $request->merchant);
        }

        $orders   = $query->paginate(15);
        $merchants = \App\Models\User::where('role', 'merchant')->get(['id', 'name']);

        // Stats
        $totalOrders   = Order::count();
        $totalApproved = Order::where('status', 'approved')->count();
        $totalPending  = Order::where('status', 'pending')->count();
        $totalRevenue  = Order::where('status', 'approved')
            ->with('product')
            ->get()
            ->sum(fn($o) => $o->product ? $o->product->price * $o->quantity : 0);

        return view('orders.admin_history', compact(
            'orders', 'merchants', 'totalOrders', 'totalApproved', 'totalPending', 'totalRevenue'
        ));
    }

    // Merchant: Order history milik sendiri (semua status)
    public function myHistory()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        $totalPending  = $orders->where('status', 'pending')->count();
        $totalApproved = $orders->where('status', 'approved')->count();
        $totalSpent    = $orders->where('status', 'approved')
            ->sum(fn($o) => $o->product ? $o->product->price * $o->quantity : 0);

        return view('orders.my_history', compact('orders', 'totalPending', 'totalApproved', 'totalSpent'));
    }
}
