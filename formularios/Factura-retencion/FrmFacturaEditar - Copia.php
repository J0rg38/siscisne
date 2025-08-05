<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioRegistrarPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar"))?true:false;?>
<?php $PrivilegioListadoPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>
<?php //$PrivilegioGenerarGuiaRemision = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"GuiaRemision","Registrar"))?true:false;?>
<?php //$PrivilegioRegistrarNotaCredito = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"NotaCredito","Registrar"))?true:false;?>
<?php $PrivilegioEditarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarEspecial"))?true:false;?>
<?php $PrivilegioRegistrarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"RegistrarEspecial"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletarv2.js" ></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("GuiaRemision");?>JsGuiaRemisionAutocompletar.js" ></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsAlmacenMovimientoSalidaAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteNotaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Regimen");?>JsRegimenFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaPagoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFacturaAlmacenMovimientoFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFactura.css');
</style>

<?php
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFactura.php');
include($InsProyecto->MtdFormulariosMsj("Cliente").'MsjCliente.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaTalonario.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');


$InsFactura = new ClsFactura();
$InsFacturaTalonario = new ClsFacturaTalonario();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();
$InsUnidadMedida = new ClsUnidadMedida();


if (isset($_SESSION['InsFacturaDetalle'.$Identificador])){	
	$_SESSION['InsFacturaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaDetalle'.$Identificador]);
}

