<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        if ($todos->count() > 0) {
            return response()->json([
                'status' => 200,
                'todos' => $todos
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:191',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $todo = Todo::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if ($todo) {
                return response()->json([
                    'status' => 200,
                    'message' => "Todo Created Successfully"
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong"
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            return response()->json([
                'status' => 200,
                'todo' => $todo
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Todo Found"
            ], 404);
        }
    }

    public function edit($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            return response()->json([
                'status' => 200,
                'todo' => $todo
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Todo Found"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:191',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {

            $todo = Todo::find($id);
            if ($todo) {

                $todo->update([
                    'title' => $request->title,
                    'description' => $request->description,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Todo Updated Successfully"
                ], 200);
            } else {

                return response()->json([
                    'status' => 404,
                    'message' => "No Such Todo Found!"
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        if ($todo) {

            $todo->delete();

            return response()->json([
                'status' => 200,
                'message' => "Todo Deleted Successfully"
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Todo Found!"
            ], 404);
        }
    }
}
