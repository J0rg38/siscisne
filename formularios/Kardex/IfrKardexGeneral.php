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

//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false) {
$ResProducto = $InsProducto->MtdObtenerProductos("ProId","esigual",$POST_ProductoId,"ProNombre","ASC",NULL,1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL,false);
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
              <th width="17">#</th>
              <th width="17">M</th>
              <th width="66">SUCURSAL</th>
              <th width="66">CODIGO</th>
              <th width="66">NOMBRE</th>
              <th width="66">MARCA</th>
              <th width="66">TIPO</th>
              <th width="66">FICHA</th>
              <th width="40">AFECTADO</th>
              <th width="40">REF.</th>
              <th width="40">FECHA</th>
              <th width="76">DOC.</th>
              <th width="38"><ipo>SERIE</ipo></th>
              <th width="77">NUMERO</th>
              <th width="115">TIPO OPE</th>
              <th width="115">ACCION REF.</th>
              <th>ULTIMA ENTRADA</th>
              <th>ULTIMA SALIDA</th>
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
foreach($ArrProductos as $DatProducto){
?>           
            
            
	<?php
    //deb($InventarioFechaInicio );
    //MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="AmoFecha",$oAlmacen=NULL,$oSucursal=NULL) 
    //$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL ,'amd.AmdFecha ASC,(amd.AmdTiempoCreacion) ASC','',NULL,$DatProducto->ProId ,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"IFNULL(amo.AmoComprobanteFecha,amd.AmdFecha)",$POST_Almacen,$POST_Sucursal);
	//$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL ,'amd.AmdFecha ASC,(amd.AmdTiempoCreacion) ASC','',NULL,$DatProducto->ProId ,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"IFNULL(amo.AmoComprobanteFecha,amd.AmdFecha)",$POST_Almacen,$POST_Sucursal);
	//$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL ,'IFNULL(amo.AmoComprobanteFecha,amd.AmdFecha) ','ASC',NULL,$DatProducto->ProId ,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"IFNULL(amo.AmoComprobanteFecha,amd.AmdFecha)",$POST_Almacen,$POST_Sucursal);
	$ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL ,'IFNULL(amo.AmoComprobanteFecha,amd.AmdFecha) ','ASC',NULL,$DatProducto->ProId ,NULL,FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"IFNULL(amo.AmoComprobanteFecha,amd.AmdFecha)",$POST_Almacen,$POST_Sucursal);
    $ArrKardexs = $ResKardex['Datos'];
    ?>

	<?php

	$TotalMovimientoEntradas = 0;
	$TotalMovimientoSalidas = 0;
	
	//$TotalMontoMovimientoEntradas = 0;
	//$TotalMontoMovimientoSalidas = 0;
	
	
	
	$TotalEntradaGeneral = 0;
	$TotalSalidaGeneral = 0;
	
	//
	$TotalEntradaCantidadItem = 0;
	$TotalEntradaUnitarioItem = 0;
	$TotalEntradaTotalItem = 0;
	
	$TotalSalidaCantidadItem = 0;
	$TotalSalidaUnitarioItem = 0;
	$TotalSalidaTotalItem = 0;

	$TotalSaldoCantidadItem = 0;
	$TotalSaldoUnitarioItem = 0;
	$TotalSaldoTotalItem = 0;
	
	
	/*
	*
	*/
	
	
	$TotalEntradaFiltro = 0;
	$TotalCostoTotalEntradaFiltro = 0;
	
	$TotalSalidaFiltro = 0;
	$TotalCostoTotalSalidaFiltro = 0;
	
			
              
              
              	
	$MostrarSaldoAnterior = true;
	//$MostrarSaldoAnterior2 = true;
	
	$j = 1;
	$Primera = true;
	//$MostrarInventario = true;	
	$MostratTotales = false;
	
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
        
		
		
				// $TotalEntradaCantidadItem += $DatKardex->KdxCantidad;
				 $TotalCostoTotalEntradaItem += $CostoTotalActual;       
				 
            }
    
            if($DatKardex->KdxMovimientoTipo==2){
                
                $TotalSalidaGeneral += $DatKardex->KdxCantidad;
    
                $CostoActual = $CostoUnitarioAnterior;
                $CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
    
                $Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
				
				
				//$TotalSalidaCantidadItem += $DatKardex->KdxCantidad;	
				//$TotalCostoTotalSalidaItem += $CostoTotalActual;
				
            }
    
	
	
	
        }else{
            
            //$MostrarSaldoAnterior2 = false;
			
			
			
            $MostratTotales = true;
    ?>         
                  
            
       <?php
	   if($MostrarSaldoAnterior){
		   
		   $SaldoAnterior = $Saldo;
		 ?>
       
          <tr>
                          <td align="left">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="center" valign="top">&nbsp;</td>
                          <td align="center" valign="top">&nbsp;</td>
                          <td align="center" valign="top" bgcolor="#99CCCC">
                          <?php echo number_format($SaldoAnterior,2);?>
                          </td>
                          <td align="center" valign="top" bgcolor="#99CCCC">
                            
					<?php echo number_format($CostoUnitarioAnterior,2);?>
                    
                          
                          
                          </td>
                          <td align="center" valign="top" bgcolor="#99CCCC"> <?php echo number_format($CostoTotalSaldo,2);?></td>
                          <td align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
                          <td align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
                          <td align="center" valign="top" bgcolor="#FFCC66">&nbsp;</td>
                          <td align="center" valign="top" bgcolor="#66CC99">&nbsp;</td>
                          <td align="center" valign="top" bgcolor="#66CC99">&nbsp;</td>
                          <td align="center" valign="top" bgcolor="#66CC99">&nbsp;</td>
              </tr>
              
                
         <?php
		   $MostrarSaldoAnterior = false;
	   }
	   ?>
       
              
              
              
                  <?php
                    if($DatKardex->KdxMovimientoTipo==1  ){
                    ?>
                       
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
                        
                       
						
						/*
						*
						*/
						
							
						$TotalEntradaFiltro += $DatKardex->KdxCantidad;
						$TotalCostoTotalEntradaFiltro += $CostoTotalActual;
						
						//$TotalEntradaCantidadItem += $DatKardex->KdxCantidad;	
						//$TotalCostoTotalEntradaItem += $CostoTotalActual;    
						
						 
                    }
                    ?>
                    
                    <?php
                    if($DatKardex->KdxMovimientoTipo==2){
                    ?>
                       
                        <?php
                        $TotalSalidaGeneral += $DatKardex->KdxCantidad;
                        
                        $CostoActual = $CostoUnitarioAnterior;
                        $CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
            
                        $Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
                        
                        $CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);	
                    
                       
						
						/*
						*
						*/
						
						$TotalSalidaFiltro  += $DatKardex->KdxCantidad;
						$TotalCostoTotalSalidaFiltro += $CostoTotalActual;
						
						
						//$TotalSalidaCantidadItem += $DatKardex->KdxCantidad;
						//$TotalCostoTotalSalidaItem += $CostoTotalActual;
						
                    }
                    ?>
                          
    
             
                <tr>
          <td align="left"><?php echo $j;?></td>
          <td align="left" valign="top">
		  
		  <span title="<?php echo $DatKardex->KdxMovimientoTipo;?>"></span>
		  <?php
    switch($DatKardex->KdxMovimientoTipo){
        case 1:
    ?>
            E
            <?php
            $TotalMovimientoEntradas++;
            //$TotalMontoMovimientoEntradas+=$DatKardex->KdxCantidad;
        break;
        
        case 2:
    ?>
            S
      <?php	
            $TotalMovimientoSalidas++;
            //$TotalMontoMovimientoSalidas+=$DatKardex->KdxCantidad;
        break;
        
        default:
    ?>
            -
      <?php	
        break;
    }
    ?></td>
          <td align="left" valign="top"><?php echo $DatKardex->SucNombre;?></td>
          <td align="left" valign="top"><?php echo $DatKardex->ProCodigoOriginal;?></td>
          <td align="left" valign="top"><?php echo $DatKardex->ProNombre;?></td>
          <td align="left" valign="top">
		  
		  <?php //echo $DatKardex->VmaNombre;?>
          <?php echo $DatKardex->ProMarcaReferencia;?>
          
          </td>
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
                    <a target="_blank" href="principal.php?Mod=TrasladoProducto&Form=Ver&Id=<?php echo $DatKardex->TptId ?>">
                    <?php echo $DatKardex->TptId;?>
                    </a>
            
            <?php		  
                        break;
                            
                        default:
                            
                                                ?>
              <a target="_blank" href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Ver&Id=<?php echo $DatKardex->KdxId ?>">
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
                    <a target="_blank" href="principal.php?Mod=TrasladoProducto&Form=Ver&Id=<?php echo $DatKardex->TptId ?>">
                    <?php echo $DatKardex->TptId;?>
                    </a>
            
            <?php		  
                        break;
                        
                        
                        
                                    case 5:
            ?>
                    <a target="_blank" href="principal.php?Mod=NotaCreditoCompra&Form=Ver&Id=<?php echo $DatKardex->KdxId ?>">
                    <?php echo $DatKardex->KdxId;?>
                    </a>
            
            <?php		  
                            break;
                            
                            default:
                            
                                                ?>
                <a target="_blank" href="principal.php?Mod=AlmacenMovimientoSalida&Form=Ver&Id=<?php echo $DatKardex->KdxId ?>">
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
          <td align="left" valign="top">-</td>
          <td align="left" valign="top">
          
          <?php
          switch($DatKardex->KdxMovimientoTipo){
                case 1:
            ?>
                    
                    
                    
                     <?php
                    switch($DatKardex->KdxMovimientoSubTipo){
                        case 6:
            ?>
                    
                    <?php echo $DatKardex->KdxFecha;?>
            
            <?php		  
                        break;
                            
                        default:
                            
                                                ?>
            
                    <?php echo $DatKardex->KdxComprobanteFecha;?>
            
    <?php	
                        break;
                            
                    }
    ?>
    
    
    
                    
            <?php	
                break;
                
                case 2:
            ?>
                    
                    <?php echo $DatKardex->KdxFecha;?>
                    
            <?php	
                break;
                
                default:
            ?>
                -
            <?php	
                break;
                
          }
          ?>
          
         
          
          </td>
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
          <td align="left" valign="top">[<?php echo $DatKardex->TopCodigo?>] <?php echo $DatKardex->TopNombre?></td>
          <td align="left" valign="top">
          
      <?php echo $DatKardex->KdxTipoMovimiento;?> 
          
          
          </td>
          <td width="60" align="center" valign="top">&nbsp;</td>
          <td width="60" align="center" valign="top">&nbsp;</td>
          <td width="60" align="center" valign="top" bgcolor="#99CCCC">
          
          <!--
          ENTRADA CANT.
          -->
        
        
                  
                    
                    
                          <?php
                    if($DatKardex->KdxMovimientoTipo==1  ){
                    ?>
                        
						<?php echo number_format($DatKardex->KdxCantidad,2);?>
                        
                        <?php
                        //$TotalEntradaGeneral += $DatKardex->KdxCantidad;
//    
//                        $CostoActual = $DatKardex->KdxCostoUnitario;
//                        $CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
//                        
//                        $Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
//                        
//                        if($Primera ){
//                            $CostoUnitarioAnterior = $CostoActual;
//                            $Primera = false;
//                        }else{
//                            $CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
//                        }
//                    
//                        $CostoTotalSaldo = ($CostoUnitarioAnterior * $Saldo);	
//                        
//                        $TotalEntradaCantidadItem += $DatKardex->KdxCantidad;	
                    }
                    ?>
                    
                    
                    
          </td>
                  <td width="72" align="center" valign="top" bgcolor="#99CCCC">
                  
                    <!--
         ENTRADA COSTO UNI.
          -->
          
          
                    <?php
                    if($DatKardex->KdxMovimientoTipo==1  ){
                    ?>
                        <?php echo number_format($DatKardex->KdxCostoUnitario,2)?>
                    <?php
                    
                        $TotalEntradaUnitarioItem += $DatKardex->KdxCostoUnitario;	
                    }
                    ?>
                
                  
          </td>
                  <td width="58" align="center" valign="top" bgcolor="#99CCCC">
                   <!--
        ENTRADA COSTO TOTAL
          -->
                    <?php
                    if($DatKardex->KdxMovimientoTipo==1  ){
                    ?>
                        <?php echo number_format($CostoTotalActual,2)?>
                    <?php
                        $TotalEntradaTotalItem += $CostoTotalActual;	
                    }
                    ?>
                
          </td>
                  <td width="60" align="center" valign="top" bgcolor="#FFCC66">
                  
                     <!--
       SALIDA CANT.
          -->
          
          
                    
                    <?php
                    if($DatKardex->KdxMovimientoTipo==2){
                    ?>
                        <?php echo number_format($DatKardex->KdxCantidad,2);?>
                        <?php
                       // $TotalSalidaGeneral += $DatKardex->KdxCantidad;
//                        
//                        $CostoActual = $CostoUnitarioAnterior;
//                        $CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
//            
//                        $Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
//                        
//                        $CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);	
                        ?>
                    <?php
                    //    $TotalSalidaCantidadItem += $DatKardex->KdxCantidad;	
                    }
                    ?>
                    
                </td>
                  <td width="72" align="center" valign="top" bgcolor="#FFCC66">
                  
                     <!--
      SALIDA COSTO UNI.
          -->
          
                    <?php
                    if($DatKardex->KdxMovimientoTipo==2 ){
                    ?>
                        <?php echo number_format($CostoActual,2)?>
                    <?php
                        $TotalSalidaUnitarioItem += $CostoActual;	
                    }
                    ?>		
            </td>
                  <td width="58" align="center" valign="top" bgcolor="#FFCC66">
                    <!--
    SALIDA COSTO TOTAL
          -->
                    <?php
                    if($DatKardex->KdxMovimientoTipo==2  ){
                    ?>
                        <?php echo number_format($CostoTotalActual,2)?>
                    <?php
                        $TotalSalidaTotalItem += $CostoTotalActual;	
                    }
                    ?>	
          </td>
                <td width="60" align="center" valign="top" bgcolor="#66CC99">
                      <!--
  SALDO CANT.
          -->
          
          
            <?php echo number_format($Saldo,2);?>
                    
                     <?php
                        $TotalSaldoCantidadItem = $Saldo;	
                    ?>	
          </td>
                <td width="72" align="center" valign="top" bgcolor="#66CC99">
                    
					    <!--
 SALDO COSTO UNI.
          -->
          
          
					
					
					
					<?php echo number_format($CostoUnitarioAnterior,2);?>
                    
                    <?php
                    $TotalSaldoUnitarioItem = $CostoUnitarioAnterior;	
                    ?>	
                    
          </td>
                <td width="64" align="center" valign="top" bgcolor="#66CC99">
                
                    
					    <!--
