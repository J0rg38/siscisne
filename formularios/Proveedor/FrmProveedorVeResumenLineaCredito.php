<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<!-- CONTROL DE PRIVILEGIOS -->
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProveedor.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProveedor.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoProveedor.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenCompra.php');


//INSTANCIAS
$InsProveedor = new ClsProveedor();
$InsTipoDocumento = new ClsTipoDocumento();
$InsMoneda = new ClsMoneda();



$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsOrdenCompra = new ClsOrdenCompra();
$InsPagoProveedor = new ClsPagoProveedor();
$InsReporteOrdenCompra = new ClsReporteOrdenCompra();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProveedorEditar.php');
//DATOS
$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResPagoProveedor = $InsPagoProveedor->MtdObtenerPagoProveedores(NULL,NULL,NULL,"PovFecha","DESC","1",3,NULL,NULL,$InsProveedor->MonId,NULL,$InsProveedor->PrvId);
$ArrPagoProveedors = $ResPagoProveedor['Datos'];



$TotalPagoProveedor = 0;
$UltimoPagoProveedorFecha = "";

if(!empty($ArrPagoProveedors)){
	foreach($ArrPagoProveedors as $DatPagoProveedor){
		
		if($DatPagoProveedor->MonId<>$EmpresaMonedaId ){
			$DatPagoProveedor->PovMonto = round($DatPagoProveedor->PovMonto / $DatPagoProveedor->PovTipoCambio,2);
		}
	
		$TotalPagoProveedor = $DatPagoProveedor->PovMonto;
		$UltimoPagoProveedorFecha = $DatPagoProveedor->PovFecha;
		
	}
}

//MtdObtenerReporteOrdenCompra($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oMoneda=NULL,$oOrdenCompraTipo=NULL,$oProveedor=NULL) {
$ResReporteOrdenCompraResumen = $InsReporteOrdenCompra->MtdObtenerReporteOrdenCompra(NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($UltimoPagoProveedorFecha),NULL,NULL,NULL,$GET_MonedaId,NULL,$GET_ProveedorId);
$ArrReporteOrdenCompraResumenes = $ResReporteOrdenCompraResumen['Datos'];

$TotalOrdenCompra = 0;

if(!empty($ArrReporteOrdenCompraResumenes)){
	foreach($ArrReporteOrdenCompraResumenes as $DatReporteOrdenCompraResumen){

		if($DatReporteOrdenCompraResumen->MonId<>$EmpresaMonedaId ){
			$DatReporteOrdenCompraResumen->PcoTotal = round($DatReporteOrdenCompraResumen->PcoTotal / $DatReporteOrdenCompraResumen->PcoTipoCambio,2);
		}
		
		$TotalOrdenCompra += $DatReporteOrdenCompraResumen->PcoTotal;
		
	}
}


$TotalDisponible = $TotalPagoProveedor - $TotalOrdenCompra;

?>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsProveedor->PrvId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
            
            
                        <?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?> 
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        LINEA DE CREDITO DE PROVEEDOR</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProveedor->PrvTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProveedor->PrvTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
         <br />
    
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo Interno:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProveedor->PrvId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tipo de Documento:</td>
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsProveedor->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Numero de Documento:</td>
                  <td align="left" valign="top"><input  name="CmpNumeroDocumento" type="text"  class="EstFormularioCaja" id="CmpNumeroDocumento" value="<?php echo $InsProveedor->PrvNumeroDocumento;?>" size="40" maxlength="50" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombre o Razon Social:</td>
                  <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsProveedor->PrvNombre;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Paterno:</td>
                  <td align="left" valign="top"><input name="CmpApellidoPaterno" type="text" class="EstFormularioCaja" id="CmpApellidoPaterno" value="<?php echo $InsProveedor->PrvApellidoPaterno;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Materno:</td>
                  <td align="left" valign="top"><input name="CmpApellidoMaterno" type="text" class="EstFormularioCaja" id="CmpApellidoMaterno" value="<?php echo $InsProveedor->PrvApellidoMaterno;?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" valign="top"><table class="EstTablaReporte" width="400" border="0" cellpadding="2" cellspacing="2">
                    <thead class="EstTablaReporteHead">
                      </thead>
                    <tbody class="EstTablaReporteBody">
                      
                      
                      <tr>
                        <td width="60%" align="left">(A) Total Pagado:</td>
                        <td width="3%" align="right">:</td>
                        <td width="37%" align="left">
                          <?php echo $InsMoneda->MonSimbolo;?>
                          
                          
                          <?php echo number_format($TotalPagoProveedor,2); ?></td>
                        </tr>
                      
                      <tr>
                        <td align="left">(B) Total de Ordenes de Compra:</td>
                        <td align="right">:</td>
                        <td align="left">
                          
                          <?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalOrdenCompra,2); ?>
                          
                          
                          </td>
                        </tr>
                      <tr>
                        <td align="left">(C) Total Facturado</td>
                        <td align="right">:</td>
                        <td align="left"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalAlmacenMovimientoEntrada,2); ?></td>
                        </tr>
                      <tr>
                        <td align="left">Linea Disponible Real (A-B):</td>
                        <td align="right">&nbsp;</td>
                        <td align="left"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($TotalDisponible,2); ?></td>
                        </tr>
                      </tbody>
                    <tfoot class="EstTablaReporteFoot">
                      </tfoot>
                  </table></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                </table>
              
              </div>
            
            </td>
        </tr>
      </table>
     
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>
	
	
	
    


<?php
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

}else{
	echo ERR_GEN_101;
}
?>