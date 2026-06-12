<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Ngekos API Documentation",
 *     version="1.0.0",
 *     description="Dokumentasi API untuk aplikasi Ngekos"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Local API Server"
 * )
 */
class OpenApi {}
