<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCompraPedidoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenCompra.css');
</style>

<?php

$Registro = false;

$GET_ori = $_GET['Ori'];

$GET_VIN = $_GET['VIN'];
$GET_OrdenTrabajo = $_GET['OrdenTrabajo'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCompra.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

$InsOrdenCompra = new ClsOrdenCompra();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

if (!isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCompraRegistrar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1,NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	//FncMonedaBuscar('Id');
	$('#CmpTipo').focus();
	
	FncOrdenCompraPedidoListar();
	
	FncOrdenCompraEstablecerMoneda();
	
});


/*
Configuracion Formulario
*/
var OrdenCompraPedidoEditar = 1;
var OrdenCompraPedidoEliminar = 2;
var OrdenCompraPedidoVerEstado = 2;

</script>







<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">

<div class="EstCapMenu">


<?php
if($Registro){
?>

	<?php
    /*if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
    
    <?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
    <?php
    if($PrivilegioGenerarExcel){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncGenerarExcel('<?php echo $InsOrdenCompra->OcoId;?>');"><img src="imagenes/iconos/excel.png" alt="[Gen. Excel]" title="Generar archivo de excel" />Excel</a></div> 
    
    <?php	  
    }*/
	?>  

<?php
}
?>    


<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" onsubmit="FncGuardar();" />

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        ORDEN DE COMPRA </span></td>
      </tr>
      <tr>
        <td colspan="2">
          
          
	<ul class="tabs">
        <li><a href="#tab1">Orden de Compra</a></li>


	</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->


<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Orden de Compra 
                        <input type="hidden" name="Guardar" id="Guardar"   />
                        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                      </span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Mes:</td>
                      <td align="left" valign="top"><?php
			switch($InsOrdenCompra->OcoMes){
				case "01":
					$OptMes1 =  'selected="selected"';
				break;
				case "02":
					$OptMes2 =  'selected="selected"';
				break;
				case "03":
					$OptMes3 =  'selected="selected"';
				break;
				case "04":
					$OptMes4 =  'selected="selected"';
				break;
				case "05":
					$OptMes5 =  'selected="selected"';
				break;
				case "06":
					$OptMes6 =  'selected="selected"';
				break;
				case "07":
					$OptMes7 =  'selected="selected"';
				break;				
				case "08":
					$OptMes8 =  'selected="selected"';
				break;
				case "09":
					$OptMes9 =  'selected="selected"';
				break;
				case "10":
					$OptMes10 =  'selected="selected"';
				break;
				case "11":
					$OptMes11 =  'selected="selected"';
				break;	
				case "12":
					$OptMes12 =  'selected="selected"';
				break;	
				default:
					$OptMes1 =  'selected="selected"';
				break;																																					
			}
			?>
                        <label>
                          <select class="EstFormularioCombo" name="CmpMes" id="CmpMes">
                            <option <?php echo $OptMes1;?> value="01">Enero</option>
                            <option <?php echo $OptMes2;?> value="02">Febrero</option>
                            <option <?php echo $OptMes3;?> value="03">Marzo</option>
                            <option <?php echo $OptMes4;?> value="04">Abril</option>
                            <option <?php echo $OptMes5;?> value="05">Mayo</option>
                            <option <?php echo $OptMes6;?> value="06">Junio</option>
                            <option <?php echo $OptMes7;?> value="07">Julio</option>
                            <option <?php echo $OptMes8;?> value="08">Agosto</option>
                            <option <?php echo $OptMes9;?> value="09">Setiembre</option>
                            <option <?php echo $OptMes10;?> value="10">Octubre</option>
                            <option <?php echo $OptMes11;?> value="11">Noviembre</option>
                            <option <?php echo $OptMes12;?> value="12">Diciembre</option>
                            </select>
                        </label></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenCompra->OcoId;?>" size="25" maxlength="25" /></td>
                      <td align="left" valign="top">Tipo:</td>
                      <td align="left" valign="top"><span id="spryselect1">
                        <?php
			switch($InsOrdenCompra->OcoTipo){
				
				case "ZGAR":
					$OcoTipo1 =  'selected="selected"';
				break;
				
				case "ZVOR":
					$OcoTipo2 =  'selected="selected"';
				break;
				
				case "YRUSH":
					$OcoTipo3 =  'selected="selected"';
				break;
				
				case "ZTOOL":
					$OcoTipo4 =  'selected="selected"';
				break;

				case "STK":
					$OcoTipo5 =  'selected="selected"';
				break;
				
				case "ALM":
					$OcoTipo6 =  'selected="selected"';
				break;
				
				case "YPRO":
					$OcoTipo7 =  'selected="selected"';
				break;
				
				case "STX":
					$OcoTipo8 =  'selected="selected"';
				break;
				
				case "YSTK":
					$OcoTipo9 =  'selected="selected"';
				break;
				
				case "YTSK":
					$OcoTipo10 =  'selected="selected"';
				break;

			}
			?><select class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
  <option value="">Escoja una opcion</option>
  <option <?php echo $OcoTipo1;?> value="ZGAR">ZGAR</option>
  <option <?php echo $OcoTipo2;?> value="ZVOR">ZVOR</option>
  <option <?php echo $OcoTipo3;?> value="YRUSH">YRUSH</option>
  <option <?php echo $OcoTipo4;?> value="ZTOOL">ZTOOL</option>
  <option <?php echo $OcoTipo7;?> value="YPRO">YPRO</option>
  <option <?php echo $OcoTipo5;?> value="STK">STK</option>
  <option <?php echo $OcoTipo8;?> value="STX">STX</option>
  <option <?php echo $OcoTipo6;?> value="ALM">ALM</option>
    <option <?php echo $OcoTipo9;?> value="YSTK">YSTK</option>
        <option <?php echo $OcoTipo9;?> value="YSTK">YSTK</option>
           <option <?php echo $OcoTipo10;?> value="YTSK">YTSK</option>
