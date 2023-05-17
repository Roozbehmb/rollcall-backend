<?php

namespace App\Http\Controllers;

use App\Models\AssignWorkingRules;
use App\Models\RulesOperation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class AssignWorkingRulesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $rulesOperation = RulesOperation::all();
        $assignWorkingRules = AssignWorkingRules::all();
        return response()->json([
            'assignWorkingRules' => $assignWorkingRules,
            'user' => $user,
            'rulesOperation'=>$rulesOperation
        ]);
    }

    public function store(Request $request)
    {
        try {
            $assignWorkingRules = AssignWorkingRules::create($request->all());
            if ($assignWorkingRules) {
                return response()->json($assignWorkingRules, Response::HTTP_OK);

            } else {
                return response()->json($assignWorkingRules, Response::HTTP_NOT_FOUND);

            }
        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $MissionRegistration = $request->all();
            $data = AssignWorkingRules::find($id);
            $data->update($MissionRegistration);
            $response = [
                'success' => true,
                'data' => AssignWorkingRules::find($id),
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
            $data = AssignWorkingRules::where('id', $id)->delete();
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
