<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Http\Resources\Car\CarResource;
use App\Http\Resources\Car\CarResourceCollection;
use App\Http\Resources\Location\LocationResource;
use App\Models\Car;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Index API Method
     *
     * @OA\Get(
     *     path="/api/cars",
     *     operationId="/api/cars(GET)",
     *     summary="Список моделей",
     *     tags={"Марки машин"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает список",
     *         @OA\JsonContent(example="")
     *     )
     * )
     *
     * Возвращает список марок
     * @return CarResourceCollection
     */
    public function index(): CarResourceCollection
    {
        return new CarResourceCollection(Car::all());
    }

    /**
     * Store API Method
     *
     * @OA\Post (
     *     path="/api/cars",
     *     operationId="/api/cars(POST)",
     *     summary="Добавление записи",
     *     tags={"Марки машин"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/StoreCarRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Возвращает модель новой записи",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param StoreCarRequest $request
     * @return CarResource
     */
    public function store(StoreCarRequest $request): CarResource
    {
        $data = $request->validated();
        $car = Car::query()->create($data);

        return new CarResource($car);
    }

    /**
     * Show API Method
     *
     * @OA\Get(
     *     path="/api/cars/{id}",
     *     operationId="/api/cars/{id}(GET)",
     *     summary="Получить запись",
     *     tags={"Марки машин"},
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
     * @param StoreCarRequest $request
     * @return CarResource
     */
    public function show(Car $car): CarResource
    {
        return new CarResource($car);
    }

    /**
     * Update API Method
     *
     * @OA\Put (
     *     path="/api/cars/{id}",
     *     operationId="/api/cars/{id}(PUT)",
     *     summary="Обновление записи",
     *     tags={"Марки машин"},
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
     *       @OA\JsonContent(ref="#/components/schemas/UpdateCarRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает положительный ответ",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param UpdateCarRequest $request
     * @param Car $car
     * @return CarResource
     */
    public function update(UpdateCarRequest $request, Car $car): CarResource
    {
        $data = $request->validated();
        $car->update($data);

        return new CarResource($car);
    }

    /**
     * Delete API Method
     *
     * @OA\Delete(
     *     path="/api/cars/{id}",
     *     operationId="/api/cars/{id}(DELETE)",
     *     summary="Удалить запись",
     *     tags={"Марки машин"},
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
     * @param Car $car
     * @return JsonResponse
     */
    public function destroy(Car $car): JsonResponse
    {
        $car->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function showFree()
    {

        // TODO: ДЕЛАТЬ ЧЕРЕРЗ ИНДЕКС, ИСПОЛЬЗОВАТЬ ФИЛЬТРЫ И ИНКЛЮДИСЫ, А ЭТО УДАЛИТЬ


        $carsData = [];
        // $cars = Car::where('status', 'free')->get();
        $cars = Car::Where('status', 'free')->with([
            'locations',
        ])->get();
        return $cars;
        return  CarResource::collection($cars);
        foreach ($cars as $car) {
            $location =  $car->locations->last();
            $res = new LocationResource($location);
            $carData = [
                'carMake' => $car->carMake->name,
                'name' => $car->name,
                'number' => $car->number,
                'color' => $car->color,
                'damages' => $car->damages,
                'location' => $res
            ];
            $carsData[] = $carData;
        }
        return $carsData;
    }
}
