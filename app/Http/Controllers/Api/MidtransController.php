<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;


class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // Log callback received
        \Log::info('Midtrans callback received', [
            'order_id' => $request->order_id,
            'transaction_status' => $request->transaction_status,
            'payment_type' => $request->payment_type,
            'gross_amount' => $request->gross_amount
        ]);

        // Handle Midtrans callback logic here
        $serverKey = config('midtrans.serverKey');
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $transaction = Transaction::with(['boardingHouse'])->where('code', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Fonnte tidak butuh inisialisasi Client di sini, cukup pakai Token nanti di method sendWhatsAppMessage

        // Format nomor ke format internasional (+62...)
        $phoneNumber = $this->formatPhoneNumber($transaction->phone_number);

        $message =
            "Halo, " . $transaction->name . " !" . PHP_EOL . PHP_EOL .
            "Kami telah menerima pembayaran untuk transaksi dengan kode " . $transaction->code . "." . PHP_EOL .
            "Total pembayaran : Rp " . number_format($transaction->total_amount, 0, ',', '.') . "." . PHP_EOL .
            "Anda bisa datang ke kos : " . $transaction->boardingHouse->name . PHP_EOL .
            "Alamat : " . $transaction->boardingHouse->address . PHP_EOL .
            "Mulai tanggal : " . date('d-m-y', strtotime($transaction->start_date))    . PHP_EOL . PHP_EOL .
            "Terima kasih atas kepercayaan anda! 🤗" . PHP_EOL .
            "Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami." . PHP_EOL .
            "Kami tunggu kedatangan Anda di kos kami! 🏠";

        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $transaction->payment_status = 'pending';
                        $this->sendWhatsAppMessage($phoneNumber, $message);
                    } else {
                        $transaction->payment_status = 'success';
                        $this->sendWhatsAppMessage($phoneNumber, $message);
                    }
                }
                break;
            case 'settlement':
                $transaction->update(['payment_status' => 'success']);
                $this->sendWhatsAppMessage($phoneNumber, $message);
                break;
            case 'pending':
                $transaction->update(['payment_status' => 'pending']);
                break;
            case 'deny':
                $transaction->update(['payment_status' => 'failed']);
                break;
            case 'expire':
                $transaction->update(['payment_status' => 'expire']);
                break;
            case 'cancel':
                $transaction->update(['payment_status' => 'canceled']);
                break;
            default:
                $transaction->update(['payment_status' => 'unknown']);
                break;
        }

        return response()->json(['message' => 'Callback received successfully']);
    }

    /**
     * Format nomor telepon ke format internasional
     * Konversi: 08xxx... menjadi +62xxx...
     */
    private function sendWhatsAppMessage(string $to, string $message)
    {
        $token = env('FONNTE_TOKEN');

        if (!$token) {
            \Log::error('Fonnte token is missing in .env');
            return null;
        }

        // Fonnte biasanya menggunakan nomor tanpa +
        $targetNumber = ltrim($to, '+');

        \Log::info('Fonnte WhatsApp send attempt', [
            'to' => $targetNumber,
            'message' => $message,
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $targetNumber,
                'message' => $message,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            \Log::error('Fonnte WhatsApp Error', [
                'message' => $e->getMessage(),
                'to' => $targetNumber,
            ]);
            return null;
        }
    }

    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . ltrim($phone, '0');
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        if (!str_starts_with($phone, '+')) {
            $phone = '+' . $phone;
        }

        return $phone;
    }
}
