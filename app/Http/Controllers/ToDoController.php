<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseMessage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ToDoController extends Controller
{
    public function index()
    {
        $todos = JWTAuth::parseToken()->authenticate()
            ->todos()
            ->paginate();

        return Response::json([
            'success' => true,
            'message' => 'ToDo retrieved Successfully',
            'data' => $todos,
        ]);
    }

    public function store(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string:max:255',
            'description' => 'required|max:50000',
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return Response::json(['error' => $validator->messages()], 200);
        }

        // Request is valid, create new todo
        $todo = JWTAuth::parseToken()->authenticate()->todos()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // todo created, return success response
        return Response::json([
            'success' => true,
            'message' => 'ToDo created successfully',
            'data' => $todo
        ], ResponseMessage::HTTP_OK);
    }

    public function show($id)
    {
        $todo = JWTAuth::parseToken()->authenticate()->todos()->find($id);

        if (!$todo) {
            return Response::json([
                'success' => false,
                'message' => 'Sorry, ToDo not found.'
            ], 400);
        }

        return $todo;
    }

    public function update(Request $request, int $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $todo = $user->todos()->find($id);

        if (! $todo) {
            return Response::json([
                'success' => false,
                'message' => 'Sorry, ToDo not found.',
                'data' => $todo
            ], ResponseMessage::HTTP_OK);
        }

        // Validate data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string:max:255',
            'description' => 'required|max:50000',
        ]);

        // Send failed response if request is not valid
        if ($validator->fails()) {
            return Response::json(['error' => $validator->messages()], 200);
        }

        // Request is valid, update todo
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // todo updated, return success response
        return Response::json([
            'success' => true,
            'message' => 'ToDo updated successfully',
            'data' => $todo
        ], ResponseMessage::HTTP_OK);
    }

    public function destroy(int $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $todo = $user->todos()->find($id);

        if ($todo) {
            $todo->delete();

            return Response::json([
                'success' => true,
                'message' => 'ToDo deleted successfully'
            ], ResponseMessage::HTTP_OK);
        }

        return Response::json([
            'success' => false,
            'message' => 'Sorry, ToDo not found.'
        ], ResponseMessage::HTTP_OK);
    }
}
