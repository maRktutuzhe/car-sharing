<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCarStatusException;
use App\Exceptions\InvalidRentEndingException;
use App\Exceptions\InvalidUserBalanceException;
use App\Exceptions\InvalidUserRentException;
use App\Exceptions\InvalidUserStatusException;
use App\Http\Requests\Rent\StoreRentRequest;
use App\Http\Requests\Rent\UpdateRentRequest;
use App\Http\Resources\Rent\RentResource;
use App\Http\Resources\Rent\RentResourceCollection;
use App\Models\Rent;
use App\Services\Rents\RentService;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Index API Method
     *
     * @OA\Get(
     *     path="/api/rents",
     *     operationId="/api/rents(GET)",
     *     summary="Список моделей",
     *     tags={"Аренда"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает список",
     *         @OA\JsonContent(example="")
     *     )
     * )
     *
     * Возвращает список аренд
     * @return RentResourceCollection
     */
    public function index(): RentResourceCollection
    {
        return new RentResourceCollection(Rent::all());
    }

    /**
     * Store API Method
     *
     * @OA\Post (
     *     path="/api/rents",
     *     operationId="/api/rents(POST)",
     *     summary="Добавление записи",
     *     tags={"Аренда"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/StoreRentRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Возвращает модель новой записи",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param StoreRentRequest $request
     * @return RentResource|string
     */
    public function store(StoreRentRequest $request): RentResource|string
    {
        $service = new RentService();
        
        try {
            $rent = $service->check($request);
            
            return new RentResource($rent);
        } catch (InvalidUserStatusException $e) {

            return $e->getMessage();
        } catch (InvalidUserBalanceException $e) {

            return $e->getMessage();
        } catch (InvalidCarStatusException $e) {

            return $e->getMessage();
        } catch (InvalidUserRentException $e) {

            return $e->getMessage();
        } catch (InvalidRentEndingException $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show API Method
     *
     * @OA\Get(
     *     path="/api/rents/{id}",
     *     operationId="/api/rents/{id}(GET)",
     *     summary="Получить запись",
     *     tags={"Аренда"},
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
     * @param StoreRentRequest $request
     * @return RentResource
     */
    public function show(Rent $rent): RentResource
    {
        return new RentResource($rent);
    }

    /**
     * Update API Method
     *
     * @OA\Put (
     *     path="/api/rents/{id}",
     *     operationId="/api/rents/{id}(PUT)",
     *     summary="Обновление записи",
     *     tags={"Аренда"},
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
     *       @OA\JsonContent(ref="#/components/schemas/UpdateRentRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает положительный ответ",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param UpdateRentRequest $request
     * @param Rent $rent
     * @return RentResource
     */
    public function update(UpdateRentRequest $request, Rent $rent): RentResource
    {
        $data = $request->validated();
        $rent->update($data);

        return new RentResource($rent);
    }

    /**
     * Delete API Method
     *
     * @OA\Delete(
     *     path="/api/rents/{id}",
     *     operationId="/api/rents/{id}(DELETE)",
     *     summary="Удалить запись",
     *     tags={"Аренда"},
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
     * @param Rent $rent
     * @return JsonResponse
     */
    public function destroy(Rent $rent): JsonResponse
    {
        $rent->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
