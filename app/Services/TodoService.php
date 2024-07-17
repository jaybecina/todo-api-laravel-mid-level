<?php

namespace App\Services;

use App\Repositories\TodoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class TodoService implements TodoServiceInterface
{
    protected $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getAllTodos()
    {
        return $this->todoRepository->getAll();
    }

    public function getTodoById($id)
    {
        return $this->todoRepository->getById($id);
    }

    public function createTodo(array $data)
    {
        DB::beginTransaction();

        try {
            $todo = $this->todoRepository->create($data);
            DB::commit();
            return $todo;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to create TODO item: ' . $e->getMessage());
        }
    }

    public function updateTodo($id, array $data)
    {
        DB::beginTransaction();
        try {
            $todo = $this->todoRepository->update($id, $data);
            DB::commit();
            return $todo;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to update TODO item: ' . $e->getMessage());
        }
    }

    public function deleteTodo($id)
    {
        DB::beginTransaction();
        try {
            $this->todoRepository->delete($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to delete TODO item: ' . $e->getMessage());
        }
    }
}
