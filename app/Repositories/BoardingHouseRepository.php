<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Models\{BoardingHouse, Room, Transaction};
use App\Interfaces\BoardingHouseRepositoryInterface;

class BoardingHouseRepository implements BoardingHouseRepositoryInterface
{
    public function getAllBoardingHouses($search = null, $city = null, $category = null)
    {
        $query = BoardingHouse::query();

        // DISINI KETIKA SEARCH DIISI MAKA DIA AKAN MENCARI NAMA YANG MENGANDUNG KEYWORD YANG DIINPUTKAN
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // DISINI KETIKA CITY DIISI MAKA DIA AKAN MENCARI NAMA CITY YANG MENGANDUNG KEYWORD YANG DIINPUTKAN
        if ($city) {
            $query->whereHas('city', function (Builder $query) use ($city) {
                $query->where('slug', $city);
            });
        }

        // DISINI KETIKA CATEGORY DIISI MAKA DIA AKAN MENCARI NAMA CATEGORY YANG MENGANDUNG KEYWORD YANG DIINPUTKAN
        if ($category) {
            $query->whereHas('category', function (Builder $query) use ($category) {
                $query->where('slug', $category);
            });
        }

        return $query->get();
    }

    public function getPopularBoardingHouse($limit = 5)
    {
        // DISINI DIA AKAN MENGAMBIL DATA BOARDING HOUSE YANG PALING BANYAK TRANSAKSINYA
        return BoardingHouse::withCount('transactions')->orderBy('transactions_count', 'desc')->take($limit)->get();
    }


    public function getBoardingHouseByCategorySlug($slug)
    {
        // DISINI DIA AKAN MENCARI BOARDING HOUSE YANG MENGANDUNG CATEGORY SLUG YANG DIINPUTKAN
        return BoardingHouse::whereHas('category', function (Builder $query) use ($slug) {
            $query->where('slug', $slug);
        })->get();
    }
    public function getBoardingHouseByCitySlug($slug)
    {
        // DISINI DIA AKAN MENCARI BOARDING HOUSE YANG MENGANDUNG CITY SLUG YANG DIINPUTKAN
        return BoardingHouse::whereHas('city', function (Builder $query) use ($slug) {
            $query->where('slug', $slug);
        })->get();
    }

    public function getBoardingHouseBySlug($slug)
    {
        // DISINI DIA AKAN MENCARI BOARDING HOUSE YANG MENGANDUNG SLUG YANG DIINPUTKAN
        return BoardingHouse::where('slug', $slug)->firstOrFail();
    }

    public function getBoardingHouseRoomById($id)
    {
        return Room::find($id);
    }
}
