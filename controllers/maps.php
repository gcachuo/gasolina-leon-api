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
       g.id_gasolinera id,
       nombre_gasolinera name,
       company_gasolinera company,
       latitud_gasolinera lat,
       longitud_gasolinera lng,
       coalesce(max(hg.estatus_gasolinera),0) status,
       size_gasolinera size,
       tiempo_gasolinera time
 from gasolineras g
left join historial_gasolineras hg on hg.id_gasolinera=g.id_gasolinera
group by g.id_gasolinera;
sql;

        $results = db_all_results($sql);
        $data = [];
        foreach ($results as $result) {
            array_push($data, [
                'id' => $result['id'],
                'name' => $result['name'],
                'company' => $result['company'],
                'position' => [
                    'lat' => $result['lat'],
                    'lng' => $result['lng']
                ],
                'size'=> $result['size'],
                'time'=> $result['time'],
                'active' => $result['status']
            ]);
        }
        return compact('data');
    }

    function changeStatus()
    {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'] == 'true' ? 1 : 0;

        $sql = <<<sql
insert into historial_gasolineras(id_gasolinera,estatus_gasolinera,responsable_registro) values ('$id',$status,'Server');
sql;

        db_query($sql);

        return true;
    }
}