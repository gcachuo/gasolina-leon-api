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
       coalesce(estatus_gasolinera,0) status,
      coalesce(size_gasolinera,0) size,
      coalesce(tiempo_gasolinera,0) time,
      coalesce(responsable_registro,'Sistema') rep,
       coalesce(fecha_historial_gasolinera,'2019-01-08') fecha
 from gasolineras g
left join (SELECT *
FROM historial_gasolineras
WHERE id_historial_gasolinera IN (
    SELECT MAX(id_historial_gasolinera)
    FROM historial_gasolineras
    where fecha_historial_gasolinera >= DATE_SUB(NOW(), INTERVAL 12 HOUR)
    GROUP BY id_gasolinera
)) hg on g.id_gasolinera=hg.id_gasolinera
order by status desc, name
sql;

        $results = db_all_results($sql);
        $data = [];
        foreach ($results as $result) {
            array_push($data, [
                'id' => $result['id'],
                'name' => htmlentities(utf8_encode($result['name'])),
                'company' => $result['company'],
                'position' => [
                    'lat' => $result['lat'],
                    'lng' => $result['lng']
                ],
                'size' => [0 => 'Desconocida', 1 => 'Pequeña', 2 => 'Mediana', 3 => 'Grande', 4 => 'Excesiva'][$result['size']],
                'time' => [0 => 'Desconocido', 1 => 'Corto', 2 => 'Regular', 3 => 'Largo', 4 => 'Eterno'][$result['time']],
                'rep' => htmlentities(utf8_encode($result['rep'])),
                'updated' => date('d-m-Y H:i:s', strtotime($result['fecha'])),
                'active' => $result['status']
            ]);
        }
        return compact('data');
    }

    function changeStatus()
    {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'] == '1' ? 1 : 0;
        $responsable = isset_get($_REQUEST['responsable'], 'Server');
        $fila = isset_get($_REQUEST['fila'], 0);
        $tiempo = isset_get($_REQUEST['tiempo'], 0);

        $sql = <<<sql
insert into historial_gasolineras(id_gasolinera,estatus_gasolinera,responsable_registro,size_gasolinera,tiempo_gasolinera) values ('$id',$status,'$responsable',$fila,$tiempo);
sql;

        db_query($sql);

        return true;
    }
}