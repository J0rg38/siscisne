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

////ACL
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
////INSTANCIAS
$InsMensaje = new ClsMensaje();
$InsSesion = new ClsSesion();
$InsACL = new ClsACL();




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>
<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">

<!--
Librerias de Validacion
-->
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextField.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationSelect.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextarea.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<!--
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>
<!--
Libreria para Caja de Autocompletar
-->
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox-compressed.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox.css" />
	
    -->
    
<script type="text/javascript">
//Pasando variables genrales PHP a Javascript	
var MonedaSimbolo = "<?php echo $EmpresaMoneda;?>";
var EmpresaMonedaId = "<?php echo $EmpresaMonedaId;?>";
var FechaHoy = "<?php echo date("d/m/Y");?>";

//var ArcPrincipal = "principal.php";
var Ruta = "<?php echo $InsProyecto->Ruta; ?>";	
</script>
</head>

<body >

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Listado")){
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Ver")){
	$PrivilegioVer = true;
}else{
	$PrivilegioVer = false;
}
?>

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Editar")){
	$PrivilegioEditar = true;
}else{
	$PrivilegioEditar = false;
}
?>

<?php
/*if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Eliminar")){
	$PrivilegioEliminar = true;
}else{
	$PrivilegioEliminar = false;
}*/
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("ClientePago");?>JsClientePago.js"></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("ClientePago");?>JsClientePagoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>-->

<?php
$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$POST_mon = $EmpresaMonedaId;

