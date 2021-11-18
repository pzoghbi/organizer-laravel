<?php


namespace App\Services;

use App\Models\TodoItem;

class TodoItemService
{
    public function store($data)
    {
        $todoItem = new TodoItem();
        $todoItem->task_id = $data['task_id'];
        $todoItem->title = $data['title'];
        return $todoItem->save();
    }
}
