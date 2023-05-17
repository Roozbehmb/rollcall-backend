<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodicShiftRequest;
use App\Models\PeriodicShift;
use App\Models\ShiftDailie;
use App\Models\WeeklyShift;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Models\CourseType;

class PeriodicShiftController extends Controller
{

    public function index()
    {
        $periodicShift = PeriodicShift::all();
        $selectCourse_type = CourseType::all();
        $shiftWorkDailies = ShiftDailie::all();
        $shiftWorkSailieSelect = PeriodicShift::with('getShift')->get();
        return response()->json([
            'periodicShift' => $periodicShift,
            'select_course_type' => $selectCourse_type,
            'shift_work_dailies' => $shiftWorkDailies,
            '$shiftWorkSailieSelect' => $shiftWorkSailieSelect

        ]);
    }

    public function store(Request $request)
    {
        try {
            $periodicShift = PeriodicShift::create($request->all());
            return response()->json($periodicShift, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($periodicShift);
    }

    public function update(Request $request, PeriodicShift $periodicShift, $id)
    {
        try {
            $shiftDailie = $request->all();
            $data = ShiftDailie::find($id);
            $data->update($shiftDailie);
            $response = [
                'success' => true,
                'data' => ShiftDailie::find($id),
                'message' => 'update Shifte_Dailie success'
            ];
            return response()->json($response, Response::HTTP_OK);

        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    public function destroy(PeriodicShiftRequest $periodicShift, $id)
    {
        try {
            $data = ShiftDailie::where('id', $id)->delete();
            if ($data) {
                $response = [
                    'status' => '1',
                    'msg' => 'success ShiftDailie deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            }  else {
                {
                    $response = [
                        'status' => false,
                        'msg' => 'The delete (ShiftDailie) operation failed '
                    ];
                    return response()->json($response, Response::HTTP_NOT_FOUND);

                }
            }

        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
