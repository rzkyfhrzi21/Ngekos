<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function information($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);

        if (!isset($transaction['room_id'])) {
            abort(404, 'Room tidak ditemukan');
        }

        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.information', compact('boardingHouse', 'transaction', 'room'));
    }

    public function check()
    {
        return view('pages.check-booking');
    }
}
