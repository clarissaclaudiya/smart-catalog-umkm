<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MerchantLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    /**
     * Tampilkan semua merchant yang sudah approved (aktif kerjasama)
     */
    public function index()
    {
        $merchants = User::where('role', 'merchant')
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('merchants.index', compact('merchants'));
    }

    /**
     * Tampilkan daftar merchant pending (menunggu persetujuan)
     */
    public function pending()
    {
        $pendingMerchants = User::where('role', 'merchant')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('merchants.pending', compact('pendingMerchants'));
    }

    /**
     * Approve merchant + catat log
     */
    public function approve(Request $request, $id)
    {
        $merchant = User::findOrFail($id);
        $merchant->update(['status' => 'approved']);

        MerchantLog::create([
            'merchant_id' => $merchant->id,
            'admin_id'    => Auth::id(),
            'action'      => 'approved',
            'note'        => $request->input('note'),
        ]);

        return redirect('/merchants/pending')
            ->with('success', "Merchant \"{$merchant->name}\" telah disetujui dan bisa login sekarang.");
    }

    /**
     * Reject merchant + catat log
     */
    public function reject(Request $request, $id)
    {
        $merchant = User::findOrFail($id);
        $merchant->update(['status' => 'rejected']);

        MerchantLog::create([
            'merchant_id' => $merchant->id,
            'admin_id'    => Auth::id(),
            'action'      => 'rejected',
            'note'        => $request->input('note'),
        ]);

        return redirect('/merchants/pending')
            ->with('error', "Merchant \"{$merchant->name}\" telah ditolak.");
    }

    /**
     * Suspend merchant langsung (cukup popup konfirmasi, tidak perlu re-approval)
     * Status: suspended — tidak masuk antrian pending
     */
    public function suspend($id)
    {
        $merchant = User::findOrFail($id);
        $merchant->update(['status' => 'suspended']);

        MerchantLog::create([
            'merchant_id' => $merchant->id,
            'admin_id'    => Auth::id(),
            'action'      => 'suspended',
            'note'        => 'Dinonaktifkan oleh admin.',
        ]);

        return redirect('/merchants')
            ->with('warning', "Akun merchant \"{$merchant->name}\" telah dinonaktifkan.");
    }

    /**
     * Aktifkan kembali merchant yang suspended
     */
    public function reactivate($id)
    {
        $merchant = User::findOrFail($id);
        $merchant->update(['status' => 'approved']);

        MerchantLog::create([
            'merchant_id' => $merchant->id,
            'admin_id'    => Auth::id(),
            'action'      => 'reactivated',
            'note'        => 'Diaktifkan kembali oleh admin.',
        ]);

        return redirect('/merchants/suspended')
            ->with('success', "Merchant \"{$merchant->name}\" telah diaktifkan kembali.");
    }

    /**
     * Daftar merchant yang dinonaktifkan (suspended)
     * Ini adalah merchant yang pernah kerjasama tapi kemudian dinonaktifkan admin
     */
    public function suspended()
    {
        // Merchant yang sedang nonaktif
        $suspendedMerchants = User::where('role', 'merchant')
            ->where('status', 'suspended')
            ->latest()
            ->get();

        // Log history nonaktif (suspend & reactivate) untuk ditampilkan di bawah
        $suspensionLogs = MerchantLog::with(['merchant', 'admin'])
            ->whereIn('action', ['suspended', 'reactivated'])
            ->latest()
            ->get();

        return view('merchants.suspended', compact('suspendedMerchants', 'suspensionLogs'));
    }

    /**
     * History persetujuan akun baru (approved & rejected dari registrasi)
     */
    public function history()
    {
        $logs = MerchantLog::with(['merchant', 'admin'])
            ->whereIn('action', ['approved', 'rejected'])
            ->latest()
            ->paginate(15);

        return view('merchants.history', compact('logs'));
    }
}
