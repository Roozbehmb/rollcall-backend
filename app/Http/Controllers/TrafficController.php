<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrafficRequest;
use App\Models\Absence;
use App\Models\Mission;
use App\Models\Month;
use App\Models\traffic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Lib\Jdf;

class TrafficController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $selectUser = Traffic::with('get_user')->get();
        $traffic = Traffic::all();
        $mission = Mission::all();
        $absence = Absence::all();
        return response()->json([
            'user' => $user,
            'traffics' => $traffic,
            'select_user_traffic' => $selectUser,
            'mission' => $mission,
            'absence' => $absence
        ]);
    }

    public function store(TrafficRequest $request)
    {
        try {
            $data = $this->check_time($request);
            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function update(TrafficRequest $request, $id)
    {
        try {
            $traffic = $request->all();
            $data = Traffic::find($id);
            $data->update($traffic);
            $response = [
                'success' => true,
                'data' => Traffic::find($id),
                'message' => 'update shifte_Week success'
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy($id)
    {

        try {
            $data = Traffic::where('id', $id)->delete();
            if ($data) {
                $response = [
                    'status' => '1',
                    'msg' => 'success Traffic deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                {
                    $response = [
                        'status' => false,
                        'msg' => 'The delete (Traffic) operation failed '
                    ];
                    return response()->json($response, Response::HTTP_NOT_FOUND);

                }
            }

        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    public function check_time($request)
    {
        $arrayTraffics = [];
//        return ($request);
        foreach ($request->id_user as $id_user) {
            foreach ($request->id_day as $id_day) {
                $arrayTraffics[] = Traffic::create([
                    'id_user' => $id_user,
                    'id_day' => $id_day,
                    'id_absents' => $request->id_absents,
                    'id_substitute' => $request->id_substitute,
                    'id_mission' => $request->id_mission,
                    'time_day_absents' => $request->time_day_absents,
                    'description_absents' => $request->description_absents,
                    'time_day_mission' => $request->time_day_mission,
                    'description_mission' => $request->description_mission,
                    'data_mission' => $request->data_mission,
                    'data_absents' => $request->data_absents,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'enter_time' => $request->enter_time,
                    'exit_time' => $request->exit_time,
                    'active' => $request->active,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return $arrayTraffics;

    }


}
