<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrafficRequest;
use App\Models\Absence;
use App\Models\Mission;
use App\Models\Month;
use App\Models\ShiftEmployee;
use App\Models\traffic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Lib\Jdf;
use Illuminate\Database\Query\Builder;

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

    public function update(Request $request, $id)
    {
        try {
            $traffic = $request->all();
            $data = Traffic::where('id_user', $id)->get();
            foreach ($data as $values) {
                $values->update($traffic);
            }

            $response = [
                'success' => true,
                'data' => Traffic::where('id_user', $id)->get(),
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
        $users = $request->id_user;
        $dateSingleTraffic = $request->date_single_traffic;
        $days = $request->id_day;
        $startDate = Carbon::parse($request->start_date);
        $dateToday = Carbon::today();
        if ($startDate < $dateToday) {
            if (is_array($request->id_user)) {
                foreach ($users as $id_user) {
                    if (is_array($days)) {
                        foreach ($days as $id_day) {
                            $idShiftEmployee = ShiftEmployee::where('id_user', $id_user)->get();
                            if (!empty($idShiftEmployee)) {
                                $arrayTraffics[] = Traffic::create([
                                    'id_user' => $id_user,
                                    'id_day' => $id_day,
                                    'id_shift' => $idShiftEmployee[0],
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
                            } else {
                                $response = [
                                    'status' => false,
                                    'msg' => 'No traffic has been recorded for this user yet'
                                ];
                                return response()->json($response, Response::HTTP_NOT_FOUND);
                            }
                        }

                    } else {
                        $idShiftEmployee = ShiftEmployee::where('id_user', $id_user)->pluck('id');
                        if (!empty($idShiftEmployee)) {
                            $arrayTraffics[] = Traffic::create([
                                'id_user' => $id_user,
                                'id_day' => $request->id_day,
                                'id_shift' => $idShiftEmployee[0],
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
                }


            } else {
                $idShiftEmployee = ShiftEmployee::where('id_user', $users)->pluck('id');
                $arrayTraffics = Traffic::create([
                    'id_user' => $request->id_user,
                    'id_day' => $request->id_day,
                    'id_shift' => $idShiftEmployee[0],
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
                    'end_date' => $request->start_date,
                    'enter_time' => $request->enter_time,
                    'exit_time' => $request->exit_time,
                    'active' => $request->active,
                    'date_single_traffic' => $dateSingleTraffic,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return $arrayTraffics;
            }

        } else {
            $response = [
                'status' => false,
                'msg' => 'Traffic cannot be recorded for the future'
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }

        return $arrayTraffics;

    }


}
