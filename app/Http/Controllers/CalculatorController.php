<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calculator;
use App\Http\Requests\CalculatorRequest;
class CalculatorController extends Controller
{
    public function add(CalculatorRequest $request)
    {
        try {
            $request->validate($request->rules());
            $calculator = new Calculator();
            $answer = $calculator->add($request->getA(), $request->getB());
            return response()->json(["result"=>$answer]);
        } catch (\Throwable $e) {
            abort(422, 'Unprocessable Entity');
        }
    }


    public function sub(CalculatorRequest $request)
    {
        try {
            $request->validate($request->rules());
            $calculator = new Calculator();
            $answer = $calculator->subtract($request->getA(), $request->getB());
            return response()->json(["result"=>$answer]);
        } catch (\Throwable $e) {
            abort(422, 'Unprocessable Entity');
        }
    }


    public function div(CalculatorRequest $request)
    {
        try {
            $request->validate($request->rules('div'));
            $calculator = new Calculator();
            $answer = $calculator->divide($request->getA(), $request->getB());
            return response()->json(["result"=>$answer]);
        } catch (\Throwable $e) {
            abort(422, 'Unprocessable Entity');
        }
    }

    public function mul(CalculatorRequest $request)
    {
        try {
            $request->validate($request->rules());
            $calculator = new Calculator();
            $answer = $calculator->multiply($request->getA(), $request->getB());
            return response()->json(["result"=>$answer]);
        } catch (\Throwable $e) {
            abort(422, 'Unprocessable Entity');
        }
    }

    public function mod(CalculatorRequest $request)
    {
        try {
            $request->validate($request->rules());
            $calculator = new Calculator();
            $answer = $calculator->modulo($request->getA(), $request->getB());
            return response()->json(["result"=>$answer]);
        } catch (\Throwable $e) {
            abort(422, 'Unprocessable Entity');
        }
    }
}
