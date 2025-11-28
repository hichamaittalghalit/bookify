<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use App\Models\PayPal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'active_books' => Book::where('is_active', true)->count(),
            'total_orders' => Order::count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'canceled_orders' => Order::where('status', 'canceled')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('price'),
            'total_users' => User::where('role', 'user')->count(),
            'paypal_accounts' => PayPal::count(),
        ];

        $recent_orders = Order::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}