SALDO COSTO TOTAL
          -->
          
          
                <?php echo number_format($CostoTotalSaldo,2);?>
                
                <?php
                    $TotalSaldoTotalItem = $CostoTotalSaldo;	
                    ?>	
                    
                    
                </td>
                </tr>
     
        <?php
        }
        ?>
                    
            


	<?php	
        $j++;
    }
    ?>


<?php
if( $MostratTotales){
?>
    <?php
	
	$TotalEntradaFiltro += $SaldoAnterior;
	
	$TotalSaldoFiltro = $TotalEntradaFiltro - $TotalSalidaFiltro;
	$TotalCostoTotalSaldoFiltro = $TotalCostoTotalEntradaFiltro - $TotalCostoTotalSalidaFiltro;
	
	if($TotalEntradaFiltro>0){
		$TotalCostoUnitarioEntradaFiltro = $TotalCostoTotalEntradaFiltro / $TotalEntradaFiltro;	
	}
	
	if($TotalSalidaFiltro>0){
		$TotalCostoUnitarioSalidaFiltro = $TotalCostoTotalSalidaFiltro / $TotalSalidaFiltro;	
	}
	
	if($TotalSaldoFiltro>0){
		$TotalCostoUnitarioSaldoFiltro = $TotalCostoTotalSaldoFiltro / $TotalSaldoFiltro;	
	}




	
	?>

	        <tr>
	          <td align="left">&nbsp;</td>
	          <td align="left" valign="top">-</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top"><?php echo $DatKardex->ProCodigoOriginal;?></td>
	          <td align="left" valign="top"><?php echo $DatKardex->ProNombre;?></td>
	          <td align="left" valign="top"><?php echo $DatKardex->VmaNombre;?></td>
	          <td align="left" valign="top"><?php echo $DatKardex->RtiNombre;?></td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">-</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">TOTALES:</td>
	          <td align="center" valign="top"><?php
							 if(empty($DatProducto->ProFechaUltimaEntrada) or $DatProducto->ProFechaUltimaEntrada == "0000-00-00" or $DatProducto->ProFechaUltimaEntrada == "00/00/0000"){
								?>
Sin Entradas
  <?php
							 }else{
								?>
  <?php echo $DatProducto->ProFechaUltimaEntrada;?>
  <?php 
							 }
							 ?></td>
	          <td align="center" valign="top"><?php //echo $DatProducto->ProFechaUltimaSalida;?>
                <?php
							 if(empty($DatProducto->ProFechaUltimaSalida) or $DatProducto->ProFechaUltimaSalida == "0000-00-00" or $DatProducto->ProFechaUltimaSalida == "00/00/0000"){
								?>
Sin Salidas
<?php
							 }else{
								?>
<?php echo $DatProducto->ProFechaUltimaSalida;?>
<?php 
							 }
							 ?></td>
	          <td align="center" valign="top">
              
              <?php echo number_format($TotalEntradaFiltro,2);?>
              
              <?php //echo number_format($TotalEntradaCantidadItem,2);?>
              
              </td>
	          <td align="center" valign="top">
              
              <?php echo number_format($TotalCostoUnitarioEntradaFiltro,2);?>
              
               <?php //echo number_format($TotalEntradaUnitarioItem,2);?>
               
               </td>
	          <td align="center" valign="top">
              
              <?php echo number_format($TotalCostoTotalEntradaFiltro,2);?>
              
               <?php //echo number_format($TotalEntradaTotalItem,2);?>
               
              </td>
              
              
              
              
              
              
	          <td align="center" valign="top">
              
               <?php echo number_format($TotalSalidaFiltro,2);?>
               
               <?php //echo number_format($TotalSalidaCantidadItem,2);?>
               
              </td>
	          <td align="center" valign="top">
              
              <?php echo number_format($TotalCostoUnitarioSalidaFiltro,2);?>
              
                <?php //echo number_format($TotalSalidaUnitarioItem,2);?>
              </td>
	          <td align="center" valign="top">
              
              <?php echo number_format($TotalCostoTotalSalidaFiltro,2);?>
              
               <?php //echo number_format($TotalSalidaTotalItem,2);?>
               
              </td>
              
              
              
              
              
              
	          <td align="center" valign="top">
              
               <?php echo number_format($TotalSaldoFiltro,2);?>
               
               <?php //echo number_format($TotalSaldoCantidadItem,2);?>
               
              </td>
	          <td align="center" valign="top">
              
              <?php echo number_format($TotalCostoUnitarioSaldoFiltro,2);?>
              
              <?php //echo number_format($TotalSaldoUnitarioItem,2);?>
              
              </td>
	          <td align="center" valign="top">
              
			  <?php echo number_format($TotalCostoTotalSaldoFiltro,2);?>
              
              <?php //echo number_format($TotalSaldoTotalItem,2);?>
              </td>
	          </tr>
              
 
<?php	
}
?>             
	
<?php
//if($MostrarSaldoAnterior2){
?>

<?php
//}
?>		


<?php
}
?>
              </tbody>
            </table>

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
</body>
</html>

