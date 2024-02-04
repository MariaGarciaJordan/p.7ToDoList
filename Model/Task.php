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

    public function setTitle($title) 
    {
        $this->title = $title;
    }

    public function getDescription() 
    {
        return $this->description;
    }

    public function setDescription($description) 
    {
        $this->description = $description;
    }

    public function getPriority() 
    {
        return $this->priority;
    }

    public function setPriority($priority) 
    {
        $this->priority = $priority;
    }

}