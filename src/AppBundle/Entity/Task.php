<?php

namespace AppBundle\Entity;

class Task
{
    protected $task;
    protected $task2;

    public function getTask2()
    {
        return $this->task2;
    }

    public function setTask2($task2)
    {
        $this->task2 = $task2;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

}