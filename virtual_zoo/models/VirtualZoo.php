<?php
class VirtualZoo
{
    private $cages = [];

    public function addPet(VirtualPet $pet)
    {
        $this->cages[] = $pet;
    }
    public function getPet($index)
    {
        return $this->cages[$index];
    }

    public function getCages()
    {
        return $this->cages;
    }

    public function sendSound(VirtualPet $pet){
        switch ($pet->getType()) {
            case 'Jaguar':
                echo '
                    <audio autoplay="true" style="display:none;">
                        <source src="resources/sounds/jaguar.mp3" type="audio/mp3">
                    </audio>
                ';
                break;
            
            case 'Elephant':
                echo '
                    <audio autoplay="true" style="display:none;">
                        <source src="resources/sounds/elephant.mp3" type="audio/mp3">
                    </audio>
                ';
                break;

            case 'Monkey':
                echo '
                    <audio autoplay="true" style="display:none;">
                        <source src="resources/sounds/monkey.mp3" type="audio/mp3">
                    </audio>
                ';
                break;

            case 'Eagle':
                echo '
                    <audio autoplay="true" style="display:none;">
                        <source src="resources/sounds/eagle.mp3" type="audio/mp3">
                    </audio>
                ';
                break;

            default:
                break;
        }
    }
}
?>