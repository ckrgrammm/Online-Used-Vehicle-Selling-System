<?php
namespace App\Observers;

abstract class Subject
{
    private $observers;
    public function __construct()
    {
        $this->observers = array();
    }

    public function attach(Observer $observer)
    {
        array_push($this->observers, $observer);
    }

    public function detach(Observer $observer)
    {
        $index = 0;
        foreach ($this->observers as $o) {
            if ($o == $observer) {
                array_splice($this->observers, $index);
            }
            $index++;
        }
    }

    public function notifyStore()
    {
        foreach ($this->observers as $observer) {
            $observer->store($this);
        }
    }

    public function notifyRetrieveAll()
    {
        foreach ($this->observers as $observer) {
           return $observer->all();
        }
    }

    public function notifyFind()
    {
        foreach ($this->observers as $observer) {
            return $observer->find($this);
        }
    }

    public function notifyUpdate()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function notifyUpdateAll()
    {
        foreach ($this->observers as $observer) {
            $observer->updateAll($this);
        }
    }

    public function notifyDelete()
    {
        foreach ($this->observers as $observer) {
            $observer->delete($this);
        }
    }
}
