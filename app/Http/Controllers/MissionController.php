<?php

namespace App\Http\Controllers;

use App\Http\Requests\missionRequest;
use App\Models\Mission;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class MissionController extends Controller
{
    public function index()
    {
        $mission = Mission::all();
        return response()->json([
            'Mission' => $mission,
        ]);
    }

    public function store(missionRequest $request)
    {
        try {
            $mission = Mission::create($request->all());
            return response()->json($mission, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_NOT_FOUND);
        }
        return response()->json($mission);
    }

    public function update(missionRequest $request, Mission $periodicShift, $id)
    {
        try {
            $absence = $request->all();
            $data = Mission::find($id);
            $data->update($absence);
            $response = [
                'success' => true,
                'data' => Mission::find($id),
                'message' => 'update Absence success'
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy($periodicShift, $id)
    {
        try {
            $data = Mission::where('id', $id)->delete();
            if($data)
            {
                $response = [
                    'status' => '1',
                    'msg' => 'success ShiftEmployee deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            }else{

            }

        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }


}
