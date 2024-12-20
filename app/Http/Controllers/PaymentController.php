<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function updateStatus($id)
    {
        try {
            // Cek apakah payment ada
            $payment = Payment::findOrFail($id);
            
            // Debug untuk melihat data sebelum diupdate
            Log::info('Payment before update:', ['payment' => $payment]);
            
            // Update status
            $payment->status = 'pending';
            $result = $payment->save();
            
            // Debug untuk melihat hasil update
            Log::info('Update result:', ['success' => $result]);
            Log::info('Payment after update:', ['payment' => $payment->fresh()]);

            if($result) {
                return redirect()->back()->with('success', 'Status pembayaran berhasil diubah menjadi pending');
            } else {
                return redirect()->back()->with('error', 'Gagal mengubah status pembayaran');
            }
        } catch (\Exception $e) {
            // Debug untuk melihat error yang terjadi
            Log::error('Error updating payment status:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
