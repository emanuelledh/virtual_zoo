<?php
class VirtualPet
{
    private $petName;
    private $type;
    private $basalCalories;
    private $currentCalories;

    function __construct($name,$type,$calories)
    {
        $this->petName = $name;
        $this->type = $type;
        $this->basalCalories = $calories;
        $this->currentCalories = $this->basalCalories;
    }

    public function setName($name)
    {
        $this->petName = $name;
    }
    public function getName()
    {
        return $this->petName;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    
    public function getBasal()
    {
        return $this->basalCalories;
    }

    public function setCurrentCalories($cc)
    {
        $this->currentCalories = $cc;
    }
    public function getCurrentCalories()
    {
        return $this->currentCalories;
    }

    public function eat(Food $food)
    {
        if($this->currentCalories + $food->getCalories()>=$this->basalCalories){
            $this->currentCalories = $this->basalCalories;
        }else{
            $this->currentCalories = $this->currentCalories + $food->getCalories();
        }

        if($this->currentCalories<=0){
            echo "O pet morreu!";
        }

        if(get_class($food)=="Apple"){
            if($food->hasWorms()){
                $this->setCurrentCalories($this->getCurrentCalories()/2);
            }
        }
    }
}
?>