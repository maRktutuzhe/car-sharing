<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserResourceCollection;
use App\Models\User;
use App\Services\CustomKMeans;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Phpml\Clustering\KMeans;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Index API Method
     *
     * @OA\Get(
     *     path="/api/users",
     *     operationId="/api/users(GET)",
     *     summary="Список моделей",
     *     tags={"Пользователи"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает список",
     *         @OA\JsonContent(example="")
     *     )
     * )
     *
     * Возвращает список пользователей
     * @return UserResourceCollection
     */
    public function index(): UserResourceCollection
    {
        return new UserResourceCollection(User::all());
    }
    
    /**
     * Store API Method
     *
     * @OA\Post (
     *     path="/api/users",
     *     operationId="/api/users(POST)",
     *     summary="Добавление записи",
     *     tags={"Пользователи"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Возвращает модель новой записи",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param StoreUserRequest $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $data = $request->validated();
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = User::query()->create($data);
        return new UserResource($user);
    }

    /**
     * Show API Method
     *
     * @OA\Get(
     *     path="/api/users/{id}",
     *     operationId="/api/users/{id}(GET)",
     *     summary="Получить запись",
     *     tags={"Пользователи"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Идентификатор записи",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Отображает существующую запись",
     *     ),
     *     @OA\Response(response="401",description="Unauthorized"),
     *     @OA\Response(response="404",description="Not found"),
     * )
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update API Method
     *
     * @OA\Put (
     *     path="/api/users/{id}",
     *     operationId="/api/users/{id}(PUT)",
     *     summary="Обновление записи",
     *     tags={"Пользователи"},
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
     *       @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Возвращает положительный ответ",
     *         @OA\JsonContent(example="")
     *     ),
     *     @OA\Response(response="422", description="Возвращает ошибки валидации")
     * )
     * @param UpdateUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $data = $request->validated();
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return new UserResource($user);
    }

    /**
     * Delete API Method
     *
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     operationId="/api/users/{id}(DELETE)",
     *     summary="Удалить запись",
     *     tags={"Пользователи"},
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
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function clusterUsers()
    {
        $users = User::all();
        $userData = [];
        $test = [
            // [2,2,2,2],
            //гонщики
            [5,0,7.7,7],
            [4.3,2,9,6],
            [7.5,1,10,6],

            //спокойные
            [3,0,2.1,5],
            [1,1,3.4,7],
            [2.4,0,2.8,6],

            //плохие
            [-3,7,6.3,4],
            [-5.2,5,8,3],
            [-4.2,4,7.7,5],

            //лучшие
            [10,0,2,10],
            [7.9,0,1.2,9],
            [9.8,0,0.2,9],

            // [7,0,2,10],
            // [7.9,5,1.2,7],
            // [6,0,0.2,9]
        ];

        // $test = [
        //     // [2,2,2,2],
        //     //гонщики
        //     [5,0,7],
        //     [4.3,2,6],
        //     [7.5,1,6],

        //     //спокойные
        //     [3,0,5],
        //     [1,1,7],
        //     [2.4,2.8,6],

        //     //плохие
        //     [-3,6.3,4],
        //     [-5.2,8,3],
        //     [-4.2,7.7,5],

        //     //лучшие
        //     [10,2,10],
        //     [7.9,1.2,9],
        //     [9.8,0.2,9],

        //     // [7,0,2,10],
        //     // [7.9,5,1.2,7],
        //     // [6,0,0.2,9]
        // ];

        $test = [
            // [2,2,2,2],
            //гонщики
            [5,7.7,7],
            [4.3,9,6],
            [7.5,10,6],
            [6.3,9.8,8],

            //спокойные
            [3,2.1,5],
            [1,3.4,7],
            [2.4,2.8,6],

            //плохие
            [-3,6.3,4],
            [-5.2,8,3],
            [-4.2,7.7,5],

            //лучшие
            [10,2,10],
            [7.9,1.2,9],
            [9.8,0.2,9],

            // [7,0,2,10],
            // [7.9,5,1.2,7],
            // [6,0,0.2,9]
        ];


        $initialCentroids = [
            [4.3,9,6],
            [1,3.4,7],
            [-5.2,8,3],
            [7.9,1.2,9],
          

        ];

        $customKMeans = new CustomKMeans(4, $initialCentroids);
        $clusters = $customKMeans->cluster($test);

        // return $clusters;

        // mt_srand(42);
        // $kmeans = new KMeans(4);
        // $clusters = $kmeans->cluster($test);
        // return $clusters;
        $userIds = [];
        foreach($users as $user) {
            $userIds[] = $user->first_name . " " . $user->middle_name . ' ' .  $user->last_name;
        }
        // $silhouette = ['silhouette' => $clusters['silhouette']];
        $clusteredUsers = [];
        foreach ($clusters['clusters'] as $clusterIndex => $cluster) {
            foreach ($cluster as $dataPoint) {
                $index = array_search($dataPoint, $test);
                $clusteredUsers[$clusterIndex][] = [
                    'id' => $userIds[$index],
                    'data' => $dataPoint
                ];
            }
        }
        $u = ['clusters' => $clusteredUsers];
        $u['silhouette']= $clusters['silhouette'];
        $u['data']= $test;
        // $clusteredUsers[] = $silhouette;


        return $u;



    }
}
