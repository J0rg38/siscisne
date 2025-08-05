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

require_once($InsPoo->MtdPaqAdministracion().'ClsRegistroOperacionUIF.php');


$InsRegistroOperacionUIF = new ClsRegistroOperacionUIF();

$InsRegistroOperacionUIF->RouId = $GET_id;
$InsRegistroOperacionUIF = $InsRegistroOperacionUIF->MtdObtenerRegistroOperacionUIF();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>operacion en efectivo (ROP) No. <?php echo $InsRegistroOperacionUIF->RouId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssRegistroOperacionUIF.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsRegistroOperacionUIFImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsRegistroOperacionUIF->RouId)){?> 
FncRegistroOperacionUIFImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td width="19%" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> <br />
    <?php echo $EmpresaCodigo;?></span></td>
  <td width="58%" align="center" valign="top">&nbsp;</td>
  <td width="23%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
<tr>
  <td colspan="3" align="center" valign="top" >
  <div class="EstRegistroOperacionUIFImprimirAdorno">
    <span class="EstPlantillaTitulo">
    
    REGISTRO DE OPERACIONES EN EFECTIVO DE MAYOR CUANTIA</span></div>
    
    
    </td>
  </tr>
</table>

<!--<hr class="EstPlantillaLinea">-->





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstRegistroOperacionUIFImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="00" class="EstRegistroOperacionUIFImprimirTabla">
    <tr>
      <td colspan="6" align="left" valign="top"><span class="EstRegistroOperacionUIFImprimirMensaje">Ley 27693 y modificatoria Ley Nº 28306  - ORGANISMO SUPERVISOR UIDF</span></td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="18%" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">CODIGO EMPRESA</span></td>
      <td width="3%" align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td width="25%" align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouCodigoEmpresa;?></span></td>
      <td width="11%" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">Fecha</span></td>
      <td width="3%" align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td width="37%" align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">CODIGO OFICIAL DE CUMLIMIENTO:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouCodigoOficialCumplimiento;?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">HORA</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouHora;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><hr class="EstRegistroOperacionUIFImprimirSeparacion"></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td colspan="4" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">TRANSACCION</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouTransaccion?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">MONEDA</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->MonNombre?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">IMPTE. EFECTIVO</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo number_format($InsRegistroOperacionUIF->RouImporte,2)?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">T. CAMBIO</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouTipoCambio?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><hr class="EstRegistroOperacionUIFImprimirSeparacion"></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td colspan="4" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">SOLICITANTE</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->CliNombre?> <?php echo $InsRegistroOperacionUIF->CliApellidoPaterno?> <?php echo $InsRegistroOperacionUIF->CliApellidoMaterno?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">DNI</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->CliNumeroDocumento?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">PAIS</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->CliPais?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">DIRECCION</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouDireccion?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">TELEFONO</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->CliTelefono?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">CELULAR</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->CliCelular?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><hr class="EstRegistroOperacionUIFImprimirSeparacion"></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">ORDENANTE</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouOrdenanteNombre?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">DNI</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouOrdenanteNumeroDocumento?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">DIRECCION</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouOrdenanteDireccion?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><hr class="EstRegistroOperacionUIFImprimirSeparacion"></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">TRAMITANTE</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouTramitanteNombre?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">DNI</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouTramitanteNumeroDocumento?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">DIRECCION</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirContenido"><?php echo $InsRegistroOperacionUIF->RouTramitanteDireccion?></span></td>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><hr class="EstRegistroOperacionUIFImprimirSeparacion" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td colspan="4" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo"><span class="EstRegistroOperacionUIFImprimirEtiqueta">ORIGEN DE LOS FONDOS</span></td>
      <td align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirEtiqueta">:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstRegistroOperacionUIFImprimirImportante"><?php echo $InsRegistroOperacionUIF->RouOrigenFondo?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="49%" align="left" valign="top">&nbsp;</td>
          <td width="51%" align="center" valign="top" class="EstRegistroOperacionUIFImprimirEtiquetaFondo">
          
          
          ________________________<br />
      
      <span class="EstRegistroOperacionUIFImprimirFirma">    <?php echo $InsRegistroOperacionUIF->CliNombre?> <?php echo $InsRegistroOperacionUIF->CliApellidoPaterno?> <?php echo $InsRegistroOperacionUIF->CliApellidoMaterno?><br />
          DNI:  <?php echo $InsRegistroOperacionUIF->CliNumeroDocumento;?></span>
          </td>
          </tr>
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="left">
    
      <span class="EstPlantillaDatosImpresion"><?php echo $InsRegistroOperacionUIF->RouId;?></span>
      
      
      </td>
  </tr>
</table>

</body>
</html>
