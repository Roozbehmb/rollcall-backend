<?php

namespace App\Http\Controllers;

use App\Http\Requests\absenceRequest;
use App\Models\Absence;
use App\Models\TypeAbsence;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AbsenceController extends Controller
{
    public function index()
    {
        $absence = Absence::all();
        $typeAbsence = TypeAbsence::all();
        return response()->json([
            'absence' => $absence,
            'typeAbsence' => $typeAbsence,
        ]);
    }

    public function store(absenceRequest $request)
    {
        try {
            $absence = Absence::create($request->all());
            return response()->json($absence, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_NOT_FOUND);
        }
        return response()->json($absence);
    }

    public function update(absenceRequest $request, Absence $periodicShift, $id)
    {
        try {
            $absence = $request->all();
            $data = Absence::find($id);
            $data->update($absence);
            $response = [
                'success' => true,
                'data' => Absence::find($id),
                'message' => 'update Absence success'
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            $message = $error->getMessage();
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function destroy($periodicShift, $id)
    {
        try {
            $data = Absence::where('id', $id)->delete();
            if($data)
            {
                $response = [
                    'status' => '1',
                    'msg' => 'success Absence deleted'
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                {
                    $response = [
                        'status' => false,
                        'msg' => 'The delete (Absence) operation failed '
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
