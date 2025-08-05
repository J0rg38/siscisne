<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$GET_id = $_GET['Id'];
$GET_ImprimirCodigo = $_GET['ImprimirCodigo'];

require_once($InsPoo->MtdPaqActividad().'ClsGarantia.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaOperacion.php');
require_once($InsPoo->MtdPaqActividad().'ClsGarantiaDetalle.php');


$InsGarantia = new ClsGarantia();

$InsGarantia->GarId = $GET_id;
$InsGarantia->MtdObtenerGarantia();

if($InsGarantia->MonId <> $EmpresaMonedaId){
	if(empty($InsGarantia->GarTipoCambio)){
		die("No se encontro tipo de cambio.");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GARANTIA No. <?php echo $InsGarantia->GarId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssGarantiaImprimir.css" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="js/JsGarantiaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsGarantia->GarId)){?> 
FncGarantiaImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>
<style type="text/css" media="print">
/*    .page
    {
     -webkit-transform: rotate(-90deg); -moz-transform:rotate(-90deg);
     filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    }*/
</style>
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
	<!--<input name="ImprimirCodigo" id="ImprimirCodigo" type="checkbox" value="1" <?php echo ($GET_ImprimirCodigo==1)?'checked="checked"':'';?>  /> Imprimir Codigos--></td>
<td>&nbsp;</td>
<td>
	<input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
</table>

</form>
<?php }?>

<!--<hr class="EstPlantillaLinea">-->

<div class="rotate">



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstGarantiaImprimirTabla">

