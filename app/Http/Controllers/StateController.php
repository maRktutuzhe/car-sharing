<?php

namespace App\Http\Controllers;

use App\Http\Requests\State\StoreStateRequest;
use App\Http\Requests\State\UpdateStateRequest;
use App\Http\Resources\State\StateResource;
use App\Http\Resources\State\StateResourceCollection;
use App\Models\State;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Index API Method
     *
     * @OA\Get(
     *     path="/api/states",
     *     operationId="/api/states(GET)",
     *     summary="Список моделей",
     *     tags={"Событие"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает список",
     *         @OA\JsonContent(example="")
     *     )
     * )
     *
     * Возвращает список событий
     * @return StateResourceCollection
     */
    public function index(): StateResourceCollection
    {
        return new StateResourceCollection(State::all());
    }

    /**
     * Store API Method
     *
     * @OA\Post (
     *     path="/api/states",
     *     operationId="/api/states(POST)",
     *     summary="Добавление записи",
     *     tags={"Событие"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/StoreStateRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Возвращает модель новой записи",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param StoreStateRequest $request
     * @return StateResource
     */
    public function store(StoreStateRequest $request): StateResource
    {
        $data = $request->validated();
        $state = State::query()->create($data);

        return new StateResource($state);
    }

    /**
     * Show API Method
     *
     * @OA\Get(
     *     path="/api/states/{id}",
     *     operationId="/api/states/{id}(GET)",
     *     summary="Получить запись",
     *     tags={"Событие"},
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
     * @param StoreStateRequest $request
     * @return StateResource
     */
    public function show(State $state): StateResource
    {
        return new StateResource($state);
    }

    /**
     * Update API Method
     *
     * @OA\Put (
     *     path="/api/states/{id}",
     *     operationId="/api/states/{id}(PUT)",
     *     summary="Обновление записи",
     *     tags={"Событие"},
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
     *       @OA\JsonContent(ref="#/components/schemas/UpdateStateRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает положительный ответ",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param UpdateStateRequest $request
     * @param State $state
     * @return StateResource
     */
    public function update(UpdateStateRequest $request, State $state): StateResource
    {
        $data = $request->validated();
        $state->update($data);

        return new StateResource($state);
    }

    /**
     * Delete API Method
     *
     * @OA\Delete(
     *     path="/api/states/{id}",
     *     operationId="/api/states/{id}(DELETE)",
     *     summary="Удалить запись",
     *     tags={"Событие"},
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
     * @param State $state
     * @return JsonResponse
     */
    public function destroy(State $state): JsonResponse
    {
        $state->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
