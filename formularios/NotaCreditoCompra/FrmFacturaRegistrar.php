<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php //$PrivilegioRegistrarClientePago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Registrar"))?true:false;?>
<?php //$PrivilegioListadoClientePago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"ClientePago","Listado"))?true:false;?>
<?php $PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("GuiaRemision");?>JsGuiaRemisionAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Regimen");?>JsRegimenFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFactura.css');
</style>

<?php

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_ori = $_GET['Ori'];
$GET_FccId = $_GET['FccId'];
$GET_AmoId = $_GET['AmoId'];
$GET_VcoId = $_GET['VcoId'];

$GET_OvvId = $_GET['OvvId'];

//$POST_id = $_POST['CmpId'];
//$POST_ta = $_POST['CmpTalonario'];
//$POST_do = isset($_POST['CmpDocumento'])?$_POST['CmpDocumento']:$_POST['CmpDocumento2'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFactura.php');
include($InsProyecto->MtdFormulariosMsj("Cliente").'MsjCliente.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');


$InsFactura = new ClsFactura();
$InsFacturaTalonario = new ClsFacturaTalonario();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();
$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaAccion = new ClsFichaAccion();
$InsCotizacionProducto = new ClsCotizacionProducto();
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();

$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

if (!isset($_SESSION['InsFacturaDetalle'.$Identificador])){	
	$_SESSION['InsFacturaDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsFacturaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFacturaRegistrar.php');

//function MtdObtenerCondicionPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResFacturaTalonario = $InsFacturaTalonario->MtdObtenerFacturaTalonarios(NULL,NULL,"FtaNumero","DESC",NULL);
$ArrFacturaTalonarios = $ResFacturaTalonario['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResRegimen = $InsRegimen->MtdObtenerRegimenes(NULL,NULL,NULL,"RegNombre","ASC",NULL);
$ArrRegimenes = $ResRegimen['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
//var ArticuloValidarStock = "1,2";
var ArticuloTipo = "1,2"; 

var Formulario = "FrmRegistrar";

var FacturaDetalleEditar = 1;
var FacturaDetalleEliminar = 1;

$().ready(function() {
/*
Configuracion carga de datos y animacion
*/			
	$('#CmpClienteNombre').focus();
	
	FncFacturaEstablecerMoneda();
	FncFacturaEstablecerCondicionPago();
	FncFacturaEstablecerRegimen();	

	FncFacturaDetalleListar();

	<?php
	if(!empty($_SESSION['SisFtaId']) and empty($POST_id) or !empty($POST_do) ){
	?>
		FncGenerarFacturaId('<?php echo $_SESSION['SisFtaId'];?>');
	<?php
	}
	?>

	//FncClienteEscoger("<?php echo $InsFactura->CliId;?>","<?php echo $InsFactura->CliNumeroDocumento;?>","<?php echo $InsFactura->CliNombre;?>","<?php echo $InsFactura->TdoId;?>");
	
	<?php
	if(!empty($POST_do)){
	?>
		if(confirm("Desea guardar el registro ahora?")){
			$('#Guardar').val("1");
			$('#'+Formulario).submit();
		}
	<?php	 
	}
	?>
	
	<?php
	if($Edito or $Registro){
	?>
		if(confirm("Desea imprimir ahora?")){
			
			FncImprmir("<?php echo $InsFactura->FacId;?>","<?php echo $InsFactura->FtaId;?>");
			
//			var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato A5\n 2 = Formato A4", "1");
//			
//			if(Tipo !== null){
//				switch(Tipo.toUpperCase()){
//					case "1":
//						FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
//					break;
//
//					case "2":
//						FncPopUp('formularios/Factura/FrmFacturaImprimir2.php?Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
//					break;
//				}
//			}
		}
	
	<?php	
	}
	?>
});
</script>



<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >
<input type="hidden" name="CmpCierre" id="CmpCierre" value="<?php echo $InsFactura->FacCierre;?>" />
	
    
<div class="EstCapMenu">
<?php
if($Registro){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFactura->FacId;?>','<?php echo $InsFactura->FtaId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFactura->FacId;?>','<?php echo $InsFactura->FtaId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
	<?php
    /*if($PrivilegioRegistrarClientePago){
    ?>
    <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Factura/FrmFacturaPagar.php?Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagar.png" alt="[Pagar]" title="Registrar Pago"  />Pagar</a></div>           
    <?php
    }*/
    ?>

	<?php
    /*if($PrivilegioListadoClientePago){
    ?>
    <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Factura/FrmFacturaPagoListado.php?Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>           
    <?php
    }*/
    ?>
    
	<?php
    /*if($PrivilegioGenerarGuiaRemision){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncGenerarGuiaRemision();"><img src="imagenes/iconos/guiaremision.png" alt="[Generar Guia Remision]" title="Generar Guia Remision"  />G. Rem.</a></div>   
    <?php
    }*/
    ?>  

<?php
}
?>    
            
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

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
        <td><span class="EstFormularioTitulo">REGISTRAR
        FACTURA</span></td>
      </tr>
      <tr>
        <td width="961">		
        
        
                                                 
          
<ul class="tabs">
	<li><a href="#tab1">Factura</a></li>
	<li><a href="#tab3">Regimen</a></li>
    
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
       <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td width="100%" colspan="2" valign="top">
         
		<div class="EstFormularioArea" >
		
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la factura</span></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="center" valign="top">R.U.C. <?php echo $EmpresaCodigo;?></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="center" valign="top">FACTURA
              
			<input type="hidden" name="Guardar" id="Guardar"  value="" />
			<input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />              </td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="center" valign="top">
              
              <table>
                <tr>
                  <td>
                    <span id="spryselect1">
                      <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span>
                      <label>
                        <select  onchange="FncGenerarFacturaId(this.value);"  class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
                          <option value="">-</option>
                          <?php
			  foreach($ArrFacturaTalonarios as $DatFacturaTalonario){
			  ?>
                          <option <?php if(!empty($InsFactura->FtaId)){ if($InsFactura->FtaId==$DatFacturaTalonario->FtaId){ echo 'selected="selected"';}}elseif($_SESSION['SisFtaId']==$DatFacturaTalonario->FtaId){ 	echo 'selected="selected"';}?> 			  value="<?php echo $DatFacturaTalonario->FtaId;?>" ><?php echo $DatFacturaTalonario->FtaNumero;?></option>
                          <?php
			  }
			  ?>
                          </select>
                        </label>
                      </span>
                    </td>
                  <td>
                    
                    N&deg;.<span id="sprytextfield3">
                      <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span>
                      <label>
                        <input tabindex="1" class="EstFormularioCaja" name="CmpId" type="text" id="CmpId" value="<?php echo $InsFactura->FacId;?>" size="20" maxlength="20"  />
                        </label>
                      </span>
                    </td>
                  <td>
                    <a href="javascript:FncGenerarFacturaId(document.getElementById('CmpTalonario').value);"><img border="0" src="imagenes/recargar.jpg" alt="[Recargar]" title="Recargar" width="18" height="18" align="absmiddle"  /></a>
                    </td>
                  <td>
                    <div id="CapFactura"></div>
                    </td>
                  </tr>
                </table>
</td>
            <td align="left" valign="top"></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Se&ntilde;ores:              </td>
            <td align="left" valign="top"><span id="sprytextfield2">
              <label>
              <input  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="45" maxlength="255" value="<?php echo $InsFactura->CliNombre;?> <?php echo $InsFactura->CliApellidoPaterno;?> <?php echo $InsFactura->CliApellidoMaterno;?>"  <?php echo !empty($InsFactura->CliId)?'readonly="readonly"':'';?> />
              </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span>
       
                <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&width=850" class="thickbox" title="">[...]</a>
                
                
                
               
               
              
         <label></label></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Guia de Remisi&oacute;n:</td>
            <td colspan="2" align="left" valign="top">
              
<!--              
              <select name="CmpGuiaRemision" id="CmpGuiaRemision" class="EstFormularioCombo">
                <option value="">Ninguna</option>
                <?php
                /*
			foreach($ArrGuiaRemisiones as $DatGuiaRemision){
			?>
                <option <?php if($InsFactura->GreId == $DatGuiaRemision->GreId and $InsFactura->GrtId == $DatGuiaRemision->GrtId){ echo 'selected="selected"';}?> value="<?php echo $DatGuiaRemision->GreId;?>#<?php echo $DatGuiaRemision->GrtId;?>"><?php echo $DatGuiaRemision->GrtNumero;?> - <?php echo $DatGuiaRemision->GreId;?></option>
                <?php
			}*/
			?>
                </select>-->
              <input  tabindex="3" maxlength="20" class="EstFormularioCaja" type="text" name="CmpGuiaRemision" id="CmpGuiaRemision" value="<?php  if(!empty($InsFactura->GrtNumero) and !empty($InsFactura->GreId)){ echo $InsFactura->GrtNumero." - ".$InsFactura->GreId; }?>" />
              <input type="hidden" size="5" id="CmpGreId" name="CmpGreId" value="<?php echo $InsFactura->GreId;?>" />
              <input type="hidden" size="5" id="CmpGrtId" name="CmpGrtId" value="<?php echo $InsFactura->GrtId;?>" />
              <input type="hidden" size="5" id="CmpGrtNumero" name="CmpGrtNumero" value="<?php echo $InsFactura->GrtNumero;?>" /></td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">R.U.C. N&deg;:
              
              
              <input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsFactura->CliId;?>" size="3" />
              <input size="3" type="hidden" name="CmpClienteTipoDocumentoId" id="CmpClienteTipoDocumentoId" value="<?php echo $InsFactura->TdoId?>" />
              
              
              </td>
            <td align="left" valign="top">              <label>
              
              
              
              
              
              
              
              
              </label>            
              
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <a href="javascript:FncClienteNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>   
                    </td>
                  <td>
                    <span id="sprytextfield5">
                      <input tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsFactura->CliNumeroDocumento;?>"  <?php echo !empty($InsFactura->CliId)?'readonly="readonly"':'';?>  />
                      <span class="textfieldRequiredMsg">
                        <img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  />              </span><span class="textfieldMinCharsMsg">
                          <img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe haber almenos 11 digitos"  />
                          
                          </span></span>
                    
                    </td>
                  <td>
                    <a href="javascript:FncClienteBuscar('NumeroDocumento');">
                      <img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a>
                    </td>
                  <td>
                  
                  
<a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
                  
                  </a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /> </a></td>
                  <td>
                    <div id="CapClienteBuscar"></div>
                    </td>
                  </tr>
              </table>            </td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Direccion:</td>
            <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsFactura->FacDireccion;?>"  /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td colspan="2" align="left" valign="top"><span id="sprytextfield1">
              <label>
                <input tabindex="6" class="EstFormularioCajaFecha" name="CmpFechaEmision" type="text" id="CmpFechaEmision" value="<?php if(empty($InsFactura->FacFechaEmision)){ echo date("d/m/Y");}else{ echo $InsFactura->FacFechaEmision; }?>" size="15" maxlength="10" />
                </label>
              <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldInvalidFormatMsg">
                
                <img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  />
                
                </span></span> <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFechaEmision" name="BtnFechaEmision" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /> </td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observaci&oacute;n Interna:</td>
            <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacion" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsFactura->FacObservacion);?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
            <td colspan="2" align="left" valign="top"><textarea tabindex="8" name="CmpObservacionImpresa" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo stripslashes($InsFactura->FacObservacionImpresa);?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Incluye Impuesto:</td>
            <td align="left" valign="top">
			
			
<?php
switch($InsFactura->FacIncluyeImpuesto){

	case 1:
		$OpcIncluyeImpuesto1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcIncluyeImpuesto2 = 'selected = "selected"';						
	break;

}
?>
              <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto" <?php if( !empty($InsFactura->VdiId) or !empty($InsFactura->OvvId) or !empty($InsFactura->AmoId) ){ echo 'disabled="disabled"';}?>  >
                <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
              </select>
              
              </td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Impuesto (%):</td>
            <td colspan="2" align="left" valign="top"><span id="sprytextfield4">
                <label>
                  <input onchange="FncFacturaDetalleListar();" name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" value="<?php if(empty($InsFactura->FacPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsFactura->FacPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" />
                  </label>
                <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top">
            
            
            
            
            
            
            <table border="0" cellpadding="0" cellspacing="0">
            <tr>
            <td>
            
            <span id="spryselect3">
            <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsFactura->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select>
            <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span> 
            
            </td>
            <td><div id="CapMonedaBuscar"></div>
            
            
            
            </td>            
            </tr>
            </table>
            
            </td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
            <td colspan="2" align="left" valign="top">
            
            <table>
            <tr>
            <td>
            
            <span id="sprytextfield6">
            <label for="CmpTipoCambio"></label>
            <input  class="EstFormularioCaja" name="CmpTipoCambio" type="text" id="CmpTipoCambio" value="<?php if (empty($InsFactura->FacTipoCambio)){ echo "";}else{ echo $InsFactura->FacTipoCambio; } ?>" size="10" maxlength="10" onchange="FncFacturaDetalleListar();" />
            </span>
            
            </td>
            <td>
            <a href="javascript:FncFacturaEstablecerMoneda();"><img src="imagenes/recargar.jpg" width="20" height="20" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
            </td>
            </tr>
            </table>
            
            
            
            </td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Condicion de Pago:</td>
            <td align="left" valign="top"><span id="spryselect2">
              <select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                <option value="">Escoja una opcion</option>
                <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                <option <?php if($InsFactura->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                <?php  
					}
					?>
                </select>
              <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Cantidad de Dias:</td>
            <td colspan="2" align="left" valign="top">
              
              
              <span id="sprytextfield11">
              <input class="EstFormularioCaja" name="CmpCantidadDia" type="text" id="CmpCantidadDia" size="10" maxlength="3" value="<?php echo $InsFactura->FacCantidadDia;?>" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cancelado:</td>
            <td align="left" valign="top"><?php
			switch($InsFactura->FacCancelado){
				case 1:
					$OpcCancelado1 = 'selected="selected"';
				break;
			
				case 2:
					$OpcCancelado2 = 'selected="selected"';
				break;

			
			}
?>
              <select  class="EstFormularioCombo" id="CmpCancelado" name="CmpCancelado" disabled="disabled">
                <option <?php echo $OpcCancelado1;?> value="1">Si</option>
                <option <?php echo $OpcCancelado2;?> value="2">No</option>
                </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td colspan="2" align="left" valign="top"><?php
			switch($InsFactura->FacEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
	
				case 5:
					$OpcEstado5 = 'selected="selected"';
				break;
				
				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;
				
				case 7:
					$OpcEstado7 = 'selected="selected"';
				break;
			
			}
			?>
              <select tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                <option <?php echo $OpcEstado7;?> value="7">Reservado</option>
                </select></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Obsequio:</td>
            <td align="left" valign="top"><?php
			switch($InsFactura->FacObsequio){
				case 1:
					$OpcObsequio1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcObsequio2 = 'selected="selected"';
				break;
				
			
			}
			?>
              <select tabindex="9" class="EstFormularioCombo" id="CmpObsequio" name="CmpObsequio">
                <option <?php echo $OpcObsequio1;?> value="1">Si</option>
                <option <?php echo $OpcObsequio2;?> value="2">No</option>
                </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">Operacion  sujeta a SPOT:</td>
            <td colspan="2" align="left" valign="top"><?php
			switch($InsFactura->FacSpot){
				case 1:
					$OpcSpot1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcSpot2 = 'selected="selected"';
				break;
				
			}
			?>
              <select tabindex="9" class="EstFormularioCombo" id="CmpSpot" name="CmpSpot">
                <option <?php echo $OpcSpot1;?> value="1">Si</option>
                <option <?php echo $OpcSpot2;?> value="2">No</option>
                </select></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="2" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          </table>
		
        </div>
        
        </td>
       </tr>
       <tr>
         <td colspan="2" valign="top">
         


<div class="EstFormularioArea" >
  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="4">&nbsp;</td>
      <td colspan="8" align="left" valign="top"><span class="EstFormularioSubTitulo">Almacen/Taller: Documentos relacionados </span></td>
      <td width="5">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">Ord. Trabajo:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsFactura->FinId;?>" size="20" maxlength="20" readonly="readonly" />
        <input size="3" type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php echo $InsFactura->FccId;?>" /></td>
      <td align="left" valign="top">Cotizacion:</td>
      <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsFactura->CprId;?>" size="20" maxlength="20" readonly="readonly" /></td>
      <td align="left" valign="top">Orden Venta:</td>
      <td align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsFactura->VdiId;?>" size="20" maxlength="20" readonly="readonly" /></td>
      <td align="left" valign="top">Ficha Salida:</td>
      <td align="left" valign="top"><input name="CmpAlmacenMovimientoSalidaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoSalidaId"  tabindex="3" value="<?php  echo $InsFactura->AmoId;?>" size="20" maxlength="20" readonly="readonly" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="8" align="left" valign="top"><span class="EstFormularioSubTitulo">Vehiculos: Documentos relacionados </span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">Proforma Vehiculo:</td>
      <td align="left" valign="top"><input name="CmpCotizacionVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionVehiculoId"  tabindex="3" value="<?php  echo $InsFactura->CveId;?>" size="20" maxlength="20" readonly="readonly" /></td>
      <td align="left" valign="top">Orden Venta Vehiculo:</td>
      <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsFactura->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
      <td align="left" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="4">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="5">&nbsp;</td>
    </tr>
  </table>
</div>
                                                                
                                                                
         </td>
       </tr>
       <tr>
         <td colspan="2" valign="top">
           <div class="EstFormularioArea">

                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="7"><span class="EstFormularioSubTitulo">ITEMS
                   que componen la FACTURA</span>
                         <input type="hidden" name="CmpFacturaDetalleItem" id="CmpFacturaDetalleItem" />
                         <input type="hidden" name="CmpFacturaDetalleId" id="CmpFacturaDetalleId" />
                         <!--           <input readonly="readonly" name="CmpFacturaDetalleProductoId" type="hidden" class="EstFormularioCaja" id="CmpFacturaDetalleProductoId" size="20" maxlength="10" />
                 -->
                         <input readonly="readonly" name="CmpFacturaDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpFacturaDetalleTiempoCreacion" size="20" maxlength="10" />
                         <input readonly="readonly" name="CmpFacturaDetalleVentaDetalleId" type="hidden" class="EstFormularioCaja" id="CmpFacturaDetalleVentaDetalleId" size="20" maxlength="10" />
                         <input type="hidden" name="CmpArticuloId" id="CmpArticuloId" /></td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>Tipo:</td>
                       <td>Descripcion:</td>
                       <td>U.M.</td>
                       <td>Precio (<span class="EstMonedaSimbolo"><span id="CapMonedaArticuloPrecio"></span></span>):</td>
                       <td>Cantidad:</td>
                       <td>Importe (<span class="EstMonedaSimbolo"><span id="CapMonedaArticuloImporte"></span></span>):</td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>
                         <a href="javascript:FncFacturaDetalleNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><select  class="EstFormularioCombo" name="CmpFacturaDetalleTipo" id="CmpFacturaDetalleTipo">
                        
                         <option value="">-</option>
                         <option value="R">Repuesto</option>
                         <option value="S">Servicio</option>
                         <option value="M">Material</option>
                       
                       </select></td>
                       <td>
                         
                         
                         <input tabindex="11" class="EstFormularioCaja" name="CmpArticuloDescripcion" type="text" id="CmpArticuloDescripcion" size="100"  /></td>
                       <td><input tabindex="10" class="EstFormularioCaja" name="CmpFacturaDetalleUnidadMedida" type="text" id="CmpFacturaDetalleUnidadMedida" size="10" maxlength="10"  /></td>
                       <td><input tabindex="10" class="EstFormularioCaja" name="CmpFacturaDetallePrecio" type="text" id="CmpFacturaDetallePrecio" size="10" maxlength="10"  /></td>
                       <td><input tabindex="10" class="EstFormularioCaja" name="CmpFacturaDetalleCantidad" type="text" id="CmpFacturaDetalleCantidad" size="10" maxlength="10"  /></td>
                       <td><input tabindex="12" class="EstFormularioCaja" name="CmpFacturaDetalleImporte" type="text" id="CmpFacturaDetalleImporte" size="10" maxlength="10"  /></td>
                       <td><a href="javascript:FncFacturaDetalleGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                       </tr>
                     </table>
             </div>                                 </td>
         </tr>
       <tr>
         <td colspan="2" valign="top">
         
         <div class="EstFormularioArea" >
             <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
               <tr>
                 <td width="2%"><input type="hidden" name="CmpFacturaDetalleAccion" id="CmpFacturaDetalleAccion" value="AccFacturaDetalleRegistrar.php" /></td>
                 <td width="48%"><div class="EstFormularioAccion" id="CapFacturaDetalleAccion">Listo
                   para registrar elementos</div></td>
                 <td width="49%"><a href="javascript:FncFacturaDetalleListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncFacturaDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
                 <td width="1%"><div id="CapFacturaDetallesResultado"> </div></td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2"><div id="CapFacturaDetalles" class="EstCapFacturaDetalles" > </div></td>
                 <td>&nbsp;</td>
               </tr>
               </table>
            </div>
            
            </td>
         </tr>
       <?php
	   
	   ?>
       <?php
	   
	   ?>
         </table>

 	</div>


    
    
    <div id="tab3" class="tab_content">
      <!--Content-->
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="97%" valign="top"><div class="EstFormularioArea">
            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>&nbsp;</td>
                <td colspan="7" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del Regimen</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td colspan="3" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Numero del Comprobante:</td>
                <td colspan="3" align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpRegimenComprobanteNumero" type="text" id="CmpRegimenComprobanteNumero" size="20" maxlength="50" value="<?php echo $InsFactura->FacRegimenComprobanteNumero;?>"  /></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">Fecha de Comprobante:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                <td align="left" valign="top"><span id="sprytextfield7">
                <input tabindex="6" class="EstFormularioCajaFecha" name="CmpRegimenComprobanteFecha" type="text" id="CmpRegimenComprobanteFecha" value="<?php echo $InsFactura->FacRegimenComprobanteFecha;?>" size="15" maxlength="10" />
                
                
                
                
                <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span>
                
                
              
            <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /> 
                
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Regimen:</td>
                <td colspan="3" align="left" valign="top"><select class="EstFormularioCombo" name="CmpRegimenId" id="CmpRegimenId">
                  <option value="">Escoja una opcion</option>
                  <?php
			foreach($ArrRegimenes as $DatRegimen){
			?>
                  <option value="<?php echo $DatRegimen->RegId?>" <?php if($InsFactura->RegId==$DatRegimen->RegId){ echo 'selected="selected"';} ?> ><?php echo $DatRegimen->RegNombre?></option>
                  <?php
			}
			?>
                </select></td>
                <td align="left" valign="top"><div id="CapRegimenBuscar"></div></td>
                <td align="left" valign="top">Porcentaje de Regimen:</td>
                <td align="left" valign="top"><span id="sprytextfield8">
                  <label for="label"></label>
                </span><span id="sprytextfield10">
                <label for="label"></label>
                <input  class="EstFormularioCaja" name="CmpRegimenPorcentaje" type="text" id="CmpRegimenPorcentaje" value="<?php if (empty($InsFactura->FacRegimenPorcentaje)){ echo "";}else{ echo $InsFactura->FacRegimenPorcentaje; } ?>" size="10" maxlength="10"  />
                </span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Monto (<span class="EstMonedaSimbolo"> <span id="CapMonedaRegimenMonto"></span></span>):</td>
                <td colspan="3" align="left" valign="top"><input  class="EstFormularioCaja" name="CmpRegimenMonto" type="text" id="CmpRegimenMonto" size="15" maxlength="10" value="<?php if (empty($InsFactura->FacRegimenMonto)){ echo "";}else{ echo number_format($InsFactura->FacRegimenMonto,2); } ?>" /></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td colspan="3" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
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
        <td align="center">&nbsp;</td>
      </tr>
    </table>
	

</div>      
    
  

</form>
<script type="text/javascript"> 

	
	Calendar.setup({ 
	inputField : "CmpComprobanteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnComprobanteFecha"// el id del botón que  
	});
	
	Calendar.setup({ 
	inputField : "CmpFechaEmision",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEmision"// el id del bot&oacute;n que  
	}); 
	


</script>

<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "currency");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {minChars:11});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "none", {isRequired:false});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "integer");
</script>


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

