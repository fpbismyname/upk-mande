<?php

namespace App\Observers;

use App\Models\Pendanaan;
use App\Models\Pinjaman;
use App\Models\Status;

class ObserverPinjaman
{
    /**
     * Handle the Pinjaman "created" event.
     */
    public function created(Pinjaman $pinjaman): void
    {
        //
    }

    /**
     * Handle the Pinjaman "updated" event.
     */
    public function updated(Pinjaman $pinjaman): void
    {
        $pernah_batalkan_pinjaman = $pinjaman->dana_kembali;
        $statusPinjamanSekarang = Status::where('id', $pinjaman->status_id)->get()->first()->toArray()['nama_status'];
        $saldoPendanaan = Pendanaan::get()->first();
        if (!$pernah_batalkan_pinjaman && $pinjaman->isDirty('status_id') && $statusPinjamanSekarang === 'dibatalkan') {
            $saldoPendanaan->saldo += $pinjaman->jumlah_pinjaman;
            $saldoPendanaan->save();
        }
        if (!$pernah_batalkan_pinjaman && $statusPinjamanSekarang === 'belum lunas') {
            // Klo berhasil kurangi saldo pendanaan
            $saldoPendanaan->saldo = max(0, $saldoPendanaan->saldo - $pinjaman->jumlah_pinjaman);
            $saldoPendanaan->save();
        }
    }

    /**
     * Handle the Pinjaman "deleted" event.
     */
    public function deleted(Pinjaman $pinjaman): void
    {
        //
    }

    /**
     * Handle the Pinjaman "restored" event.
     */
    public function restored(Pinjaman $pinjaman): void
    {
        //
    }

    /**
     * Handle the Pinjaman "force deleted" event.
     */
    public function forceDeleted(Pinjaman $pinjaman): void
    {
        //
    }
}
