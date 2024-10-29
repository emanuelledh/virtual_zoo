<?php
class Apple extends Food
{
    private $wormInApple;

    function __construct($name,$calories,$hasWorms=false){
        parent::__construct($name,$calories);
        $this->wormInApple = $hasWorms;
        if($hasWorms)parent::setCalories(0);
    }

    //hasWorms() looks better :/
    public function hasWorms()
    {
        return $this->wormInApple;
    }

    public function getType()
    {
        return "It is what It is, an apple...";
    }
}
?>