</select>
                        <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Proveedor:
                        <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsOrdenCompra->PrvId;?>" size="3" /></td>
                      <td colspan="3" align="left" valign="top"><table>
                        <tr>
                          <td><select <?php if(!empty($InsOrdenCompra->PrvId)){ echo 'disabled="disabled"';} ?>  class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
                            <option value="">Escoja una opcion</option>
                            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsOrdenCompra->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                            <?php
			}
			?>
                            </select></td>
                          <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input <?php if(!empty($InsOrdenCompra->PrvId)){ echo 'readonly="readonly"';} ?> name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsOrdenCompra->PrvNumeroDocumento;?>" size="15" maxlength="50" /></td>
                          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><span id="sprytextfield5">
                            <label>
                              <input <?php if(!empty($InsOrdenCompra->PrvId)){ echo 'readonly="readonly"';} ?> class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $InsOrdenCompra->PrvNombreCompleto;?>" size="35" maxlength="255"  />
                              </label>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <a href="comunes/Proveedor/FrmProveedorBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                          <td><a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                          </tr>
                        </table></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Fecha:<br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><span id="sprytextfield7">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsOrdenCompra->OcoFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenCompra->OcoFecha; }?>" size="15" maxlength="10" />
                          </label>
                        <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td align="left" valign="top">Hora:<br />
                        <span class="EstFormularioSubEtiqueta">(00:00:00)</span></td>
                      <td align="left" valign="top"><span id="sprytextfield">
                        <label for="CmpHora"></label>
                        <input  class="EstFormularioCaja" name="CmpHora" type="text" id="CmpHora" value="<?php if (empty($InsOrdenCompra->OcoHora)){ echo "";}else{ echo $InsOrdenCompra->OcoHora; } ?>" size="10" maxlength="10" onchange="FncOrdenCompraDetalleListar();" />
                        <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top"> Llegada Estimada:<br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><span id="sprytextfield2">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpFechaLlegadaEstimada" type="text" id="CmpFechaLlegadaEstimada" value="<?php echo $InsOrdenCompra->OcoFechaLlegadaEstimada;?>" size="15" maxlength="10" />
                          </label>
                        <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaLlegadaEstimada" name="BtnFechaLlegadaEstimada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td align="left" valign="top">Marca Ref.:</td>
                      <td align="left" valign="top">
                      
                      <select  class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca">
                  <option value="">Escoja una opcion</option>
                  <?php
				foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
				
				?>
                  <option <?php echo (($InsOrdenCompra->VmaId==$DatVehiculoMarca->VmaId)?'selected="selected"':'');?>  value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
                  <?php	
				}
				?>
                </select>
                
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Incluye Impuesto:</td>
                      <td align="left" valign="top"><?php
