<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftEmployeeRequest;
use App\Models\PeriodicShift;
use App\Models\ShiftDailie;
use App\Models\ShiftEmployee;
use App\Models\Traffic;
use App\Models\WeeklyShift;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class ShiftEmployeeController extends Controller
{


    public function index()
    {
        $user = auth()->user();
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

    public function store(ShiftEmployeeRequest $request)
    {
        try {
            $ShiftEmployee = ShiftEmployee::create($request->all());
            return response()->json($ShiftEmployee, Response::HTTP_OK);
        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $employeesFormShift = ShiftEmployee::with('users:id,name,email', 'shiftWeek:id,title',
                'shiftPeriodic:id,title',
                'shiftDedicated:id,title',
                'shiftDay:id,title')
                ->where('id', $id)->first();
            return response()->json($employeesFormShift, Response::HTTP_OK);
        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $employeesFormShiftRequest = $request->all();
            $data = ShiftEmployee::find($id);
            $data->update($employeesFormShiftRequest);
            $employeesFormShift = ShiftEmployee::with('users:id,name,email', 'shiftWeek:id,title',
                'shiftPeriodic:id,title',
                'shiftDedicated:id,title',
                'shiftDay:id,title')
                ->where('id', $id)->first();
            $response = [
                'success' => true,
                'data' => ShiftEmployee::find($id),
                'message' => 'update shifte_Week success'
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy($id)
    {
        try {
            $data = ShiftEmployee::where('id', $id)->delete();
            if ($data) {
                $response = [
                    'status' => '1',
                    'msg' => 'success ShiftEmployee deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                {
                    $response = [
                        'status' => false,
                        'msg' => 'The delete (ShiftEmployee) operation failed '
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
