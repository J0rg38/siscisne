<?php
//session_destroy();
session_start();
//session_destroy();
if (empty($_SESSION['MysqlDeb'])) {
    $_SESSION['MysqlDeb'] = false;
}
if (empty($_SESSION['MysqlDeb'])) {
    $_SESSION['MysqlDebLevel'] = 0;
}
if (!empty($_GET['d']) and !empty($_GET['v'])) {
    if (($_GET['d'] == 1)) {
        $_SESSION['MysqlDeb'] = true;
    } else {
        $_SESSION['MysqlDeb'] = false;
    }
    $_SESSION['MysqlDebLevel'] = $_GET['v'];
}

/*
*Archivos de Sistema
*/
require_once('proyecto/ClsProyecto.php');
require_once('proyecto/ClsPoo.php');

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfConexion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes() . 'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases() . 'ClsSesion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias() . 'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases() . 'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones() . 'ClsConexion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones() . 'FncGeneral.php');

//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();
$InsConexion = new ClsConexion();

if (empty($_SESSION['SesAviso'])) {
    $InsSesion->MtdDestruirSesion();
}

require_once($InsPoo->MtdPaqConfiguracion() . 'ClsConfiguracionEmpresa.php');
require_once($InsPoo->MtdPaqEmpresa() . 'ClsSucursal.php');

$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
$InsConfiguracionEmpresa->CemId = "CEM-10000";
$InsConfiguracionEmpresa->CemRuta = $InsProyecto->MtdRutConfiguraciones();
$InsConfiguracionEmpresa->MtdGenerarConfiguracionEmpresa();


//deb($InsConfiguracionEmpresa);


$GET_t = isset($_GET['t']) ? $_GET['t'] : null;

if ($GET_t == "1") {

    $InsSucursal = new ClsSucursal();
    //MtdObtenerSucursales($oCampo=NULL,$oFiltro=NULL,$oOrden = 'SucId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
    $RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL, NULL, "SucNombre", "ASC", NULL, "");
    $ArrSucursales = $RepSucursal['Datos'];
} else {

    $InsSucursal = new ClsSucursal();
    //MtdObtenerSucursales($oCampo=NULL,$oFiltro=NULL,$oOrden = 'SucId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
    $RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL, NULL, "SucNombre", "ASC", NULL, "VEN");
    $ArrSucursales = $RepSucursal['Datos'];
}
 

echo $POST_Sucursal = (isset($_COOKIE["Sesion[SesionSucursal]"]) ? $_COOKIE["Sesion[SesionSucursal]"] : NULL);

