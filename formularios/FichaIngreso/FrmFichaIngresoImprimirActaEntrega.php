<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');

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

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');


//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');


$InsFichaIngreso = new ClsFichaIngreso();

$InsFichaIngreso->FinId = $GET_id;
$InsFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngreso();

//deb($InsFichaIngreso);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Trabajo No. <?php echo $InsFichaIngreso->FinId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssFichaIngreso.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsFichaIngresoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsFichaIngreso->FinId)){?> 
FncFichaIngresoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>

<?php if($_GET['P']<>1){ ?>
<form method="get" enctype="multipart/form-data" action="#">
<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="Ta" id="Ta" value="<?php echo $GET_ta;?>" />
<input type="hidden" name="P" id="P" value="1" />

<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
	<input name="ImprimirCodigo" id="ImprimirCodigo" type="checkbox" value="1" <?php echo ($GET_ImprimirCodigo==1)?'checked="checked"':'';?>  /> Imprimir Codigos</td>
<td>&nbsp;</td>
<td>
	<input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
</table>

</form>
<?php }?>




<table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="3" align="left" valign="top"><img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  /></td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="34%" align="left" valign="top">&nbsp;</td>
      <td width="28%" align="center" valign="top">&nbsp;</td>
      <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
        <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="0%" align="right" valign="top">&nbsp;</td>
    </tr>
    </table>
    
    




<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstFichaIngresoImprimirTabla">

<!--<tr>
  <td height="70" valign="top">&nbsp;</td>
  <td height="70" colspan="2" valign="top">&nbsp;</td>
  <td height="70">&nbsp;</td>
</tr>-->
<tr>
  <td width="5%" valign="top">&nbsp;</td>
  <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="2" class="EstActaEntregaImprimirTabla">
    <tr>
      <td colspan="4" align="center" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
        
        <span class="EstPlantillaTitulo">ACTA DE ENTREGA </span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsFichaIngreso->FinId;?></span>
        
        </td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="35%" align="left" valign="top" >&nbsp;</td>
      <td colspan="2" align="right" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
        
        
<!--        <?php list($Dia,$Mes,$Ano) = explode("/",$InsFichaIngreso->FinFecha);?>
        
        <span class="EstActaEntregaImprimirFecha">
          <?php echo $EmpresaDepartamento;?>, <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?>  del <?php echo $Ano;?>
          </span>    -->  
          
             
       
        <span class="EstActaEntregaImprimirFecha">
        <!--  <?php echo $EmpresaDepartamento;?>, <?php echo date("d");?> de <?php echo FncConvertirMes(date("m"));?>  del <?php echo date("Y");?>-->
         
          <?php
		echo $InsFichaIngreso->FinActaEntregaFecha
		?>
         </span>    
          
</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirEtiqueta">Sr.:</span></td>
      <td align="left" valign="top" >&nbsp;</td>
      <td width="17%" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="31%" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirCliente"><?php echo $InsFichaIngreso->CliNombre;?> <?php echo $InsFichaIngreso->CliApellidoPaterno;?> <?php echo $InsFichaIngreso->CliApellidoMaterno;?></span></td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="4" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirEtiqueta">Ciudad.- </span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="4" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirContenido"><?php echo $EmpresaDepartamento;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="4" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
      <span class="EstActaEntregaImprimirContenido">
      <p align="justify">De  nuestra consideración:</p>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
      
      <span class="EstActaEntregaImprimirContenido">
      <p align="justify">Por  medio de la presente le hacemos entrega de la siguiente unidad vehicular en  perfecto estado mecánico y de carrocería, luego de las tareas realizadas.</p>
      
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirEtiqueta">MARCA </span></td>
      <td align="left" valign="top" ><span class="EstActaEntregaImprimirContenido"><?php echo $InsFichaIngreso->VmaNombre;?></span></td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirEtiqueta">MODELO </span></td>
      <td align="left" valign="top" ><span class="EstActaEntregaImprimirContenido"><?php echo $InsFichaIngreso->VmoNombre;?></span></td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirEtiqueta">VIN </span></td>
      <td align="left" valign="top" ><span class="EstActaEntregaImprimirContenido"><?php echo $InsFichaIngreso->EinVIN;?></span></td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirEtiqueta">Color </span></td>
      <td align="left" valign="top" ><span class="EstActaEntregaImprimirContenido"><?php echo $InsFichaIngreso->EinColor;?></span></td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo"><span class="EstActaEntregaImprimirEtiqueta">PLACA </span></td>
      <td align="left" valign="top" ><span class="EstActaEntregaImprimirContenido"><?php echo $InsFichaIngreso->FinPlaca;?></span></td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
      
      
      
      <span class="EstActaEntregaImprimirContenido">
      <p align="justify">
      
      Estando conforme el cliente con la entrega-recepción del vehículo, queda bajo la responsabilidad del mismo el funcionamiento total de la unidad.
      
      </p>
      </span>
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
      
       <span class="EstActaEntregaImprimirContenido">

<?php echo $InsFichaIngreso->FinActaEntrega;?>

      </span>
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
      
           <span class="EstActaEntregaImprimirContenido">
      <p align="justify">Atentamente,</p></span>
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
      
      ___________________________________<br>
      <?php echo $InsFichaIngreso->PerNombreAsesor;?> <?php echo $InsFichaIngreso->PerApellidoPaternoAsesor;?> <?php echo $InsFichaIngreso->PerApellidoMaternoAsesor;?><br />
      
      <?php echo $InsFichaIngreso->PerNumeroDocumentoAsesor;?>
      
      
      
      </td>
      <td colspan="2" align="center" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">
      
            ___________________________________<br>
     
	  <?php echo $InsFichaIngreso->CliNombre;?> <?php echo $InsFichaIngreso->CliApellidoPaterno;?> <?php echo $InsFichaIngreso->CliApellidoMaterno;?>
      
      <br />
      
      <?php echo $InsFichaIngreso->CliNumeroDocumento;?>
    
      
      
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstActaEntregaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  <td width="5%">&nbsp;</td>
  </tr>
  
<tr>
  <td width="5%" valign="top">&nbsp;</td>
  <td colspan="2" valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>

</table>


</body>
</html>
