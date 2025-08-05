<?php
session_start();
////PRINCIPALES
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
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"REPORTE_COMPRA_".date('d-m-Y').".xls\";");
}
?>
<html>
<head>

<?php
if($_GET['P']<>2){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 
<?php
}
?>

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php

$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");
//$POST_mon = isset($_POST['CmpMoneda'])?$_POST['CmpMoneda']:$EmpresaMonedaId;
$POST_mon = ($_POST['CmpMoneda']);
$POST_ffi = isset($_POST['CmpFechaFiltro'])?$_POST['CmpFechaFiltro']:"ComFechaEmision";

$POST_ProveedorNombre = $_POST['CmpProveedorNombre'];
$POST_ProveedorId = $_POST['CmpProveedorId'];

$POST_dec = $_POST['CmpDeclarado'];
$POST_imp = $_POST['CmpImpuesto'];

$POST_ord = isset($_POST['CmpOrden'])?$_POST['CmpOrden']:"ComFechaEmision";
$POST_sen = isset($_POST['CmpSentido'])?$_POST['CmpSentido']:"DESC";

$POST_suc = isset($_POST['CmpSucursal'])?$_POST['CmpSucursal']:$_SESSION['SisSucId'];
$POST_mgasto = isset($_POST['CmpMostrarGasto'])?$_POST['CmpMostrarGasto']:2;

require_once($InsPoo->MtdPaqActividad().'ClsCompra.php');
require_once($InsPoo->MtdPaqActividad().'ClsCompraGasto.php');
//require_once($InsPoo->MtdPaqReporte().'ClsReporteCompra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
//$InsReporteCompra = new ClsReporteCompra();

$InsCompra = new ClsCompra();
$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();
$InsSucursal = new ClsSucursal();
$InsCompraGasto = new ClsCompraGasto();
$InsProveedor = new ClsProveedor();

if(empty($POST_ClienteId) and !empty($POST_ClienteNombre)){

	$InsProveedor->MtdIdentificarProveedor("PrvNombre","contiene",$POST_ProveedorNombre,'PrvNombre','ASC','1');
	$POST_ProveedorId = $InsProveedor->PrvId;
	
	if(empty($POST_ProveedorId)){
		die("No se pudo identificar al proveedor.");
	}
}


//MtdObtenerCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'ComId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oEstricto=false,$oFechaFiltro="ComFechaEmision",$oCondicionPago=NULL,$oDeclarado=NULL,$oImpuesto=NULL,$oProveedor=NULL,$oRegimen=NULL)
$ResCompra = $InsCompra->MtdObtenerCompras(NULL,NULL,NULL ,$POST_ord ,$POST_sen,1,NULL,$POST_suc,3,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_mon,true,$POST_ffi,NULL,$POST_dec,$POST_imp,$POST_ProveedorId);
$ArrCompras = $ResCompra['Datos'];

$ResRegimen = $InsRegimen->MtdObtenerRegimenes(NULL,NULL,NULL,"RegNombre","ASC",1,NULL);
$ArrRegimenes = $ResRegimen['Datos'];

$InsMoneda->MonId = $POST_mon;
$InsMoneda = $InsMoneda->MtdObtenerMoneda();

$InsSucursal->SucId = $POST_suc;
$InsSucursal->MtdObtenerSucursal();
?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="271" height="92" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">REPORTE DE COMPRAS
  
  DEL
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
EXPRESADO EN <?php echo $InsMoneda->MonNombre;?> (<?php echo $InsMoneda->MonSimbolo;?>)

