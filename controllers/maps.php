<?php

/**
 * Created by PhpStorm.
 * User: Cachu
 * Date: 9/01/19
 * Time: 02:45 AM
 */
class Maps
{
    function getData()
    {
        $data = [
            [
                'company' => 'Oxxo Gas',
                'position' => ['lat' => 21.1413763, 'lng' => -101.6602022],
                'active' => 1
            ],
            [
                'company' => 'Pemex',
                'position' => ['lat' => 21.1439166, 'lng' => -101.6586434],
                'active' => 0
            ]
        ];
        return compact('data');
    }
}