<?php
//namespace App\Http\Controllers;
//
//use App\Models\PeriodicShift;
//use App\Models\ShiftDailie;
//use App\Models\ShiftEmployee;
//use App\Models\Traffic;
//use App\Models\User;
//use App\Models\WeeklyShift;
//use Illuminate\Http\Request;
//use Carbon\Carbon;
//use Carbon\CarbonPeriod;
//use Illuminate\Support\Facades\DB;
//use Symfony\Component\HttpFoundation\Response;
//use Exception;
//
//
//class TestController extends Controller
//{
//    protected $arrayEmployee = [];
//    protected $shiftEmployees = [];
//
//
//    public function show(Request $request, $id)
//    {
//        $now = Carbon::now();
//        $getMonth = $request->month;
//        $dataSortMonth = [];
//        $dataTraffic = [];
//
//        try {
//            $startOfMonth = Carbon::create($now->year, $getMonth, 1, 0);
//            $dataSortMonth = Traffic::where('id_user', $id)->
//            with('get_employee.get_shift_dailies')->whereBetween('created_at',
//                [
//                    $startOfMonth,
//                    Carbon::now()->endOfMonth()
//                ])->get();
//
//        } catch (Exception $error) {
//            return response()->json($error, Response::HTTP_BAD_REQUEST);
//        }
//
//        $startTrafficDate = Carbon::parse($dataSortMonth[0]->get_employee->shift_dailies_date_up);
//        $endTrafficDate = Carbon::parse($dataSortMonth[0]->get_employee->shift_dailies_date_at);
//        $dataTraffic = Traffic::where('id_user', $id)->
//        with(
//            'get_absents.get_absents_type:id,title',
//            'get_substitute',
//            'get_mission',
//            'get_day',
//            'get_employee.get_absents_default',
//            'get_employee.get_periodic_shift',
//            'get_employee.get_shift_dailies',
//            'get_employee.get_dedicated_shift',
//            'get_employee.get_days',
//            'get_employee.get_week_shift'
//        )->whereBetween('start_date', [
//            $startTrafficDate,
//            $endTrafficDate
//        ])->get();
//
//
//        $this->functional_description($dataTraffic);
//        $user = auth()->user();
//        if (request('search')) {
//            $user = User::where('name', 'like', '%' . request('search') . '%')->get();
//        } else {
//            $user = User::all();
//        }
//
//        $shiftDailie = ShiftDailie::all();
//        $shiftPeriodic = PeriodicShift::all();
//        $shiftWeek = WeeklyShift::all();
//        $employeesFormShift = ShiftEmployee::with('users:id,name,email', 'shiftWeek:id,title',
//            'shiftPeriodic:id,title', 'shiftDedicated:id,title', 'shiftDay:id,title')->get();
//
//
//        $traffic = Traffic::all();
//        return response()->json([
//            'traffic' => $traffic,
//            'user' => $user,
//            'shift_periodic' => $shiftPeriodic,
//            'shiftPeriodic' => $shiftPeriodic,
//            'shiftWeek' => $shiftWeek,
//            'shiftDailie' => $shiftDailie,
//            'employeesFormShift' => $employeesFormShift
//
//        ]);
//    }
//
//    public function functional_description($dataMonth)
//    {
//        $differentTime = 0;
//        $arrayData = ["shiftEmployee" => [
//            "courseStandard" => 0, "fullTrafficShift" => 0,
//            "totalEmployeeShift" => 0, "days" => 0, "countDay" => 0, "countTraffics" => 0], []];
//
//        foreach ($dataMonth as $shiftEmployee) {
//
//
//            $shiftDailiesEnterTime = Carbon::parse($shiftEmployee->get_employee->get_shift_dailies[0]->watch_enter_time);
//            $shiftDailiesExitTime = Carbon::parse($shiftEmployee->get_employee->get_shift_dailies[0]->watch_exit_time);
//            $shiftDailiesSecondEnterTime = Carbon::parse($shiftEmployee->get_employee->get_shift_dailies[0]->watch_second_enter_time);
//            $shiftDailiesSecondExitTime = Carbon::parse($shiftEmployee->get_employee->get_shift_dailies[0]->watch_second_exit_time);
//
//            $arrayData["shiftEmployee"]["trafficEnterTime"] = $shiftEmployee['enter_time'];
//            $arrayData["shiftEmployee"]["trafficExitTime"] = $shiftEmployee['exit_time'];
//            $shiftDailiesDateUp = $shiftEmployee->get_employee->shift_dailies_date_up;
//            $shiftDailiesDateAt = $shiftEmployee->get_employee->shift_dailies_date_at;
//            $toDate = Carbon::parse($arrayData["shiftEmployee"]["trafficEnterTime"]);
//            $fromDate = Carbon::parse($arrayData["shiftEmployee"]["trafficExitTime"]);
//            $differentTrafficShift['fullTrafficShift'] = $toDate->diffInHours($fromDate);
//            $arrayData["shiftEmployee"]["fullTrafficShift"] += $toDate->diffInHours($fromDate);
//
//            if ($shiftDailiesEnterTime < $arrayData["shiftEmployee"]["trafficEnterTime"]) {
//                $toDate = Carbon::parse($arrayData["shiftEmployee"]["trafficExitTime"]);
//                $fromDate = Carbon::parse($arrayData["shiftEmployee"]["trafficExitTime"]);
//                $arrayData["shiftEmployee"]["fullTraffic"] = $arrayData["shiftEmployee"]["fullTrafficShift"] + $toDate->diffInHours($fromDate);
//            }
//
//            $arrayData["shiftEmployee"]["watchEnterTime"] = $shiftEmployee->get_employee->get_shift_dailies[0]->watch_enter_time;
//            $arrayData["shiftEmployee"]["watchExitTime"] = $shiftEmployee->get_employee->get_shift_dailies[0]->watch_exit_time;
//            $arrayData["shiftEmployee"]["watchSecondEnterTime"] = $shiftEmployee->get_employee->get_shift_dailies[0]->watch_second_enter_time;
//            $arrayData["shiftEmployee"]["watchSecondExitTime"] = $shiftEmployee->get_employee->get_shift_dailies[0]->watch_second_exit_time;
//            $toDate = Carbon::parse($arrayData["shiftEmployee"]["watchEnterTime"]);
//            $fromDate = Carbon::parse($arrayData["shiftEmployee"]["watchExitTime"]);
//            $toDateSecond = Carbon::parse($arrayData["shiftEmployee"]["watchSecondEnterTime"]);
//            $fromDateSecond = Carbon::parse($arrayData["shiftEmployee"]["watchSecondExitTime"]);
//            $differentTrafficShift['totalEmployeeShift'] = (($toDate->diffInHours($fromDate)) + ($toDateSecond->diffInHours($fromDateSecond)));
//
//            $arrayData["shiftEmployee"]['totalEmployeeShift'] += (($toDate->diffInHours($fromDate)) + ($toDateSecond->diffInHours($fromDateSecond))) - $differentTime;
//
//            if ($differentTrafficShift['fullTrafficShift'] < $differentTrafficShift['totalEmployeeShift']) {
//                $differentTime = ($differentTrafficShift['totalEmployeeShift'] - $differentTrafficShift['fullTrafficShift']);
//
//            }
//
//
//            $toDate = Carbon::parse($shiftDailiesDateUp);
//            $fromDate = Carbon::parse($shiftDailiesDateAt);
//            $arrayData["shiftEmployee"]['totalShift'] = $toDate->diff($fromDate)->format('%D %H:%I:%S');//tedad roz hay shift tain shode
//            $arrayData["shiftEmployee"]['days'] = $toDate->diffInDays($fromDate);
//
//            for ($i = $arrayData["shiftEmployee"]["countDay"]; $arrayData["shiftEmployee"]["countDay"] < $arrayData["shiftEmployee"]["days"]; $i++) {
//
//                $arrayData["shiftEmployee"]["totalDateTraffic"] = $shiftDailiesSecondEnterTime->diffInHours($shiftDailiesSecondExitTime);
//                $totalDateTrafficSecond = $shiftDailiesEnterTime->diffInHours($shiftDailiesExitTime);
//                $arrayData["shiftEmployee"]['courseStandard'] += $arrayData["shiftEmployee"]["totalDateTraffic"] + $totalDateTrafficSecond;
//                $arrayData["shiftEmployee"]["countDay"]++;
//            }
//
//
//            $arrayData["shiftEmployee"]["countTraffics"]++;
////            $this->get_employee($shiftEmployee,$differentTrafficShift);
//
//        }
//
//
//        $this->shiftEmployees = [
//            'courseStandard' => $arrayData["shiftEmployee"]['courseStandard'],
//            'totalEmployeeShift' => $arrayData["shiftEmployee"]['totalEmployeeShift'],
//            'fullTraffic' => $arrayData["shiftEmployee"]["fullTrafficShift"],
//            'countTraffics' => $arrayData["shiftEmployee"]["countTraffics"],
//            'traffic_enter_time' => $arrayData["shiftEmployee"]["trafficEnterTime"],
//            'traffic_exit_time' => $arrayData["shiftEmployee"]["trafficExitTime"],
//            'watchShiftDailies-EnterTime' => $arrayData["shiftEmployee"]["watchEnterTime"],
//            'watchShiftDailies-ExitTime' => $arrayData["shiftEmployee"]["watchExitTime"],
//            'watchSecondEnterTime' => $arrayData["shiftEmployee"]["watchSecondEnterTime"],
//            'watchSecondExitTime' => $arrayData["shiftEmployee"]["watchSecondExitTime"],
//            'totalShift' => $arrayData["shiftEmployee"]["totalShift"],
//            'Days' => $arrayData["shiftEmployee"]['days'],
//
//        ];
//
//        dd($this->shiftEmployees);
//        return $dataMonth;
//
//    }
//
//
//    public function get_employee($dataEmployee, $differentTrafficShift)
//    {
//        $this->arrayEmployee = [
//            'differentTrafficShift' => $differentTrafficShift,
//
//        ];
//        dd($this->arrayEmployee);
//
//        dd($dataEmployee);
//        return $this->arrayEmployee;
//    }
//
//}
