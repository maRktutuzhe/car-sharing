<?php

namespace App\Services\Rents;

use App\Exceptions\InvalidCarStatusException;
use App\Exceptions\InvalidRentEndingException;
use App\Exceptions\InvalidUserBalanceException;
use App\Exceptions\InvalidUserRentException;
use App\Exceptions\InvalidUserStatusException;
use App\Http\Requests\Rent\StoreRentRequest;
use App\Models\Car;
use App\Models\Rent;
use App\Models\User;

class RentService
{
    /**
     * Проверка данных для аренды
     * 
     * @param StoreRentRequest $request
     * @throws InvalidCarStatusException
     * @throws InvalidRentEndingException
     * @throws InvalidUserBalanceException
     * @throws InvalidUserRentException
     * @throws InvalidUserStatusException
     * @return Rent
     */

    public function changeStatus(StoreRentRequest $request)
    {
        $car = Car::find($request->car_id);
        if ($request->event == 'start') {
            $data = ['status' => 'rented'];
            $car->update($data);
        }
        if ($request->event == 'end') {
            $data = ['status' => 'free'];
            $car->update($data);
        }
        
    }
    
    public function check(StoreRentRequest $request): Rent
    {
        $user = User::find($request->user_id);
        if ($request->event == "start") {}

            if ($user->status == 'active') {
                if ($user->balance < 150000) {
                    throw new InvalidUserBalanceException($user->balance);
                }
                return $this->checkCar($request);
            }
            if ($user->status == 'premium') {
                return $this->checkCar($request);
            };
            
            throw new InvalidUserStatusException($user->status);
        
    }

    /**
     * Проверка события аренды
     * 
     * @param StoreRentRequest $request
     * @throws InvalidCarStatusException
     * @throws InvalidRentEndingException
     * @throws InvalidUserRentException
     * @return Rent
     */
    private function checkCar($request): Rent
    {
        return ($request->event == 'start')? $this->checkStartEvent($request) : $this->checkEndEvent($request);
    }

    /**
     * Проверка для начала аренды
     * 
     * @param StoreRentRequest $request
     * @throws InvalidCarStatusException
     * @throws InvalidUserRentException
     * @return Rent
     */
    private function checkStartEvent(StoreRentRequest $request): Rent
    {
        $user = User::find($request->user_id);
        $car = Car::find($request->car_id);

        if ($car->status != 'free') {
            throw new InvalidCarStatusException;
        }

        if ($lastRent = $user->latestRent) {
            if ($lastRent->event == 'start') {
                throw new InvalidUserRentException($car);
            }
        }
        return $this->createRent($request);
    }

    /**
     * Проверка для завершения аренды
     * 
     * @param StoreRentRequest $request
     * @throws InvalidCarStatusException
     * @throws InvalidRentEndingException
     * @return Rent
     */
    private function checkEndEvent(StoreRentRequest $request): Rent
    {
        $user = User::find($request->user_id);
        $car = Car::find($request->car_id);

        if ($car->status == 'free') {
            throw new InvalidCarStatusException;
        }
        
        return $this->createRent($request);

        if ($lastRent = $user->latestRent) {
            if ($lastRent->event == 'start' && $lastRent->car->id == $car->id) {
                return $this->createRent($request);
            }
        }
        throw new InvalidRentEndingException($car);
    }

    /**
     * Создание записи аренды
     * 
     * @param StoreRentRequest $request
     * @return Rent
     */
    private function createRent(StoreRentRequest $request): Rent
    {
        $car = Car::find($request->car_id);
        $data = $request->validated();
        $data['location_id'] = $car->locations->last()->id;
        return Rent::query()->create($data);
    }

}