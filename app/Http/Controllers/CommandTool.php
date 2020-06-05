<?php

namespace App\Http\Controllers;


use Symfony\Component\Console\Command\Command;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class CommandTool extends Command
{
    //
    public function __construct()
    {
        parent::__construct();
    }

    public function configure(){

        $this->setName('clean')
             ->addOption(
                'floor',
                NULL,
               InputOption::VALUE_REQUIRED,
                'Type of floor.'
            )
            ->addOption(
                'area',
                NULL,
                InputOption::VALUE_REQUIRED,
                'Area in meter squared.'
            );

    }

    public function execute(InputInterface $input, OutputInterface $output) {
        $this->CommandLineOutput($input, $output);
    }

    protected function CommandLineOutput(InputInterface $input, OutputInterface $output) {
        $output->writeln([
            '===========  Program starts  ===========',
            '',
        ]);
        $floor = $input->getOption('floor');
        $area = $input->getOption('area');
        $isFloorValid = $this->ValidateFloor($floor);
        $isAreaValid = $this->ValidateArea($area);
        $floorMessage = ($isFloorValid) ? "" : " - Error";
        $areaMessage = ($isAreaValid) ? "" : " - Error";

        $output->writeln("floor Type: " . $floor . $floorMessage);
        $output->writeln("area To Clean: " . $area . $areaMessage);
        $output->writeln('==============    Computing   ============================');

        if ($isFloorValid and $isAreaValid) {
            $robot = new CleanerRobo($input->getOption('floor'), floatval($input->getOption('area')));
            $tasks = $robot->run();
            foreach ($tasks as $taskType => $taskTime) {
                $output->writeln($taskType . ": " . $taskTime . "s");
                sleep(intval($taskTime));
            }
        }
    }




    private function ValidateFloor($floor) {
        if (array_key_exists($floor, CleanerRobo::FLOOR_TYPES)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    private function ValidateArea($area) {
        if (is_numeric($area) and $area > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

}
