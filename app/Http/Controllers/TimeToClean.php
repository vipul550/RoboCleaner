<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeToClean extends Controller
{

    public function __construct(float $timeToClean) {
        $this->timeToClean = $timeToClean;
    }

    public function getTime(float $time): float {
        return $time * $this->timeToClean;
    }

    public function getArea(float $area): float {
        return $area / $this->timeToClean;
    }
}