EN

    <?php echo $InsSucursal->SucNombre;?>


 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">
        <thead class="EstTablaReporteHead">
        <tr>
          <th width="2%">#</th>
          <th width="6%">COD. COMPRA</th>
          <th width="7%">FEC. INGRESO</th>
          <th width="8%">COMPROB.</th>
          <th width="8%">NUM. COMPROB.</th>
          <th width="8%">FEC. COMPROB.</th>
          <th width="5%">NUM. G. REM.</th>
          <th width="10%">FEC. G. REM.</th>
          <th width="8%">DECLA.</th>
          <th width="8%">FEC. DECLA.</th>
          <th width="8%">R.U.C.</th>
          <th width="17%">PROVEEDOR</th>
          <th width="3%"><span title="Tipo de Cambio">T.C.</span></th>
          <th width="5%">SUB TOTAL</th>
          
          <th width="8%">IMPUESTO</th>
          <th width="5%">EXONERADO</th>
          

            
            
          <th width="5%">TOTAL</th>
          
			<?php
			foreach($ArrRegimenes as $DatRegimen){
			?>
            <th>
				<?php echo strtoupper($DatRegimen->RegNombre);?>
			</th>

			<?php
			}
			?>
            <th>TOTAL REAL</th>
            
           

            
            
          </tr>
        </thead>
        <tbody class="EstTablaReporteBody">
        
        
        <?php
		$SumaCompraSubTotal = 0;
		$SumaCompraImpuesto = 0;
		$SumaCompraTotal = 0;
		$SumaCompraTotalReal = 0;
		$SumaCompraRegimen = array();
		$c=1;
        foreach($ArrCompras as $DatCompra){
        ?>
        <tr class="EstTablaListado"  >
          <td align="right" valign="middle"   ><?php echo $c;?></td>
          <td align="right" valign="middle"   >
		  
          <a href="../../principal.php?Mod=Compra&Form=Ver&Id=<?php echo $DatCompra->ComId;?>" target="_parent">
			 <?php echo $DatCompra->ComId;  ?></a>          </td>
          <td align="right" ><?php echo ($DatCompra->ComFechaEmision);?></td>
          <td align="right" ><?php echo $DatCompra->CtiNombre;  ?></td>
          <td align="right" ><?php echo $DatCompra->ComComprobanteNumero;  ?> </td>
          <td align="right" ><?php echo $DatCompra->ComComprobanteFecha;  ?></td>
          <td align="right" ><?php echo $DatCompra->ComGuiaRemisionNumero;  ?></td>
          <td align="right" >
          <?php echo $DatCompra->ComGuiaRemisionFecha;  ?></td>
          <td align="right" >
		  <?php
				switch($DatCompra->ComDeclarado){
					case 1:
				?>
                Si
                <?php	
					break;
					
					case 2:
				?>
                No
                <?php	
					break;
					
					case 3:
				?>
                 Por Declarar
                <?php	
					break;
					
					case 4:
				?>
				No Declarable
                <?php	
					break;					

				}
				?>
                
                
                
                </td>
          <td align="right" ><?php echo ($DatCompra->ComDeclaradoFecha);?></td>
          <td align="right" ><?php echo ($DatCompra->PrvNumeroDocumento);?></td>
          <td align="right" ><?php echo ($DatCompra->PrvNombre);?></td>
          <td align="right" ><?php echo ($DatCompra->ComTipoCambio);?></td>
        <td align="right" >
		  
			<?php
			$SumaCompraSubTotal += $DatCompra->ComSubTotal;
			?>
			<?php echo number_format($DatCompra->ComSubTotal,2);?>
      
        
		</td>
          <td align="right" >
		  
		  
			<?php
            $SumaCompraImpuesto += $DatCompra->ComImpuesto;
            ?>
			<?php echo number_format($DatCompra->ComImpuesto,2);?>
            
			</td>
			<td align="right" >
			<?php
			$SumaCompraExonerado += $DatCompra->ComMontoExonerado;
			?>
            <?php echo number_format($DatCompra->ComMontoExonerado,2);?>
          </td>
          <td align="right" >
		  
		  
		<?php
		
			$SumaCompraTotal += $DatCompra->ComTotal;
		?>
			<?php echo number_format($DatCompra->ComTotal,2);?>
			</td>
        
			<?php
			foreach($ArrRegimenes as $DatRegimen){
			?>
            <td align="right">
				<?php
				if($DatRegimen->RegId==$DatCompra->RegId){
				?>
					<?php
                    $SumaCompraRegimen[$DatRegimen->RegId] += $DatCompra->ComRegimenMonto;
                    ?>
                    <?php echo number_format($DatCompra->ComRegimenMonto,2);?>
                <?php
				}else{
				?>
                -
                <?php
				}
				?>
			</td>
			<?php
			}
			?>
            
              <td align="right">
			  
			  <?php
	
			$SumaCompraTotalReal += $DatCompra->ComTotalReal;
		?>
                <?php echo number_format($DatCompra->ComTotalReal,2);?>
               
        
        </td>
        



        </tr>
        <?php	
		$c++;
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
            <td align="right">TOTALES:</td>
            <td align="right">&nbsp;</td>
            <td align="right">
                <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> 
                <?php echo number_format($SumaCompraSubTotal,2);?>            
            </td>
            <td align="right">
                <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>  
                <?php echo number_format($SumaCompraImpuesto,2);?>            
            </td>
            <td align="right">
                <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> 
                <?php echo number_format($SumaCompraExonerado,2);?>
            </td>
            <td align="right">
				<span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>  
				<?php echo number_format($SumaCompraTotal,2);?>            
			</td>
           	<?php
			foreach($ArrRegimenes as $DatRegimen){
			?>
			<td align="right">
            	 <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>
                <?php
				echo number_format($SumaCompraRegimen[$DatRegimen->RegId],2);
				?>
			</td>
			<?php
			}
			?>
            <td align="right">
                <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span>
                <?php echo number_format($SumaCompraTotalReal,2);?>
			</td>
		</tr>
		</tbody>
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>