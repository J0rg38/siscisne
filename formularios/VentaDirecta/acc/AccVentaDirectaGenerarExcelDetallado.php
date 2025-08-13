<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"ORDEN_VENTA_REPUESTOS_".date('d-m-Y').".xls\";");
 
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EXPORTAR A EXCEL - ORDENES DE VENTA DE REPUESTOS</title>
</head>
<body>

<?php

//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');

$InsACL = new ClsACL();
$PrivilegioAccesoTotal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"CotizacionVehiculo","AccesoTotal"))?true:false;




$POST_cam = ($_POST['Cam'] ?? '');
$POST_fil = $_POST['Fil'];

   if($_POST){
	   $_SESSION[$GET_mod."Filtro"] = $POST_fil;
   }else{
		$POST_fil = (empty($_GET['Fil'])?$_SESSION[$GET_mod."Filtro"]:$_GET['Fil']);
   }


$POST_ord = ($_POST['Ord'] ?? '');
$POST_sen = $_POST['Sen'] ?? '';
$POST_pag = ($_POST['Pag'] ?? '');
$POST_p = ($_POST['P'] ?? '');
$POST_num = $_POST['Num'] ?? '';

if($_POST){
	$_SESSION[$GET_mod."Num"] = $POST_num;
}else{
	$POST_num =  $_SESSION[$GET_mod."Num"];	
}

$POST_seleccionados = $_POST['cmp_seleccionados'] ?? '';
$POST_acc = $_POST['Acc'] ?? '';

/*
* Otras variables
*/
$POST_estado = $_POST['Estado'];
$POST_finicio = $_POST['FechaInicio'];
$POST_ffin = $_POST['FechaFin'];
$POST_con = $_POST['Con'];
$POST_Moneda = $_POST['Moneda'];

$POST_PedidoCompra = $_POST['PedidoCompra'];
$POST_VentaConcretada = $_POST['VentaConcretada'];
$POST_Personal = $_POST['CmpPersonal'];
$POST_Sucursal = $_POST['CmpSucursal'] ?? '';


if(empty($POST_p)){
	$POST_p = '1';
}

if(empty($POST_num)){
	$POST_num = '10';
}
if(empty($POST_ord)){
	$POST_ord = 'VdiTiempoCreacion';
}

if(empty($POST_sen)){
	$POST_sen = 'DESC';
}

if(empty($POST_pag)){
	$POST_pag = '0,'.$POST_num;
}

/*
* Otras variables
*/

if(empty($POST_finicio)){
	$POST_finicio = "01/01/".date("Y");
}


if(empty($POST_ffin)){
	$POST_ffin = date("d/m/Y");
}

if(empty($POST_estado)){
	$POST_estado = 0;
}
if(empty($POST_con)){
	$POST_con = "contiene";
}

//if(empty($POST_Moneda)){
//	$POST_Moneda = $EmpresaMonedaId;
//}
if(!$_POST){
	$POST_Sucursal = $_SESSION['SesionSucursal'];
}




require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsVentaDirecta = new ClsVentaDirecta();
$InsMoneda = new ClsMoneda();
$InsPersonal = new ClsPersonal();
$InsSucursal = new ClsSucursal();



//MtdObtenerVentaDirectas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oConCotizacionRepuesto=0,$oCotizacionRepuestoEstado=NULL,$oCotizacionRepuesto=NULL,$oMoneda=NULL,$oCliente=NULL,$oConOrdenCompraReferencia=NULL,$oPedidoCompra=NULL,$oVentaConcretada=NULL,$oClienteClasificacion=NULL,$oOrigen=NULL,$oObservado=NULL,$oEstricto=false,$oOrdenCompraReferencia=NULL,$oProductoCodigoOriginal=NULL,$oOrdenCompraTipo=NULL,$oExonerar=NULL,$oFichaIngreso=NULL,$oTieneGenerarVentaConcretada=false,$oPersonal=NULL,$oConCodigoExterno=0,$oSucursal=NULL)
$ResVentaDirecta = $InsVentaDirecta->MtdObtenerVentaDirectas("vdi.VdiId,cli.CliNombreCompleto,cli.CliNombre,cli.CliApellidoPaterno,cli.CliApellidoMaterno,cli.CliNumeroDocumento,lti.LtiNombre,vdi.CprId,VdiOrdenCompraNumero,VdiMarca,VdiModelo,VdiPlaca,VdiAnoModelo",$POST_con,$POST_fil,$POST_ord,$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_estado,0,NULL,NULL,$POST_Moneda,NULL,NULL,$POST_PedidoCompra,$POST_VentaConcretada,NULL,NULL,NULL,false,NULL,NULL,NULL,NULL,NULL,false,$POST_Personal,0,$POST_Sucursal);
$ArrVentaDirectas = $ResVentaDirecta['Datos'];
$VentaDirectasTotal = $ResVentaDirecta['Total'];
$VentaDirectasTotalSeleccionado = $ResVentaDirecta['TotalSeleccionado'];



