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


class FunctionalDescriptionController extends Controller
{
    protected $arrayEmployee = [];

    public function show(Request $request, $id, Carbon $start)
    {
        $now = Carbon::now();
        $get_month = $request->month;
        $startOfMonth = Carbon::create($now->year, $get_month, 1, 0);

        $dataMonth = Traffic::where('id_user', $id)->
        with(
            'get_employee.get_absents_default',
            'get_employee.get_periodic_shift',
            'get_employee.get_shift_dailies',
            'get_employee.get_dedicated_shift',
            'get_employee.get_days',
            'get_employee.get_week_shift'
        )->whereBetween('created_at',
            [
                $startOfMonth,
                Carbon::now()->endOfMonth()
            ])->get();

        $enter_time=$dataMonth[0]->get_employee->get_shift_dailies[0]->watch_enter_time;
        $exit_time=$dataMonth[0]->get_employee->get_shift_dailies[0]->watch_exit_time;

        $dataFull = Traffic::where('id_user', $id)->
        with(
            'get_user:id,name,email',
            'get_absents.get_absents_type:id,title',
            'get_substitute',
            'get_mission',
            'get_day'
        )->whereBetween('created_at',
            [
                $enter_time,
                Carbon::now()
            ])->get();



        return $dataFull;








//
//


        return $dataMonth;
        $this->functional_description($dataMonth);
        $user = auth()->user();
        if (request('search')) {
            $user = User::where('name', 'like', '%' . request('search') . '%')->get();
        } else {
            $user = User::all();
        }

        $shiftDailie = ShiftDailie::all();
        $shiftPeriodic = PeriodicShift::all();
        $shiftWeek = WeeklyShift::all();
        $selectShift = Traffic::with('get_user')->get();
        $employeesFormShift = ShiftEmployee::with('users:id,name,email', 'shiftWeek:id,title',
            'shiftPeriodic:id,title', 'shiftDedicated:id,title', 'shiftDay:id,title')->get();


        $traffic = Traffic::all();
        return response()->json([
            'traffic' => $traffic,
            'user' => $user,
            'shift_periodic' => $shiftPeriodic,
            'shiftPeriodic' => $shiftPeriodic,
            'shiftWeek' => $shiftWeek,
            'shiftDailie' => $shiftDailie,
            'employeesFormShift' => $employeesFormShift

        ]);
    }

    public function functional_description($dataMonth)
    {
        $today = Carbon::now();
        $totalDuration = 0;
        $totalDateTraffic = 0;
        $functionShift = 0;
        $totalShift = 0;
        $days = 0;
        $totalTrafficShift = 0;
        $countDay = 0;
        $totalDateTrafficOne = 0;
        $totalDateTrafficSecond = 0;
        $fullTraffic = 0;


        foreach ($dataMonth as $date) {
            $traffic_enter_time = $date['enter_time'];
            $traffic_exit_time = $date['exit_time'];
            $toDate = Carbon::parse($traffic_enter_time);
            $fromDate = Carbon::parse($traffic_exit_time);
            $totalTrafficShift += $toDate->diffInHours($fromDate);///kole zaman sabte taradod

            $shiftDailiesDateUp = $date->get_employee->shift_dailies_date_up;
            $shiftDailiesDateAt = $date->get_employee->shift_dailies_date_at;
            $toDate = Carbon::parse($shiftDailiesDateUp);
            $fromDate = Carbon::parse($shiftDailiesDateAt);
            $totalShift = $toDate->diff($fromDate)->format('%Y:%M:%D %H:%I:%S');//tedad roz hay shift tain shode
            $days = $toDate->diffInDays($fromDate);
            for ($i = $countDay; $countDay < $days; $i++) {
                $traffic_enter_time = $date->get_employee->get_shift_dailies[0]->watch_enter_time;
                $traffic_exit_time = $date->get_employee->get_shift_dailies[0]->watch_exit_time;
                $traffic_second_enter_time = $date->get_employee->get_shift_dailies[0]->watch_second_enter_time;
                $traffic_second_exit_time = $date->get_employee->get_shift_dailies[0]->watch_second_exit_time;

                $toDate = Carbon::parse($traffic_enter_time);
                $fromDate = Carbon::parse($traffic_exit_time);
                $toDateOne = Carbon::parse($traffic_second_enter_time);
                $fromDateTwo = Carbon::parse($traffic_second_exit_time);

                $totalDateTraffic = $toDateOne->diffInHours($fromDateTwo);
                $totalDateTrafficSecond = $toDate->diffInHours($fromDate);//in shift ha saate shifte rozane sabet hastatn///saate sabte taradod az roy saate shift

                $fullTraffic += $totalDateTraffic + $totalDateTrafficSecond;
                $countDay++;
            }
            $watchEnterTime = $date->get_employee->get_shift_dailies[0]->watch_enter_time;
            $watchExitTime = $date->get_employee->get_shift_dailies[0]->watch_exit_time;
            $to = Carbon::createFromFormat('H:s:i', $watchEnterTime);
            $from = Carbon::createFromFormat('H:s:i', $watchExitTime);
//                $totalDateSingleTraffic = $toDate->diff($fromDate)->format('%H:%I:%S');;
            $totalDuration += ($to->diffInHours($from));///kole sate shifte rozone  ha az roy tarikh jostejo


        }
        $this->arrayEmployee[] = [
            'courseStandard' => $fullTraffic,
            'totalTrafficShift' => $totalTrafficShift,
            'totalShift' => $totalShift,
            'Days' => $days,
            'functionShift' => $functionShift

        ];

        dd($this->arrayEmployee);
        return $dataMonth;

    }

}
