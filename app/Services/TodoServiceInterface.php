<?php

namespace App\Services;

interface TodoServiceInterface
{
    public function getAllTodos();
    public function getTodoById($id);
    public function createTodo(array $data);
    public function updateTodo($id, array $data);
    public function deleteTodo($id);
}