include($InsProyecto->MtdFormulariosMsj("ClientePago").'MsjClientePago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsClientePago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsClientePago = new ClsClientePago();

//include($InsProyecto->MtdRutFormularios().'ClientePago/acc/AccClientePago.php');

$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta = $InsBoleta->MtdObtenerBoleta();

// MtdObtenerClientePagos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CpaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFormaPago=NULL,$oVenta=NULL,$oVentaTalonario=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario,$oNotaEntrega=NULL,$oNotaEntregaTalonario=NULL,$oMoneda=NULL,$oEstado=NULL)

$RepClientePago = $InsClientePago->MtdObtenerClientePagos(NULL,NULL,NULL,NULL,NULL,1,NULL,$_SESSION['SesionSucursal'],NULL,NULL,NULL,NULL,NULL,NULL,NULL,$GET_id,$GET_ta,NULL,NULL,NULL,3);
$ArrClientePagos = $RepClientePago['Datos'];

$InsMoneda->MonId = $POST_mon;
$InsMoneda = $InsMoneda->MtdObtenerMoneda();

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<form id="FrmListado" name="FrmListado" method="post" action="#" enctype="multipart/form-data">

	
    
<div class="EstCapMenu">
  <div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove();" ><img src="../../imagenes/iconos/salir.png" alt="[Salir]" title="Salir"  />Salir</a></div>

</div>

<div class="EstCapContenido">
                                                 

        
<table class="EstTablaListado" width="100%" border="0" cellpadding="2" cellspacing="2">
<tbody class="EstTablaListadoBody" >

<tr>
  <td colspan="2">        
		
	
   
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTablaListado">
		<thead class="EstTablaListadoHead">
            <tr>
              <th width="2%">#</th>
              <th width="2%">Id</th>
              <th width="4%">Fecha</th>
              <th width="9%">Forma de Pago</th>
              <th width="7%">Num. Tarj.</th>
              <th width="8%">Tipo. Tarj.</th>
              <th width="8%">Marca Tarj.</th>
              <th width="8%">Entidad Tarj.</th>
              <th width="7%">Banco</th>
              <th width="11%">Banco Depos.</th>
              <th width="10%">Num. Cheque</th>
              <th width="12%">Num. Transaccion</th>
              <th width="2%"><span title="Tipo de Cambio">T.C.</span></th>
              <th width="10%">Monto</th>
              <th width="10%">Acciones</th>
              </tr>
		</thead>
        <tbody class="EstTablaListadoBody" >
       
        <?php
		$SumaTotal = 0;
		$c = 1;
		foreach($ArrClientePagos as $DatClientePago){
		?>


            <tr>
              <td align="right"><?php echo $c;?></td>
              <td align="right">
			  
			  <?php echo $DatClientePago->CpaId;?>
              </td>
              <td align="right"><?php echo $DatClientePago->CpaFecha;?></td>
              <td align="right"><?php echo $DatClientePago->FpaNombre;?></td>
              <td align="right"><?php echo $DatClientePago->CpaTarjetaNumero; ?></td>
              <td align="right"><?php echo $DatClientePago->CpaTarjetaTipo; ?></td>
              <td align="right"><?php echo $DatClientePago->TmaNombre; ?></td>
              <td align="right"><?php echo $DatClientePago->TenNombre; ?></td>
              <td align="right"><?php echo $DatClientePago->BanNombre; ?></td>
              <td align="right"><?php echo $DatClientePago->BanNombreDepositar; ?></td>
              <td align="right"><?php echo $DatClientePago->CpaChequeNumero; ?></td>
              <td align="right"><?php echo $DatClientePago->CpaTransaccionNumero; ?></td>
              <td align="right"><?php echo $DatClientePago->CpaTipoCambio; ?></td>
              <td align="right"><?php
                if($POST_mon == $EmpresaMonedaId){
				?>
                <!--<span class="EstMonedaSimbolo"><?php echo ($EmpresaMoneda);?></span>-->
                <?php echo number_format($DatClientePago->CpaMonto,2);?>
                <?php
					$SumaTotal += $DatClientePago->CpaMonto;
                }else{
				?>
                <?php
                    if($DatClientePago->MonId<>$EmpresaMonedaId){
						if(!empty($DatClientePago->CpaTipoCambio)){
							$ClientePagoMonto = redondear_dos_decimal($DatClientePago->CpaMonto/$DatClientePago->CpaTipoCambio);
                    ?>
                <!--                  <span class="EstMonedaSimbolo"><?php echo ($DatClientePago->MonSimbolo);?></span>-->
                <?php echo number_format(($ClientePagoMonto),2);?>
                <?php
						$SumaTotal += $ClientePagoMonto;
						}else{
					?>
No hay tipo de cambio
<?php		
						}
                    }
                    ?>
<?php	
				}
				?></td>
              <td align="right">
              
              
<?php
/*if($PrivilegioEliminar){
?>
          <a href="javascript:FncEliminarSeleccionado('<?php echo $DatClientePago->CpaId; ?>');"> <img  src="imagenes/eliminar.gif" alt="[Eliminar]" width="19" height="19" border="0" title="Eliminar completamente"   /></a>
<?php
}*/
?>


<?php
if($PrivilegioEditar){
?>
<a href="FrmBoletaPagoEditar.php?Id=<?php echo $DatClientePago->CpaId;?>"><img src="imagenes/acciones/acc_editar.png" width="19" height="19" border="0" title="Editar" alt="[Editar]"   /></a>
<?php
}
?>

<?php
if($PrivilegioVer){
?>
<a href="FrmBoletaPagoVer.php?Id=<?php echo $DatClientePago->CpaId;?>"><img src="imagenes/acciones/acc_ver.png" width="19" height="19" border="0" title="Ver" alt="[Ver]"   /></a>
<?php
}
?>	

              </td>
              </tr>
		<?php
			$c++;
		}
		?>
            </tbody>
        </table>
        

    </td>
</tr>

<tr>
  <td width="90%" align="right">MONTO TOTAL DEL DOCUMENTO:</td>
  <td width="10%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span> <?php echo number_format($InsBoleta->BolTotal,2);?></td>
</tr>

<?php
if(!empty($InsBoleta->RegId)){
	
?>
<tr>
  <td width="90%" align="right">MONTO <?php echo strtoupper($InsBoleta->RegNombre);?>:</td>
  <td width="10%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span> <?php echo number_format($InsBoleta->BolRegimenMonto,2);?></td>
</tr>
<tr>
  <td width="90%" align="right">MONTO REAL:</td>
  <td width="10%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span> <?php echo number_format($InsBoleta->BolTotalReal,2);?></td>
</tr>
<?php
	$Saldo = $InsBoleta->BolTotalReal - $SumaTotal;
}else{
	$Saldo = $InsBoleta->BolTotal - $SumaTotal;	
}
?>


<tr>
  <td align="right">TOTAL DE PAGOS:</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span> <?php echo number_format($SumaTotal,2);?></td>
</tr>
<tr>
<td align="right">SALDO:
	
	
	
   
        
        

</td>
<td align="right">

<span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo;?></span>


<?php echo number_format($Saldo,2);?>

</td>
</tr>
</tbody>
</table>			 
	
        
  </div>      
    
  

</form>    <?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

</body>
</html>
