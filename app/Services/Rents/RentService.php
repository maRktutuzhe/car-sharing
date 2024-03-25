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
     * @param StoreRentRequest $data
     * @throws InvalidCarStatusException
     * @throws InvalidRentEndingException
     * @throws InvalidUserBalanceException
     * @throws InvalidUserRentException
     * @throws InvalidUserStatusException
     * @return Rent
     */
    public function check(StoreRentRequest $data)
    {
        $user = User::find($data->user_id);

        if ($user->status == 'active') {
            if ($user->balance < 150000) {
                throw new InvalidUserBalanceException($user->balance);
            }
            return $this->checkCar($data);
        }
        if ($user->status == 'premium') {
            return $this->checkCar($data);
        };
        
        throw new InvalidUserStatusException($user->status);
    }

    /**
     * Проверка события аренды
     * 
     * @param StoreRentRequest $data
     * @throws InvalidCarStatusException
     * @throws InvalidRentEndingException
     * @throws InvalidUserRentException
     * @return Rent
     */
    private function checkCar($data): Rent
    {
        return ($data->event == 'start')? $this->checkStartEvent($data) : $this->checkEndEvent($data);
    }

    /**
     * Проверка для начала аренды
     * 
     * @param StoreRentRequest $data
     * @throws InvalidCarStatusException
     * @throws InvalidUserRentException
     * @return Rent
     */
    private function checkStartEvent($data): Rent
    {
        $user = User::find($data->user_id);
        $car = Car::find($data->car_id);

        if ($car->status != 'free') {
            throw new InvalidCarStatusException;
        }

        if ($lastRent = $user->latestRent) {
            if ($lastRent->event == 'start') {
                throw new InvalidUserRentException($car);
            }
        }
        return $this->createRent($data);
    }

    /**
     * Проверка для завершения аренды
     * 
     * @param StoreRentRequest $data
     * @throws InvalidCarStatusException
     * @throws InvalidRentEndingException
     * @return Rent
     */
    private function checkEndEvent($data): Rent
    {
        $user = User::find($data->user_id);
        $car = Car::find($data->car_id);

        if ($car->status != 'free') {
            throw new InvalidCarStatusException;
        }

        if ($lastRent = $user->latestRent) {
            if ($lastRent->event == 'start' && $lastRent->car == $car) {
                return $this->createRent($data);
            }
        }
        throw new InvalidRentEndingException($car);
    }

    /**
     * Создание записи аренды
     * 
     * @param StoreRentRequest $data
     * @return Rent
     */
    private function createRent(StoreRentRequest $data): Rent
    {
        $car = Car::find($data->car_id);
        $data = $data->validated();
        $data['location_id'] = $car->locations->last()->id;
        return Rent::query()->create($data);
    }

}