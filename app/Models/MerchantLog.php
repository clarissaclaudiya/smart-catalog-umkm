<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantLog extends Model
{
    protected $table = 'merchant_approval_logs';

    protected $fillable = ['merchant_id', 'admin_id', 'action', 'note'];

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Label badge berdasarkan aksi
     */
    public function getActionBadgeAttribute(): string
    {
        return match($this->action) {
            'approved'    => '<span class="badge bg-success px-3 py-2" style="border-radius:20px;">✅ Disetujui</span>',
            'rejected'    => '<span class="badge bg-danger px-3 py-2" style="border-radius:20px;">❌ Ditolak</span>',
            'suspended'   => '<span class="badge bg-warning text-dark px-3 py-2" style="border-radius:20px;">⛔ Dinonaktifkan</span>',
            'reactivated' => '<span class="badge bg-info text-white px-3 py-2" style="border-radius:20px;">🔄 Diaktifkan Ulang</span>',
            default       => '<span class="badge bg-secondary px-3 py-2" style="border-radius:20px;">' . $this->action . '</span>',
        };
    }
}
