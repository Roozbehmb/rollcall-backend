<?php

namespace App\Http\Controllers;

use App\Http\Requests\setAbsentRequest;
use App\Models\Absence;
use App\Models\setAbsent;
use App\Models\ShiftDailie;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class SetAbsentController extends Controller
{
    public function index()
    {
        $setAbsent = setAbsent::all();
        $absence = Absence::all();
        $shiftWorkDailies = ShiftDailie::all();
        return response()->json([
            'setAbsent' => $setAbsent,
            'absence' => $absence,
            'shift_work_dailies' => $shiftWorkDailies

        ]);
    }

    public function store(setAbsentRequest $request)
    {
        try {
            $absence = setAbsent::create($request->all());
            return response()->json($absence, Response::HTTP_OK);

        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_NOT_FOUND);
        }
        return response()->json($absence);
    }

    public function update(setAbsentRequest $request, setAbsent $weeklyShift, $id)
    {
        try {
            $shiftWeek = $request->all();
            $data = setAbsent::find($id);
            $data->update($shiftWeek);
            $response = [
                'success' => true,
                'data' => setAbsent::find($id),
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
            $data = setAbsent::where('id', $id)->delete();
            if ($data) {
                $response = [
                    'status' => true,
                    'msg' => 'success setAbsent deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                $response = [
                    'status' => false,
                    'msg' => 'The delete (setAbsent) operation failed '
                ];
                return response()->json($response, Response::HTTP_NOT_FOUND);

            }


        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