<tr>
  <td colspan="2" valign="top">
    
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstGarantiaImprimirTabla">
      <tbody class="EstGarantiaImprimirTablaBody">
        <tr>
          <td colspan="5" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo">&nbsp;</td>
          <td colspan="12" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstPlantillaTitulo">HOJA DE GARANTÍA POST-ENTREGA- REPUESTOS/ALMACEN</span> <br />
            <span class="EstPlantillaTituloCodigo"> <?php echo $InsGarantia->GarId;?></span></td>
          <td colspan="3" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="7" rowspan="2" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">GENERAL MOTORS PERU S.A.:</span></td>
          <td colspan="2" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">PLACA: </span></td>
          <td colspan="5" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">VIN: </span></td>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">MODELO</span></td>
          <td colspan="2" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">CL: </span></td>
          <td width="80" align="left" valign="top"><span class="EstGarantiaImprimirEtiqueta">N°: </span></td>
          </tr>
        <tr>
          <td colspan="2" align="center" valign="top" ><span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->EinPlaca;?></span></td>
          <td colspan="5" align="center" valign="top" ><span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->EinVIN;?></span></td>
          <td colspan="3" align="center" valign="top" ><span class="EstGarantiaImprimirContenido">
            
            <?php echo $InsGarantia->GarModelo;?><br />
            Color: <?php echo $InsGarantia->EinColor;?> A&ntilde;o Fab.: <?php echo $InsGarantia->EinAnoFabricacion;?> Nro. Motor: <?php echo $InsGarantia->EinNumeroMotor;?>
            </span>
            
            </td>
          <td colspan="2" align="center" valign="top" >&nbsp;</td>
          <td rowspan="3" align="center" valign="middle">
          <span class="EstGarantiaImprimirModalidadIngreso">
          <?php
		  	echo $InsGarantia->MinNombre
		  ?>
          
          </span>
          <span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->GarId;?></span>
          
          </td>
          </tr>
        <tr>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">1</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">2</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">3</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">4</span></td>
          <td width="48" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">5</span></td>
          <td colspan="8" rowspan="7" align="center" valign="middle" class="EstGarantiaImprimirEtiquetaFondo">
            
            <span class="EstGarantiaImprimirContenido">
              Identificación Concesionario:<br />
              Nombre:  C & C S.A.C<br />
              Dirección:  Urb. Los cedros Mz B Lt 10<br />
              Ciudad:   Tacna
              </span>
            
            </td>
          <td colspan="3" rowspan="2" align="left" valign="bottom" ><span class="EstGarantiaImprimirEtiqueta">IDENTIFICACION PROPIETARIO</span></td>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Fecha DE GARANTIA</span></td>
          </tr>
        <tr>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">6</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">7</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">8</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">9</span></td>
          <td width="48" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">10</span></td>
          <td colspan="3" align="center" valign="top" ><span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->GarFechaEmision;?></span></td>
          </tr>
        <tr>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">11</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">12</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">13</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">14</span></td>
          <td width="48" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">15</span></td>
          <td colspan="7" rowspan="5" align="center" valign="middle" >
            
            <span class="EstGarantiaImprimirEtiqueta">Nombre:</span> 
            
            <span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->CliNombre;?> <?php echo $InsGarantia->CliApellidoPaterno;?> <?php echo $InsGarantia->CliApellidoMaterno;?></span><br />
            
            
            <span class="EstGarantiaImprimirEtiqueta">Direccion:</span> 
            <span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->GarDireccion;?></span><br />
            
            <span class="EstGarantiaImprimirEtiqueta">Ciudad:</span> 
            <span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->GarCiudad;?></span><br />
            
            <span class="EstGarantiaImprimirEtiqueta">Poliza N°: </span>
            <span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->EinPoliza;?></span><br />
            
            
            
            </td>
          </tr>
        <tr>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">16</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">17</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">18</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">19</span></td>
          <td width="48" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">20</span></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">Devolución / Rechazo</span></td>
          </tr>
        <tr>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">21</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">22</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">23</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">24</span></td>
          <td width="48" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">25</span></td>
          </tr>
        <tr>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">26</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">27</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">28</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">29</span></td>
          <td width="48" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">30</span></td>
          </tr>
        <tr>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">31</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">32</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">33</span></td>
          <td width="43" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">34</span></td>
          <td width="48" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">35</span></td>
          <td width="71" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">v</span></td>
          <td width="71" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta"> s</span></td>
          <td width="72" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">OR/Nº</span></td>
          <td colspan="4" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo">
            
            <span class="EstGarantiaImprimirEtiqueta">
              Fecha OR
              </span>
            </td>
          <td colspan="2" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Fecha SDA</span></td>
          <td width="189" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Fecha DE VENTA</span></td>
          <td colspan="3" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">KILOMETRAJE</span></td>
          <td colspan="2" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">N° LINEA</span></td>
          </tr>
        <tr>
          <td align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">36</span></td>
          <td align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">37</span></td>
          <td align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">38</span></td>
          <td align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">39</span></td>
          <td align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">40</span></td>
          <td align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo">
            <?php
	  if($InsGarantia->OncId == "ONC-10000"){
	?>
            <span class="EstGarantiaImprimirContenido">X</span>
            <?php
	  }
	  ?>
            
            </td>
          <td align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo">
            
            <?php
	  if($InsGarantia->OncId <> "ONC-10000" and !empty($InsGarantia->OncId)){
	?>
            <span class="EstGarantiaImprimirContenido">X</span>
            <?php
	  }
	  ?>
            
            
            </td>
          <td align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo">&nbsp;</td>
          <td colspan="4" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo">&nbsp;</td>
          <td colspan="2" align="center" valign="top" ><span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->FinTrabajoTerminado;?></span></td>
          <td align="center" valign="top" >
            
            
            
            <span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->GarFechaVenta;?></span>
            
            </td>
          <td colspan="3" align="center" valign="top" ><span class="EstGarantiaImprimirContenido"><?php echo number_format($InsGarantia->FinVehiculoKilometraje,2);?></span></td>
          <td colspan="2" align="center" valign="top" >1</td>
          </tr>
        <tr>
          <td colspan="4" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">Operación Nº</span></td>
          <td align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">T</span></td>
          <td colspan="2" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">VALOR</span></td>
          <td align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">M/O</span></td>
          <td colspan="2" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">T.C.</span></td>
          <td width="66" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">P</span></td>
          <td colspan="2" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">NUMERO DE REP.</span></td>
          <td colspan="3" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">DESCRIPCION</span></td>
          <td width="62" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">CANT.</span></td>
          <td width="69" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">COSTO</span></td>
          <td colspan="2" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">CREDITO</span></td>
          </tr>
        <tr>
          <td height="60" colspan="4" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo">
            
            <?php
	if(!empty($InsGarantia->GarantiaOperacion)){
		foreach($InsGarantia->GarantiaOperacion as $DatGarantiaOperacion){
	?>
            <?php echo $DatGarantiaOperacion->GopNumero;?><br />
            <?php
		}
	}
	?>
            </td>
          <td height="60" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><?php
	if(!empty($InsGarantia->GarantiaOperacion)){
		foreach($InsGarantia->GarantiaOperacion as $DatGarantiaOperacion){
	?>
            <?php echo number_format($DatGarantiaOperacion->GopTiempo,2);?><br />
            <?php
		}
	}
	?></td>
          <td height="60" colspan="2" align="right" valign="top" class="EstGarantiaImprimirEtiquetaFondo">
            
            
            
            <?php
	if(!empty($InsGarantia->GarantiaOperacion)){
		foreach($InsGarantia->GarantiaOperacion as $DatGarantiaOperacion){
			
			if($InsGarantia->MonId<>$EmpresaMonedaId){
				$DatGarantiaOperacion->GopValor = round($DatGarantiaOperacion->GopValor / $InsGarantia->GarTipoCambio,2);				
			}
	?>
            <?php echo number_format($DatGarantiaOperacion->GopValor,2);?><br />
            <?php
		}
	}
	?>
            
            </td>
          <td height="60" align="right" valign="top" class="EstGarantiaImprimirEtiquetaFondo">
            <?php
	  $TotalManoObra = 0;
	  ?>
            <?php
	if(!empty($InsGarantia->GarantiaOperacion)){
		foreach($InsGarantia->GarantiaOperacion as $DatGarantiaOperacion){
			
			
			if($InsGarantia->MonId<>$EmpresaMonedaId){
				$DatGarantiaOperacion->GopCosto = round($DatGarantiaOperacion->GopCosto / $InsGarantia->GarTipoCambio,2);
				
			}
			
			
	?>
            <?php echo number_format($DatGarantiaOperacion->GopCosto,2);?><br />
            
            <?php $TotalManoObra += $DatGarantiaOperacion->GopCosto;?>
            <?php
		}
	}
	?></td>
          <td height="60" colspan="2" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo">&nbsp;</td>
          <td height="60" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo">&nbsp;</td>
          <td height="60" colspan="2" align="center" valign="top" ><span class="EstGarantiaImprimirEtiquetaFondo">
            <?php
	if(!empty($InsGarantia->GarantiaDetalle)){
		foreach($InsGarantia->GarantiaDetalle as $DatGarantiaDetalle){
	?>
            <?php echo $DatGarantiaDetalle->GdeCodigo;?><br />
            <?php
		}
	}
	?>
            </span></td>
          <td height="60" colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiquetaFondo">
            <?php
	if(!empty($InsGarantia->GarantiaDetalle)){
		foreach($InsGarantia->GarantiaDetalle as $DatGarantiaDetalle){
	?>
            <?php echo $DatGarantiaDetalle->GdeDescripcion;?><br />
            <?php
		}
	}
	?>
            </span></td>
          <td height="60" align="right" valign="top" ><span class="EstGarantiaImprimirEtiquetaFondo">
            <?php
	if(!empty($InsGarantia->GarantiaDetalle)){
		foreach($InsGarantia->GarantiaDetalle as $DatGarantiaDetalle){
	?>
            <?php echo number_format($DatGarantiaDetalle->GdeCantidad,2);?><br />
            <?php
		}
	}
	?>
            </span></td>
          <td height="60" align="right" valign="top" ><span class="EstGarantiaImprimirEtiquetaFondo">
            
            <?php
	$SubTotalRepuestoStock = 0;
	?>      
            <?php
	if(!empty($InsGarantia->GarantiaDetalle)){
		foreach($InsGarantia->GarantiaDetalle as $DatGarantiaDetalle){
			
			if($InsGarantia->MonId<>$EmpresaMonedaId){
				//$DatGarantiaDetalle->GdeCostoMargen = round($DatGarantiaDetalle->GdeCostoMargen / $InsGarantia->GarTipoCambio,2);
				$DatGarantiaDetalle->GdeCosto = round($DatGarantiaDetalle->GdeCosto / $InsGarantia->GarTipoCambio,2);
			}
			
			
	?>
            <?php echo number_format($DatGarantiaDetalle->GdeCosto,2);?><br />
            <?php $SubTotalRepuestoStock += $DatGarantiaDetalle->GdeCosto;?>
            <?php
		}
	}
	?>
            </span></td>
          <td height="60" colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">TOTAL M/O</span></td>
          <td colspan="2" align="right" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><?php echo number_format($TotalManoObra,2);?></td>
          <td colspan="2" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">GARANTIA</span></td>
          <td colspan="2" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirEtiqueta">POLITICA</span></td>
          <td width="69" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">CAMPAÑA</span></td>
          <td width="65" align="center" valign="top" ><span class="EstGarantiaImprimirEtiqueta">OTRO</span></td>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Sub total Repuestos Stock</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            
            
            
            
            <?php echo number_format($SubTotalRepuestoStock,2); ?>
            </td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo">
            <span class="EstGarantiaImprimirEtiqueta">
              Tarifa autorizada $:
              </span>
            </td>
          <td colspan="2" align="right" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><?php echo number_format($InsGarantia->GarTarifaAutorizada,2);?></td>
          <td colspan="2" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo">
            
            <?php
	if($InsGarantia->MinId == "MIN-10000"){
	?>
            <span class="EstGarantiaImprimirContenido">X</span>
            <?php
	}
	?> 
            
            
            
            </td>
          <td colspan="2" align="center" valign="top" class="EstGarantiaImprimirEtiquetaFondo"><?php
	if($InsGarantia->MinId == "MIN-10010"){
	?>
            <span class="EstGarantiaImprimirContenido">X</span>
            <?php
	}
	?></td>
          <td align="center" valign="top" ><span class="EstGarantiaImprimirEtiquetaFondo">
            <?php
	if($InsGarantia->MinId == "MIN-10008"){
	?>
            <span class="EstGarantiaImprimirContenido">X</span>
            <?php
	}
	?>
            </span></td>
          <td align="center" valign="top" >&nbsp;</td>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">% Factor</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="7" rowspan="2" align="center" valign="middle" class="EstGarantiaImprimirEtiquetaFondo"><span class="EstGarantiaImprimirContenido"><?php echo $InsGarantia->GarCausa;?></span></td>
          <td colspan="6" rowspan="8" align="left" valign="top" class="EstGarantiaImprimirEtiquetaFondo">&nbsp;</td>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Sub total Repuestos Otros</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">% Factor</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" >&nbsp;</td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="7" rowspan="6" align="center" valign="middle" class="EstGarantiaImprimirEtiquetaFondo">
            
            
            <img src="../../imagenes/firma_garantia.png"  />
            
            <br />
            Firma y Sello del Concesionario
            
            
            </td>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Total Repuestos</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            <?php
	  $TotalRepuestos = $SubTotalRepuestoStock;
	  $SubTotal = $TotalManoObra + $TotalRepuestos;
      $Impuesto = $SubTotal * ($InsGarantia->GarPorcentajeImpuestoVenta/100);
	  $Total = $SubTotal + $Impuesto;
	  ?>
            
            <?php echo number_format($TotalRepuestos,2);?>
            </td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Total Mano de Obra</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" >
            <?php echo number_format($TotalManoObra,2);?></td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Total (Base Imponible)</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            <?php echo number_format($SubTotal,2);?>
            
            </td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">IGV 18%</span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" >
            
            
            
            <?php
	  echo number_format($Impuesto,2);
	  ?>
            </td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3" align="left" valign="top" ><span class="EstGarantiaImprimirEtiqueta">Total </span></td>
          <td align="right" valign="top" ><?php echo ($InsGarantia->MonSimbolo);?></td>
          <td align="right" valign="top" ><?php
	  echo number_format($Total,2);
	  ?></td>
          <td colspan="2" align="left" valign="top" >&nbsp;</td>
          </tr>
        <tr>
          <td height="60" colspan="4" align="center" valign="bottom" >
            
            
            <?php echo $InsGarantia->CliNombre;?> <?php echo $InsGarantia->CliApellidoPaterno;?> <?php echo $InsGarantia->CliApellidoMaterno;?><br />
            _________________________<br />
            CLIENTE  <?php echo $InsGarantia->TdoNombre;?>: <?php echo $InsGarantia->CliNumeroDocumento;?>
            &nbsp;
            
            </td>
          <td colspan="3" align="center" valign="bottom" >
            
            <?php echo $InsGarantia->PerNombre;?> <?php echo $InsGarantia->PerApellidoPaterno;?> <?php echo $InsGarantia->PerApellidoMaterno;?><br />
            ____________________________<br />
            MECANICO RESPONSABLE
            &nbsp; </td>
          </tr>
        </table>
    
    </tbody>
  </td>
  </tr>

 
</table>
</div>
</body>
</html>
