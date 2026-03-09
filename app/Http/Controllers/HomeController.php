<?php

namespace App\Http\Controllers;

use App\Repositories\{BoardingHouseRepository, CategoryRepository, CityRepository};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private BoardingHouseRepository $boardingHouseRepository;
    private CategoryRepository $categoryRepository;
    private CityRepository $cityRepository;

    public function __construct(
        BoardingHouseRepository $boardingHouseRepository,
        CategoryRepository $categoryRepository,
        CityRepository $cityRepository
    ) {
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->categoryRepository = $categoryRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        $boardingHouses = $this->boardingHouseRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $cities = $this->cityRepository->getAll();

        return view('home', compact('boardingHouses', 'categories', 'cities'));
    }
}
