<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class RoboCapacity extends Controller
{
    //

    private $capacity;
    private $charge;
    private $power;

    public function __construct(float $capacity, float $charge) {
        $this->capacity = $capacity;
        $this->charge = $charge;
        $this->power = 1;
    }

    public function getCleanTime(): float {
        return $this->capacity * $this->power;
    }
    public function charging(): float {
        $timeToCharge = $this->charge * (1 - $this->power);
        $this->power = 1;
        return $timeToCharge;
    }

    public function clean(float $seconds) {
        if ($seconds <= $this->getCleanTime()) {
            $this->power = 1 - ($seconds / $this->capacity);
        }
        else {
            throw new Exception('ROBO do not have power.');
        }
    }


}
