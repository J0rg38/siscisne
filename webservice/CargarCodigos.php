<?php
    
    date_default_timezone_set('America/Lima');
    error_reporting(0);

    $FechaActual = date('Y-m-d H:i:s');

    $servidor="localhost";
    $user="root";
    $password = "";
    $database = "siscisne10";

    $conexion = mysqli_connect($servidor,$user,$password,$database);

    $valorCodigo = $_POST['valorCodigo'];
    $existe = '';

    $consultacodigos = "
        SELECT * FROM codigosrepuestos WHERE codigo = '".$valorCodigo."'
    ";
    $resultadocodigos = mysqli_query($conexion,$consultacodigos);

    $numExistencia = mysqli_num_rows($resultadocodigos);

    if($numExistencia > 0){
        $existe = 'si';

        while($datacodigos = mysqli_fetch_array($resultadocodigos)){
            $json[]=array(
              'descripcion' => $datacodigos['descripcion']
          );
        }
        
    }else{
        $existe = 'no';

            $json[]=array(

              'existeCliente' => $existe
              );

    }


    $jsonString = json_encode($json[0]);
    echo $jsonString;
?>