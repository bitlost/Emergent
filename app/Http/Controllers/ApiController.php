<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\EmergentGrid;

class ApiController extends Controller
{

    public function nextgen(Request $request) {

        $grid = new EmergentGrid($request->input('M'), $request->input('N'));

        $grid->setLiveCells($request->input('liveCells'));
        $grid->buildContactCells();

        $nextLiveCells = $grid->nextGeneration();

        return response()->json($nextLiveCells)
                        ->setCallback($request->input('callback'));
    }

}
