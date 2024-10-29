<?php
class IceCream extends Food
{
    public $type;

    function __construct($name,$calories,$type)
    {
        parent::__construct($name,$calories);
        $this->type = $type;
    }
}
?>