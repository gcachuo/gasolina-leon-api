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
        $sql = <<<sql
select 
       id_gasolinera id,
       nombre_gasolinera name,
       company_gasolinera company,
       latitud_gasolinera lat,
       longitud_gasolinera lng,
       estatus_gasolinera status
 from gasolineras;
sql;

        $results = db_all_results($sql);
        $data = [];
        foreach ($results as $result) {
            array_push($data, [
                'name'=>$result['name'],
                'company' => $result['company'],
                'position' => [
                    'lat' => $result['lat'],
                    'lng' => $result['lng']
                ],
                'active' => $result['status']
            ]);
        }
        return compact('data');
    }
}