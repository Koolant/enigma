<?php

$alphabet = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");

$input = str_split("QHSGUWIG");
$output = array();

$plugboard = new PlugBoard(array("A"=>"B","S"=>"Z","U"=>"Y","G"=>"H","L"=>"Q","E"=>"N"));
$reflector = new Rotor("YRUHQSLDPXNGOKMIEBFZCWVJAT","A");

$scramblerTwo      = new Rotor("UWYGADFPVZBECKMTHXSLRINQOJ","E");
$scrambler         = new Rotor("AJPCZWRLFBDKOTYUQGENHXMIVS","A");
$scramblerThree    = new Rotor("TAGBPCSDQEUFVNZHYIXJWLRKOM","B");

$counter = 0;

while ($scramblerThree->counter < 26) {
    $scrambler->reset();
    $scramblerTwo->reset();
    $scramblerThree->reset();

    $scrambler->rotateLeft($counter);
    $scramblerTwo->rotateLeft(floor($counter/25));
    $scramblerThree->rotateLeft(floor($counter/50));

    
    $output = [];
    foreach ($input as $key => $val) {
        $scrambler->rotateLeft(1);
        $plugResult = $plugboard->getOut($val);
        $a = $scrambler->getOutIndex(array_search($plugResult, $alphabet));
        $b = $scramblerTwo->getOutIndex($a);
        $c = $scramblerThree->getOutIndex($b);
        $d = $reflector->getOutIndex($c);
        $e = $scramblerThree->getInIndex($d);
        $f = $scramblerTwo->getInIndex($e);
        $g = $scrambler->getInIndex($f);
        $result = $plugboard->getIn(array_search($g, $alphabet));

        if ($result === $val) {
            break;
        }
        $output[] = $alphabet[$g];
    }
    echo implode($output) . PHP_EOL;
    $counter++;
}