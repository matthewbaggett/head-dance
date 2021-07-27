<?php
namespace MatthewBaggett\HeadDance;

use GuzzleHttp\Client;

class HeadDance{

    private Client $guzzle;
    public function __construct(){
        $options = getopt('',['octoprint:','apikey:','cycles::']);

        $this->guzzle = new Client([
            'base_uri' => $options['octoprint'],
            "headers" => [
                "X-API-KEY" => $options['apikey'],
            ]
        ]);
        $cycleCount = 0;

        $shouldCycle = true;
        while($shouldCycle) {
            $this->guzzle->post(
                "/api/printer/printhead",
                [
                    "json" => [
                        "absolute" => true,
                        "z" => rand(0, 360),
                        "y" => rand(-100, 100),
                        "x" => rand(-100, 100),
                        "command" => "jog",
                    ]
                ]
            );
            sleep(1);
            $cycleCount++;
            if (isset($options['cycles'])) {
                if ($cycleCount >= $options['cycles']){
                    $shouldCycle = false;
                }
            }
        }
    }
}