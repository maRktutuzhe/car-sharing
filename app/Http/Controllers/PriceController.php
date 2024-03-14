<?php

namespace App\Http\Controllers;

use App\Http\Requests\Price\StorePriceRequest;
use App\Http\Requests\Price\UpdatePriceRequest;
use App\Http\Resources\Price\PriceResource;
use App\Http\Resources\Price\PriceResourceCollection;
use App\Models\Price;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Index API Method
     *
     * @OA\Get(
     *     path="/api/prices",
     *     operationId="/api/prices(GET)",
     *     summary="Список моделей",
     *     tags={"Цена"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает список",
     *         @OA\JsonContent(example="")
     *     )
     * )
     *
     * Возвращает список марок
     * @return PriceResourceCollection
     */
    public function index(): PriceResourceCollection
    {
        return new PriceResourceCollection(Price::all());
    }

    /**
     * Store API Method
     *
     * @OA\Post (
     *     path="/api/prices",
     *     operationId="/api/prices(POST)",
     *     summary="Добавление записи",
     *     tags={"Цена"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/StorePriceRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Возвращает модель новой записи",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param StorePriceRequest $request
     * @return PriceResource
     */
    public function store(StorePriceRequest $request): PriceResource
    {
        $data = $request->validated();
        $price = Price::query()->create($data);

        return new PriceResource($price);
    }

    /**
     * Show API Method
     *
     * @OA\Get(
     *     path="/api/prices/{id}",
     *     operationId="/api/prices/{id}(GET)",
     *     summary="Получить запись",
     *     tags={"Цена"},
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
     * @param StorePriceRequest $request
     * @return PriceResource
     */
    public function show(Price $price): PriceResource
    {
        return new PriceResource($price);
    }

    /**
     * Update API Method
     *
     * @OA\Put (
     *     path="/api/prices/{id}",
     *     operationId="/api/prices/{id}(PUT)",
     *     summary="Обновление записи",
     *     tags={"Цена"},
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
     *       @OA\JsonContent(ref="#/components/schemas/UpdatePriceRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает положительный ответ",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param UpdatePriceRequest $request
     * @param Price $price
     * @return PriceResource
     */
    public function update(UpdatePriceRequest $request, Price $price): PriceResource
    {
        $data = $request->validated();
        $price->update($data);

        return new PriceResource($price);
    }

    /**
     * Delete API Method
     *
     * @OA\Delete(
     *     path="/api/prices/{id}",
     *     operationId="/api/prices/{id}(DELETE)",
     *     summary="Удалить запись",
     *     tags={"Цена"},
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
     * @param Price $price
     * @return JsonResponse
     */
    public function destroy(Price $price): JsonResponse
    {
        $price->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
