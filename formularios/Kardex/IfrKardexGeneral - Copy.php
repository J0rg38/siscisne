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
	header("Content-Disposition:  filename=\"KARDEX_GENERAL_".date('d-m-Y').".xls\";");
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

<link rel="stylesheet" type="text/css" href="css/CssKardex.css">
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

//$POST_ProductoTipo = $_GET['ProductoTipo'];
//$POST_Moneda = $_GET['Moneda'];
//$POST_FechaTipo = (empty($_GET['CmpFechaTipo'])?"AmoFecha":$_GET['CmpFechaTipo']);

$POST_FechaInicio = $_GET['FechaInicio'];
$POST_FechaFin = $_GET['FechaFin'];
//$POST_Sucursal = (empty($_GET['CmpSucursal'])?$_SESSION['SesionSucursal']:$_GET['CmpSucursal']);
$POST_Sucursal = $_GET['Sucursal'];

$POST_Almacen = $_GET['Almacen'];

$POST_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];
$POST_ProductoNombre = $_GET['ProductoNombre'];
$POST_ProductoUnidadMedidaKardex = $_GET['ProductoUnidadMedidaKardex'];
$POST_ProductoId = $_GET['ProductoId'];

if(!empty($POST_ProductoCodigoOriginal)){
	if(empty($POST_ProductoId)){
		exit("No ha ingresado correctamente el producto");
	}
}

require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsKardex = new ClsKardex();
$InsProducto = new ClsProducto();
$InsSucursal = new ClsSucursal();


$aux = explode("/",$POST_FechaInicio);
$KardexFechaInicio = "01/01/".$aux[2];

$InsSucursal->SucId = $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();

$InventarioFechaInicio = (empty($InsSucursal->SucInventarioFechaInicio)?$SistemaInventarioFecha:$InsSucursal->SucInventarioFechaInicio);


// MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProNombre","ASC",NULL,1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,NULL,true,NULL);
$ArrProductos = $ResProducto['Datos'];





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
  
  
  <span class="EstReporteTitulo">KARDEX GENERAL 
 
<?php
if($POST_FechaInicio == $POST_FechaFin){
?>
	<?php echo $POST_FechaInicio; ?>
<?php
}else{
?>
	<?php echo $POST_FechaInicio; ?> AL <?php echo $POST_FechaFin; ?>
<?php  
}
?>



</span>


  </td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>




<hr class="EstReporteLinea">

<?php }?>

 <table class="EstTablaListado" width="100%">
            <thead class="EstTablaListadoHead">
            <tr>
              <th width="17" rowspan="2">#</th>
              <th width="66" rowspan="2">SUCURSAL</th>
              <th width="66" rowspan="2">COD. ORIG</th>
              <th width="66" rowspan="2">NOMBRE</th>
              <th width="66" rowspan="2">MARCA</th>
              <th width="66" rowspan="2">TIPO</th>
              <th width="66" rowspan="2">FICHA</th>
              <th width="40" rowspan="2">AFECTADO</th>
              <th width="40" rowspan="2">FECHA MOV.</th>
              <th width="76" rowspan="2">DOC.</th>
              <th width="38" rowspan="2"><ipo>SERIE</ipo></th>
              <th width="77" rowspan="2">NUMERO</th>
              <th width="17" rowspan="2">FECHA COMP.</th>
              <th width="17" rowspan="2">&nbsp;</th>
              <th width="115" rowspan="2">TIPO OPE</th>
              <th width="115" rowspan="2">ACCION REF.</th>
              <th colspan="3">ENTRADAS</th>
              <th colspan="3">SALIDAS</th>
              <th colspan="3">SALDO</th>
              </tr>
            <tr>
              <th>CANT.</th>
              <th>COSTO UNI.</th>
              <th>COSTO TOTAL</th>
              <th>CANT.</th>
              <th>COSTO UNI.</th>
              <th>COSTO TOTAL</th>
              <th>CANT.</th>
              <th>COSTO UNI.</th>
              <th>COSTO TOTAL</th>
              </tr>
              
            </thead>
            <tbody class="EstTablaListadoBody">
            
            
<?php

//deb($InventarioFechaInicio );
//MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="AmoFecha",$oAlmacen=NULL,$oSucursal=NULL) 
$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL ,'amd.ProId ASC,amd.AmdFecha ASC,(amd.AmdTiempoCreacion) ASC','',NULL,$POST_ProductoId ,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"amd.AmdFecha",$POST_Almacen,$POST_Sucursal);
$ArrKardexs = $ResKardex['Datos'];


?>
	<?php

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
	foreach($ArrKardexs as $DatKardex){

		$DatKardex->KdxCostoUnitario = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardex->KdxCostoUnitario:($DatKardex->KdxCostoUnitario/$DatKardex->KdxTipoCambio));  

