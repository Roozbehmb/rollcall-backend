<?php

namespace App\Http\Controllers;

use App\Http\Requests\shiftWeekRequest;
use App\Models\DayWeek;
use App\Models\ShiftDailie;
use App\Models\WeeklyShift;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class WeeklyShiftController extends Controller
{

    public function index()
    {
        $PeriodicShift = WeeklyShift::all();
        $selectDayWeek = DayWeek::all();
        $shiftWorkDailies = ShiftDailie::all();
        return response()->json([
            'PeriodicShift' => $PeriodicShift,
            'Day_Week' => $selectDayWeek,
            'shift_work_dailies' => $shiftWorkDailies

        ]);
    }

    public function store(shiftWeekRequest $request)
    {
        try {
            $shiftWeek = new WeeklyShift();
            $data = $request->get('days_week');
            $shiftWeek->title = $request->title;
            $shiftWeek->id_shift_work = $request->id_shift_work;
            $shiftWeek->alternate_shift = $request->alternate_shift;
            $shiftWeek->id_alternate_shift = $request->id_alternate_shift;
            $shiftWeek->active = $request->active;
            $shiftWeek->id_days_week = $request->id_days_week;

            $shiftWeek->save();
            return response()->json($shiftWeek, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function update(shiftWeekRequest $request, $id)
    {
        try {
            $shiftWeek = $request->all();
            $data = WeeklyShift::find($id);
            $data->update($shiftWeek);
            $response = [
                'success' => true,
                'data' => WeeklyShift::find($id),
                'message' => 'update shifte_Week success'
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy(WeeklyShift $weeklyShift, $id)
    {
        try {
            $response = WeeklyShift::where('id', $id)->delete();
            if ($response) {
                $response = [
                    'status' => '1',
                    'msg' => 'success WeeklyShift deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                {
                    $response = [
                        'status' => false,
                        'msg' => 'The delete (WeeklyShift) operation failed '
                    ];
                    return response()->json($response, Response::HTTP_NOT_FOUND);

                }
            }

        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
