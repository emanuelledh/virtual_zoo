<?php
abstract class Food
{
    private $calories;
    private $name;

    function __construct($name,$calories)
    {
        $this->name = $name;
        $this->calories = $calories;
    }

    public function setCalories($calories)
    {
        $this->calories = $calories;
    }
    public function getCalories()
    {
        return $this->calories;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getType(){
        return $this->type;
    }
}
?>