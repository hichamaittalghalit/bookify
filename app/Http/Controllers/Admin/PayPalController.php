<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayPal;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paypals = PayPal::orderBy('created_at', 'desc')->get();
        return view('admin.paypals.index', compact('paypals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.paypals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'email' => 'required|email',
            'test_client_id' => 'required|string',
            'test_secret_key' => 'required|string',
            'live_client_id' => 'nullable|string',
            'live_secret_key' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['transactions_count'] = 0;

        PayPal::create($validated);

        return redirect()->route('admin.paypals.index')->with('success', __('admin.paypal_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paypal = PayPal::findOrFail($id);
        return view('admin.paypals.show', compact('paypal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paypal = PayPal::findOrFail($id);
        return view('admin.paypals.edit', compact('paypal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paypal = PayPal::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'email' => 'required|email',
            'test_client_id' => 'required|string',
            'test_secret_key' => 'required|string',
            'live_client_id' => 'nullable|string',
            'live_secret_key' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $paypal->update($validated);

        return redirect()->route('admin.paypals.index')->with('success', __('admin.paypal_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paypal = PayPal::findOrFail($id);
        $paypal->delete();

        return redirect()->route('admin.paypals.index')->with('success', __('admin.paypal_deleted'));
    }
}
