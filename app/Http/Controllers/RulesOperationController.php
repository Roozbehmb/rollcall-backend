<?php

namespace App\Http\Controllers;

use App\Http\Requests\RulesOperationRequest;
use App\Models\RulesOperation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class RulesOperationController extends Controller
{
    public function index()
    {
        $rulesOperation = RulesOperation::all();
        return response()->json([
            'rulesOperation' => $rulesOperation,
        ]);
    }

    public function store(RulesOperationRequest $request)
    {
        try {
            $rulesOperation = RulesOperation::create($request->all());
            return $request;

            return response()->json($rulesOperation, Response::HTTP_OK);

        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_NOT_FOUND);
        }
        return response()->json($rulesOperation);
    }

    public function update(RulesOperationRequest $request, RulesOperation $periodicShift, $id)
    {
        try {
            $absence = $request->all();
            $data = RulesOperation::find($id);
            $data->update($absence);
            $response = [
                'success' => true,
                'data' => RulesOperation::find($id),
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
            $data = RulesOperation::where('id', $id)->delete();

            if ($data) {
                $response = [
                    'status' => true,
                    'msg' => 'success RulesOperation deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                {
                    $response = [
                        'status' => false,
                        'msg' => 'The delete (RulesOperation) operation failed '
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
