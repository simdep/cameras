<?php
/**
 * This file is part of the camera.
 *
 * PHP version 5.6 | 7.0 | 7.1
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license   MIT
 *
 * @see https://github.com/Alexandre-T/casguard/blob/master/LICENSE
 */

$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;


memory("first_line");
//$toto = file_get_contents('http://192.168.0.1:8000/meci-L1/discr/output/ucL12018_03_05');
$data = [];
//$inputFilename = __DIR__ . '/../data/input/ucL12018_03_05.txt';
//$outputFilename = __DIR__ . '/../data/output/ucL12018_03_05.csv';
$inputFilename = __DIR__ . '/../data/input/100000.txt';
$outputFilename = __DIR__ . '/../data/output/100000.csv';
$row = 1;


memory("initialized");

if (($plume = fopen($outputFilename, 'w+')) !== FALSE){
    if (($lecteur = fopen($inputFilename, "r")) !== FALSE) {
        while (($data = fgetcsv($lecteur, 1000, "\t")) !== FALSE) {
            if ($row == 1 ) {
                //Première ligne j'aoute les entêtes
                $line = my_header($data);
                fwrite($plume, implode("\t", $line)."\r\n");
                unset($line);
            }
            memory("before hash");
            $line = format($data);
            memory("after hash");
            fwrite($plume, implode("\t", $line)."\r\n");
            unset($line, $data);
            memory("after line write");
            $row++;
        }
        fclose($lecteur);
    }
    fclose($plume);
}

memory("end");
memory_peak('PIC de mémoire');


//var_dump($result);
function format(array $data): array
{
    $resultat = [];
    $cryptage='sha1';

    foreach($data as $line) {
        list($key, $value) = explode('=', $line);
        switch ($key) {
            case 'P':
            case 'p':
            $resultat[$key] = $cryptage($value.'un sel crystallisé');
            break;
            default:
                $resultat[$key] = $value;
        }
    }

    if (count($data) !== count($resultat)) {
        die ('error');
    }
    return $resultat;
}

function my_header(array $data): array
{
    $resultat = [];
    foreach($data as $line) {
        list($key, ) = explode('=', $line);
        $resultat[] = $key;
    }

    if (count($data) !== count($resultat)) {
        die ('error');
    }
    return $resultat;
}

function memory(string $intro): void
{
    echo "$intro: " . round(memory_get_usage()/(1024),2)." Ko \n";
}

function memory_peak(string $intro): void
{
    echo "$intro: " . round(memory_get_peak_usage()/(1024),2)." Ko \n";
}

$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
echo 'Page générée en '.number_format($totaltime,4,',','').' s';