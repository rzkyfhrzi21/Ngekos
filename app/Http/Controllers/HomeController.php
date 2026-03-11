<?php

namespace App\Http\Controllers;

use App\Interfaces\{BoardingHouseRepositoryInterface, CategoryRepositoryInterface, CityRepositoryInterface};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private CityRepositoryInterface $cityRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private BoardingHouseRepositoryInterface $boardingHouseRepository;

    public function __construct(
        CityRepositoryInterface $cityRepository,
        CategoryRepositoryInterface $categoryRepository,
        BoardingHouseRepositoryInterface $boardingHouseRepository
    ) {
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->boardingHouseRepository = $boardingHouseRepository;
    }

    public function index()
    {

        $categories = $this->categoryRepository->getAllCategories();
        $cities = $this->cityRepository->getAllCities();
        $boardingHouses = $this->boardingHouseRepository->getAllBoardingHouses();
        $popularBoardingHouses = $this->boardingHouseRepository->getPopularBoardingHouse();

        return view('pages.home', compact('categories', 'cities', 'boardingHouses', 'popularBoardingHouses'));
    }
}