?>



<table class="EstTablaListado" width="100%" cellspacing="0" cellpadding="0" border="0" >

            <thead class="EstTablaListadoHead">

              <tr>
                <th width="1%" >#</th>
                <th width="5%" >ID</th>
                <th width="4%" >FECHA</th>
                <th width="3%" >TIPO CLIENTE</th>
                <th width="3%" >NUM. DOC.</th>
                <th width="19%" >CLIENTE</th>
                <th width="3%" >VIN</th>
                <th width="5%" >VEHICULO</th>
                <th width="4%" >PLACA</th>
                <th width="4%" >COT.</th>
                <th width="5%" >PED. COMPR.</th>
                <th width="5%" >REF</th>
                <th width="7%" >TIPO VENTA</th>
                <th width="7%" >TIPO PEDIDO</th>
                <th width="5%" >V.C</th>
                <th width="7%" >O.T.</th>
                <th width="2%" >ABONOS</th>
                <th width="7%" >COND. PAGO</th>
                <th width="7%" >MONEDA </th>
                <th width="6%" >DESCUENTO</th>
                <th width="7%" >TOTAL</th>
                <th width="2%" >COTIZADOR</th>
                <th width="2%" >SITUACION</th>
                <th width="2%" >ESTADO</th>
                <th width="2%" >CODIGO</th>
                <th width="2%" >NOMBRE</th>
                <th width="2%" >CANTIDAD</th>
                <th width="2%" >IMPORTE</th>
                <th width="8%" >FECHA CREACION</th>
              </tr>
            </thead>

            <tfoot class="EstTablaListadoFoot">
            </tfoot>
 <tbody class="EstTablaListadoBody">
            <?php




								$pagina = explode(",",$POST_pag);
								$f=$pagina[0]+1;
					$SubTotal = 0;
					$Impuesto = 0;
					$Total = 0;
								foreach($ArrVentaDirectas as $dat){





$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$ResVentaDirectaDetalle =  $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,NULL,NULL,NULL,$dat->VdiId);
		$ArrVentaDirectaDetalles = 	$ResVentaDirectaDetalle['Datos'];

			
			if(!empty($ArrVentaDirectaDetalles)){
				foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
					
			
?>





              <tr id="Fila_<?php echo $f;?>">
                <td width="1%" align="center" bgcolor="<?php echo ($dat->VdiObservado==1?'#FF9933':((($dat->VdiOrigen=="EXT")?'#00CC33':'')));?>"   ><?php echo $f;?></td>
                <td align="right" valign="middle" width="5%"   >
				
				<?php echo $dat->VdiId;  ?></td>
                <td  width="4%" align="right" ><?php echo ($dat->VdiFecha);?></td>
                <td  width="3%" align="right" ><?php echo (empty($dat->LtiAbreviatura)?$dat->LtiNombre:$dat->LtiAbreviatura)//FncCortarTexto($dat->LtiNombre,15);?></td>
                <td  width="3%" align="right" ><?php echo ($dat->TdoNombre);?>/<?php echo ($dat->CliNumeroDocumento);?></td>
                <td  width="19%" align="right" >
                  
                  
                  <?php
if($PrivilegioClienteVer){
?>
                  <a href="javascript:FncClienteCargarFormulario('Ver','<?php echo $dat->CliId?>');"  ><?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?></a>
                  <?php	
}else{
?>
                  <?php echo $dat->CliNombre;?> <?php echo $dat->CliApellidoPaterno;?> <?php echo $dat->CliApellidoMaterno;?>
                  <?php	
}
?>
                  
                  
                  
                  
                </td>
                <td  width="3%" align="right" ><?php
if($PrivilegioVehiculoIngresoVer and !empty($dat->EinId)){
?>
                  <a href="javascript:FncVehiculoIngresoSimpleCargarFormulario('Ver','<?php echo $dat->EinId?>');"  ><?php echo ($dat->CprVIN);?></a>
                  <?php	
}else{
?>
                  <?php echo $dat->CprVIN;  ?>
                  <?php	
}
?></td>
                <td  width="5%" align="left" bgcolor="<?php echo $Color;?>" ><b>Marca:</b> <?php echo ($dat->VmaNombre);?>
                  <b>Modelo:</b> <?php echo ($dat->VmoNombre);?>
                  <b>Version:</b> <?php echo ($dat->VveNombre);?></td>
                <td  width="4%" align="right" ><h2><?php echo ($dat->VdiPlaca);?></h2></td>
                <td  width="4%" align="right" >
                  
                  <?php
if($PrivilegioCotizacionProductoVer){
?>
                  <a href="javascript:FncCotizacionProductoCargarFormulario('Ver','<?php echo $dat->CprId?>');"  ><?php echo ($dat->CprId);?></a>
                  <?php	
}else{
?>
                  <?php echo ($dat->CprId);?>
                  <?php	
}
?>
                  
                  
                  
                  
                  
                  
                </td>
                <td  width="5%" align="right" >
                  
                  
  <?php
if($dat->VdiPedidoCompra == "Si"){
?>
                  
  Tiene Pedido         
  <?php	
}else{
?>
	No Tiene Pedido

  <?php	
}
?>
                  
                  
                  
                  
                  
                </td>
                <td  width="5%" align="right" ><?php echo $dat->VdiOrdenCompraNumero;?></td>
                <td  width="7%" align="right" ><span class="EstFormularioResaltar"><?php echo $dat->VdiTipo;  ?></span></td>
                <td  width="7%" align="right" ><span class="EstFormularioResaltar"><?php echo $dat->VdiTipoPedido;  ?></span></td>
                <td  width="5%" align="right" >
                  
                  
                  <?php
if($dat->VdiVentaConcretada == "Si"){
?>
             
                  
                 Tiene  Concretada
                  
                  <?php	
}else{
?>
                  No Tiene Concretada
                
                  <?php	
}
?>
                  
                  
                  
                </td>
                <td  width="7%" align="right" >
                
                
                 
                  <?php
if($dat->VdiFichaIngreso == "Si"){
?>
                  
                  
                 Tiene  O.T.
                  
                  <?php	
}else{
?>
                  No Tiene O.T.
                 
                  <?php	
}
?>
    
                
                </td>
                <td  width="2%" align="right" ><?php
/*if($PrivilegioPagoListado and $dat->VdiPago == "Si"){
?>
<a href="javascript:FncPagoVentaDirectaCargarFormulario('Listado','<?php echo $dat->VdiId;?>');" >Ord. Cobro / Abonos</a>
<?php
}else{
?>
No Tiene Abono/Ord. Cobro
<?php	
}*/

?>
                  <?php
//if($PrivilegioPagoListado and $dat->VdiPago == "Si"){

if($dat->VdiPago == "Si"){
?>
                  <?php
	if($PrivilegioPagoListado){
	?>
                 Tiene Abonos
                  <?php	
	}else{
	?>
                  Tiene Abonos
  <?php	
	}
	?>
  <?php
}else{
?>
                  No Tiene Abonos
  <?php	
}
?></td>
                <td  width="7%" align="right" ><?php echo $dat->NpaNombre;  ?></td>
                <td  width="7%" align="right" ><?php echo $dat->MonSimbolo;  ?></td>
                <td  width="6%" align="right" >
                  
                  <?php $dat->VdiDescuento = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VdiDescuento:($dat->VdiDescuento/$dat->VdiTipoCambio));?>
                  
                  <?php echo number_format($dat->VdiDescuento,2);?>
                  
                </td>
                <td  width="7%" align="right" >
                  
                  
                  
                
                <?php $dat->VdiTotal = (($dat->VdiTotal/(empty($dat->VdiTipoCambio)?1:$dat->VdiTipoCambio)));?>
                <?php echo number_format($dat->VdiTotal,2); ?>
                
                  <?php //$dat->VdiTotal = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$dat->VdiTotal:($dat->VdiTotal/$dat->VdiTipoCambio));?>                  
                  
                  <?php //echo number_format($dat->VdiTotal,2);?>
                  <?php
					$Total += $dat->VdiTotal ;
			
				?>
                </td>
                <td  width="2%" align="right" ><?php echo $dat->PerNombre;  ?> <?php echo $dat->PerApellidoPaterno;  ?> <?php echo $dat->PerApellidoMaterno;  ?></td>
                <td  width="2%" align="right" >
                  
                  
  <?php
