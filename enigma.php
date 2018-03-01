<?php

class Rotor
{
    public $alphabet;
    public $wiring;
    
    public function __construct($wiring)
    {
        $this->alphabet = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
        $this->wiring = str_split($wiring);
    }
    
    public function rotateLeft()
    {
        array_push($this->alphabet, array_shift($this->alphabet));
        array_push($this->wiring,array_shift($this->wiring));
    }
    
    public function getOutIndex($idx)
    {
        $char = $this->alphabet[$idx];
        return array_search($char, $this->wiring);
    }
    
    public function getInIndex($idx)
    {
        $char = $this->wiring[$idx];
        return array_search($char, $this->alphabet);
    }
}

$alphabet = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");

$input = str_split("QHSGUWIG");
$output = array();


$reflector = new Rotor("YRUHQSLDPXNGOKMIEBFZCWVJAT");

for ($i = 0;$i < count($alphabet); $i++) {
    $scrambler = new Rotor("UWYGADFPVZBECKMTHXSLRINQOJ");
    for ($j = 0;$j < $i;$j++) {
        if($j>0){
            $scrambler->rotateLeft();
        }
    }
    $output = [];
    foreach ($input as $val) {
        $scrambler->rotateLeft();
        $stepOne = $scrambler->getOutIndex(array_search($val, $alphabet));
        $stepTwo = $reflector->getOutIndex($stepOne);
        $stepThree = $scrambler->getInIndex($stepTwo);
        $output[] = $alphabet[$stepThree];
    }
    if($output[0].$output[1] !== 'XV') {
        continue;
    }
    echo implode($output) . PHP_EOL;
}