switch($InsOrdenCompra->OcoIncluyeImpuesto){

	case 1:
		$OpcIncluyeImpuesto1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcIncluyeImpuesto2 = 'selected = "selected"';						
	break;

}
?>
                        <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  disabled="disabled"  >
                          <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                          <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                        </select></td>
                      <td align="left" valign="top">Impuesto (%):</td>
                      <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta" onchange="FncFacturaDetalleListar();" value="<?php echo $InsOrdenCompra->OcoPorcentajeImpuestoVenta;?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Moneda:</td>
                      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><span id="spryselect2">
                            
                            <select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                              <option value="">Escoja una opcion</option>
                              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                              <?php
			  }
			  ?>
                              </select>
                            <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                          <td><div id="CapMonedaBuscar"></div></td>
                          </tr>
                        </table></td>
                      <td align="left" valign="top">Tipo de Cambio:<br />
                        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                      <td align="left" valign="top">
                        
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>
                              
                              <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncOrdenCompraDetalleListar();" value="<?php if (empty($InsOrdenCompra->OcoTipoCambio)){ echo "";}else{ echo $InsOrdenCompra->OcoTipoCambio; } ?>" size="10" maxlength="10" />
                              </td>
                            <td><a href="javascript:FncOrdenCompraEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                            </tr>
                          </table>
                        
                        </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">VIN:</td>
                      <td align="left" valign="top"><input name="CmpVIN" type="text" class="EstFormularioCaja" id="CmpVIN" value="<?php echo $InsOrdenCompra->OcoVIN;?>" size="20" maxlength="20" /></td>
                      <td align="left" valign="top">Orden de Trabajo:</td>
                      <td align="left" valign="top"><input name="CmpOrdenTrabajo" type="text" class="EstFormularioCaja" id="CmpOrdenTrabajo" value="<?php echo $InsOrdenCompra->OcoOrdenTrabajo;?>" size="20" maxlength="20" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo Dealer:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoDealer" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCodigoDealer" value="<?php echo $InsOrdenCompra->OcoCodigoDealer;?>" size="20" maxlength="20" /></td>
                      <td align="left" valign="top">Estado:</td>
                      <td align="left" valign="top"><?php
					switch($InsOrdenCompra->OcoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						/*case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;*/
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;

						case 31:
							$OpcEstado31 = 'selected = "selected"';						
						break;

						
						case 4:
							$OpcEstado4 = 'selected = "selected"';						
						break;
						
						case 6:
							$OpcEstado6 = 'selected = "selected"';						
						break;
						
						
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                          <option <?php echo $OpcEstado1;?> value="1">En Armado</option>
                          <option <?php echo $OpcEstado3;?> value="3">Enviado</option>
                          <option <?php echo $OpcEstado31;?> value="31">Correo Enviado</option>
                          <option <?php echo $OpcEstado4;?> value="4">Con Entrada</option>                   
                          <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                          
                          </select></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="40" rows="4" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenCompra->OcoObservacion;?></textarea></td>
                      <td align="left" valign="top">Respuesta de Proveedor:</td>
                      <td align="left" valign="top"><textarea name="CmpRespuestaProveedor" cols="40" rows="4" readonly="readonly" class="EstFormularioCajaDeshabilitada" id="CmpRespuestaProveedor"><?php echo $InsOrdenCompra->OcoRespuestaProveedor;?></textarea></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Procesado por Proveedor:</td>
                      <td align="left"><?php
					switch($InsOrdenCompra->OcoProcesadoProveedor){
						case 1:
							$OpcProcesadoProveedor1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcProcesadoProveedor2 = 'selected = "selected"';						
						break;
						
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpProcesadoProveedor" id="CmpProcesadoProveedor" disabled="disabled">
                          <option <?php echo $OpcProcesadoProveedor1;?> value="1">Si</option>
                          <option <?php echo $OpcProcesadoProveedor2;?> value="2">No</option>
                          
                          </select>
                        
                        
                        </td>
                      <td>&nbsp;</td>
                    </tr>
                    </table>
                  </div>     
                </td>
            </tr>
            
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td>&nbsp;</td>
                    <td><input type="hidden" name="CmpOrdenCompraPedidoAccion" id="CmpOrdenCompraPedidoAccion" value="AccOrdenCompraDetalleRegistrar.php" /></td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right"><a href="javascript:FncOrdenCompraPedidoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncOrdenCompraPedidoEliminarTodo();"></a></td>
                    <td width="1%"><div id="CapOrdenCompraPedidosResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapOrdenCompraPedidos" class="EstCapOrdenCompraPedidos" > </div></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div></td>
            </tr>        
          </table>
          
          
    </div>

 

</div>      
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>
	
	
	
  


<!--  -->
  
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
	
	Calendar.setup({ 
	inputField : "CmpFechaLlegadaEstimada",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaLlegadaEstimada"// el id del botón que  
	});
	
	
	
</script>

<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "time");
</script>
<?php

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();


}else{
	echo ERR_GEN_101;
}



if(empty($GET_dia)){

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}



?>
