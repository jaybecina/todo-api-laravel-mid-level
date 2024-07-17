<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TodoServiceInterface;

class TodoController extends BaseController
{
    protected $todoService;

    public function __construct(TodoServiceInterface $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index()
    {
        return $this->handleRequest(function () {
            $todos = $this->todoService->getAllTodos();

            if ($todos) {
                return $this->sendResponse($todos, 'TODO items retrieved successfully.');
            } else {
                return $this->sendError('TODO items not found.', [], 404);
            }
        });
    }

    public function show($id)
    {
        return $this->handleRequest(function () use ($id) {
            $todo = $this->todoService->getTodoById($id);

            if ($todo) {
                return $this->sendResponse($todo, 'TODO item retrieved successfully.');
            } else {
                return $this->sendError('TODO item not found.', [], 404);
            }
        });
    }

    public function store(Request $request)
    {
        return $this->handleRequest(function () use ($request) {
            $todo = $this->todoService->createTodo($request->all());

            if ($todo) {
                return $this->sendResponse($todo, 'TODO item created successfully.');
            } else {
                return $this->sendError('Error in creating TODO.', [], 404);
            }
        });
    }

    public function update(Request $request, $id)
    {
        return $this->handleRequest(function () use ($request, $id) {
            $todo = $this->todoService->updateTodo($id, $request->all());
            if ($todo) {
                return $this->sendResponse($todo, 'TODO item updated successfully.');
            } else {
                return $this->sendError('TODO item not found or update failed.', [], 404);
            }
        });
    }

    public function destroy($id)
    {
        return $this->handleRequest(function () use ($id) {
            $result = $this->todoService->deleteTodo($id);
            if ($result) {
                return $this->sendResponse([], 'TODO item deleted successfully.');
            } else {
                return $this->sendError('TODO item not found or delete failed.', [], 404);
            }
        });
    }
}
