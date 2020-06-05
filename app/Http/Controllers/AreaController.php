<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class AreaController extends Controller
{
    private $totalArea;
    private $areaCleaned;
    public function __construct(float $totalArea) {
        $this->totalArea = $totalArea;
        $this->areaCleaned = 0;
    }

    public function work(float $metersSquared): float {
        if ($metersSquared > $this->totalArea - $this->areaCleaned) {
            throw new Exception('Hoover would like to clean more meters than it is possible.');
        }
        else {
            $this->areaCleaned += $metersSquared;
        }
        return $this->totalArea - $this->areaCleaned - $metersSquared;
    }
    public function getRemainingArea(): float {
        return $this->totalArea - $this->areaCleaned;
    }

    public function isWorkDone(): bool {
        return $this->areaCleaned >= $this->totalArea;
    }
}
