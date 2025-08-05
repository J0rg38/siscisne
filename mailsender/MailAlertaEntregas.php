<?php
    date_default_timezone_set('America/Bogota');
    $diaAnterior = date('Y-m-d', strtotime('-1 day'));
    // Datos para el correo a enviar
    require("class.phpmailer.php");
    require("class.smtp.php");

    $nombre = "SISTEMA DE ALERTAS SISCISNE";
    $email = "siscisne@cisne.com.pe";
    $asunto = "Notificacion Entrega de Vehiculos";
    $destinatario = "c.callcenter@cisne.com.pe";
    $mensaje = "";

    // Fin de datos para correo a enviar


    $usuario = "root";
    $contrasena = "";  // en mi caso tengo contraseña pero en casa caso introducidla aquí.
    $servidor = "localhost";
    $basededatos = "siscisne10";

    $mysqli = new mysqli($servidor, $usuario, $contrasena, $basededatos, 3306);
        if ($mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

    

    $consulta="SELECT
    tblovvordenventavehiculo.OvvId,
    tblclicliente.CliNumeroDocumento,
    tblclicliente.CliNombreCompleto,
    tblclicliente.CliDireccion,
    tblclicliente.CliTelefono,
    tblclicliente.CliCelular,
    tblclicliente.CliEmail,
    tbleinvehiculoingreso.EinVIN,
    tblvmavehiculomarca.VmaNombre,
    tblvmovehiculomodelo.VmoNombre,
    tblvvevehiculoversion.VveNombre,
    tblsucsucursal.SucNombre,
    CONCAT(tblperpersonal.PerNombre, ' ',tblperpersonal.PerApellidoPaterno, ' ', tblperpersonal.PerApellidoMaterno) AS Asesor
    FROM
    tblovvordenventavehiculo
    Inner Join tblclicliente ON tblovvordenventavehiculo.CliId = tblclicliente.CliId
    Inner Join tblsucsucursal ON tblovvordenventavehiculo.SucId = tblsucsucursal.SucId
    Inner Join tbleinvehiculoingreso ON tblovvordenventavehiculo.EinId = tbleinvehiculoingreso.EinId
    Inner Join tblvvevehiculoversion ON tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
    Inner Join tblvmovehiculomodelo ON tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
    Inner Join tblvmavehiculomarca ON tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
    Inner Join tblperpersonal ON tblovvordenventavehiculo.PerId = tblperpersonal.PerId
    WHERE
    tblovvordenventavehiculo.OvvActaEntregaFecha =  '$diaAnterior'";

    $resultado = mysqli_query($mysqli,$consulta);

    $filas = mysqli_num_rows($resultado);

    // Datos de la cuenta de correo utilizada para enviar v�a SMTP
        $smtpHost = "mail.cisne.com.pe";  // Dominio alternativo brindado en el email de alta 
        $smtpUsuario = "siscisne@cisne.com.pe";  // Mi cuenta de correo
        $smtpClave = "S2020cisne";  // Mi contrase�a

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = 587; 
        $mail->IsHTML(true); 
        $mail->CharSet = "utf-8";

        // VALORES A MODIFICAR //
        $mail->Host = $smtpHost; 
        $mail->Username = $smtpUsuario; 
        $mail->Password = $smtpClave;


        $mail->From = $email; // Email desde donde env�o el correo.
        $mail->FromName = $nombre;
        $mail->AddAddress($destinatario); // Esta es la direcci�n a donde enviamos los datos del formulario
	$mail->addCC('jl.quispe@cisne.com.pe');
	$mail->addCC('p.regente@cisne.com.pe');
	$mail->addCC('d.zuniga@cisne.com.pe');	

        $mail->Subject = $asunto; // Este es el titulo del email.
        $mensajeHtml = nl2br($mensaje);

        if($filas > 0){

        $msg .= "<h2>Vehiculos entregados el: ";
        $msg .= date('d-m-Y', strtotime('-1 day'));
        $msg .= "</h2><br>";
        $msg .= "
            <table width='1250' border='1' cellpadding='0' cellspacing='1' bordercolor='#000000' style='
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size:11px;
                text-align: center;
                width: 800px;
                border-collapse:collapse;
                border-color:#ddd;
            '>
                <tbody>
                    <tr style = '
                        padding: 5px;
                        font-size: 12px;
                        background-color: #1C70BB;
                        background-image: url(fondo_th.png);
                        background-repeat: repeat-x;
                        color: #FFFFFF;
                        border-right-width: 1px;
                        border-bottom-width: 1px;
                        border-right-style: solid;
                        border-bottom-style: solid;
                        border-right-color: #558FA6;
                        border-bottom-color: #558FA6;
                        font-family: “Trebuchet MS”, Arial;
                        text-transform: uppercase;
                    '>
                    <th scope='col'>Id</th>
                    <th scope='col'>Documento</th>
                    <th scope='col'>Nombre Cliente</th>
                    <th scope='col'>Direccion</th>
                    <th scope='col'>Telefono</th>
                    <th scope='col'>Celular</th>
                    <th scope='col'>Email</th>
                    <th scope='col'>VIN</th>
                    <th scope='col'>Marca</th>
                    <th scope='col'>Modelo</th>
                    <th scope='col'>Version</th>
                    <th scope='col'>Sucursal</th>
                    <th scope='col'>Asesor</th>
                    </tr>
        ";

        while ($dato = mysqli_fetch_array($resultado)){

        $msg .= "<tr>";

            $msg .= "<td>";
            $msg .=  $dato['OvvId'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['CliNumeroDocumento'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['CliNombreCompleto'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['CliDireccion'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['CliTelefono'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['CliCelular'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['CliEmail'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['EinVIN'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['VmaNombre'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['VmoNombre'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['VveNombre'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['SucNombre'];
            $msg .= "</td>";

            $msg .= "<td>";
            $msg .=  $dato['Asesor'];
            $msg .= "</td>";

        $msg .= "</tr>";
    }
        
        $msg .= "</tbody>";
        $msg .= "</table>";

        $msg .= "<p>Correo autogenerado por el sistema SISCISNE el ";
        $msg .= date('d-m-Y');
        $msg .= "</p>";

    }else{
        $msg .= "<h3 style = 'color: red;'>No se encontraron registros para el dia de hoy</h3>";
        $msg .= "<h3 style = 'color: red;'>Mañana con fé</h3>";
    

        $msg .= "<p>Correo autogenerado por el sistema SISCISNE el ";
        $msg .= date('d-m-Y');
        $msg .= "</p>";
    
    }

        $mail->Body = $msg; // Texto del email en formato HTML


        $mail->AltBody = "{$mensaje} \n\n "; // Texto sin formato HTML
        // FIN - VALORES A MODIFICAR //

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $estadoEnvio = $mail->Send(); 
        if($estadoEnvio){
            echo "El correo fue enviado correctamente.";
            echo $msg;
        } else {
            echo "Ocurrio un error inesperado.";
        }

    
?>
