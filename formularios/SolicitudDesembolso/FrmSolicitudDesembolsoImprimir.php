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

require_once($InsPoo->MtdPaqLogistica().'ClsSolicitudDesembolso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsSolicitudDesembolsoDetalle.php');

$InsSolicitudDesembolso = new ClsSolicitudDesembolso();

$InsSolicitudDesembolso->SdsId = $GET_id;
$InsSolicitudDesembolso->MtdObtenerSolicitudDesembolso();

if($InsSolicitudDesembolso->MonId <> $EmpresaMonedaId){
	
	$InsSolicitudDesembolso->SdsMonto = ($InsSolicitudDesembolso->SdsMonto/$InsSolicitudDesembolso->SdsTipoCambio);
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SOLICITUD DE DESEMBOLSO No. <?php echo $InsSolicitudDesembolso->SdsId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssSolicitudDesembolsoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsSolicitudDesembolsoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsSolicitudDesembolso->SdsId)){?> 
FncSolicitudDesembolsoImprimir(); 
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
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" /></td>
  <td width="52%" align="center" valign="top">
  <span class="EstPlantillaTitulo">SOLICITUD DE DESEEMBOLSO</span><br />
    <span class="EstPlantillaTituloCodigo"><?php echo $InsSolicitudDesembolso->SdsId;?></span>
  
  
  </td>
  <td width="28%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstSolicitudDesembolsoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstSolicitudDesembolsoImprimirTabla">
    <tr>
      <td colspan="6" align="left" valign="top"><span class="EstSolicitudDesembolsoImprimirCabecera">Datos del Solicitud de Desembolso</span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="13%" align="left" valign="top">&nbsp;</td>
      <td width="3%" align="left" valign="top" >&nbsp;</td>
      <td width="34%" align="left" valign="top" >&nbsp;</td>
      <td width="10%" align="left" valign="top">&nbsp;</td>
      <td width="3%" align="left" valign="top" >&nbsp;</td>
      <td width="35%" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">FECHA</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->SdsFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">MONEDA</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"> <?php echo $InsSolicitudDesembolso->MonNombre;?></span></td>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">T.C.</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->SdsTipoCambo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">TIPO</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"> <?php echo $InsSolicitudDesembolso->TgaNombre;?></span></td>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">AREA</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->AreNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">CLIENTE(S) REFERENCIA</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->SdsCliente;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">VIN</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->SdsVIN?></span></td>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">PLACA</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->SdsPlaca?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">SOLICITANTE</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->PerNombre?><?php echo $InsSolicitudDesembolso->PerApellidoPaterno?><?php echo $InsSolicitudDesembolso->PerApellidoMaterno?></span></td>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">O.T.</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->FinId?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiqueta">Observaciones</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo $InsSolicitudDesembolso->SdsObservacionImpresa;?></span></td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
  <td colspan="5" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstSolicitudDesembolsoImprimirTabla">
      <thead class="EstSolicitudDesembolsoImprimirTablaHead">
        <tr>
          <th width="5%" align="center" >
            
            #
          </th>
          <th width="82%" align="center" >DESCRIPCION </th>
          <th width="13%" align="center" >CANTDAD</th>
          <th width="13%" align="center" >IMPORTE</th>
          </tr>
      </thead>
      <tbody class="EstSolicitudDesembolsoImprimirTablaBody">
        <?php

$TotalRepuesto = 0;

$i = 1;
if (!empty($InsSolicitudDesembolso->SolicitudDesembolsoDetalle)) {
    foreach ($InsSolicitudDesembolso->SolicitudDesembolsoDetalle as $DatSolicitudDesembolsoDetalle) {

		if($InsSolicitudDesembolso->MonId<>$EmpresaMonedaId ){
			$DatSolicitudDesembolsoDetalle->SddImporte = round($DatSolicitudDesembolsoDetalle->SddImporte / $InsSolicitudDesembolso->SdsTipoCambio,2);
		}


?>
        <tr>
          <td align="right" class="EstSolicitudDesembolsoDetalleImprimirContenido"><?php
            echo $i;
?></td>
          <td align="left" class="EstSolicitudDesembolsoDetalleImprimirContenido" ><?php
            echo $DatSolicitudDesembolsoDetalle->SreNombre;
?></td>
          <td align="right" class="EstSolicitudDesembolsoDetalleImprimirContenido" >    <?php
            echo number_format($DatSolicitudDesembolsoDetalle->SddCantidad,2);
?></td>
          <td align="right" class="EstSolicitudDesembolsoDetalleImprimirContenido" >
          
          <?php
            echo number_format($DatSolicitudDesembolsoDetalle->SddImporte,2);
?>
          
          </td>
          </tr>
        <?php
            $i++;
            $TotalBruto += $DatSolicitudDesembolsoDetalle->SddImporte;
      
    }
}
?>









    
      </tbody>
    </table></td>
</tr>
<tr>
    <td colspan="5" align="center"><table class="EstTablaTotal" width="100%" cellpadding="0" cellspacing="0" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="82%" align="right" valign="top" class="EstSolicitudDesembolsoImprimirEtiquetaFondo"><span class="EstSolicitudDesembolsoImprimirEtiquetaTotal">MONTO SOLICITADO:</span></td>
          <td width="18%" align="right" valign="top" ><span class="EstSolicitudDesembolsoImprimirMoneda">
            <?php
echo $InsSolicitudDesembolso->MonSimbolo;
?>
            </span><span class="EstSolicitudDesembolsoImprimirContenido"><?php echo number_format($InsSolicitudDesembolso->SdsMonto,2);?></span></td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="center"><table class="EstTablaTotal" width="100%" cellpadding="0" cellspacing="0" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top" >&nbsp;</td>
        </tr>
        <tr>
          <td width="50%" align="center" valign="top">_________________________________<br />
            <span class="EstSolicitudDesembolsoImprimirContenidoFirma"><?php echo $InsSolicitudDesembolso->PerNombre;?> <?php echo $InsSolicitudDesembolso->PerApellidoPaterno;?> <?php echo $InsSolicitudDesembolso->PerApellidoMaterno;?><br />
            <?php echo $InsSolicitudDesembolso->PerNumeroDocumento;?></span></td>
          <td width="50%" align="center" valign="top" >&nbsp;</td>
        </tr>
        </tbody>
    </table></td>
  </tr>

</table>

</body>
</html>
