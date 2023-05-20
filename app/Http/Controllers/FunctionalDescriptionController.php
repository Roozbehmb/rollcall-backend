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
    public function show(Request $request, $id, Carbon $start)
    {

        $now = Carbon::now();
        $get_month = $request->month;
        $startOfMonth = Carbon::create($now->year, $get_month, 1, 0);
        $dataMonth = Traffic::where('id_user', $id)->
        with(
            'get_user:id,name,email',
            'get_absents.get_absents_type:id,title',
            'get_substitute',
            'get_mission',
            'get_day'
        )
            ->whereBetween('created_at',
                [
                    $startOfMonth,
                    Carbon::now()->endOfMonth()
                ])
            ->get();
        $arrayEmployee = [];

        foreach ($dataMonth as $date) {
            return $date;
            $arrayEmployee=[
                'courseStandard'=>1
        ];
        }
        return $dataMonth;




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
}