$InsVentaDirectaDetalle = new ClsVentaDirectaDetalle();
$ResVentaDirectaDetalle =  $InsVentaDirectaDetalle->MtdObtenerVentaDirectaDetalles(NULL,NULL,NULL,NULL,NULL,NULL,$dat->VdiId);
$ArrVentaDirectaDetalles = $ResVentaDirectaDetalle['Datos'];
?>
                  
                  <?php

$Situacion = 0;

$Pendiente = 0;
$Incompleto = 0;
$Completo = 0;

foreach($ArrVentaDirectaDetalles as $DatVentaDirectaDetalle){
?>
                  
                  
                  <?php	

		if($DatVentaDirectaDetalle->VddEstado == 1){

			if(empty($DatVentaDirectaDetalle->VddCantidadLlegada) and empty($DatVentaDirectaDetalle->AmdCantidad)){
				//$fondo = "#F30";//ROJO - NO LLEGO
				$Pendiente = 1;

			}else if( ($DatVentaDirectaDetalle->VddCantidadLlegada >= $DatVentaDirectaDetalle->VddPrecioVenta) or ($DatVentaDirectaDetalle->AmdCantidad >= $DatVentaDirectaDetalle->VddCantidad)  ){
				//$fondo = "#6F3"; // VERDE
				$Completo = 1;

			}else if($DatVentaDirectaDetalle->VddCantidadLlegada < $DatVentaDirectaDetalle->VddCantidad){
				//$fondo = "#FC0";//NARAJA - LLEGADA PARCIAL	
				$Incompleto = 1;

			}

		}
        
    ?>
                  <?php	
}
?>
                  
                  
                  
  <?php
