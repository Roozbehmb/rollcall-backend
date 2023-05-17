<?php

namespace App\Http\Controllers;

use App\Models\MissionRegistration;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class MissionRegistrationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $MissionRegistration = MissionRegistration::all();
        return response()->json([
            'Mission' => $MissionRegistration,
            'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $MissionRegistration = MissionRegistration::create($request->all());
            if ($MissionRegistration) {
                return response()->json($MissionRegistration, Response::HTTP_OK);

            } else {
                return response()->json($MissionRegistration, Response::HTTP_NOT_FOUND);

            }
        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $MissionRegistration = $request->all();
            $data = MissionRegistration::find($id);
            $data->update($MissionRegistration);
            $response = [
                'success' => true,
                'data' => MissionRegistration::find($id),
                'message' => 'update Mission success'
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
            $data = MissionRegistration::where('id', $id)->delete();
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
