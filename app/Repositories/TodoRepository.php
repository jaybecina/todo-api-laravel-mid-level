<?php 

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{
    protected $todoModel;

    public function __construct(Todo $todoModel)
    {
        $this->todoModel = $todoModel;
    }

    public function getAll()
    {
        return $this->todoModel->all();
    }

    public function getById($id)
    {
        return $this->todoModel->find($id);
    }

    public function create(array $attributes)
    {
        return $this->todoModel->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $todo = $this->getById($id);
        if ($todo) {
            $todo->update($attributes);
            return $todo;
        }
        return null;
    }

    public function delete($id)
    {
        $todo = $this->getById($id);
        if ($todo) {
            $todo->delete();
            return true;
        }
        return false;
    }
}