<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\{BookingShowRequest, CustomerInformationStoreRequest};
use App\Interfaces\{BoardingHouseRepositoryInterface, TransactionRepositoryInterface};

class BookingController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(
        BoardingHouseRepositoryInterface $boardingHouseRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function booking(Request $request, $slug)
    {

        $this->transactionRepository->saveTransactionDataToSession($request->all());

        return redirect()->route('booking.information', $slug);
    }

    public function information(Request $request, $slug)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->only(['boarding_house_id', 'room_id']));

        $transaction = $this->transactionRepository->getTransactionDataFromSession();

        if (!isset($transaction['room_id'])) {
            abort(404, 'Room tidak ditemukan');
        }

        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.information', compact('boardingHouse', 'transaction', 'room'));
    }

    public function saveInformation(CustomerInformationStoreRequest $request, $slug)
    {
        $data = $request->validated();

        $this->transactionRepository->saveTransactionDataToSession($data);

        // dd($this->transactionRepository->getTransactionDataFromSession());

        return redirect()->route('booking.checkout', $slug);
    }

    public function checkout($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();

        if (!isset($transaction['room_id'])) {
            abort(404, 'Room tidak ditemukan');
        }

        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.checkout', compact('boardingHouse', 'transaction', 'room'));
    }

    public function payment(Request $request)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());

        $transaction = $this->transactionRepository->saveTransaction($this->transactionRepository->getTransactionDataFromSession());

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaction->code,
                'gross_amount' => $transaction->total_amount,
            ),
            'customer_details' => array(
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone_number,
            )
        );

        $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        return redirect($paymentUrl);
    }

    public function success(Request $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCode($request->order_id);

        if (!$transaction) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan');
        }

        return view('pages.booking.success', compact('transaction'))->with('success', 'Booking berhasil!');
    }


    public function check()
    {
        return view('pages.booking.check-booking');
    }

    public function show(BookingShowRequest $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCodeEmailPhone($request->code, $request->email, $request->phone_number);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Data Transaksi tidak ditemukan');
        }
    }
}
