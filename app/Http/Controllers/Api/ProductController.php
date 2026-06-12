<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Menampilkan daftar produk",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data produk",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data produk berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Produk A"),
     *                     @OA\Property(property="price", type="integer", example=15000)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil diambil',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Produk A',
                    'price' => 15000,
                ],
                [
                    'id' => 2,
                    'name' => 'Produk B',
                    'price' => 20000,
                ],
            ],
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Menyimpan produk baru",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","price"},
     *             @OA\Property(property="name", type="string", example="Produk Baru"),
     *             @OA\Property(property="price", type="integer", example=25000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produk berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Produk berhasil dibuat")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dibuat',
            'data' => [
                'name' => $request->name,
                'price' => $request->price,
            ],
        ], 201);
    }
}
