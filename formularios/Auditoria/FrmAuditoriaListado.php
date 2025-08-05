<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

//INSTANCIAS
$InsMensaje = new ClsMensaje();
$InsSesion = new ClsSesion();
$InsACL = new ClsACL();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.2.min.js"></script>
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>
<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">

<!--
Nombre: JQUERY-TABS2
Descripcion: Libreria para tabs
-->
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-tab/jquery-tab.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-tab/jquery-tab.js"></script>

<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>tipsy-0.1.7/src/stylesheets/tipsy.css" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>tipsy-0.1.7/src/javascripts/jquery.tipsy.js"></script>


<script type="text/javascript">
//Pasando variables genrales PHP a Javascript	
var MonedaSimbolo = "<?php echo $EmpresaMoneda;?>";
var EmpresaMonedaId = "<?php echo $EmpresaMonedaId;?>";
var FechaHoy = "<?php echo date("d/m/Y");?>";

//
var Ruta = "<?php echo $InsProyecto->Ruta; ?>";	
</script>
</head>

<body >

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver")){
?>

<?php
$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TipoTabla = $_GET['TipoTabla'];
//include($InsProyecto->MtdFormulariosMsj("ClientePago").'MsjClientePago.php');

require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

$InsAuditoria = new ClsAuditoria();


// MtdObtenerAuditorias($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ZonId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCodigo=NULL,$oCodigoExtra=NULL) 
$ResAuditoria = $InsAuditoria->MtdObtenerAuditorias($GET_TipoTabla,NULL,NULL,"AudTiempoCreacion","ASC",NULL,$GET_id,$GET_ta);
$ArrAuditorias = $ResAuditoria['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>



    
<div class="EstCapMenu">
  
            <div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove();" ><img src="../../imagenes/iconos/salir.png" alt="[Salir]" title="Salir"  />Salir</a></div>


</div>

<div class="EstCapContenido">
                                                 

        

	
       
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td colspan="2" valign="top"><div class="EstFormularioArea" >
		<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
          <tr>
            <td width="1">&nbsp;</td>
            <td colspan="2"><span class="EstFormularioTitulo">AUDITORIA </span></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
            
            
            
            
            
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
		<thead class="EstTablaListadoHead">
            <tr>
              <th>#</th>
              <th>Id</th>
              <th>Usuario</th>
              <th>Empleado</th>
              <th>Accion</th>
              <th>Descripcion</th>
              <th width="7%">Fecha y Hora</th>
              </tr>
		</thead>
        <tbody class="EstTablaListadoBody" >
       
        <?php
			$c = 1;
		foreach($ArrAuditorias as $DatAuditoria){
		?>


            <tr>
              <td width="1%" align="right"><?php echo $c;?></td>
              <td width="8%" align="right"><?php echo $DatAuditoria->AudId;?></td>
              <td width="10%" align="right"><?php echo $DatAuditoria->UsuUsuario;?></td>
              <td width="27%" align="right"><?php echo $DatAuditoria->PerNombre;?> <?php echo $DatAuditoria->PerApellidoPaterno;?> <?php echo $DatAuditoria->PerApellidoMaterno;?></td>
              <td width="11%" align="right"><?php echo $DatAuditoria->AudAccionDescripcion;?></td>
              <td width="36%" align="right"><?php echo $DatAuditoria->AudDescripcion;?></td>
              <td align="right"><?php echo $DatAuditoria->AudTiempoCreacion; ?></td>
              </tr>
		<?php
			$c++;
		}
		?>
            </tbody>
        </table>
        
        
            
            
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="193">&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
          </table>
		</div></td>
       </tr>
    </table>
	 
	
        
  </div>      
    
  
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

</body>
</html>
