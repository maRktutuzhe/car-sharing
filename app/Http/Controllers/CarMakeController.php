<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarMake\StoreCarMakeRequest;
use App\Http\Requests\CarMake\UpdateCarMakeRequest;
use App\Http\Resources\CarMake\CarMakeResource;
use App\Http\Resources\CarMake\CarMakeResourceCollection;
use App\Models\CarMake;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CarMakeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Index API Method
     *
     * @OA\Get(
     *     path="/api/carmakes",
     *     operationId="/api/carmakes(GET)",
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
     * @return CarMakeResourceCollection
     */
    public function index(): CarMakeResourceCollection
    {
        return new CarMakeResourceCollection(CarMake::all());
    }

    /**
     * Store API Method
     *
     * @OA\Post (
     *     path="/api/carmakes",
     *     operationId="/api/carmakes(POST)",
     *     summary="Добавление записи",
     *     tags={"Марки машин"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/StoreCarMakeRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Возвращает модель новой записи",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param StoreCarMakeRequest $request
     * @return CarMakeResource
     */
    public function store(StoreCarMakeRequest $request): CarMakeResource
    {
        $data = $request->validated();
        $carMake = CarMake::query()->create($data);

        return new CarMakeResource($carMake);
    }

    /**
     * Show API Method
     *
     * @OA\Get(
     *     path="/api/carmakes/{id}",
     *     operationId="/api/carmakes/{id}(GET)",
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
     * @param StoreCarMakeRequest $request
     * @return CarMakeResource
     */
    public function show(CarMake $carMake): CarMakeResource
    {
        return new CarMakeResource($carMake);
    }

    /**
     * Update API Method
     *
     * @OA\Put (
     *     path="/api/carmakes/{id}",
     *     operationId="/api/carmakes/{id}(PUT)",
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
     *       @OA\JsonContent(ref="#/components/schemas/UpdateCarMakeRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает положительный ответ",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param UpdateCarMakeRequest $request
     * @param CarMake $carMake
     * @return CarMakeResource
     */
    public function update(UpdateCarMakeRequest $request, CarMake $carMake): CarMakeResource
    {
        $data = $request->validated();
        $carMake->update($data);

        return new CarMakeResource($carMake);
    }

    /**
     * Delete API Method
     *
     * @OA\Delete(
     *     path="/api/carmakes/{id}",
     *     operationId="/api/carmakes/{id}(DELETE)",
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
     * @param CarMake $carMake
     * @return JsonResponse
     */
    public function destroy(CarMake $carMake): JsonResponse
    {
        $carMake->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
