<?php
require("models/Food.php");
require("models/Apple.php");
require("models/Icecream.php");
require("models/Sushi.php");
require("models/VirtualZoo.php");
require("models/VirtualPet.php");

$zoo = new VirtualZoo();

$pet = new VirtualPet(
    'Rob',
    'Aligator',
    3000
);

$zoo->addPet($pet);

$fruit = new Apple('Apple',150,true);

$candy = new IceCream('Icecream',300,'Vanilla');

$lunch = new Sushi('Sushi',300,'Takoyaki');

$pet->eat($fruit);

$pet->eat($candy);

$pet->eat($lunch);

var_dump($lunch->getType());