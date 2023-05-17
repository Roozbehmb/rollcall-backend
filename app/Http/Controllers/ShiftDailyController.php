<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShitWorkDailiesRequest;
use App\Models\ShiftDailie;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ShiftDailyController extends Controller
{

    public function index()
    {
        $shiftWorkDailies = ShiftDailie::all();
        return response()->json($shiftWorkDailies);
    }

    public function store(Request $request)
    {
        try {
            $ShiftDailie = ShiftDailie::create($request->all());
            return response()->json($ShiftDailie, Response::HTTP_OK);
        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_NOT_FOUND);
        }
        return response()->json($data);

    }

    public function update(ShitWorkDailiesRequest $request, ShiftDailie $shift_work_Daily, $id)
    {
        try {
            $ShiftDailie = $request->all();
            $data = ShiftDailie::find($id);
            $data->update($ShiftDailie);
            $response = [
                'success' => true,
                'data' => ShiftDailie::find($id),
                'message' => 'update Shifte_Dailie success'
            ];
            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(ShiftDailie $shift_work_Daily, $id)
    {
        try {
            $data = ShiftDailie::where('id', $id)->delete();
            if ($data) {
                $response = [
                    'status' => '1',
                    'msg' => 'success ShiftDailie deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
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
