<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role == 'admin') {
            // Admin stats
            $totalMerchant = User::where('role', 'merchant')->count();
            $totalProducts = Product::count();
            $pendingOrders = Order::where('status', 'pending')->count();
            
            return view('dashboard', compact('totalMerchant', 'totalProducts', 'pendingOrders'));
        } else {
            // Merchant stats
            $myStock = Order::where('user_id', $user->id)->where('status', 'approved')->count();
            $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
            
            return view('dashboard', compact('myStock', 'pendingOrders'));
        }
    }
}
