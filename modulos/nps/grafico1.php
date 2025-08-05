<?php

    include "config/conexion.php";

    $mar = $_POST['Mar'];
    $suc = $_POST['Suc'];
    $ase = $_POST['Ase'];
    $fecIni = $_POST['FecIni'];
    $fecTer = $_POST['FecTerm'];

    if($mar == "todosMarca"){
        $consulta = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10014'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

        $consulta2 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10008'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

        $consulta3 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10009'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

        $consulta4 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10010'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

    $consulta5 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10011'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
    $consulta6 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10012'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
    $consulta7 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10013'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
    $consultaDetalle = "
            SELECT
            tblencencuesta.EncId,
            tblclicliente.CliNombreCompleto,
            tblencencuesta.EncFecha,
            tblencencuesta.EncObservacion,
            tblencencuesta.OvvId,
            tblencencuesta.EncTipo,
            tblvmovehiculomodelo.VmoNombre,
            tbleinvehiculoingreso.EinVIN,
            tbleinvehiculoingreso.EinPlaca,
            tblencencuesta.EncEstado,
            tblencencuesta.EncTiempoCreacion,
            tblencencuesta.EncTiempoModificacion,
            tbledeencuestadetalle.EdeRespuesta,
            tblovvordenventavehiculo.CliId,
            CONCAT(tblperpersonal.PerNombre,' ',tblperpersonal.PerApellidoPaterno,' ',tblperpersonal.PerApellidoMaterno) AS asesor,
            tblclicliente.CliTelefono,
            tblclicliente.CliCelular
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tblclicliente ON tblovvordenventavehiculo.CliId = tblclicliente.CliId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblperpersonal ON tblovvordenventavehiculo.PerId = tblperpersonal.PerId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tbledeencuestadetalle.EprId =  'EPR-10014'
        ";


    }elseif($suc=="todosSucursal"){
        $consulta = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10014' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

        $consulta2 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10008' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

        $consulta3 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10009' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

        $consulta4 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10010' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

    $consulta5 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10011' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
    $consulta6 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10012' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
    $consulta7 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tbledeencuestadetalle.EprId =  'EPR-10013' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
    $consultaDetalle = "
            SELECT
            tblencencuesta.EncId,
            tblclicliente.CliNombreCompleto,
            tblencencuesta.EncFecha,
            tblencencuesta.EncObservacion,
            tblencencuesta.OvvId,
            tblencencuesta.EncTipo,
            tblvmovehiculomodelo.VmoNombre,
            tbleinvehiculoingreso.EinVIN,
            tbleinvehiculoingreso.EinPlaca,
            tblencencuesta.EncEstado,
            tblencencuesta.EncTiempoCreacion,
            tblencencuesta.EncTiempoModificacion,
            tbledeencuestadetalle.EdeRespuesta,
            tblovvordenventavehiculo.CliId,
            CONCAT(tblperpersonal.PerNombre,' ',tblperpersonal.PerApellidoPaterno,' ',tblperpersonal.PerApellidoMaterno) AS asesor,
            tblclicliente.CliTelefono,
            tblclicliente.CliCelular
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tblclicliente ON tblovvordenventavehiculo.CliId = tblclicliente.CliId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblperpersonal ON tblovvordenventavehiculo.PerId = tblperpersonal.PerId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tbledeencuestadetalle.EprId =  'EPR-10014' AND
            tblvmavehiculomarca.VmaId =  '".$mar."'
        ";

    }elseif($ase=="todosAsesor"){
        $consulta = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tblencencuesta.OvvId like  '%".$suc."' AND
        tbledeencuestadetalle.EprId =  'EPR-10014' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

        $consulta2 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tblencencuesta.OvvId like  '%".$suc."' AND
        tbledeencuestadetalle.EprId =  'EPR-10008' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

        $consulta3 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tblencencuesta.OvvId like  '%".$suc."' AND
        tbledeencuestadetalle.EprId =  'EPR-10009' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

    $consulta4 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tblencencuesta.OvvId like  '%".$suc."' AND
        tbledeencuestadetalle.EprId =  'EPR-10010' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";

    $consulta5 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tblencencuesta.OvvId like  '%".$suc."' AND
        tbledeencuestadetalle.EprId =  'EPR-10011' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
        $consulta6 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tblencencuesta.OvvId like  '%".$suc."' AND
        tbledeencuestadetalle.EprId =  'EPR-10012' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
    $consulta7 = "
        SELECT
        tbledeencuestadetalle.EdeRespuesta,
        COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
        FROM
        tblencencuesta
        Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
        Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
        Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
        Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
        Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
        Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
        WHERE
        tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
        tblencencuesta.EncTipo =  'VENTA' AND
        tblencencuesta.OvvId like  '%".$suc."' AND
        tbledeencuestadetalle.EprId =  'EPR-10013' AND
        tblvmavehiculomarca.VmaId =  '".$mar."'
        GROUP BY  tbledeencuestadetalle.EdeRespuesta
    ";
    $consultaDetalle = "
            SELECT
            tblencencuesta.EncId,
            tblclicliente.CliNombreCompleto,
            tblencencuesta.EncFecha,
            tblencencuesta.EncObservacion,
            tblencencuesta.OvvId,
            tblencencuesta.EncTipo,
            tblvmovehiculomodelo.VmoNombre,
            tbleinvehiculoingreso.EinVIN,
            tbleinvehiculoingreso.EinPlaca,
            tblencencuesta.EncEstado,
            tblencencuesta.EncTiempoCreacion,
            tblencencuesta.EncTiempoModificacion,
            tbledeencuestadetalle.EdeRespuesta,
            tblovvordenventavehiculo.CliId,
            CONCAT(tblperpersonal.PerNombre,' ',tblperpersonal.PerApellidoPaterno,' ',tblperpersonal.PerApellidoMaterno) AS asesor,
            tblclicliente.CliTelefono,
            tblclicliente.CliCelular
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tblclicliente ON tblovvordenventavehiculo.CliId = tblclicliente.CliId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblperpersonal ON tblovvordenventavehiculo.PerId = tblperpersonal.PerId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tbledeencuestadetalle.EprId =  'EPR-10014' AND
            tblvmavehiculomarca.VmaId =  '".$mar."' AND
            tblovvordenventavehiculo.OvvId LIKE  '%".$suc."'
        ";
    }else{
    
        $consulta = "
            SELECT
            tbledeencuestadetalle.EdeRespuesta,
            COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.OvvId like  '%".$suc."' AND
            tbledeencuestadetalle.EprId =  'EPR-10014' AND
            tblovvordenventavehiculo.PerId =  '".$ase."' AND
            tblvmavehiculomarca.VmaId =  '".$mar."'
            GROUP BY  tbledeencuestadetalle.EdeRespuesta
        ";

            $consulta2 = "
            SELECT
            tbledeencuestadetalle.EdeRespuesta,
            COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.OvvId like  '%".$suc."' AND
            tbledeencuestadetalle.EprId =  'EPR-10008' AND
            tblovvordenventavehiculo.PerId =  '".$ase."' AND
            tblvmavehiculomarca.VmaId =  '".$mar."'
            GROUP BY  tbledeencuestadetalle.EdeRespuesta
        ";

        $consulta3 = "
            SELECT
            tbledeencuestadetalle.EdeRespuesta,
            COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.OvvId like  '%".$suc."' AND
            tbledeencuestadetalle.EprId =  'EPR-10009' AND
            tblovvordenventavehiculo.PerId =  '".$ase."' AND
            tblvmavehiculomarca.VmaId =  '".$mar."'
            GROUP BY  tbledeencuestadetalle.EdeRespuesta
        ";

        $consulta4 = "
            SELECT
            tbledeencuestadetalle.EdeRespuesta,
            COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.OvvId like  '%".$suc."' AND
            tbledeencuestadetalle.EprId =  'EPR-10010' AND
            tblovvordenventavehiculo.PerId =  '".$ase."' AND
            tblvmavehiculomarca.VmaId =  '".$mar."'
            GROUP BY  tbledeencuestadetalle.EdeRespuesta
        ";

        $consulta5 = "
            SELECT
            tbledeencuestadetalle.EdeRespuesta,
            COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.OvvId like  '%".$suc."' AND
            tbledeencuestadetalle.EprId =  'EPR-10011' AND
            tblovvordenventavehiculo.PerId =  '".$ase."' AND
            tblvmavehiculomarca.VmaId =  '".$mar."'
            GROUP BY  tbledeencuestadetalle.EdeRespuesta
        ";
        $consulta6 = "
            SELECT
            tbledeencuestadetalle.EdeRespuesta,
            COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.OvvId like  '%".$suc."' AND
            tbledeencuestadetalle.EprId =  'EPR-10012' AND
            tblovvordenventavehiculo.PerId =  '".$ase."' AND
            tblvmavehiculomarca.VmaId =  '".$mar."'
            GROUP BY  tbledeencuestadetalle.EdeRespuesta
        ";
        $consulta7 = "
            SELECT
            tbledeencuestadetalle.EdeRespuesta,
            COUNT( tbledeencuestadetalle.EdeRespuesta) AS CONT
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.OvvId like  '%".$suc."' AND
            tbledeencuestadetalle.EprId =  'EPR-10013' AND
            tblovvordenventavehiculo.PerId =  '".$ase."' AND
            tblvmavehiculomarca.VmaId =  '".$mar."'
            GROUP BY  tbledeencuestadetalle.EdeRespuesta
        ";
        $consultaDetalle = "
            SELECT
            tblencencuesta.EncId,
            tblclicliente.CliNombreCompleto,
            tblencencuesta.EncFecha,
            tblencencuesta.EncObservacion,
            tblencencuesta.OvvId,
            tblencencuesta.EncTipo,
            tblvmovehiculomodelo.VmoNombre,
            tbleinvehiculoingreso.EinVIN,
            tbleinvehiculoingreso.EinPlaca,
            tblencencuesta.EncEstado,
            tblencencuesta.EncTiempoCreacion,
            tblencencuesta.EncTiempoModificacion,
            tbledeencuestadetalle.EdeRespuesta,
            tblovvordenventavehiculo.CliId,
            CONCAT(tblperpersonal.PerNombre,' ',tblperpersonal.PerApellidoPaterno,' ',tblperpersonal.PerApellidoMaterno) AS asesor,
            tblclicliente.CliTelefono,
            tblclicliente.CliCelular
            FROM
            tblencencuesta
            Inner Join tbledeencuestadetalle ON tblencencuesta.EncId = tbledeencuestadetalle.EncId
            Inner Join tblovvordenventavehiculo ON tblencencuesta.OvvId = tblovvordenventavehiculo.OvvId
            Inner Join tblclicliente ON tblovvordenventavehiculo.CliId = tblclicliente.CliId
            Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
            Inner Join tblperpersonal ON tblovvordenventavehiculo.PerId = tblperpersonal.PerId
            Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
            Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
            Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
            WHERE
            tblencencuesta.EncTipo =  'VENTA' AND
            tblencencuesta.EncFecha BETWEEN  '".$fecIni."' AND '".$fecTer."' AND
            tbledeencuestadetalle.EprId =  'EPR-10014' AND
            tblvmavehiculomarca.VmaId =  '".$mar."' AND
            tblovvordenventavehiculo.OvvId LIKE  '%".$suc."' AND
            tblperpersonal.PerId =  '".$ase."'
        ";
    }

    $resultado = mysqli_query($conexion,$consulta);
    $resultado2 = mysqli_query($conexion,$consulta2);
    $resultado3 = mysqli_query($conexion,$consulta3);
    $resultado4 = mysqli_query($conexion,$consulta4);
    $resultado5 = mysqli_query($conexion,$consulta5);
    $resultado6 = mysqli_query($conexion,$consulta6);
    $resultado7 = mysqli_query($conexion,$consulta7);
    $resultadoDetalle = mysqli_query($conexion,$consultaDetalle);

    //declaracion de variables para graficos
    $promotores = 0;
    $neutros = 0;
    $detractores = 0;

        //pregunta 2

        $totalInsatisfecho = 0;
        $insatisfecho = 0;
        $indiferente = 0;
        $satisfecho = 0;
        $totalSatisfecho = 0;

        //pregunta 3

        $totalInsatisfecho3 = 0;
        $insatisfecho3 = 0;
        $indiferente3 = 0;
        $satisfecho3 = 0;
        $totalSatisfecho3 = 0;

        //pregunta 4

        $respuestaSI_4 = 0;
        $respuestaNO_4 = 0;

        //pregunta 5

        $respuestaSI_5 = 0;
        $respuestaNO_5 = 0;

        //pregunta 6

        $respuestaSI_6 = 0;
        $respuestaNO_6 = 0;

        //pregunta 6

        $respuestaSI_7 = 0;
        $respuestaNO_7 = 0;

    //declaracion de variables para graficos
    while ($dataNPS = mysqli_fetch_array($resultado)){
        if($dataNPS['EdeRespuesta'] == 10){
            $promotores = $promotores+$dataNPS['CONT'];
        }elseif($dataNPS['EdeRespuesta'] == 9){
            $promotores = $promotores+$dataNPS['CONT'];
        }elseif($dataNPS['EdeRespuesta'] == 8){
            $neutros = $neutros+$dataNPS['CONT'];
        }elseif($dataNPS['EdeRespuesta'] == 7){
            $neutros = $neutros+$dataNPS['CONT'];
        }elseif($dataNPS['EdeRespuesta'] < 7){
            $detractores = $detractores+$dataNPS['CONT'];
        }
    }


    $encuestados = $promotores+$neutros+$detractores;

    if($encuestados != 0){
        $ponderadoPromotores = (100*$promotores)/$encuestados;
        $ponderadoNeutros = (100*$neutros)/$encuestados;
        $ponderadoDetractores = (100*$detractores)/$encuestados;

        $NPS = $ponderadoPromotores-$ponderadoDetractores;

        if($NPS <= 100 && $NPS >= 75){
            $color = "success";
            $palabra = "Excelente";
        }elseif($NPS <= 75 && $NPS >= 50){
            $color = "success";
            $palabra = "Bueno";
        }elseif($NPS <= 50 && $NPS >= 25){
            $color = "warning";
            $palabra = "Medio";
        }elseif($NPS <= 25 && $NPS >= 0){
            $color = "warning";
            $palabra = "Bajo";
        }elseif($NPS <= 0){
            $color = "danger";
            $palabra = "Alerta";
        }
        
        while ($data2 = mysqli_fetch_array($resultado2)){
            if($data2['EdeRespuesta'] == 1){
                $totalInsatisfecho = $totalInsatisfecho+$data2['CONT'];
            }elseif($data2['EdeRespuesta'] == 2){
                $insatisfecho = $insatisfecho+$data2['CONT'];
            }elseif($data2['EdeRespuesta'] == 3){
                $indiferente = $indiferente+$data2['CONT'];
            }elseif($data2['EdeRespuesta'] == 4){
                $satisfecho = $satisfecho+$data2['CONT'];
            }elseif($data2['EdeRespuesta'] == 5){
                $totalSatisfecho = $totalSatisfecho+$data2['CONT'];
            }
        }

        while ($data3 = mysqli_fetch_array($resultado3)){
            if($data3['EdeRespuesta'] == 1){
                $totalInsatisfecho3 = $totalInsatisfecho3+$data3['CONT'];
            }elseif($data3['EdeRespuesta'] == 2){
                $insatisfecho3 = $insatisfecho3+$data3['CONT'];
            }elseif($data3['EdeRespuesta'] == 3){
                $indiferente3 = $indiferente3+$data3['CONT'];
            }elseif($data3['EdeRespuesta'] == 4){
                $satisfecho3 = $satisfecho3+$data3['CONT'];
            }elseif($data3['EdeRespuesta'] == 5){
                $totalSatisfecho3 = $totalSatisfecho3+$data3['CONT'];
            }
        }

        //tabulacion de anteriores preguntas

        $indicador = ($totalSatisfecho*100)+($satisfecho*75)+($indiferente*50)+($insatisfecho*25)+($totalInsatisfecho*0);
        $valorIndicador = round($indicador/$encuestados);

        $indicador3 = ($totalSatisfecho3*100)+($satisfecho3*75)+($indiferente3*50)+($insatisfecho3*25)+($totalInsatisfecho3*0);
        $valorIndicador3 = round($indicador3/$encuestados);

        //Consecionario mantuvo sus compromisos?

        while ($data4 = mysqli_fetch_array($resultado4)){
            if($data4['EdeRespuesta'] == "Si"){
                $respuestaSI_4 = $respuestaSI_4+$data4['CONT'];
            }elseif($data4['EdeRespuesta'] == "No"){
                $respuestaNO_4 = $respuestaNO_4+$data4['CONT'];
            }
        }
        
        $totalValorRespuesta_4 = $respuestaSI_4*100;
        $cantidadRespuestas_4 = $respuestaSI_4+$respuestaNO_4;
        $noAplica_4 = $encuestados - $cantidadRespuestas_4;

        $valorCalculado_4 = $totalValorRespuesta_4/$cantidadRespuestas_4;


        if($valorCalculado_4 >= 50){
            $palabra_4 = "Positivo";
            $color_4 = "success";
        }else{
            $palabra_4 = "Negativo";
            $color_4 = "danger";
        }

         //Su vehiculo fue entregado en el tiempo acordado?

         while ($data5 = mysqli_fetch_array($resultado5)){
            if($data5['EdeRespuesta'] == "Si"){
                $respuestaSI_5 = $respuestaSI_5+$data5['CONT'];
            }elseif($data5['EdeRespuesta'] == "No"){
                $respuestaNO_5 = $respuestaNO_5+$data5['CONT'];
            }
        }
        
        $totalValorRespuesta_5 = $respuestaSI_5*100;
        $cantidadRespuestas_5 = $respuestaSI_5+$respuestaNO_5;
        $noAplica_5 = $encuestados - $cantidadRespuestas_5;

        $valorCalculado_5 = $totalValorRespuesta_5/$cantidadRespuestas_5;


        if($valorCalculado_5 >= 50){
            $palabra_5 = "Positivo";
            $color_5 = "success";
        }else{
            $palabra_5 = "Negativo";
            $color_5 = "danger";
        }

        //En la entrega tuvo contacto con alguien de postventa?

        while ($data6 = mysqli_fetch_array($resultado6)){
            if($data6['EdeRespuesta'] == "Si"){
                $respuestaSI_6 = $respuestaSI_6+$data6['CONT'];
            }elseif($data6['EdeRespuesta'] == "No"){
                $respuestaNO_6 = $respuestaNO_6+$data6['CONT'];
            }
        }
        
        $totalValorRespuesta_6 = $respuestaSI_6*100;
        $cantidadRespuestas_6 = $respuestaSI_6+$respuestaNO_6;
        $noAplica_6 = $encuestados - $cantidadRespuestas_6;

        $valorCalculado_6 = $totalValorRespuesta_6/$cantidadRespuestas_6;

        if($valorCalculado_6 >= 50){
            $palabra_6 = "Positivo";
            $color_6 = "success";
        }else{
            $palabra_6 = "Negativo";
            $color_6 = "danger";
        }

        //Esta conforme con el servicio?
        
        while ($data7 = mysqli_fetch_array($resultado7)){
            if($data7['EdeRespuesta'] == "Si"){
                $respuestaSI_7 = $respuestaSI_7+$data7['CONT'];
            }elseif($data7['EdeRespuesta'] == "No"){
                $respuestaNO_7 = $respuestaNO_7+$data7['CONT'];
            }
        }
        
        $totalValorRespuesta_7 = $respuestaSI_7*100;
        $cantidadRespuestas_7 = $respuestaSI_7+$respuestaNO_7;
        $noAplica_7 = $encuestados - $cantidadRespuestas_7;

        $valorCalculado_7 = $totalValorRespuesta_7/$cantidadRespuestas_7;

        if($valorCalculado_7 >= 50){
            $palabra_7 = "Positivo";
            $color_7 = "success";
        }else{
            $palabra_7 = "Negativo";
            $color_7 = "danger";
        }

?>

        
            <div class="row">
                <div class='col-md-auto'>
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title" style='text-align: center'><?php echo round($NPS); ?></h1>
                            <h2 class="card-title" style='text-align: center'>NPS <span class="badge badge-<?php echo $color; ?>"><?php echo $palabra; ?></span></h2>
                            <p class='card-text'>%promotores - %detractores = %NPS</p>
                        </div>
                    </div>
                </div>
                <div class='col-md-5'>
                    <div class='card'>
                        <div class='card-body' style='text-align:center'>
                            <canvas id="barh" width="400" height="120"></canvas>
                            <span class="badge badge-success"><?php echo "Promotores: ".$promotores ?></span>
                            <span class="badge badge-warning"><?php echo "Neutros: ".$neutros ?></span>
                            <span class="badge badge-danger"><?php echo "Detractores: ".$detractores ?></span>
                        </div>
                    </div>
                </div>
                <div class='col-md-auto'>
                    <div class="card">
                        <div class="card-body">
                        <h1 class="card-title" style='text-align: center'><?php echo $encuestados; ?></h1>
                        <h2 class="card-title" style='text-align: center'>Encuestados</h2>
                        <p class='card-text'><?php echo "entre el ".$fecIni." al ".$fecTer;?></p>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class='row'>
                <div class='col-md-6'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5>Grado de Satisfaccion General de Compra y Entrega</h5>
                            <canvas id="piechart" height="150"></canvas>
                            <div class='row'>
                                
                                    <div style='background: #02DC10; border-radius: 4px; width:15px; height:15px; margin-top:0.9%; margin-left:31%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $totalSatisfecho; ?></label>
                                    </div>
                                    <div style='background: #B2F403; border-radius: 4px; width:15px; height:15px; margin-top:0.9%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $satisfecho; ?></label>
                                    </div>
                                    <div style='background: #F4C503; border-radius: 4px; width:15px; height:15px; margin-top:0.9%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $indiferente; ?></label>
                                    </div>
                                    <div style='background: #F46603; border-radius: 4px; width:15px; height:15px; margin-top:0.9%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $insatisfecho; ?></label>
                                    </div>
                                    <div style='background: #DC0202; border-radius: 4px; width:15px; height:15px; margin-top:0.9%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $totalInsatisfecho; ?></label>
                                    </div>
                                
                            </div>
                            <div class='row'>
                                <div class='col-md-12' style='text-align:center'>
                                    <h4>Valor: <?php echo $valorIndicador; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5>Grado de Satisfaccion con el Asesor comercial</h5>
                            <canvas id="piechart2"  height="150"></canvas>
                            <div class='row'>
                                
                                    <div style='background: #02DC10; border-radius: 4px; width:15px; height:15px; margin-top:0.9%; margin-left:31%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $totalSatisfecho3; ?></label>
                                    </div>
                                    <div style='background: #B2F403; border-radius: 4px; width:15px; height:15px; margin-top:0.9%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $satisfecho3; ?></label>
                                    </div>
                                    <div style='background: #F4C503; border-radius: 4px; width:15px; height:15px; margin-top:0.9%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $indiferente3; ?></label>
                                    </div>
                                    <div style='background: #F46603; border-radius: 4px; width:15px; height:15px; margin-top:0.9%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $insatisfecho3; ?></label>
                                    </div>
                                    <div style='background: #DC0202; border-radius: 4px; width:15px; height:15px; margin-top:0.9%'>
                                        
                                    </div>
                                    <div style='margin-left:1%; margin-right:3%'>
                                        <label><?php echo $totalInsatisfecho3; ?></label>
                                    </div>
                                
                            </div>
                            <div class='row'>
                                <div class='col-md-12' style='text-align:center'>
                                    <h4>Valor: <?php echo $valorIndicador3; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class='row'>
                        <div class='col-md-6' style='text-align:center'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h6>Consecionario mantuvo sus compromisos?</h6>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                            <th scope="col">SI</th>
                                            <th scope="col">NO</th>
                                            <th scope="col">NO APLICA</th>
                                            <th scope="col">TOTAL</th>
                                            <th scope="col">VALOR</th>
                                            <th scope="col">RESULTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td><?php echo $respuestaSI_4; ?></td>
                                            <td><?php echo $respuestaNO_4; ?></td>
                                            <td><?php echo $noAplica_4; ?></td>
                                            <td><?php echo $respuestaSI_4+$respuestaNO_4+$noAplica_4; ?></td>
                                            <td><?php echo round($valorCalculado_4)."%"; ?></td>
                                            <td><span class="badge badge-<?php echo $color_4?>"><?php echo $palabra_4 ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h6>Su vehiculo fue entregado en el tiempo acordado?</h6>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                            <th scope="col">SI</th>
                                            <th scope="col">NO</th>
                                            <th scope="col">NO APLICA</th>
                                            <th scope="col">TOTAL</th>
                                            <th scope="col">VALOR</th>
                                            <th scope="col">RESULTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td><?php echo $respuestaSI_5; ?></td>
                                            <td><?php echo $respuestaNO_5; ?></td>
                                            <td><?php echo $noAplica_5; ?></td>
                                            <td><?php echo $respuestaSI_5+$respuestaNO_5+$noAplica_5; ?></td>
                                            <td><?php echo round($valorCalculado_5)."%"; ?></td>
                                            <td><span class="badge badge-<?php echo $color_5?>"><?php echo $palabra_5 ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6' style='text-align:center'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h6>En la entrega tuvo contacto con alguien de postventa?</h6>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                <th scope="col">SI</th>
                                                <th scope="col">NO</th>
                                                <th scope="col">NO APLICA</th>
                                                <th scope="col">TOTAL</th>
                                                <th scope="col">VALOR</th>
                                                <th scope="col">RESULTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td><?php echo $respuestaSI_6; ?></td>
                                                <td><?php echo $respuestaNO_6; ?></td>
                                                <td><?php echo $noAplica_6; ?></td>
                                                <td><?php echo $respuestaSI_6+$respuestaNO_6+$noAplica_6; ?></td>
                                                <td><?php echo round($valorCalculado_6)."%"; ?></td>
                                                <td><span class="badge badge-<?php echo $color_6?>"><?php echo $palabra_6 ?></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h6>Esta conforme con el servicio?</h6>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                <th scope="col">SI</th>
                                                <th scope="col">NO</th>
                                                <th scope="col">NO APLICA</th>
                                                <th scope="col">TOTAL</th>
                                                <th scope="col">VALOR</th>
                                                <th scope="col">RESULTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td><?php echo $respuestaSI_7; ?></td>
                                                <td><?php echo $respuestaNO_7; ?></td>
                                                <td><?php echo $noAplica_7; ?></td>
                                                <td><?php echo $respuestaSI_7+$respuestaNO_7+$noAplica_7; ?></td>
                                                <td><?php echo round($valorCalculado_7)."%"; ?></td>
                                                <td><span class="badge badge-<?php echo $color_7?>"><?php echo $palabra_7 ?></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
            </div><br>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5>Comentarios</h5>
                            <table class="table table-sm" style="font-size:11px">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" style='width:20%'>CLIENTE</th>
                                    <th scope="col" style='width:7%'>FECHA</th>
                                    <th scope="col" style='width:22%'>VERBATINES</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">PLACA</th>
                                    <th scope="col">MODELO</th>
                                    <th scope="col">ASESOR</th>
                                    <th scope="col">TELEFONO</th>
                                    <th scope="col">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i = 1;
                                        while ($dataDetalle = mysqli_fetch_array($resultadoDetalle)){ 
                                        if($dataDetalle['EdeRespuesta'] <= 8){
                                            if($dataDetalle['EdeRespuesta']<=8 && $dataDetalle['EdeRespuesta']>=7){
                                                $color_celda = "warning";
                                                $posicion = "Neutro";
                                            }elseif($dataDetalle['EdeRespuesta']<=6 && $dataDetalle['EdeRespuesta']>=1){
                                                $color_celda = "danger";
                                                $posicion = "Detractor";
                                            }
                                        ?>
                                        <tr>
                                            <th scope="row" class='bg-<?php echo $color_celda; ?>'>
                                                <?php echo $i;
                                                $i++;?>
                                            </th>
                                            <td class='table-<?php echo $color_celda; ?>'><?php echo utf8_encode($dataDetalle['CliNombreCompleto']); ?></td>
                                            <td class='table-<?php echo $color_celda; ?>'><?php echo $dataDetalle['EncFecha']; ?></td>
                                            <td class='table-<?php echo $color_celda; ?>'><?php echo utf8_encode($dataDetalle['EncObservacion']); ?></td>
                                            <td class='table-<?php echo $color_celda; ?>'><?php echo $dataDetalle['EinVIN']; ?></td>
                                            <td class='table-<?php echo $color_celda; ?>'><?php echo $dataDetalle['EinPlaca']; ?></td>
                                            <td class='table-<?php echo $color_celda; ?>'><?php echo $dataDetalle['VmoNombre']; ?></td>
                                            <td class='table-<?php echo $color_celda; ?>'><?php echo utf8_encode($dataDetalle['asesor']); ?></td>
                                            <td class='table-<?php echo $color_celda; ?>'><?php echo $dataDetalle['CliCelular']; ?></td>
                                            <td class='table-<?php echo $color_celda; ?>' style='text-align:center;'>
                                                <button data-toggle="modal" data-target="#encuesta-<?php echo $dataDetalle['EncId'];?>" style='border:none; background:none; cursor: pointer; outline: inherit;'>
                                                    <img src="img/lista.png" alt="Ver Encuesta" style="width:20px;">
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="encuesta-<?php echo $dataDetalle['EncId'];?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <?php
                                                    $idEncuesta = $dataDetalle['EncId'];
                                                    $consultaEncuesta = "
                                                        SELECT
                                                        tbledeencuestadetalle.EncId,
                                                        tbledeencuestadetalle.EdeId,
                                                        tbleprencuestapregunta.EprNombre,
                                                        tbledeencuestadetalle.EdeRespuesta
                                                        FROM
                                                        tbledeencuestadetalle
                                                        Inner Join tbleprencuestapregunta ON tbledeencuestadetalle.EprId = tbleprencuestapregunta.EprId
                                                        WHERE
                                                        tbledeencuestadetalle.EncId =  '$idEncuesta'
                                                    ";
                                                    $resultadoEncuesta = mysqli_query($conexion,$consultaEncuesta);
                                                ?>
                                                <h5 class="modal-title" id="staticBackdropLabel">Encuesta: <?php echo $idEncuesta; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-8 input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">Cliente</span>
                                                        </div>
                                                        <input type="text" class="form-control" value='<?php echo utf8_encode($dataDetalle['CliNombreCompleto']); ?>'>
                                                    </div>

                                                    <div class='col-md-4'>
                                                        <h4>Posicion: <span class="badge badge-<?php echo $color_celda?>"><?php echo $posicion ?></span></h4>
                                                    </div>
                                                </div><br>
                                                <div class='row'>
                                                <?php while ($dataEncuesta = mysqli_fetch_array($resultadoEncuesta)){  ?>
                                                
                                                    <div class='col-md-6'>
                                                        <h6><?php echo utf8_encode($dataEncuesta['EprNombre']); ?></h6>
                                                        <p>Respuesta: <?php echo utf8_encode($dataEncuesta['EdeRespuesta']); ?></p>
                                                    </div>
                                                
                                                <?php } ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    <?php
                                            }else{

                                            } 
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><br>

            <?php 
            
                }else{
                    ?>

                        <div class='row'>
                            <div class='col-md-12' style='text-align:center'>
                                <img src="img/noresults.png" alt="" style='width: auto'>
                            </div>
                        </div>


                    <?php
                }
            
            ?>

        <script>
            var ctx = document.getElementById('barh').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: ['Detractores', 'Promotores', 'Neutros'],
                    datasets: [{
                        label: 'Encuestas',
                        data: [<?php echo $detractores.", ".$promotores.", ".$neutros; ?>],
                        backgroundColor: [
                            '#E7694A',
                            '#7EC675',
                            '#EEDB50'
                        ],
                        borderColor: [
                            '#DC2D01',
                            '#199101',
                            '#DABF00'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>
        <script>
            var ctx = document.getElementById('barv').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                    datasets: [{
                        label: 'Encuestas',
                        data: [1, 1, 2, 0, 0, 0, 0, 2, 5, 6],
                        backgroundColor: [
                            '#E7694A',
                            '#E7694A',
                            '#E7694A',
                            '#E7694A',
                            '#E7694A',
                            '#E7694A',
                            '#EEDB50',
                            '#EEDB50',
                            '#7EC675',
                            '#7EC675'
                        ],
                        borderColor: [
                            '#DC2D01',
                            '#DC2D01',
                            '#DC2D01',
                            '#DC2D01',
                            '#DC2D01',
                            '#DC2D01',
                            '#DABF00',
                            '#DABF00',
                            '#199101',
                            '#199101'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>
        <script>
            var ctx = document.getElementById('piechart').getContext('2d');
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: data = {
                    datasets: [{
                        data: [<?php echo $totalSatisfecho.", ".$satisfecho.", ".$indiferente.", ".$insatisfecho.", ".$totalInsatisfecho; ?>],
                        backgroundColor: [
                            '#02DC10',
                            '#B2F403',
                            '#F4C503',
                            '#F46603',
                            '#DC0202'
                        ]
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                        'Muy Satisfecho',
                        'Satisfecho',
                        'Indiferente',
                        'Insatisfecho',
                        'Muy Insatisfecho'
                    ]
                },
                options: {
                    tooltips: {
                        yAlign: 'bottom'
                    }
                }
            });
        </script>
        <script>
            var ctx = document.getElementById('piechart2').getContext('2d');
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: data = {
                    datasets: [{
                        data: [<?php echo $totalSatisfecho3.", ".$satisfecho3.", ".$indiferente3.", ".$insatisfecho3.", ".$totalInsatisfecho3; ?>],
                        backgroundColor: [
                            '#02DC10',
                            '#B2F403',
                            '#F4C503',
                            '#F46603',
                            '#DC0202'
                        ]
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                        'Muy Satisfecho',
                        'Satisfecho',
                        'Indiferente',
                        'Insatisfecho',
                        'Muy Insatisfecho'
                    ]
                },
                options: Chart.defaults.doughnut
            });
        </script>