<?php

class Task 
{
    private $title;
    private $description;
    private $priority;

    public function __construct($title, $description, $priority)
    {
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
    }

    public function getTitle() 
    {
        return $this->title;
    }

    public function getDescription() 
    {
        return $this->description;
    }

    public function getPriority() 
    {
        return $this->priority;
    }

}