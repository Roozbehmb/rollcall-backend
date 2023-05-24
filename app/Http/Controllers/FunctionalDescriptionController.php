<?php

namespace App\Http\Controllers;

use App\Models\PeriodicShift;
use App\Models\ShiftDailie;
use App\Models\ShiftEmployee;
use App\Models\Traffic;
use App\Models\User;
use App\Models\WeeklyShift;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Exception;


class FunctionalDescriptionController extends Controller
{
    protected $arrayEmployee = [];
    protected $shiftEmployees = [];


    public function show(Request $request, $id)
    {
        $now = Carbon::now();
        $getMonth = $request->month;
        $dataSortMonth = [];
        $dataTraffic = [];

        try {
            $startOfMonth = Carbon::create($now->year, $getMonth, 1, 0);
            $dataSortMonth = Traffic::where('id_user', $id)->
            with('getEmployee.get_shift_dailies')->whereBetween('created_at',
                [
                    $startOfMonth,
                    Carbon::now()->endOfMonth()
                ])
                ->get();

        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_BAD_REQUEST);
        }
        $startTrafficDate = Carbon::parse($dataSortMonth[0]->getEmployee->shift_dailies_date_up);
        $endTrafficDate = Carbon::parse($dataSortMonth[0]->getEmployee->shift_dailies_date_at);
        $dataTraffic = Traffic::where('id_user', $id)->
        with(
            'get_absents.get_absents_type:id,title',
            'get_substitute',
            'get_mission',
            'get_day',
            'getEmployee.get_absents_default',
            'getEmployee.get_periodic_shift',
            'getEmployee.get_shift_dailies',
            'getEmployee.get_dedicated_shift',
            'getEmployee.get_days',
            'getEmployee.get_week_shift'
        )->whereBetween('start_date', [
            $startTrafficDate,
            $endTrafficDate
        ])->get();

