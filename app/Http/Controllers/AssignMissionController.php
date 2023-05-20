<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignMissionRequest;
use App\Models\AssignMission;
use App\Models\Mission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class AssignMissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $mission = Mission::all();
        return response()->json([
            'user' => $user,
            'mission' => $mission,
        ]);
    }

    public function store(AssignMissionRequest $request)
    {
        try {
            $assignMission = AssignMission::create($request->all());
            if ($assignMission) {
                return response()->json($assignMission, Response::HTTP_OK);

            } else {
                return response()->json($assignMission, Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignMission $assignMission)
    {
        //
    }

    public function update(AssignMissionRequest $request,$id)
    {
        try {
            $assignMission = $request->all();
            $data = AssignMission::find($id);
            $data->update($assignMission);
            $response = [
                'success' => true,
                'data' => AssignMission::find($id),
                'message' => 'update Mission success'
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy(AssignMission $assignMission,$id)
    {
        try {
            $data = AssignMission::where('id', $id)->delete();
            if ($data) {
                $response = [
                    'status' => '1',
                    'msg' => 'success Mission deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                {
                    $response = [
                        'status' => false,
                        'msg' => 'The delete (Mission) operation failed '
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
