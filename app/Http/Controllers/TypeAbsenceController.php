<?php

namespace App\Http\Controllers;

use App\Models\TypeAbsence;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class TypeAbsenceController extends Controller
{

    public function index()
    {
        $TypeAbsence = TypeAbsence::all();
        return response()->json($TypeAbsence);
    }

    public function store(Request $request)
    {
        try {
            $TypeAbsence = TypeAbsence::create($request->all());
        } catch (Exception $error) {
            return response()->json($error, Response::HTTP_NOT_FOUND);
        }
        return response()->json($TypeAbsence);
    }

    public function update(Request $request, TypeAbsence $typeAbsence)
    {
        //
    }

    public function destroy(TypeAbsence $typeAbsence)
    {
        //
    }
}