        $this->functional_description($dataTraffic);




    }

    public function functional_description($dataMonth)
    {
        $differentTime = 0;
        $arrayData=["shiftEmployee"=>[
            "courseStandard" => 0, "fullTrafficShift" => 0,
            "totalEmployeeShift" => 0, "days" => 0, "countDay" => 0, "countTraffics" => 0],[]];

        foreach ($dataMonth as $shiftEmployee) {

            $arrayData=$this->getFullTrafficShift($arrayData,$shiftEmployee);

            $arrayData=$this->getShiftEmployee($shiftEmployee,$arrayData);

            $arrayData=$this->getTotalEmployeeShift($shiftEmployee,$arrayData,$differentTime);
//            dd($arrayData);

            if( $arrayData["differentTrafficShift"]["fullTrafficShift"] < $arrayData['differentTrafficShift'] )
            {
                $differentTime = ($arrayData['totalEmployeeShift'] - $arrayData["differentTrafficShift"]["fullTrafficShift"]);
            }

            $arrayData=$this->getCourseStandard($shiftEmployee,$arrayData,$differentTime);
            $arrayData["shiftEmployee"]["countTraffics"]++;

        }






        $arrayData=$this->showShiftEmployees($arrayData);

        dd($arrayData);
        return $dataMonth;

    }



    public function getEmployee($dataEmployee,$differentTrafficShift){
        $this->arrayEmployee=[
            'differentTrafficShift'=>$differentTrafficShift,
        ];

        return $this->arrayEmployee;
    }


    public function getShiftEmployee($shiftEmployee,$arrayData)
    {
        $shiftDailiesEnterTime = Carbon::parse($shiftEmployee->getEmployee->get_shift_dailies[0]->watch_enter_time);
        $shiftDailiesExitTime = Carbon::parse($shiftEmployee->getEmployee->get_shift_dailies[0]->watch_exit_time);
        $shiftDailiesSecondEnterTime = Carbon::parse($shiftEmployee->getEmployee->get_shift_dailies[0]->watch_second_enter_time);
        $shiftDailiesSecondExitTime = Carbon::parse($shiftEmployee->getEmployee->get_shift_dailies[0]->watch_second_exit_time);

        $arrayData["shiftDailiesEnterTime"] = $shiftDailiesEnterTime;
        $arrayData["shiftDailiesExitTime"] = $shiftDailiesExitTime;

        $arrayData["shiftDailiesSecondEnterTime"] = $shiftDailiesSecondEnterTime;
        $arrayData["shiftDailiesSecondExitTime"] = $shiftDailiesSecondExitTime;
        if ($shiftDailiesEnterTime < $arrayData["shiftEmployee"]["trafficEnterTime"]) {
            $toDate = Carbon::parse($arrayData["shiftEmployee"]["trafficExitTime"]);
            $fromDate = Carbon::parse($arrayData["shiftEmployee"]["trafficExitTime"]);
            $arrayData["fullTraffic"] = $arrayData["shiftEmployee"]["fullTrafficShift"] + $toDate->diffInHours($fromDate);
        }
        return $arrayData;

    }



    public function getFullTrafficShift($arrayData,$shiftEmployee)
    {
        $arrayData["shiftEmployee"]["trafficEnterTime"] = $shiftEmployee['enter_time'];
        $arrayData["shiftEmployee"]["trafficExitTime"] = $shiftEmployee['exit_time'];
        $toDate = Carbon::parse($arrayData["shiftEmployee"]["trafficEnterTime"]);
        $fromDate = Carbon::parse($arrayData["shiftEmployee"]["trafficExitTime"]);
        $differentTrafficShift['fullTrafficShift'] = $toDate->diffInHours($fromDate);
        $arrayData["shiftEmployee"]["fullTrafficShift"] += $toDate->diffInHours($fromDate);
        $arrayData["differentTrafficShift"] = $differentTrafficShift;

        return $arrayData;

    }
    public function getTotalEmployeeShift($shiftEmployee,$arrayData,$differentTime)
    {
        $arrayData["shiftEmployee"]["watchEnterTime"] = $shiftEmployee->getEmployee->get_shift_dailies[0]->watch_enter_time;
        $arrayData["shiftEmployee"]["watchExitTime"] = $shiftEmployee->getEmployee->get_shift_dailies[0]->watch_exit_time;
        $arrayData["shiftEmployee"]["watchSecondEnterTime"] = $shiftEmployee->getEmployee->get_shift_dailies[0]->watch_second_enter_time;
        $arrayData["shiftEmployee"]["watchSecondExitTime"] = $shiftEmployee->getEmployee->get_shift_dailies[0]->watch_second_exit_time;
        $toDate = Carbon::parse($arrayData["shiftEmployee"]["watchEnterTime"]);
        $fromDate = Carbon::parse($arrayData["shiftEmployee"]["watchExitTime"]);
        $toDateSecond = Carbon::parse($arrayData["shiftEmployee"]["watchSecondEnterTime"]);
        $fromDateSecond = Carbon::parse($arrayData["shiftEmployee"]["watchSecondExitTime"]);
        $arrayData['totalEmployeeShift'] = ( ($toDate->diffInHours($fromDate)) + ($toDateSecond->diffInHours($fromDateSecond)) );

        $arrayData["shiftEmployee"]['totalEmployeeShift'] += ( ($toDate->diffInHours($fromDate)) + ($toDateSecond->diffInHours($fromDateSecond)) ) - $differentTime;
        return $arrayData;
    }

    public function getCourseStandard($shiftEmployee,$arrayData,$differentTime)
    {

        $shiftDailiesDateUp = $shiftEmployee->getEmployee->shift_dailies_date_up;
        $shiftDailiesDateAt = $shiftEmployee->getEmployee->shift_dailies_date_at;

        $toDate = Carbon::parse($shiftDailiesDateUp);
        $fromDate = Carbon::parse($shiftDailiesDateAt);
        $arrayData["shiftEmployee"]['totalShift'] = $toDate->diff($fromDate)->format('%D %H:%I:%S');//tedad roz hay shift tain shode
        $arrayData["shiftEmployee"]['days'] = $toDate->diffInDays($fromDate);

        for ($i = $arrayData["shiftEmployee"]["countDay"]; $arrayData["shiftEmployee"]["countDay"] < $arrayData["shiftEmployee"]["days"]; $i++) {
            $arrayData["shiftEmployee"]["totalDateTraffic"] = $arrayData["shiftDailiesSecondEnterTime"]->diffInHours($arrayData["shiftDailiesSecondExitTime"]);
            $totalDateTrafficSecond = $arrayData['shiftDailiesEnterTime']->diffInHours($arrayData["shiftDailiesExitTime"]);
            $arrayData["shiftEmployee"]['courseStandard'] += $arrayData["shiftEmployee"]["totalDateTraffic"] + $totalDateTrafficSecond;
            $arrayData["shiftEmployee"]["countDay"]++;

        }
        return $arrayData;

    }


    public function showShiftEmployees($arrayData)
    {
        $data=$this->shiftEmployees = [
            'courseStandard'                => $arrayData["shiftEmployee"]['courseStandard'],
            'totalEmployeeShift'            => $arrayData["shiftEmployee"]['totalEmployeeShift'],
            'fullTraffic'                   => $arrayData["shiftEmployee"]["fullTrafficShift"],
            'countTraffics'                 => $arrayData["shiftEmployee"]["countTraffics"],
            'traffic_enter_time'            => $arrayData["shiftEmployee"]["trafficEnterTime"],
            'traffic_exit_time'             => $arrayData["shiftEmployee"]["trafficExitTime"],
            'watchShiftDailies-EnterTime'   => $arrayData["shiftEmployee"]["watchEnterTime"],
            'watchShiftDailies-ExitTime'    => $arrayData["shiftEmployee"]["watchExitTime"],
            'watchSecondEnterTime'          => $arrayData["shiftEmployee"]["watchSecondEnterTime"],
            'watchSecondExitTime'           => $arrayData["shiftEmployee"]["watchSecondExitTime"],
            'totalShift'                    => $arrayData["shiftEmployee"]["totalShift"],
            'Days'                          => $arrayData["shiftEmployee"]['days'],

        ];
        return $data;
    }


}