//deb($Pendiente." - ".$Incompleto." - ".$Completo);
	if($Pendiente == 1){
		
		if($Completo == 1){
			
			$Situacion = 2;
			
		}else{
			
			if($Incompleto == 1){
				
				$Situacion = 2;
				
			}else{
				
				$Situacion = 1;
				
			}
		
		}
		
		
	}else{
		
		if($Incompleto == 1){
			
			$Situacion = 2;
			
		}else{
			$Situacion = 3;
		}
		
	}
?>
                  
  <?php
	switch($Situacion){
		case 1:
?>
                  PENDIENTE
                  <?php
		break;
		
		case 2:
?>
                  INCOMPLETO
                  <?php	
		break;
		
		case 3:
?>
                  COMPLETADO
  <?php
		break;
	}
?>
                  
                  
</td>
                <td  width="2%" align="right" >
					<?php //echo $dat->VdiEstadoIcono;?>
                    <?php echo $dat->VdiEstadoDescripcion;?>
				</td>
                <td  width="2%" align="right" ><?php echo ($DatVentaDirectaDetalle->ProCodigoOriginal);?></td>
                <td  width="2%" align="right" ><?php echo ($DatVentaDirectaDetalle->ProNombre);?></td>
                <td  width="2%" align="right" ><?php echo ($DatVentaDirectaDetalle->VddCantidad);?></td>
                <td  width="2%" align="right" ><?php echo ($DatVentaDirectaDetalle->VddImporte);?></td>
                <td  width="8%" align="right" ><?php echo ($dat->VdiTiempoCreacion);?></td>
        </tr>
        
        
        
        
<?php
				}
	}
?>

              <?php		$f++;

									
								

                
                
									

									}
									
									$Total = number_format($Total,2);
									$Impuesto = number_format($Impuesto,2);
									$SubTotal = number_format($SubTotal,2);

									?>
            </tbody>
      </table>
      
      
</body>
</html>