//  print_r($_COOKIE); 

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ES">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width" />
    <title>ADMINISTRADOR DE <?php echo $SistemaNombre; ?></title>
    <!--  <link rel="stylesheet" type="text/css" href="estilos/CssPrincipal.css">-->
    <!-- <link rel="stylesheet" type="text/css" href="estilos/CssGeneral.css">    
            <link rel="stylesheet" type="text/css" href="estilos/CssAcceso.css">    -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos/fonts/stylesheet.css">


    <script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias(); ?>jquery-1.7.2.min.js"></script>
    <!--
            Funciones Generales
            -->
    <script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones(); ?>FncGeneral.js"></script>

    <style type="text/css">
        body {
            font-family: 'SF Pro Display';
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <!--
Nombre: DHTMLX MESSAGES
Descripcion:
-->
    <script src="<?php echo $InsProyecto->MtdRutLibrerias(); ?>dhtmlxSuite_v50_std/codebase/dhtmlx.js"></script>
    <link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias(); ?>dhtmlxSuite_v50_std/codebase/dhtmlx.css">



    <script type="text/javascript" src="sesion/js/JsSesionFunciones.js"></script>


</head>
<!-- <body onLoad="FncReloj();">-->

<body style="width: 100%">
    <?php
    $sesAviso = isset($_SESSION['SesAviso']) ? $_SESSION['SesAviso'] : null;
    $InsMensaje->MenResultado = $sesAviso;
    $InsMensaje->MtdImprimirResultado();
    unset($_SESSION['SesAviso']);
    ?>

    <div class="CapAccesoPrincipal">
        <!--	<div class="CapAccesoBarraSuperior">
    
    <table width="100%" class="EstTablaSesion">
            <tr>
            <td align="right">
            
			<?php FncFechaHoy(); ?> <<span id="spanreloj" ></span>>
            
            </td>
            </tr>
            </table>
    </div>-->
        <!--    <div class="CapAccesoCuerpoMargenArriba"></div>-->
        <!-- <div class="CapAccesoCuerpo">-->

        <!--<div class="CapAccesoFormularioMargen">-</div>-->

        <!--<div class="CapAccesoFormulario">-->
        <form method="post" name="FrmSesion" id="FrmSesion" action="sesion/SesIniciar.php" enctype="application/x-www-form-urlencoded">


            <div class="login">

                <div class="login-form">

                    <div class="container">
                        <div class="row" style="width: 100%; margin: 2% 0 2% 0;">

                            <div class="col-md-2" style="text-align: center;">
                                <img src="imagenes/login/logo-automotriz.png" class="img-fluid" alt="" />
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-2" style="text-align: center">
                                <img src="imagenes/login/logo-chevrolet.png" class="img-fluid" style="width: 80%" alt="" />
                            </div>

                        </div>
                    </div>


                    <div class="container">
                        <div class="row" style="width: 100%; margin-bottom: 2%;">
                            <div class="col-md-12" style="text-align: center;">
                                <h3>Ingreso al Sistema😉</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Usuario</label>
                                    <input class="form-control" type="text" placeholder="Usuario" id="CmpUsuario" name="CmpUsuario" />
                                </div>
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input class="form-control" type="password" placeholder="Contraseña" name="CmpContrasena" id="CmpContrasena" />
                                </div>
                                <div class="form-group">
                                    <label>Sucursal</label>
                                    <select class="form-control" name="CmpSucursal" id="CmpSucursal">
                                        <option value="">Escoja una sucursal</option>
                                        <?php
                                        foreach ($ArrSucursales as $DatSucursal) {
                                        ?>
                                            <option <?php echo (($POST_Sucursal == $DatSucursal->SucId) ? 'selected="selected"' : ''); ?> value="<?php echo $DatSucursal->SucId ?>"><?php echo $DatSucursal->SucNombre; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="imagenes/login/camaro.jpg" class="d-block img-fluid" style="border-radius: 25px;" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="imagenes/login/chevyf1.jpg" class="d-block img-fluid" style="border-radius: 25px" alt="...">
                                        </div>
                                        <!-- <div class="carousel-item">
                          <img src="imagenes/login/vacunacion.jpg" class="d-block w-100 img-fluid" alt="...">
                        </div> -->
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row mt-5" style="width:100%">
                        <div class="col-md-12" style="text-align: center; padding: 0;">
                            <input class="btn btn-success" name="BtnIniciarSesion" id="BtnIniciarSesion" type="submit" value="Iniciar Sesion">
                        </div>
                    </div>

                    <div class="row mt-5" style="width:100%">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="text-align: center; padding: 0;">
                            <small>Le presentamos la nueva interfaz para el sistema de Automotriz Cisne, no se asusten, sigue siendo el mismo sistema, poco a poco se hara la migracion!!! 😁🖥😎</small>
                        </div>
                        <div class="col-md-3"></div>
                    </div>


                </div>
            </div>
            <!--<div class="error-page">
  <div class="try-again">Error: Try again?</div>
</div>-->




        </form>
        <!--</div>-->

        <!-- <div class="CapAccesoFormularioMargen">-</div>-->

        <!--   </div>-->
        <!--    <div class="CapAccesoCuerpoMargenAbajo"></div>-->

        <!--    <div class="CapAccesoBarraInferior">
	
<?php echo $EmpresaNombre; ?>  - <?php echo date("Y"); ?>    <br> 
     <?php echo $SistemaNombre; ?> v<?php echo $SistemaVersion; ?>
    
    </div>
    -->
    </div>
    </div>





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>

</html>