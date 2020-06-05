<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CleanerRobo extends Controller
{
    //

    const FLOOR_TYPES = ['hard' => 1, 'carpet' => 0.5];
    const ROBO_POWER = 60;
    const ROBO_CHARGE = 30;
    private $AreaController;
    private $TimeToClean;
    private $roboCapacity;
    public function __construct(string $floorType, float $area) {

        $this->AreaController = new AreaController($area);
        $this->TimeToClean = new TimeToClean($this::FLOOR_TYPES[$floorType]);
        $this->roboCapacity = new RoboCapacity($this::ROBO_POWER, $this::ROBO_CHARGE);

    }

    public function run(): array {
        $tasks = [];
        $i = 0;
        while (TRUE) {
            $i++;
            [$area,$cleanTime, ] = $this->getCleaningTime();
            //work
            $this->AreaController->work($area);
            $this->roboCapacity->clean($cleanTime);
            $tasks["Robo is Cleaning"] = $cleanTime;
            //power
            $timeToCharge = $this->roboCapacity->charging();
            $tasks["Robo is Charging Battery"] = $timeToCharge;
            if ($this->AreaController->isWorkDone()) {
                break;
            }
        }
        return $tasks;
    }

    private function getCleaningTime() {
        $maxWorkingTime = $this->roboCapacity->getCleanTime();
        $maxCleaningArea = $this->AreaController->getRemainingArea();
        $areaToCleanInMaxTime = $this->TimeToClean->getTime($maxWorkingTime);
        $maxCleaningAreaTime = $this->TimeToClean->getArea($maxCleaningArea);
        $minArea = min($areaToCleanInMaxTime, $maxCleaningArea);
        $minCleaningTime = min($maxWorkingTime, $maxCleaningAreaTime);
        return [$minArea, $minCleaningTime];
    }

}
