<?php
session_start();
/*
*Archivos de Sistema
*/
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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


if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"KARDEX_VEHICULO_".date('d-m-Y').".xls\";");
}

?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.3.2.min.js"></script>

<!--
Nombre: TBOX
Descripcion:
-->
<link rel="STYLESHEET" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>tbox/thickbox.css">
<script  src="<?php echo $InsProyecto->MtdRutLibrerias();?>tbox/thickbox.js"></script>

<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php 
if($_GET['P']==1){
?> 
	setTimeout("window.close();",2500);	
	window.print(); 
<?php 
}
?>
});

</script>
      
       
<?php


$POST_FechaInicio = $_GET['CmpFechaInicio'];
$POST_FechaFin = $_GET['CmpFechaFin'];

$POST_VehiculoId = $_GET['CmpVehiculoId'];
$POST_UnidadMedidaUso = $_GET['CmpVehiculoUnidadMedidaKardex'];
$POST_Moneda = $_GET['CmpMoneda'];
$POST_SucursalId = $_GET['CmpSucursalId'];
$POST_VehiculoCodigoIdentificador = $_GET['CmpVehiculoCodigoIdentificador'];

require_once($InsPoo->MtdPaqAlmacen().'ClsKardexVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsKardexVehiculo = new ClsKardexVehiculo();
$InsVehiculo = new ClsVehiculo();

$aux = explode("/",$POST_FechaInicio);
$KardexFechaInicio = "01/01/".$aux[2];

//if(!empty($POST_SucursalId)){
//	$stipo = "";	
//}else{
//	$stipo = "1,2";
//}

//MtdObtenerVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VehId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoTipo=NULL,$oEstado=NULL)
$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos("veh.VehId","esigual",$POST_VehiculoId,"VehCodigoIdentificador","ASC",NULL,NULL,NULL,NULL,NULL,1);
$ArrVehiculos = $ResVehiculo['Datos'];
//
//
//
////deb($POST_UnidadMedidaUso);
////MtdObtenerKardexVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="VmvFecha",$oSucursal=NULL,$oVehiculoId=NULL,$oVehiculoIngresoId=NULL)
//$ResKardexVehiculo = $InsKardexVehiculo->MtdObtenerKardexVehiculos(NULL,NULL,NULL,'vmd.VmdFecha ASC,(vmd.VmdTiempoCreacion) ASC','',NULL,$POST_VehiculoId ,FncCambiaFechaAMysql($KardexFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_UnidadMedidaUso,$POST_Moneda,"vmd.VmdFecha",$POST_SucursalId,$POST_VehiculoId,NULL);
//$ArrKardexVehiculos = $ResKardexVehiculo['Datos'];
//
//$InsVehiculo->VehId = $POST_VehiculoId;
//$InsVehiculo->MtdObtenerVehiculo(false);

?>

<?php if($_GET['P']==1){?>

<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
    
    
  </td>
  <td width="54%" align="center" valign="top">
  
  
  <span class="EstReporteTitulo">KARDEX DE VEHICULOS
 
  <?php
  if($POST_finicio == $POST_ffin){
?>
<?php echo $POST_finicio; ?>
<?php
  }else{
?>
<?php echo $POST_finicio; ?> AL <?php echo $POST_ffin; ?>
<?php  
  }
?>

<br>
<?php echo $InsVehiculo->VehId ;?> - 
<?php echo $InsVehiculo->ProNombre ;?>

</span>


  </td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>




<hr class="EstReporteLinea">

<?php }?>


<table class="EstTablaListado">
            <tbody class="EstTablaListadoBody">
            <tr>
              <td rowspan="2">Codigo:</td>
              <td rowspan="2"><?php echo $InsVehiculo->VehCodigoIdentificador;?></td>
              <td rowspan="2">Nombre:</td>
              <td rowspan="2"><?php echo $InsVehiculo->VmaNombre;?> <?php echo $InsVehiculo->VmoNombre;?> <?php echo $InsVehiculo->VveNombre;?></td>
              <td rowspan="2">&nbsp;</td>
              <td rowspan="2">&nbsp;</td>

            </tr>
 </tbody>

</table>





            <table class="EstTablaListado" width="100%">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="17">#</th>
              <th width="66">M</th>
              <th width="66">SUCURSAL</th>
              <th width="66">CODIGO</th>
              <th width="66">NOMBRE</th>
              <th width="66">MARCA</th>
              <th width="66">TIPO</th>
              <th width="66">FICHA</th>
              <th width="40">AFECTADO</th>
              <th width="40">REF.</th>
              <th width="40">FECHA</th>
              <th width="76">DOC</th>
              <th width="38"><ipo>SERIE</ipo></th>
              <th width="77">NUMERO</th>
              <th width="115">TIPO OPE</th>
              <th width="115">ACCION REF.</th>
              <th>ENTRADA CANT.</th>
              <th>ENTRADA COSTO UNI.</th>
              <th>ENTRADA COSTO TOTAL</th>
              <th>SALIDA CANT.</th>
              <th>SALIDA COSTO UNI.</th>
              <th>SALIDA COSTO TOTAL</th>
              <th>SALDO CANT.</th>
              <th>SALDO COSTO UNI.</th>
              <th>SALDO COSTO TOTAL</th>
              </tr>
              
            </thead>

<tbody class="EstTablaListadoBody">

 <?php
$i = 1;
foreach($ArrVehiculos as $DatVehiculo){
?>    

     
<?php
//deb($POST_UnidadMedidaUso);
//MtdObtenerKardexVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="VmvFecha",$oSucursal=NULL,$oVehiculoId=NULL,$oVehiculoIngresoId=NULL)
$ResKardexVehiculo = $InsKardexVehiculo->MtdObtenerKardexVehiculos(NULL,NULL,NULL,'vmd.VmdFecha ASC,(vmd.VmdTiempoCreacion) ASC','',NULL,NULL ,FncCambiaFechaAMysql($KardexFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_UnidadMedidaUso,$POST_Moneda,"vmd.VmdFecha",$POST_SucursalId,$DatVehiculo->VehId,NULL);
$ArrKardexVehiculos = $ResKardexVehiculo['Datos'];

$InsVehiculo->VehId = $DatVehiculo->VehId;
$InsVehiculo->MtdObtenerVehiculo(false);



?>
          
	<?php

	$CostoTotalMovimientoEntradas = 0;
	$CostoTotalMovimientoSalidas = 0;
	
	
	$TotalMovimientoEntradas = 0;
	$TotalMovimientoSalidas = 0;
	
	$TotalMontoMovimientoEntradas = 0;
	$TotalMontoMovimientoSalidas = 0;
	
	$TotalEntradaGeneral = 0;
	$TotalSalidaGeneral = 0;
	
	$MostrarSaldoAnterior = true;
	$MostrarSaldoAnterior2 = true;
	
	$j = 1;
	$Primera = true;
	$MostrarInventario = true;	
	foreach($ArrKardexVehiculos as $DatKardexVehiculo){

		$DatKardexVehiculo->KdvCostoUnitario = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardexVehiculo->KdvCostoUnitario:($DatKardexVehiculo->KdvCostoUnitario/$DatKardexVehiculo->KdvTipoCambio));  
		$DatKardexVehiculo->KdvCostoIngreso = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardexVehiculo->KdvCostoIngreso:($DatKardexVehiculo->KdvCostoIngreso/$DatKardexVehiculo->KdvTipoCambio));  

?>
    
<?php
	
	if( FncConvetirTimestamp($DatKardexVehiculo->KdvFecha) < FncConvetirTimestamp($POST_FechaInicio)){	

		if($DatKardexVehiculo->KdvMovimientoTipo==1  ){
			
			$TotalEntradaGeneral += $DatKardexVehiculo->KdvCantidad;

			$CostoActual = $DatKardexVehiculo->KdvCostoUnitario;
			$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
			
			$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);
			
			if($Primera ){
				$CostoUnitarioAnterior = $CostoActual;
				$Primera = false;
			}else{
				//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
				$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
			}
	
		}

		if($DatKardexVehiculo->KdvMovimientoTipo==2){
			
			$TotalSalidaGeneral += $DatKardexVehiculo->KdvCantidad;

			$CostoActual = $CostoUnitarioAnterior;
			$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;

			$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);			
		}

	}else{
		
		$MostrarSaldoAnterior2 = false;
		
?>         
              

<?php
/*if($MostrarSaldoAnterior){
?>
	<tr>
	  <td height="30" align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="left">.</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC"><!--Saldo Anterior--></td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td width="58" height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td width="60" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="58" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="60" height="30" align="center" valign="top" bgcolor="#66CC99"><?php  
		echo number_format($CantidadSaldo,2);
		?></td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td width="64" align="center" valign="top" bgcolor="#66CC99"><?php 
		echo number_format($CostoTotalAnterior,2);
		?></td>
	  </tr>
<?php
}*/
$MostrarSaldoAnterior = false;
?>



			<?php
            if($DatKardexVehiculo->TopId == "TOP-10015" and $MostrarInventario){
            ?>
                <tr>
                    <td colspan="25" align="center">
                    INVENTARIO
                    </td>
                </tr>
            <?php
				$CantidadSaldo = 0;
				$MostrarInventario = false;								
            }
            ?>
            
            

	<tr>
	  <td align="left"><?php echo $j;?></td>
	  <td align="left" valign="top"><?php
switch($DatKardexVehiculo->KdvMovimientoTipo){
	case 1:
?>
E
  <?php
		$TotalMovimientoEntradas++;
		$TotalMontoMovimientoEntradas+=$DatKardexVehiculo->KdvCantidad;
	break;
	
	case 2:
?>
S
<?php	
		$TotalMovimientoSalidas++;
		$TotalMontoMovimientoSalidas+=$DatKardexVehiculo->KdvCantidad;
	break;
	
	default:
?>
-
<?php	
	break;
}
?></td>
	  <td align="left" valign="top"><?php echo $DatKardexVehiculo->SucNombre;?></td>
	  <td align="left" valign="top"><?php echo $DatKardexVehiculo->VehCodigoIdentificador;?></td>
	  <td align="left" valign="top"><?php echo $DatKardexVehiculo->VmoNombre;?> <?php echo $DatKardexVehiculo->VveNombre;?></td>
	  <td align="left" valign="top"><?php echo $DatKardexVehiculo->VmaNombre;?></td>
	  <td align="left" valign="top">-</td>
	  <td align="left" valign="top">
      
      
		<?php
		switch($DatKardexVehiculo->KdvMovimientoTipo){
			case 1:
		?>
                
                


<?php
				switch($DatKardexVehiculo->KdvMovimientoSubTipo){
					case 6:
		?>
                <a target="_blank" href="../../principal.php?Mod=TrasladoSucursal&Form=Ver&Id=<?php echo $DatKardexVehiculo->TalId ?>">
                <?php echo $DatKardexVehiculo->TalId;?>
                </a>
        
        <?php		  
					break;
						
					default:
						
											?>
          <a target="_blank" href="../../principal.php?Mod=SucursalMovimientoEntrada&Form=Ver&Id=<?php echo $DatKardexVehiculo->KdvId ?>">
                <?php echo $DatKardexVehiculo->KdvId;?>
                </a>
        
<?php	
					break;
						
				}
?>




		<?php
			break;
		  
			case 2:
		?>

<?php
					switch($DatKardexVehiculo->KdvMovimientoSubTipo){
						
						
							case 6:
		?>
                <a target="_blank" href="../../principal.php?Mod=TrasladoSucursal&Form=Ver&Id=<?php echo $DatKardexVehiculo->TalId ?>">
                <?php echo $DatKardexVehiculo->TalId;?>
                </a>
        
        <?php		  
					break;
					
					
					
								case 5:
		?>
                <a target="_blank" href="../../principal.php?Mod=NotaCreditoCompra&Form=Ver&Id=<?php echo $DatKardexVehiculo->KdvId ?>">
                <?php echo $DatKardexVehiculo->KdvId;?>
                </a>
        
        <?php		  
						break;
						
						default:
						
											?>
            <a target="_blank" href="../../principal.php?Mod=SucursalMovimientoSalida&Form=Ver&Id=<?php echo $DatKardexVehiculo->KdvId ?>">
            <?php echo $DatKardexVehiculo->KdvId;?>
            </a>
        
<?php	
						break;
						
					}
?>
        
        <?php
	  
			break;
			
			
		}
		?>
      </td>
	  <td align="left" valign="top">
	    
	    <?php echo $DatKardexVehiculo->CliNombre;?>      
	    <?php echo $DatKardexVehiculo->CliApellidoPaterno;?>
	    <?php echo $DatKardexVehiculo->CliApellidoMaterno;?>
	    
	    <?php echo $DatKardexVehiculo->PrvNombre;?>
	    <?php echo $DatKardexVehiculo->PrvApellidoPaterno;?>
	    <?php echo $DatKardexVehiculo->PrvApellidoMaterno;?>
      </td>
	  <td align="left" valign="top"><?php echo $DatKardexVehiculo->EinVIN;?></td>
	  <td align="left" valign="top">
	  
	  
	    <?php
	  switch($DatKardexVehiculo->KdvMovimientoTipo){
			case 1:
		?>
				
				<?php echo $DatKardexVehiculo->KdvComprobanteFecha;?>
                
        <?php	
			break;
			
			case 2:
		?>
        		
				<?php echo $DatKardexVehiculo->KdvFecha;?>
                
        <?php	
			break;
			
			default:
		?>
        	-
        <?php	
			break;
			
	  }
	  ?>
	  
	  
	  <?php //echo $DatKardexVehiculo->KdvFecha;?></td>
	  <td align="left" valign="top">
	  
          [<?php echo $DatKardexVehiculo->CtiCodigo;?>]
          <?php echo $DatKardexVehiculo->CtiNombre;?>
          
      </td>
	  <td align="left" valign="top">
      
	<?php
    if(empty($DatKardexVehiculo->KdvComprobanteNumero)){
    ?>
		<?php list($Serie,$Numero)=explode("-",$DatKardexVehiculo->KdvComprobanteNumero2);?>
    <?php  
    }else{
    ?>
		<?php list($Serie,$Numero)=explode("-",$DatKardexVehiculo->KdvComprobanteNumero);?>        
    <?php  
    }
    ?>

		<?php echo $Serie;?>&nbsp;
	  </td>
	  <td align="left" valign="top">
	    <?php echo $Numero;?>&nbsp;
	    
	    <?php
	  if(!empty($DatKardexVehiculo->KdvFoto)){
	?>
	    <a  target="_blank" href="../../subidos/vehiculo_movimiento_fotos/<?php echo $DatKardexVehiculo->KdvFoto;?>"  title=""><img  src="../../imagenes/documento.gif" width="20" height="20" border="0"  /></a>
	    <?php
	  }
	  ?>
      </td>
	  <td align="left" valign="top">[<?php echo $DatKardexVehiculo->TopCodigo?>] <?php echo $DatKardexVehiculo->TopNombre?></td>
	  <td align="left" valign="top">-</td>
	  <td width="60" align="center" valign="top" bgcolor="#99CCCC">
	  			
				
				
                  <!--
            ENTRADAS - CANTIDAD
            -->
				
				<?php
				if($DatKardexVehiculo->KdvMovimientoTipo==1  ){
				?>
                
					<?php echo number_format($DatKardexVehiculo->KdvCantidad,2);?>
                    
					<?php
					$TotalEntradaGeneral += $DatKardexVehiculo->KdvCantidad;
					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					$CostoActual = $DatKardexVehiculo->KdvCostoUnitario;
					$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
					$CostoTotalMovimientoEntradas += $CostoTotalActual;
					
					if($Primera ){
						//$CostoUnitarioAnterior = $CostoActual;
						$CostoTotalAnterior = $CostoTotalActual;
						$Primera = false;
						//echo "PS";
					}else{
						//$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
						$CostoTotalAnterior = (($CostoTotalAnterior + $CostoActual));	
						
						//deb($CostoTotalAnterior);
						//deb($CostoActual);
						//echo "PN";
					}
				
					//$CostoTotalSaldo = ($CostoUnitarioAnterior * $CantidadSaldo);
					$CostoTotalSaldo = ($CostoTotalAnterior);	
					$CostoUnitarioSaldo = $CostoTotalSaldo/(empty($CantidadSaldo)?1:$CantidadSaldo);	
						
				}
				?>
                
                
                &nbsp;
                </td>
              <td width="72" align="center" valign="top" bgcolor="#99CCCC">
				
				
                  <!--
            ENTRADAS - COSTO UNITARIO
            -->
            
				<?php
				if($DatKardexVehiculo->KdvMovimientoTipo==1  ){
				?>
					
					<?php //echo number_format($DatKardexVehiculo->KdvCostoUnitario,2)?>
                    <?php echo number_format($CostoActual,2)?>
                    
		        <?php
				}
				?>
                &nbsp;
              
      </td>
              <td width="58" align="center" valign="top" bgcolor="#99CCCC">
			  
                  <!--
            ENTRADAS - COSTO TOTAL
            -->
            
				<?php
				if($DatKardexVehiculo->KdvMovimientoTipo==1  ){
				?>
					<?php echo number_format($CostoTotalActual,2)?>
				<?php
				}
				?>
                &nbsp;
	  </td>
              <td width="60" align="center" valign="top" bgcolor="#FFCC66">
			  
			<!--
            SALIDAS - CANTIDAD
            -->
            
            <?php //echo number_format($CantidadSaldo,2);?>
			<?php //echo number_format($CostoUnitarioAnterior,2);?>
      		<?php //echo number_format($CostoTotalSaldo,2);?>
            
              	<?php
				if($DatKardexVehiculo->KdvMovimientoTipo==2){
				?>
                	
					<!--<span style="color:#CCC;"><?php echo $CostoTotalAnterior;?> / <?php echo $CostoTotalAnterior;?></span>-->
					<?php   
					
					if($DatKardexVehiculo->KdvSubTipo == 3){
						
						//$DatKardexVehiculo->KdvCostoIngreso = $$DatKardexVehiculo->KdvCostoIngreso *-1;
						
					}else{
						
						
					}
					
				//	$TotalSalidaGeneral += $DatKardexVehiculo->KdvCantidad;
//					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
//					
//					$Cantidad = $DatKardexVehiculo->KdvCantidad;
//					$CostoActual = $DatKardexVehiculo->KdvCostoIngreso;
//					$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
//					
//					$CostoTotalMovimientoSalidas += $CostoTotalActual;
//					
//					$CostoTotalAnterior = (($CostoTotalAnterior - $CostoActual));	
//					
//					$CostoTotalSaldo = ($CostoTotalAnterior);	
//					$CostoUnitarioSaldo = $CostoTotalSaldo/(empty($CantidadSaldo)?1:$CantidadSaldo);

					$TotalSalidaGeneral += $DatKardexVehiculo->KdvCantidad;
					$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					$Cantidad = $DatKardexVehiculo->KdvCantidad;
					$CostoActual = $DatKardexVehiculo->KdvCostoIngreso;
					$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
					
					$CostoTotalMovimientoSalidas += $CostoTotalActual;
					
					$CostoTotalAnterior = (($CostoTotalAnterior - $CostoActual));	
					
					$CostoTotalSaldo = ($CostoTotalAnterior - $CostoTotalActual);	
					$CostoUnitarioSaldo = $CostoTotalSaldo/(empty($CantidadSaldo)?1:$CantidadSaldo);
					
					?>
                    
                    <?php echo number_format($Cantidad,2);?>
                    
                <?php
				}
				?>
               
                &nbsp;
	  </td>
              <td width="72" align="center" valign="top" bgcolor="#FFCC66">
			  
                <!--
            SALIDAS - COSTO UNITARIO
            -->
			    <?php
				if($DatKardexVehiculo->KdvMovimientoTipo==2 ){
				?>
					<?php echo number_format($CostoActual,2)?>
				<?php
				}
				?>&nbsp;				
		</td>
              <td width="58" align="center" valign="top" bgcolor="#FFCC66">
                 <!--
            SALIDAS - COSTO TOTAL
            -->
			    <?php
				if($DatKardexVehiculo->KdvMovimientoTipo==2  ){
				?>

					<?php echo number_format($CostoTotalActual,2)?>
                    
		        <?php
				}
				?>
                
                &nbsp;		
	  </td>
			<td width="60" align="center" valign="top" bgcolor="#66CC99">
				 
			<!--
            SALDO - CANTIDAD
            -->
            
			<?php echo number_format($CantidadSaldo,2);?>
              
			</td>
			<td width="72" align="center" valign="top" bgcolor="#66CC99">
               
			<!--
            SALDO - COSTO UNITARIO
            -->
            
			<?php //echo number_format($CostoUnitarioAnterior,2);?>
            <?php echo number_format($CostoUnitarioSaldo,2);?>
                
			</td>
			<td width="64" align="center" valign="top" bgcolor="#66CC99">
                
			<!--
            SALDO - COSTO TOTAL
            -->
            
      		<?php echo number_format($CostoTotalSaldo,2);?>
            
            </td>
			</tr>
 
	<?php
    }
    ?>
    
    
