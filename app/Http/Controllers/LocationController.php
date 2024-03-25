<?php

namespace App\Http\Controllers;

use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\Location\LocationResourceCollection;
use App\Models\Location;
use App\Services\Locations\LocationService;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Index API Method
     *
     * @OA\Get(
     *     path="/api/locations",
     *     operationId="/api/locations(GET)",
     *     summary="Список моделей",
     *     tags={"Локация"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает список",
     *         @OA\JsonContent(example="")
     *     )
     * )
     *
     * Возвращает список локаций
     * @return LocationResourceCollection
     */
    public function index(): LocationResourceCollection
    {

        return new LocationResourceCollection(Location::all());
    }

    /**
     * Store API Method
     *
     * @OA\Post (
     *     path="/api/locations",
     *     operationId="/api/locations(POST)",
     *     summary="Добавление записи",
     *     tags={"Локация"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/StoreLocationRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Возвращает модель новой записи",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param StoreLocationRequest $request
     * @return LocationResource
     */
    public function store(StoreLocationRequest $request)
    {
        $service = new LocationService();
        $location = $service->storeLocation($request);
        
        return new LocationResource($location);
    }

    /**
     * Show API Method
     *
     * @OA\Get(
     *     path="/api/locations/{id}",
     *     operationId="/api/locations/{id}(GET)",
     *     summary="Получить запись",
     *     tags={"Локация"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Идентификатор записи",
     *         required=true,
     *         @OA\Schema(type="string", format="id")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Отображает существующую запись",
     *     ),
     *     @OA\Response(response="401",description="Unauthorized"),
     *     @OA\Response(response="404",description="Not found"),
     * )
     * @param StoreLocationRequest $request
     * @return LocationResource
     */
    public function show(Location $location): LocationResource
    {
        return new LocationResource($location);

        //  Превращение координат в адрес
        // $latitude = 51.834436;
        // $longitude = 55.160602;
        
        // $url = 'https://nominatim.openstreetmap.org/reverse?lat=' . $latitude . '&lon=' . $longitude . '&format=json';
        
        // $client = new Client();
        // $response = $client->request('GET', $url);
        
        // if ($response->getStatusCode() == 200) {
        //     $data = json_decode($response->getBody(), true);
        //     if (!empty($data)) {
        //         $address = $data['display_name'];
        //         return ($address);
        //     } else {
        //         return ("Адрес не найден");
        //     }
        // } else {
        //     return ("Ошибка при выполнении запроса");
        // }

    }

    /**
     * Update API Method
     *
     * @OA\Put (
     *     path="/api/locations/{id}",
     *     operationId="/api/locations/{id}(PUT)",
     *     summary="Обновление записи",
     *     tags={"Локация"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Идентификатор записи",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/UpdateLocationRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает положительный ответ",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param UpdateLocationRequest $request
     * @param Location $location
     * @return LocationResource
     */
    public function update(UpdateLocationRequest $request, Location $location): LocationResource
    {
        $service = new LocationService();
        $location = $service->updateLocation($request, $location);

        return new LocationResource($location);
    }

    /**
     * Delete API Method
     *
     * @OA\Delete(
     *     path="/api/locations/{id}",
     *     operationId="/api/locations/{id}(DELETE)",
     *     summary="Удалить запись",
     *     tags={"Локация"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Идентификатор записи",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Удаляет существующую запись",
     *         @OA\JsonContent(example="")
     *     )
     * )
     * @param Location $location
     * @return JsonResponse
     */
    public function destroy(Location $location): JsonResponse
    {
        $location->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