?>
    
<?php
	
	if( FncConvetirTimestamp($DatKardex->KdxFecha) < FncConvetirTimestamp($POST_FechaInicio)){	

		if($DatKardex->KdxMovimientoTipo==1  ){
			
			$TotalEntradaGeneral += $DatKardex->KdxCantidad;

			$CostoActual = $DatKardex->KdxCostoUnitario;
			$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
			
			$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);
			
			if($Primera ){
				$CostoUnitarioAnterior = $CostoActual;
				$Primera = false;
			}else{
				//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
				$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
			}
	
		}

		if($DatKardex->KdxMovimientoTipo==2){
			
			$TotalSalidaGeneral += $DatKardex->KdxCantidad;

			$CostoActual = $CostoUnitarioAnterior;
			$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;

			$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);			
		}

	}else{
		
		$MostrarSaldoAnterior2 = false;
		
?>         
              

<?php
if($MostrarSaldoAnterior){
?>
	<tr>
	  <td height="30" align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td align="left">&nbsp;</td>
	  <td height="30" align="left">.</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC"><!--Saldo Anterior--></td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td width="58" height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td width="60" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="58" height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td width="60" height="30" align="center" valign="top" bgcolor="#66CC99"><?php  
		echo number_format($Saldo,2);
		?></td>
	  <td width="72" height="30" align="center" valign="top" bgcolor="#66CC99"><?php 
	 	echo number_format($CostoUnitarioAnterior,2);
		?></td>
	  <td width="64" align="center" valign="top" bgcolor="#66CC99"><?php 
		echo number_format($CostoTotalAnterior,2);
		?></td>
	  </tr>
<?php
}
$MostrarSaldoAnterior = false;
?>



			<?php
            if($DatKardex->TopId == "TOP-10015" and $MostrarInventario){
            ?>
                <tr>
                    <td colspan="25" align="center">
                    INVENTARIO
                    </td>
                </tr>
            <?php
				$Saldo = 0;
				$MostrarInventario = false;								
            }
            ?>
            
            

	<tr>
	  <td align="left"><?php echo $j;?></td>
	  <td align="left" valign="top"><?php echo $DatKardex->SucNombre;?></td>
	  <td align="left" valign="top"><?php echo $DatKardex->ProCodigoOriginal;?></td>
	  <td align="left" valign="top"><?php echo $DatKardex->ProNombre;?></td>
	  <td align="left" valign="top"><?php echo $DatKardex->VmaNombre;?></td>
	  <td align="left" valign="top"><?php echo $DatKardex->RtiNombre;?></td>
	  <td align="left" valign="top">
      
      
		<?php
		switch($DatKardex->KdxMovimientoTipo){
			case 1:
		?>
                
                


<?php
				switch($DatKardex->KdxMovimientoSubTipo){
					case 6:
		?>
                <a target="_blank" href="../../principal.php?Mod=TrasladoAlmacen&Form=Ver&Id=<?php echo $DatKardex->TalId ?>">
                <?php echo $DatKardex->TalId;?>
                </a>
        
        <?php		  
					break;
						
					default:
						
											?>
          <a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatKardex->KdxId ?>">
                <?php echo $DatKardex->KdxId;?>
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
					switch($DatKardex->KdxMovimientoSubTipo){
						
						
							case 6:
		?>
                <a target="_blank" href="../../principal.php?Mod=TrasladoAlmacen&Form=Ver&Id=<?php echo $DatKardex->TalId ?>">
                <?php echo $DatKardex->TalId;?>
                </a>
        
        <?php		  
					break;
					
					
					
								case 5:
		?>
                <a target="_blank" href="../../principal.php?Mod=NotaCreditoCompra&Form=Ver&Id=<?php echo $DatKardex->KdxId ?>">
                <?php echo $DatKardex->KdxId;?>
                </a>
        
        <?php		  
						break;
						
						default:
						
											?>
            <a target="_blank" href="../../principal.php?Mod=AlmacenMovimientoSalida&Form=Ver&Id=<?php echo $DatKardex->KdxId ?>">
            <?php echo $DatKardex->KdxId;?>
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
	    
	    <?php echo $DatKardex->CliNombre;?>      
	    <?php echo $DatKardex->CliApellidoPaterno;?>
	    <?php echo $DatKardex->CliApellidoMaterno;?>
	    
	    <?php echo $DatKardex->PrvNombre;?>
	    <?php echo $DatKardex->PrvApellidoPaterno;?>
	    <?php echo $DatKardex->PrvApellidoMaterno;?>
      </td>
	  <td align="left" valign="top"><?php echo $DatKardex->KdxFecha;?></td>
	  <td align="left" valign="top">
	  
          [<?php echo $DatKardex->CtiCodigo;?>]
          <?php echo $DatKardex->CtiNombre;?>
          
      </td>
	  <td align="left" valign="top">
      
	<?php
    if(empty($DatKardex->KdxComprobanteNumero)){
    ?>
		<?php list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero2);?>
    <?php  
    }else{
    ?>
		<?php list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero);?>        
    <?php  
    }
    ?>

		<?php echo $Serie;?>&nbsp;
	  </td>
	  <td align="left" valign="top">
      <?php echo $Numero;?>&nbsp;
      </td>
	  <td align="left" valign="top"><?php echo $DatKardex->KdxComprobanteFecha;?></td>
	  <td align="left" valign="top">
	  
<?php
switch($DatKardex->KdxMovimientoTipo){
	case 1:
?>
	    E
<?php
		$TotalMovimientoEntradas++;
		$TotalMontoMovimientoEntradas+=$DatKardex->KdxCantidad;
	break;
	
	case 2:
?>
	    S
<?php	
		$TotalMovimientoSalidas++;
		$TotalMontoMovimientoSalidas+=$DatKardex->KdxCantidad;
	break;
	
	default:
?>
	    -
  <?php	
	break;
}
?>

</td>
	  <td align="left" valign="top">[<?php echo $DatKardex->TopCodigo?>] <?php echo $DatKardex->TopNombre?></td>
	  <td align="left" valign="top">
      
  <?php echo $DatKardex->KdxTipoMovimiento;?> 
      
      
      </td>
	  <td width="60" align="center" valign="top" bgcolor="#99CCCC">
	  			<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($DatKardex->KdxCantidad,2);?>
					<?php
					$TotalEntradaGeneral += $DatKardex->KdxCantidad;

					$CostoActual = $DatKardex->KdxCostoUnitario;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
					
					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					if($Primera ){
						$CostoUnitarioAnterior = $CostoActual;
						$Primera = false;
					}else{
						$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
					}
				
					$CostoTotalSaldo = ($CostoUnitarioAnterior * $Saldo);			
				}
				?>
                
                
                &nbsp;
      </td>
              <td width="72" align="center" valign="top" bgcolor="#99CCCC">
				<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($DatKardex->KdxCostoUnitario,2)?>
		        <?php
				}
				?>
                &nbsp;
              
      </td>
              <td width="58" align="center" valign="top" bgcolor="#99CCCC">
			  
				<?php
				if($DatKardex->KdxMovimientoTipo==1  ){
				?>
					<?php echo number_format($CostoTotalActual,2)?>
				<?php
				}
				?>
                &nbsp;
	  </td>
              <td width="60" align="center" valign="top" bgcolor="#FFCC66">
			  	<?php
				if($DatKardex->KdxMovimientoTipo==2){
				?>
                	<?php echo number_format($DatKardex->KdxCantidad,2);?>
					<?php
                    $TotalSalidaGeneral += $DatKardex->KdxCantidad;
					
					$CostoActual = $CostoUnitarioAnterior;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
		
					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					$CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);	
					?>
                <?php
				}
				?>&nbsp;
			</td>
              <td width="72" align="center" valign="top" bgcolor="#FFCC66">
			  
			    <?php
				if($DatKardex->KdxMovimientoTipo==2 ){
				?>
					<?php echo number_format($CostoActual,2)?>
				<?php
				}
				?>&nbsp;				
		</td>
              <td width="58" align="center" valign="top" bgcolor="#FFCC66">
              
			    <?php
				if($DatKardex->KdxMovimientoTipo==2  ){
				?>
					<?php echo number_format($CostoTotalActual,2)?>
		        <?php
				}
				?>&nbsp;		
	  </td>
			<td width="60" align="center" valign="top" bgcolor="#66CC99">
				<?php echo number_format($Saldo,2);?>
	  </td>
			<td width="72" align="center" valign="top" bgcolor="#66CC99">
				<?php echo number_format($CostoUnitarioAnterior,2);?>
	  </td>
			<td width="64" align="center" valign="top" bgcolor="#66CC99"><?php
				
				?>
            <?php echo number_format($CostoTotalSaldo,2);?></td>
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
if($MostrarSaldoAnterior2){
?>
	<tr>
	  <td height="30" align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">-</td>
	  <td align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td align="center">-</td>
	  <td height="30" align="center">-</td>
	  <td align="left">&nbsp;</td>
	  <td height="30" align="left">..</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC"><!--Saldo Anterior--></td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#99CCCC">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
	  <td height="30" align="center" valign="top" bgcolor="#66CC99"><?php  
		echo number_format($Saldo,2);
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
?>		

                           <tr>
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
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right"><?php //echo number_format($TotalEntradaGeneral,2);?>&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right"><?php //echo number_format($TotalSalidaGeneral,2);?>&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                             <td align="right">&nbsp;</td>
                           </tr>
              </tbody>
            </table>
 
</body>
</html>