if (isset($_SESSION['InsFacturaAlmacenMovimiento'.$Identificador])){	
	$_SESSION['InsFacturaAlmacenMovimiento'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFacturaAlmacenMovimiento'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFacturaEditar.php');

$ResFacturaTalonario = $InsFacturaTalonario->MtdObtenerFacturaTalonarios(NULL,NULL,"FtaNumero","DESC",NULL,$InsFactura->SucId,true);
$ArrFacturaTalonarios = $ResFacturaTalonario['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResRegimen = $InsRegimen->MtdObtenerRegimenes(NULL,NULL,NULL,"RegNombre","ASC",NULL);
$ArrRegimenes = $ResRegimen['Datos'];

//MtdObtenerUnidadMedidas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'UmeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,NULL);	
$ArrUnidadMedidas = $ResUnidadMedida['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<?php
//if($InsFactura->FacCierre==1 & $InsFactura->FacNotaCredito=="No"){
if($InsFactura->FacCierre==2){
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

var Formulario = "FrmEditar";

var FacturaDetalleEditar = 1;
var FacturaDetalleEliminar = 1;

var FacturaAlmacenMovimientoEliminar = 1;

$(document).ready(function() {
/*
Configuracion carga de datos y animacion
*/	

	$('#CmpClienteNombre').focus();
		
	FncFacturaEstablecerMoneda();
	FncFacturaEstablecerCondicionPago();
	FncFacturaEstablecerRegimen();
					
	//var Tipo = $("input[name='CmpTipo']").val();	
	//alert(Tipo);
	//FncFacturaEstablecerTipo(Tipo);
	
	//setTimeout('FncFacturaEstablecerTipo($("input[name=CmpTipo]").val());',2000);
	
	FncFacturaEstablecerTipo($("input[name=CmpTipo]:checked").val());
	
	//$('input[name=name_of_your_radiobutton]:checked').val();
	
	FncFacturaDetalleListar();
	FncFacturaAlmacenMovimientoListar();
		FncFacturaPagoListar();
	//FncClienteEscoger("<?php echo $InsFactura->CliId;?>","<?php echo $InsFactura->CliNumeroDocumento;?>","<?php echo $InsFactura->CliNombre;?>","<?php echo $InsFactura->TdoId;?>");
	 
	<?php
	if($Edito or $Registro){
	?>
	/*	if(confirm("Desea imprimir ahora?")){

			FncImprmir("<?php echo $InsFactura->FacId;?>","<?php echo $InsFactura->FtaId;?>");

		}*/
		
		dhtmlx.confirm("Desea imprimir ahora?", function(result){
			if(result==true){
				
			  FncImprmir("<?php echo $InsFactura->FacId;?>","<?php echo $InsFactura->FtaId;?>");
			   
			}else{
				
				window.location.href = 'principal.php?Mod=Factura&Form=Listado';
				
			}
		});

	
		<?php	
	}else{
	?>
		FncClienteNotaVerificar();
		
	<?php	
	}
	?>
	
});

</script>




 

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" >
<input type="hidden" name="CmpCierre" id="CmpCierre" value="<?php echo $InsFactura->FacCierre;?>" />
	
    
<div class="EstCapMenu">
<?php
if($Edito){
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
    /*if($PrivilegioGenerarGuiaRemision){
    ?>
	    <div class="EstSubMenuBoton"><a href="javascript:FncGenerarGuiaRemision();"><img src="imagenes/iconos/guiaremision.png" alt="[Generar Guia Remision]" title="Generar Guia Remision"  />G. Rem.</a></div>   
    <?php
    }*/
    ?>  
<?php
}
?>    

<?php
/*if($PrivilegioRegistrarNotaCredito and $InsFactura->FacNotaCredito=="No"){
?>
	<div class="EstSubMenuBoton"><a href="javascript:FncGenerarNotaCredito();"><img src="imagenes/iconos/ncredito.png" alt="[Generar N. Credito]" title="Generar Nota de Credito"  />N. Credito</a></div>
<?php	
}*/
?>

<?php
if($PrivilegioRegistrarPago){
?>
	
<div class="EstSubMenuBoton"><a href="javascript:FncPagoFacturaCargarFormulario('Registrar','<?php echo $InsFactura->FacId;?>','<?php echo $InsFactura->FtaId;?>');" ><img src="imagenes/iconos/pagar.png" alt="[Pagar]" title="Registrar Pago"  />Pagar</a></div>    
<?php
}
?>

<?php
/*if($PrivilegioListadoPago){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncPagoFacturaCargarFormulario('Listado','<?php echo $InsFactura->FacId;?>','<?php echo $InsFactura->FtaId;?>');" ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>   

<?php
}*/
?>

<?php
if($PrivilegioAuditoriaVer){
?>
	<div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsFactura->FacId;?>&Ta=<?php echo $InsFactura->FtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>
<?php
}
?>     


<?php
if(empty($GET_dia) and !empty($InsFactura->VdiId)){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncPagoVentaDirectaCargarFormulario('<?php echo $InsFactura->VdiId;?>');" ><img src="imagenes/submenu/abonos.png" alt="[Abonos]" title="Abonos" border="0"  />Abonos</a></div>&nbsp;

<?php	
}
?>

<?php
if(empty($GET_dia) and !empty($InsFactura->OvvId)){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('<?php echo $InsFactura->OvvId;?>');" ><img src="imagenes/submenu/abonos.png" alt="[Abonos]" title="Abonos" border="0"  />Abonos</a></div>&nbsp;

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
        <td><span class="EstFormularioTitulo">EDITAR 
        FACTURA</span></td>
      </tr>
      <tr>
        <td width="961">		

 		<div class="EstFormularioArea">
         
                <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFactura->FacTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFactura->FacTiempoModificacion;?></span></td>
            <td>&nbsp;</td>
            <td>Creado por: </td>
            <td>
			
			  <span class="EstFormularioDatoRegistro"><?php echo $InsFactura->UsuUsuario;?></span>			</td>
          </tr>
        </table>
        
        </div>   
         <br /> 
		          
<ul class="tabs">
	<li><a href="#tab1">Factura</a></li>

	<li><a href="#tab3">Regimen</a></li>
    <li><a href="#tab4">SUNAT</a></li>
  
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
        

 

	    <table width="100%" border="0" cellpadding="2" cellspacing="2">
                                                          <tr>
                                                            <td colspan="2" valign="top"><div class="EstFormularioArea" >
                                                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                <tr>
                                                                  <td width="4">&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Factura 
                                                                    <input type="hidden" name="Guardar" id="Guardar"  value="" />
                                                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                                                  </span></td>
                                                                  <td width="5">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td width="133" align="left" valign="top">&nbsp;</td>
                                                                  <td width="1" align="left" valign="top">&nbsp;</td>
                                                                  <td width="1" align="left" valign="top">&nbsp;</td>
                                                                  <td colspan="2" align="center" valign="top">
                                                                  
                                                                  <table>
                                                                  <tr>
                                                                    <td><select disabled="disabled" class="EstFormularioCombo" name="CmpTalonario" id="CmpTalonario">
                                                                      <?php
			  foreach($ArrFacturaTalonarios as $DatFacturaTalonario){
			  ?>
                                                                      <option <?php if($InsFactura->FtaId==$DatFacturaTalonario->FtaId){ echo 'selected="selected"';}?> value="<?php echo $DatFacturaTalonario->FtaId;?>" ><?php echo $DatFacturaTalonario->FtaNumero;?> (<?php echo $DatFacturaTalonario->FtaDescripcion;?>)</option>
                                                                      <?php
			  }
			  ?>
                                                                    </select></td>
                                                                  <td>N&deg;.
                                                                    <input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsFactura->FacId;?>" size="20" maxlength="20" readonly="readonly"  /></td>
                                                                  <td>&nbsp;</td>
                                                                  </tr>
                                                                  </table></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Cliente:</td>
                                                                  <td colspan="4" align="left" valign="top">
                                                                    <table>
                                                                      <tr>
                                                                        <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsFactura->CliId;?>" size="3" />
                                                                        <input size="3" type="hidden" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento" value="<?php echo $InsFactura->TdoId?>" /></td>
                                                                        <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                        <td><input tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsFactura->CliNumeroDocumento;?>"  <?php echo !empty($InsFactura->CliId)?'readonly="readonly"':'';?>  /></td>
                                                                        <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                        <td><input  tabindex="2"class="EstFormularioCaja" name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" size="45" maxlength="255" value="<?php echo $InsFactura->CliNombre;?> <?php echo $InsFactura->CliApellidoPaterno;?> <?php echo $InsFactura->CliApellidoMaterno;?>" <?php echo !empty($InsFactura->CliId)?'readonly="readonly"':'';?>/>
                                                                          <input type="hidden" name="CmpClienteApellidoPaterno" id="CmpClienteApellidoPaterno" value="<?php echo $InsFactura->CliApellidoPaterno;?>" size="3" />
                                                                        <input type="hidden" name="CmpClienteApellidoMaterno" id="CmpClienteApellidoMaterno" value="<?php echo $InsFactura->CliApellidoMaterno;?>" size="3" /></td>
                                                                        <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a><a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a></td>
                                                                      </tr>
                                                                    </table>
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Direccion:</td>
                                                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsFactura->FacDireccion;?>"  /></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td width="127" align="left" valign="top">Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                                                  <td width="377" align="left" valign="top"><input name="CmpFechaEmision" type="text" class="EstFormularioCajaFecha" id="CmpFechaEmision" tabindex="6" value="<?php if(empty($InsFactura->FacFechaEmision)){ echo date("d/m/Y");}else{ echo $InsFactura->FacFechaEmision; }?>" size="10" maxlength="10" <?php echo (($PrivilegioEditarEspecial)?'':'readonly="readonly"');?>  /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Email:</td>
                                                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteEmail" type="text" id="CmpClienteEmail" size="45" maxlength="255" value="<?php echo $InsFactura->CliEmail;?>"  /></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Interna:</td>
                                                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsFactura->FacObservacion);?></textarea></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                                                  <td align="left" valign="top"><textarea tabindex="8" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsFactura->FacObservacionImpresa;?></textarea></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Caja:</td>
                                                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacionCaja" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionCaja"><?php echo stripslashes($InsFactura->FacObservacionCaja);?></textarea></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Observado:</td>
                                                                  <td align="left" valign="top"><?php
			switch($InsFactura->FacObservado){
				case 1:
					$OpcObservado1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcObservado2 = 'selected="selected"';
				break;
				
			
			}
			?>
                                                                    <select tabindex="9" class="EstFormularioCombo" id="CmpObservado" name="CmpObservado">
                                                                      <option <?php echo $OpcObservado1;?> value="1">Si</option>
                                                                      <option <?php echo $OpcObservado2;?> value="2">No</option>
                                                                    </select></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Leyenda:<br />
                                                                    <span class="EstFormularioSubEtiqueta">(Transf. Grat., Descts, etc.)</span></td>
                                                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpLeyenda" cols="25" rows="2" class="EstFormularioCaja" id="CmpLeyenda"><?php echo stripslashes($InsFactura->FacLeyenda);?></textarea></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Guia de Remisi&oacute;n:</td>
                                                                  <td align="left" valign="top"><input tabindex="3" maxlength="20" class="EstFormularioCaja" type="text" name="CmpGuiaRemision" id="CmpGuiaRemision" value="<?php  if(!empty($InsFactura->GrtNumero) and !empty($InsFactura->GreId)){ echo $InsFactura->GrtNumero." - ".$InsFactura->GreId; }?>" />
                                                                    <input type="hidden" size="5" id="CmpGreId" name="CmpGreId" value="<?php echo $InsFactura->GreId;?>" />
                                                                    <input type="hidden" size="5" id="CmpGrtId" name="CmpGrtId" value="<?php echo $InsFactura->GrtId;?>" />
                                                                    <input type="hidden" size="5" id="CmpGrtNumero" name="CmpGrtNumero" value="<?php echo $InsFactura->GrtNumero;?>" /></td>
                                                                  <td>&nbsp;</td>
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
                                                                  <td align="left" valign="top">IGV:<br />
                                                                  (%)</td>
                                                                  <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" onchange="FncFacturaDetalleListar();" value="<?php if(empty($InsFactura->FacPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsFactura->FacPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" readonly="readonly" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">ISC:<br />
                                                                  (%)</td>
                                                                  <td align="left" valign="top"><input name="CmpPorcentajeImpuestoSelectivo" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoSelectivo" onchange="FncFacturaDetalleListar();" value="<?php echo $InsFactura->FacPorcentajeImpuestoSelectivo;?>" size="10" maxlength="10" readonly="readonly" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Moneda:</td>
                                                                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                      <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                                                                        <option value="">Escoja una opcion</option>
                                                                        <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                                                                        <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsFactura->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                                                                        <?php
			  }
			  ?>
                                                                      </select></td>
                                                                      <td><div id="CapMonedaBuscar"></div></td>
                                                                    </tr>
                                                                    <tr> </tr>
                                                                  </table></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
                                                                  <td align="left" valign="top">
                                                                  
                                                                  <table>
                                                                  <tr>
                                                                  <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncFacturaDetalleListar();" value="<?php if (empty($InsFactura->FacTipoCambio)){ echo "";}else{ echo $InsFactura->FacTipoCambio; } ?>" size="10" maxlength="10" <?php echo (($PrivilegioEditarEspecial)?'':'readonly="readonly"');?>  /></td>
                                                                  <td>
<a href="javascript:FncFacturaEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>


                                                                  </td>
                                                                  </tr>
                                                                  </table>
                                                                  
                                                                  </td>
                                                                  <td>&nbsp;</td>
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
                                                                    <select  class="EstFormularioCombo" id="CmpCancelado" name="CmpCancelado" >
                                                                      <option <?php echo $OpcCancelado1;?> value="1">Si</option>
                                                                      <option <?php echo $OpcCancelado2;?> value="2">No</option>
                                                                    </select></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
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
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Operacion  sujeta a SPOT:</td>
                                                                  <td align="left" valign="top"><?php
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
                                                                  <td align="left" valign="top">Estado:</td>
                                                                  <td align="left" valign="top"><?php
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
                                                                    <select  tabindex="9" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                                                                      <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                                                                      <option <?php echo $OpcEstado5;?> value="5">Entregado</option>
                                                                      <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                                                                      <option <?php echo $OpcEstado7;?> value="7">Reservado</option>
                                                                    </select></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">CONDICIONES DE VENTA</span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Condicion de Pago:</td>
                                                                  <td align="left" valign="top"><select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                                                                    <option value="">Escoja una opcion</option>
                                                                    <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                                                                    <option <?php if($InsFactura->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                                                                    <?php  
					}
					?>
                                                                  </select></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Cantidad de Dias:</td>
                                                                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCantidadDia" type="text" id="CmpCantidadDia" size="10" maxlength="3" value="<?php echo $InsFactura->FacCantidadDia;?>" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Fecha de Vencimiento:<br />
                                                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                                                  <td align="left" valign="top"><span id="sprytextfield1">
                                                                    <label>
                                                                      <input readonly="readonly" tabindex="6" class="EstFormularioCajaDeshabilitada" name="CmpFechaVencimiento" type="text" id="CmpFechaVencimiento" value="<?php  echo $InsFactura->FacFechaVencimiento;?>" size="10" maxlength="10" />
                                                                    </label>
                                                                  </span> <!--<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaVencimiento" name="BtnFechaVencimiento" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />--></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Descuento:</td>
                                                                  <td align="left" valign="top"><input name="CmpTotalDescuento" type="text" class="EstFormularioCaja" id="CmpTotalDescuento" value="<?php echo $InsFactura->FacTotalDescuento;?>" size="10" maxlength="10" readonly="readonly" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">DOCUMENTOS RELACIONADOS</span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top">Almacen/Taller
                                                                      <input name="CmpAlmacenMovimientoSalidaIdAux" type="hidden" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoSalidaIdAux"  tabindex="3" value="<?php  echo $InsFactura->AmoId;?>" size="20" maxlength="20" readonly="readonly" />
                                                                 </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top">
                                                                    
                                                                    <table>
                                                                      <tr>
                                                                        <td align="left" valign="top" class="EstFormulario">Ord. Trabajo: </td>
                                                                        <td align="left" valign="top" class="EstFormulario"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsFactura->FinId;?>" size="20" maxlength="20" readonly="readonly" />
                                                                          <input size="3" type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php echo $InsFactura->FccId;?>" /></td>
                                                                        <td align="left" valign="top" class="EstFormulario">Cotizacion:</td>
                                                                        <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsFactura->CprId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                        <td align="left" valign="top" class="EstFormulario">Orden Venta:</td>
                                                                        <td width="5" align="left" valign="top" class="EstFormulario"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsFactura->VdiId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                        <td width="5" align="left" valign="top" class="EstFormulario">Abono:</td>
                                                                        <td width="5" align="left" valign="top" class="EstFormulario"><span class="EstFormularioSubTitulo">
                                                                          <input name="CmpPagoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPagoId"  tabindex="3" value="<?php  echo $InsFactura->PagId;?>" size="20" maxlength="20" readonly="readonly" />
                                                                        </span></td>
                                                                      </tr>
                                                                    </table>
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top">Vehiculos</td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top">
                                                                  <table>
                                                                  <tr>
                                                                    <td align="left" valign="top" class="EstFormulario">Proforma Vehiculo:</td>
                                                                    <td align="left" valign="top" class="EstFormulario"><input name="CmpCotizacionVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionVehiculoId"  tabindex="3" value="<?php  echo $InsFactura->CveId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                    <td align="left" valign="top" class="EstFormulario">Orden Venta Vehiculo:</td>
                                                                    <td align="left" valign="top" class="EstFormulario"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsFactura->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                    </tr>
                                                                  </table>
                                                                  
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="6" align="left" valign="top">Usuario/Vendedor</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="6" align="left" valign="top"><table>
                                                                    <tr class="EstFormulario">
                                                                      <td align="left" valign="top">Usuario:</td>
                                                                      <td align="left" valign="top"><input name="CmpUsuario" type="text" class="EstFormularioCajaDeshabilitada" id="CmpUsuario"  tabindex="3" value="<?php  echo $InsFactura->FacUsuario;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                      <td align="left" valign="top">Vendedor:</td>
                                                                      <td align="left" valign="top"><input name="CmpVendedor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVendedor"  tabindex="3" value="<?php  echo $InsFactura->FacVendedor;?>" size="20" maxlength="20" readonly="readonly" />
                                                                        <input type="hidden" name="CmpNumeroPedido" id="CmpNumeroPedido" value="<?php echo $InsFactura->FacNumeroPedido;?>" /></td>
                                                                    </tr>
                                                                  </table></td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">ABONO</span></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2" align="left" valign="top"><input <?php echo (($InsFactura->FacProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar" disabled="disabled" />
Procesar comprobante  <br /><br />   
                                                                  
                                                                 </td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top" bgcolor="#CCFFCC">Monto:</td>
                                                                  <td align="left" valign="top"><input name="CmpAbono" type="text" class="EstFormularioCaja" id="CmpAbono" value="<?php echo number_format($InsFactura->FacAbono,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top"><div id="CapFacturaConcepto" class="EstFormularioArea" >
                                                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2"><span class="EstFormularioSubTitulo">CONCEPTO GENERAL </span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td width="1">&nbsp;</td>
                                                                  <td colspan="2"><textarea name="CmpConcepto" cols="60" rows="4"  id="CmpConcepto" tabindex="11"><?php echo stripslashes($InsFactura->FacConcepto);?></textarea></td>
                                                                  <td width="1">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td width="92">TOTAL:
                                                                    <script type="text/javascript">
tinymce.init({
selector: "textarea#CmpConcepto",
theme: "modern",
menubar : false,
toolbar1: "bold italic | bullist numlist | alignleft | aligncenter | alignright | alignjustify",
width : 600,
height : 140
});
                                                              </script></td>
                                                                  <td width="261"><input tabindex="10" class="EstFormularioCaja" name="CmpTotal" type="text" id="CmpTotal" size="10" maxlength="10" value="<?php echo number_format($InsFactura->FacTotal,2);?>" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td width="88%" valign="top">
                                                            
                                                            <div id="CapFacturaDetalle" class="EstFormularioArea">
                                                          
                                                                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="9"><span class="EstFormularioSubTitulo">Items </span>
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
                                                                      <td align="left">Tipo:</td>
                                                                      <td align="left">Codigo:</td>
                                                                      <td align="left">Descripcion:</td>
                                                                      <td align="left">U.M.</td>
                                                                      <td align="left">Precio:</td>
                                                                      <td align="left">Cant.</td>
                                                                      <td align="left">Desc.:</td>
                                                                      <td align="left">Importe:</td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td><a href="javascript:FncFacturaDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td>
                                                                        
  <select  class="EstFormularioCombo" name="CmpFacturaDetalleTipo" id="CmpFacturaDetalleTipo">
    
  <option value="">-</option>
  <option value="R">Repuesto</option>
  <option value="S">Servicio</option>
  <option value="M">Material</option>
    <option value="T">Texto</option>
    </select>
                                                                        
                                                                      </td>
                                                                      <td><input tabindex="11" class="EstFormularioCaja" name="CmpFacturaDetalleCodigo" type="text" id="CmpFacturaDetalleCodigo" size="10" maxlength="45"   /></td>
                                                                      <td><input tabindex="11" class="EstFormularioCaja" name="CmpFacturaDetalleDescripcion" type="text" id="CmpFacturaDetalleDescripcion" size="45"  /></td>
                                                                      <td><select  class="EstFormularioCombo" name="CmpFacturaDetalleUnidadMedida" id="CmpFacturaDetalleUnidadMedida" >
                                                                        <option value="">Escoja una Opcion</option>
                         <?php
				 if(!empty($ArrUnidadMedidas)){
					 foreach($ArrUnidadMedidas as $DatUnidadMedida){
				?>
                         <option value="<?php echo $DatUnidadMedida->UmeNombre;?>"><?php echo $DatUnidadMedida->UmeNombre;?></option>
                         <?php		 
					 }
				 }
				 ?>
                     </select>
                       
                       
                       
                                                                      
                                                                      </td>
                                                                      <td><input tabindex="10" class="EstFormularioCaja" name="CmpFacturaDetallePrecio" type="text" id="CmpFacturaDetallePrecio" size="5" maxlength="10"  /></td>
                                                                      <td><input tabindex="10" class="EstFormularioCaja" name="CmpFacturaDetalleCantidad" type="text" id="CmpFacturaDetalleCantidad" size="5" maxlength="10"  /></td>
                                                                      <td><input name="CmpFacturaDetalleDescuento" type="text" class="EstFormularioCaja" id="CmpFacturaDetalleDescuento" tabindex="12" size="5" maxlength="10"  /></td>
                                                                      <td><input tabindex="12" class="EstFormularioCaja" name="CmpFacturaDetalleImporte" type="text" id="CmpFacturaDetalleImporte" size="5" maxlength="10"  /></td>
                                                                      <td><a href="javascript:FncFacturaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="8" align="right"><input type="checkbox" name="CmpFacturaDetalleGratuito" id="CmpFacturaDetalleGratuito" value="1" />
Transf. Grat.
  <input type="checkbox" name="CmpFacturaDetalleExonerado" id="CmpFacturaDetalleExonerado" value="1" />
Exon. Imp
<input type="checkbox" name="CmpFacturaDetalleIncluyeSelectivo" id="CmpFacturaDetalleIncluyeSelectivo" value="1" />
Inc. Select. </td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                  </table>
                                                            </div>                                                            </td>
                                                            <td width="12%" valign="top"><div id="CapFacturaDetalle" class="EstFormularioArea">
                                                          
                                                                     <?php
														  if(!empty($InsFactura->OvvId)){
														?>
                                                        
                                                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="2"><span class="EstFormularioSubTitulo">Fichas
                                                                      </span>
                                                                        <input type="hidden" name="CmpFacturaAlmacenMovimientoItem" id="CmpFacturaAlmacenMovimientoItem" />
                                                                        <input type="hidden" name="CmpFacturaAlmacenMovimientoId" id="CmpFacturaAlmacenMovimientoId" />
                                                                        
                                                                        
                                                                        
                                                                        <input type="hidden" name="CmpVehiculoMovimientoId" id="CmpVehiculoMovimientoId" />
                                                                        
                                                                      </td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td>&nbsp;</td>
                                                                      <td>Ficha de Salida:</td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td><a href="javascript:FncFacturaAlmacenMovimientoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td><input name="CmpAlmacenMovimiento" type="text" class="EstFormularioCaja" id="CmpAlmacenMovimiento" tabindex="11" size="20" maxlength="20" readonly="readonly"  /></td>
                                                                      <td><a href="javascript:FncFacturaAlmacenMovimientoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                    </tr>
                                                                  </table>
                                                                  
                                                        <?php	  
														  }else{
															?>
                                                            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="2"><span class="EstFormularioSubTitulo">Fichas
                                                                      </span>
                                                                        <input type="hidden" name="CmpFacturaAlmacenMovimientoItem" id="CmpFacturaAlmacenMovimientoItem" />
                                                                        <input type="hidden" name="CmpFacturaAlmacenMovimientoId" id="CmpFacturaAlmacenMovimientoId" />
                                                                        
                                                                        
                                                                        
                                                                        <input type="hidden" name="CmpAlmacenMovimientoId" id="CmpAlmacenMovimientoId" />
                                                                        
                                                                      </td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td>&nbsp;</td>
                                                                      <td>Ficha de Salida:</td>
                                                                      <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td><a href="javascript:FncFacturaAlmacenMovimientoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td><input name="CmpAlmacenMovimiento" type="text" class="EstFormularioCaja" id="CmpAlmacenMovimiento" tabindex="11" size="20" maxlength="20"  /></td>
                                                                      <td><a href="javascript:FncFacturaAlmacenMovimientoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                    </tr>
                                                                  </table>
                                                            <?php  
														  }
														  ?>
                                                            </div></td>
                                                           </tr>

                                                          <tr>
                                                            <td rowspan="4" valign="top"><div class="EstFormularioArea" >
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                  <tr>
                                                                    <td width="1%">&nbsp;</td>
                                                                    <td width="48%"><div class="EstFormularioAccion" id="CapFacturaDetalleAccion">Listo
                                                                      para registrar elementos</div></td>
                                                                    <td width="50%" align="right"><a href="javascript:FncFacturaDetalleListar();">
                                                                      <input type="hidden" name="CmpFacturaDetalleAccion" id="CmpFacturaDetalleAccion" value="AccFacturaDetalleRegistrar.php" />
                                                                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFacturaDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
                                                                    <td width="1%"><div id="CapFacturaDetallesResultado"> </div></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2"><div id="CapFacturaDetalles" class="EstCapFacturaDetalles" > </div></td>
                                                                    <td>&nbsp;</td>
                                                                  </tr>
                                                                </table>
                                                            </div></td>
                                                            <td valign="top"><div class="EstFormularioArea" >
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                  <tr>
                                                                    <td width="1%">&nbsp;</td>
                                                                    <td width="48%"><div class="EstFormularioAccion" id="CapFacturaAlmacenMovimientoAccion">Listo
                                                                      para registrar elementos</div></td>
                                                                    <td width="50%" align="right"><a href="javascript:FncFacturaAlmacenMovimientoListar();">
                                                                      <input type="hidden" name="CmpFacturaAlmacenMovimientoAccion" id="CmpFacturaAlmacenMovimientoAccion" value="AccFacturaAlmacenMovimientoRegistrar.php" />
                                                                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> 
                                                                    
                                                                    
                                                                   <!-- <a href="javascript:FncFacturaAlmacenMovimientoEliminarTodo();">
                                                                    
                                                                    
                                                                    <img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a>-->
                                                                    
                                                                    
                                                                    </td>
                                                                    <td width="1%"><div id="CapFacturaAlmacenMovimientosResultado"> </div></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2"><div id="CapFacturaAlmacenMovimientos" class="EstCapFacturaAlmacenMovimientos" > </div></td>
                                                                    <td>&nbsp;</td>
                                                                  </tr>
                                                                </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top"><div id="CapFacturaDetalle" class="EstFormularioArea">
                                                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2"><span class="EstFormularioSubTitulo">Abonos Relacionados</span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top"><div class="EstFormularioArea" >
                                                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                <tr>
                                                                  <td width="1%">&nbsp;</td>
                                                                  <td width="48%"><div class="EstFormularioAccion" id="CapFacturaPagoAccion">Listo
                                                                    para registrar elementos</div></td>
                                                                  <td width="50%" align="right"><a href="javascript:FncFacturaPagoListar();">
                                                                    <input type="hidden" name="CmpBoletPagoAccion" id="CmpFacturaPagoAccion" value="AccFacturaPagoRegistrar.php" />
                                                                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                                                                    <!-- <a href="javascript:FncFacturaAlmacenMovimientoEliminarTodo();">
                                                                    
                                                                    
                                                                    <img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a>--></td>
                                                                  <td width="1%"><div id="CapFacturaPagosResultado"> </div></td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2"><div id="CapFacturaPagos" class="EstCapFacturaPagos" > </div></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top">
                                                              
                                                              
                                                              
                                                              
                                                              
                                                            </td>
                                                           </tr>
                                                          
                                                          <tr>
                                                            <td colspan="2" valign="top"><!--<div class="EstFormularioArea" >
                                                              <table width="62%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                <tr>
                                                                  <td width="3%">&nbsp;</td>
                                                                  <td width="97%" align="left"><span class="EstFormularioSubTitulo">Notas de Entrega</span></td>
                                                                </tr>
                                                                <tr>
                                                                  <td height="100">&nbsp;</td>
                                                                  <td align="left" valign="top"><div id="CapNotaEntregas"></div></td>
                                                                </tr>
                                                              </table>
                                                            </div>--></td>
                                                           </tr>
        </table>
 	
    </div>
    
    

    <div id="tab3" class="tab_content">
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="97%" valign="top"><div class="EstFormularioArea">
            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>&nbsp;</td>
                <td colspan="7"><span class="EstFormularioSubTitulo">Datos del Regimen</span></td>
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
                <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
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
                    <span id="sprytextfield3">
                    <label for="label"></label>
                    <input  class="EstFormularioCaja" name="CmpRegimenPorcentaje" type="text" id="CmpRegimenPorcentaje" value="<?php if (empty($InsFactura->FacRegimenPorcentaje)){ echo "";}else{ echo $InsFactura->FacRegimenPorcentaje; } ?>" size="10" maxlength="10"  />
                    </span></span></td>
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
    
    
 <div id="tab4" class="tab_content">
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="97%" valign="top"><div class="EstFormularioArea">
            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>&nbsp;</td>
                <td colspan="6"><span class="EstFormularioSubTitulo">Datos SUNAT</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Numero de Ticket:</td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaTicket" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaTicket" tabindex="5" value="<?php echo $InsFactura->FacSunatRespuestaTicket;?>" size="20" maxlength="50" readonly="readonly"  /></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Fecha de Respuesta:<br />
                  (dd/mm/yyyy)</td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaFecha" tabindex="6" value="<?php echo $InsFactura->FacSunatRespuestaFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td align="left" valign="top">Hora de Respuesta:<br />
(00:00)</td>
                <td align="left" valign="top"><input name="CmpSunatRespuestaHora" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaHora" tabindex="6" value="<?php echo $InsFactura->FacSunatRespuestaHora;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Codigo de Respuesta:<br /></td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaCodigo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaCodigo" tabindex="6" value="<?php echo $InsFactura->FacSunatRespuestaCodigo;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td align="left" valign="top">Descripcion de Respuesta:</td>
                <td align="left" valign="top"><textarea name="CmpSunatRespuestaContenido" cols="45" rows="2" readonly="readonly" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaContenido" tabindex="6"><?php echo $InsFactura->FacSunatRespuestaContenido;?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Estado de Ticket</td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaEstado" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaEstado" tabindex="5" value="<?php echo $InsFactura->FacSunatRespuestaEstado;?>" size="20" maxlength="50" readonly="readonly"  /></td>
                <td align="left" valign="top">Observaciones:</td>
                <td align="left" valign="top"><textarea name="CmpSunatRespuestaObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCajaFecha" id="CmpSunatRespuestaObservacion" tabindex="6"><?php echo $InsFactura->FacSunatRespuestaObservacion;?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
	

	
	<?php
	if($PrivilegioEditarEspecial){
	?>
	
			Calendar.setup({ 
	inputField : "CmpFechaEmision",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEmision",// el id del bot&oacute;n que  
	onUpdate	:    FncFacturaCalcularFechaVencimiento
	}); 
	
		
<?php
	}
?>
	
	/*	Calendar.setup({ 
	inputField : "CmpFechaVencimiento",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaVencimiento"// el id del bot&oacute;n que  
	}); */
	



	
</script>


<?php
}elseif(($InsFactura->FacCierre==2)){
	echo ERR_FAC_401;
}elseif($InsFactura->FacNotaCredito=="Si"){
	echo ERR_FAC_403;
}

/*}elseif(!empty($InsFactura->FacCierre)){
	echo ERR_FAC_401;
}else{
	echo ERR_FAC_403;
}
*/?>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
