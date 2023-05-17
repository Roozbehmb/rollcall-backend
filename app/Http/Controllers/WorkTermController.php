<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\WorkTerm;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class WorkTermController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $workTerm = WorkTerm::all();
        $month = Month::all();
        return response()->json([
            'user' => $user,
            'workTerm' => $workTerm,
            'month' => $month
        ]);
    }

    public function store(Request $request)
    {
        try {
            $workTerm = WorkTerm::create($request->all());
            if ($workTerm) {
                return response()->json($workTerm, Response::HTTP_OK);

            } else {
                return response()->json($workTerm, Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $workTerm = $request->all();
            $data = WorkTerm::find($id);
            $data->update($workTerm);
            $response = [
                'success' => true,
                'data' => WorkTerm::find($id),
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
            $data = WorkTerm::where('id', $id)->delete();
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
