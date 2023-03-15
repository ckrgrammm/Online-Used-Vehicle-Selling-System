<?php

use App\Observers;

interface ProductObserverInterface
{
    public function creating($model);

    public function updating($model);

    public function saving($model);

    public function deleting($model);

    public function restoring($model);
}



class Product implements Observable
{
    private $make;
    private $model;
    private $year;
    private $mileage;
    private $color;
    private $transmission;
    private $description;
    private $images;

    private $observers = [];

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer)
    {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function setMake($make)
    {
        $this->make = $make;
        $this->notify();
    }

    public function setModel($model)
    {
        $this->model = $model;
        $this->notify();
    }

    public function setYear($year)
    {
        $this->year = $year;
        $this->notify();
    }

    public function setMileage($mileage)
    {
        $this->mileage = $mileage;
        $this->notify();
    }

    public function setColor($color)
    {
        $this->color = $color;
        $this->notify();
    }

    public function setTransmission($transmission)
    {
        $this->transmission = $transmission;
        $this->notify();
    }

    public function setDescription($description)
    {
        $this->description = $description;
        $this->notify();
    }

    public function setImages($images)
    {
        $this->images = $images;
        $this->notify();
    }

    // Add getters for the attributes as well
    public function getMake()
    {
        return $this->make;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getMileage()
    {
        return $this->mileage;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getTransmission()
    {
        return $this->transmission;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImages()
    {
        return $this->images;
    }
}

?>