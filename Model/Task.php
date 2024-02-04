<?php

class Task 
{
    private $id;
    private $title;
    private $description;
    private $createDate;
    private $checked;
    private $priority;

    public function __construct($title, $description, $priority)
    {
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreateDate()
    {
        return $this->createDate;
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

    public function getChecked() 
    {
        return $this->checked;
    }

    public function setChecked($checked) 
    {
        $this->checked = $checked;
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