<?php

?>          

            		
            


            <?php	
				$j++;
			}
			?>
            
	
<?php
/*if($MostrarSaldoAnterior2){
?>
	<tr>
	  <td height="30" align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td align="center">-</td>
	  <td align="center">&nbsp;</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="left">..</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC"><!--Saldo Anterior--></td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#66CC99"><?php  
		echo number_format($CantidadSaldo,2);
		?></td>
	  <td height="30" align="center" valign="top" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td align="center" valign="top" bgcolor="#66CC99"><?php 
		echo number_format($CostoTotalAnterior,2);
		?></td>
	  </tr>
<?php
}
*/?>		

                       <!--    <tr>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right"><?php echo number_format($TotalEntradaGeneral,2);?>&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right"><?php echo number_format($TotalSalidaGeneral,2);?>&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">
							 
                             <?php
							 $CantidadSaldoGeneral = $TotalEntradaGeneral - $TotalSalidaGeneral;
							 
							 ?>
							 <?php echo number_format($CantidadSaldoGeneral,2);?>
                             
                             </td>
                             <td align="right">&nbsp;</td>
                             <td>&nbsp;</td>
                           </tr>-->
 
 
<?php
}
?>
   
   
   
              </tbody>
            </table>


<?php
$CostoTotalMovimientoSaldos = $CostoTotalMovimientoEntradas - $CostoTotalMovimientoSalidas;
?>

<!-- <table class="EstTablaListado">
 <thead class="EstTablaListadoHead">
 <tr>
   <th>Concepto</th>
   <th>Monto</th>
 </tr>
 </thead>
 <tbody class="EstTablaListadoBody">
 <tr>
   <td>Costo Total Entradas:</td>
   <td><?php echo number_format($CostoTotalMovimientoEntradas,2);?></td>
 </tr>
 <tr>
   <td>Costo Total Salidas:</td>
   <td><?php echo number_format($CostoTotalMovimientoSalidas,2);?></td>
 </tr>
 <tr>
   <td>Costo Saldo:</td>
 <td><?php echo number_format($CostoTotalMovimientoSaldos,2);?></td>
 </tr>
 </tbody>
 </table>
  
 (*) Tiene costos adicionales
 -->
</body>
</html>

