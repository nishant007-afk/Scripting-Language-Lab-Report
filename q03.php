<?php

class Student
{
    public $name;
    public $surname;
    public $country;

    private $tuition = 1000;
    protected $indexNumber = "BCA001";

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function helloWorld()
    {
        return "Hello World!";
    }

    public function helloFamily()
    {
        return "Hello Family!";
    }

    public function helloMe()
    {
        return "Hello " . $this->name;
    }

    public function getTuition()
    {
        return $this->tuition;
    }
}

class PartTimeStudent extends Student
{
    public function helloParent()
    {
        return "Hello Parent!";
    }
}

$student = new Student();
$student->name = "Nishant";
$student->surname = "Dahal";
$student->country = "Nepal";

$partTime = new PartTimeStudent();
$partTime->name = "Rohan";

echo $student->helloWorld() . "<br>";
echo $student->helloMe() . "<br>";
echo $student->getTuition() . "<br>";
echo $partTime->helloParent();
