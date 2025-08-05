<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioAuditoriaVer = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Auditoria","Ver"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioRegistrarPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar"))?true:false;?>
<?php $PrivilegioListadoPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>
<?php $PrivilegioEditarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"EditarEspecial"))?true:false;?>
<?php $PrivilegioRegistrarEspecial = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"RegistrarEspecial"))?true:false;?>

<?php //$PrivilegioRegistrarPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Registrar"))?true:false;?>
<?php //$PrivilegioListadoPago = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Pago","Listado"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletarv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteNotaFunciones.js" ></script>

<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteAutocompletar.js" ></script>-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Moneda");?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Regimen");?>JsRegimenFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsAlmacenMovimientoSalidaAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Documento");?>JsVehiculoMovimientoSalidaAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoletaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoletaDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoletaPagoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsBoletaAlmacenMovimientoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssBoleta.css');
</style>
<?php
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
 
$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];


include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjBoleta.php');
include($InsProyecto->MtdFormulariosMsj("Cliente").'MsjCliente.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsRegimen.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');


$InsBoleta = new ClsBoleta();
$InsBoletaTalonario = new ClsBoletaTalonario();
$InsTipoDocumento = new ClsTipoDocumento();
$InsCondicionPago = new ClsCondicionPago();
$InsMoneda = new ClsMoneda();
$InsRegimen = new ClsRegimen();

if (isset($_SESSION['InsBoletaDetalle'.$Identificador])){	
	$_SESSION['InsBoletaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsBoletaDetalle'.$Identificador]);
}
	
if (isset($_SESSION['InsBoletaAlmacenMovimiento'.$Identificador])){	
	$_SESSION['InsBoletaAlmacenMovimiento'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsBoletaAlmacenMovimiento'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccBoletaEditar.php');

$ResBoletaTalonario = $InsBoletaTalonario->MtdObtenerBoletaTalonarios(NULL,NULL,"BtaNumero","DESC",NULL,$InsBoleta->SucId,true);
$ArrBoletaTalonarios = $ResBoletaTalonario['Datos'];



$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$ResRegimen = $InsRegimen->MtdObtenerRegimenes(NULL,NULL,NULL,"RegNombre","ASC",NULL);
$ArrRegimenes = $ResRegimen['Datos'];

?>

<?php
if($InsBoleta->BolCierre==1){
?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";
var BoletaDetalleEditar = 1;
var BoletaDetalleEliminar = 1;

var BoletaAlmacenMovimientoEliminar = 1;

$().ready(function() {

/*
Configuracion carga de datos y animacion
*/		

	$('#CmpClienteNombre').focus();
	
	FncBoletaEstablecerMoneda();
	FncBoletaEstablecerCondicionPago();
	FncBoletaEstablecerRegimen();		
		
	FncBoletaDetalleListar();
	
	FncBoletaAlmacenMovimientoListar();
		
	FncBoletaPagoListar();
	

	//FncClienteEscoger("<?php echo $InsBoleta->CliId;?>","<?php echo $InsBoleta->CliNumeroDocumento;?>","<?php echo $InsBoleta->CliNombre;?>","<?php echo $InsBoleta->TdoId;?>");

	<?php
	if($Edito or $Registro){
	?>
		/*if(confirm("Desea imprimir ahora?")){
			
			
			
		}*/
		
		
		dhtmlx.confirm("Desea imprimir ahora?", function(result){
			if(result==true){
				
			FncImprmir("<?php echo $InsBoleta->BolId;?>","<?php echo $InsBoleta->BtaId;?>","<?php echo ($InsBoleta->BtaNumero=="200")?'2':'1';?>");
			   
			}else{
				
				window.location.href = 'principal.php?Mod=Boleta&Form=Listado';
				
			}
		});
		
	<?php	
	}else if(!empty($InsBoleta->CliId)){
	?>
		FncClienteNotaVerificar();
		
	<?php	
	}
	?>

});
</script>





<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >
<input type="hidden" name="CmpCierre" id="CmpCierre" value="<?php echo $InsBoleta->BolCierre;?>" />
	
<div class="EstCapMenu">
			<?php
			if($Edito){
			?>
            
			<?php
			if($PrivilegioVistaPreliminar){
			?>
 
  <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsBoleta->BolId;?>','<?php echo $InsBoleta->BtaId;?>','<?php echo ($InsBoleta->BtaNumero=="200")?'2':'1';?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>


        	<?php
			}
			?>
        
        	<?php
			if($PrivilegioImprimir){
			?>        
  
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsBoleta->BolId;?>','<?php echo $InsBoleta->BtaId;?>','<?php echo ($InsBoleta->BtaNumero=="200")?'2':'1';?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>


   
   
              
			<?php
			}
			?>    
			<?php
			}
			?>   
            
 
<?php
/*if($PrivilegioRegistrarPago){
?>
 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Boleta/FrmBoletaPagar.php?Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagar.png" alt="[Pagar]" title="Registrar Pago"  />Pagar</a></div>           
<?php
}*/
?>
      
      
      <?php
/*if($PrivilegioListadoPago){
?>
 <div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Boleta/FrmBoletaPagoListado.php?Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>           
<?php
}*/
?>   
<?php
if($PrivilegioRegistrarPago){
?>
	
<div class="EstSubMenuBoton"><a href="javascript:FncPagoBoletaCargarFormulario('Registrar','<?php echo $InsBoleta->BolId;?>','<?php echo $InsBoleta->BtaId;?>');" ><img src="imagenes/iconos/pagar.png" alt="[Pagar]" title="Registrar Pago"  />Pagar</a></div>    
<?php
}
?>

<?php
/*if($PrivilegioListadoPago){
?>

<div class="EstSubMenuBoton"><a href="javascript:FncPagoBoletaCargarFormulario('Listado','<?php echo $InsBoleta->BolId;?>','<?php echo $InsBoleta->BtaId;?>');" ><img src="imagenes/iconos/pagos.png" alt="[Pagos]" title="Listar Pagos"  />Pagos</a></div>   

<?php
}*/
?>


<?php
if($PrivilegioAuditoriaVer){
?>
<div class="EstSubMenuBoton"><a href="<?php echo $InsProyecto->MtdRutFormularios();?>Auditoria/FrmAuditoriaListado.php?Id=<?php echo $InsBoleta->BolId;?>&Ta=<?php echo $InsBoleta->BtaId;?>&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=850&modal=true" class="thickbox"  ><img src="imagenes/auditoria.png" alt="[Auditar]"  border="0" title="Auditar" />Auditar</a></div>  
<?php
}
?>   

	
<?php
if(empty($GET_dia) and !empty($InsBoleta->VdiId)){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncPagoVentaDirectaCargarFormulario('<?php echo $InsBoleta->VdiId;?>');" ><img src="imagenes/submenu/abonos.png" alt="[Abonos]" title="Abonos" border="0"  />Abonos</a></div>&nbsp;

<?php	
}
?>

<?php
if(empty($GET_dia) and !empty($InsBoleta->OvvId)){
?>
<div class="EstSubMenuBoton"><a href="javascript:FncPagoOrdenVentaVehiculoCargarFormulario('<?php echo $InsBoleta->OvvId;?>');" ><img src="imagenes/submenu/abonos.png" alt="[Abonos]" title="Abonos" border="0"  />Abonos</a></div>&nbsp;

<?php	
}
?>


            
            <input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" >

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
        <td width="961" height="25"><span class="EstFormularioTitulo">EDITAR BOLETA</span></td>
      </tr>
      <tr>
        <td>	
        
                     
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsBoleta->BolTiempoCreacion;?></span></td>
            <td></td>
			<td>Modificado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsBoleta->BolTiempoModificacion;?></span></td>
			<td></td>
			<td>Creado por:</td>
			<td><span class="EstFormularioDatoRegistro"><?php echo $InsBoleta->UsuUsuario;?></span></td>
          </tr>
        </table>
		</div>                                
        
        
 <br />
 
 
 <ul class="tabs">
	<li><a href="#tab1">Boleta</a></li>
    <li><a href="#tab2">Regimen</a></li>
    <li><a href="#tab4">Sunat</a></li>
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->   
	
       
<table width="100%" border="0" cellpadding="2" cellspacing="2">
                                                          <tr>
                                                            <td colspan="2" valign="top"><div class="EstFormularioArea" >
                                                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5"><span class="EstFormularioSubTitulo"> Datos de la boleta
                                                                    <input type="hidden" name="Guardar" id="Guardar"  value="" />
                                                                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                                                                  </span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2" align="center" valign="bottom">
                                                                  
                                                                  <table border="0" cellpadding="0" cellspacing="0">
                                                                  <tr>
                                                                  <td>
                                                                  
                                                                  <input name="CmpTalonario" id="CmpTalonario" type="hidden" value="<?php echo $InsBoleta->BtaId;?>" />
                                                                    <select disabled="disabled" class="EstFormularioCombo" name="CmpTalonario2" id="CmpTalonario2">
                                                                      <?php

			  foreach($ArrBoletaTalonarios as $DatBoletaTalonario){
			  ?>
                                                                      <option <?php if($InsBoleta->BtaId==$DatBoletaTalonario->BtaId){ echo 'selected="selected"';}?> value="<?php echo $DatBoletaTalonario->BtaId;?>" ><?php echo $DatBoletaTalonario->BtaNumero;?>   (<?php echo $DatBoletaTalonario->BtaDescripcion;?>)</option>
                                                                      <?php
			  }
			  ?>
                                                                  </select>
                                                                  
                                                                  </td>
                                                                  <td>
                                                                  
                                                                  N&deg;.
                                                                  <input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsBoleta->BolId;?>" size="20" maxlength="20" readonly="readonly"  />
                                                                  
                                                                  </td>
                                                                  <td>
                                                                  
                                                                  
                                                                  </td>
                                                                  </tr>
                                                                  </table>
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Cliente:</td>
                                                                  <td colspan="4" align="left" valign="top">
                                                                    <table>
                                                                      <tr>
                                                                        <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsBoleta->CliId;?>" /></td>
                                                                        <td><select class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento" disabled="disabled" >
                                                                          
                                                                          <option value="">Escoja una opcion</option>                                                                  
                                                                          <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento ){
			?>
                                                                          <option <?php if($InsBoleta->TdoId==$DatTipoDocumento->TdoId){ echo 'selected="selected"';}?> value="<?php echo $DatTipoDocumento->TdoId; ?>">[<?php echo $DatTipoDocumento->TdoCodigo; ?>] <?php echo $DatTipoDocumento->TdoNombre; ?></option>
                                                                          
                                                                          
                                                                          
                                                                          <?php
			}			
			?>
                                                                        </select></td>
                                                                        <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                        <td><input  tabindex="3" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsBoleta->CliNumeroDocumento;?>"  <?php echo !empty($InsBoleta->CliId)?'readonly="readonly"':'';?> /></td>
                                                                        <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                        <td><span id="sprytextfield2">
                                                                        <label>
                                                                          <input tabindex="2" class="EstFormularioCaja" name= "CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" size="45" maxlength="255" value="<?php echo $InsBoleta->CliNombre;?> <?php echo $InsBoleta->CliApellidoPaterno;?> <?php echo $InsBoleta->CliApellidoMaterno;?>" <?php echo !empty($InsBoleta->CliId)?'readonly="readonly"':'';?>  />
                                                                        </label>
                                                                        
<input type="hidden" name="CmpClienteNombre" id="CmpClienteNombre" value="<?php echo $InsBoleta->CliNombre;?>" />
<input type="hidden" name="CmpClienteApellidoPaterno" id="CmpClienteApellidoPaterno" value="<?php echo $InsBoleta->CliApellidoPaterno;?>" />
<input type="hidden" name="CmpClienteApellidoMaterno" id="CmpClienteApellidoMaterno" value="<?php echo $InsBoleta->CliApellidoMaterno;?>" />



                                                                        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                                                                        <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a><a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" alt="" width="25" height="25" border="0" align="absmiddle" /></a></td>
                                                                        <td>&nbsp;</td>
                                                                      </tr>
                                                                    </table>    
                                                                    
                                                                    <?php
if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario)){
	foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
		if($DatOrdenVentaVehiculoPropietario->CliId<>$InsBoleta->CliId){
			
			echo $DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
			echo "<br>";
		}
	}
}
?>

                                                              
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Direcci&oacute;n:</td>
                                                                  <td align="left" valign="top"><input tabindex="4" class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" size="45" maxlength="255" value="<?php echo $InsBoleta->BolDireccion;?>"  /></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Fecha de Emisi&oacute;n:<br /><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                                                  <td align="left" valign="top">
                                                                  <input name="CmpFechaEmision" type="text" class="EstFormularioCajaFecha" id="CmpFechaEmision" tabindex="5" value="<?php if(empty($InsBoleta->BolFechaEmision)){ echo date("d/m/Y");}else{ echo $InsBoleta->BolFechaEmision; }?>" size="15" maxlength="10" <?php echo (($PrivilegioEditarEspecial)?'':'readonly="readonly"');?>  />
                                                                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEmision" name="BtnFechaEmision" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Email:</td>
                                                                  <td align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpClienteEmail" type="text" id="CmpClienteEmail" size="45" maxlength="255" value="<?php echo $InsBoleta->CliEmail;?>"  /></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Interna:</td>
                                                                  <td align="left" valign="top"><textarea  tabindex="6" name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsBoleta->BolObservacion;?></textarea></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Impresa:</td>
                                                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsBoleta->BolObservacionImpresa;?></textarea></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Observaci&oacute;n Caja:</td>
                                                                  <td align="left" valign="top"><textarea  tabindex="6" name="CmpObservacionCaja" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionCaja"><?php echo $InsBoleta->BolObservacionCaja;?></textarea></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Observado:</td>
                                                                  <td align="left" valign="top"><?php
			switch($InsBoleta->BolObservado){
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
                                                                  <td align="left" valign="top"><textarea tabindex="7" name="CmpLeyenda" cols="25" rows="2" class="EstFormularioCaja" id="CmpLeyenda"><?php echo stripslashes($InsBoleta->BolLeyenda);?></textarea></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">IGV:<br />
                                                                    (%)</td>
                                                                  <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta" value="<?php if(empty($InsBoleta->BolPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsBoleta->BolPorcentajeImpuestoVenta;}?>" size="10" maxlength="10" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">ISC:<br />
                                                                    (%)</td>
                                                                  <td align="left" valign="top"><input onchange="FncBoletaDetalleListar();" name="CmpPorcentajeImpuestoSelectivo" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoSelectivo" value="<?php echo $InsBoleta->BolPorcentajeImpuestoSelectivo;?>" size="10" maxlength="10" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Moneda:</td>
                                                                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                      <td><span id="spryselect3">
                                                                        <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                                                                          <option value="">Escoja una opcion</option>
                                                                          <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                                                                          <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsBoleta->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                                                                          <?php
			  }
			  ?>
                                                                        </select>
                                                                        <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                                                                      <td><div id="CapMonedaBuscar"></div></td>
                                                                    </tr>
                                                                    <tr> </tr>
                                                                  </table></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Tipo de Cambio:<br /><span class="EstFormularioSubEtiqueta">(0.000)</span></td>
                                                                  <td align="left" valign="top">
                                                                  

<table>
<tr>
<td>
                                                                  <span id="sprytextfield6">
                                                                  <label for="CmpTipoCambio"></label>
                                                                  <input name="CmpTipoCambio" type="text"  class="EstFormularioCaja" id="CmpTipoCambio" onchange="FncBoletaDetalleListar();" value="<?php if (empty($InsBoleta->BolTipoCambio)){ echo "";}else{ echo $InsBoleta->BolTipoCambio; } ?>" size="10" maxlength="10" <?php echo (($PrivilegioEditarEspecial)?'':'readonly="readonly"');?>  />
                                                                  </span>
</td>
<td>

<a href="javascript:FncBoletaEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>

</td>
</tr>
</table>                                                              
                                                                  
                                                                  </td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                
                                                                 <tr>
                                                                   <td>&nbsp;</td>
                                                                   <td>Cancelado:</td>
                                                                   <td><?php
			switch($InsBoleta->BolCancelado){
				case 1:
					$OpcCancelado1 = 'selected="selected"';
				break;
			
				case 2:
					$OpcCancelado2 = 'selected="selected"';
				break;

			
			}
?>
                                                                     <select  disabled="disabled" class="EstFormularioCombo" id="CmpCancelado" name="CmpCancelado">
                                                                       <option <?php echo $OpcCancelado1;?> value="1">Si</option>
                                                                       <option <?php echo $OpcCancelado2;?> value="2">No</option>
                                                                     </select></td>
                                                                   <td align="left" valign="top">&nbsp;</td>
                                                                   <td align="left" valign="top">Obsequio:</td>
                                                                   <td align="left" valign="top"><?php
			switch($InsBoleta->BolObsequio){
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
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Estado:</td>
                                                                  <td align="left" valign="top"><?php
			switch($InsBoleta->BolEstado){
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
                                                                    <select tabindex="8" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
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
                                                                  <td align="left" valign="top"><span id="spryselect2">
                                                                  <select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                                                                    <option value="">Escoja una opcion</option>
                                                                    <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                                                                    <option <?php if($InsBoleta->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                                                                    <?php  
					}
					?>
                                                                  </select>
                                                                  <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Cantidad de Dias:</td>
                                                                  <td align="left" valign="top"><span id="sprytextfield11">
                                                                  <input class="EstFormularioCaja" name="CmpCantidadDia" type="text" id="CmpCantidadDia" size="10" maxlength="3" value="<?php echo $InsBoleta->BolCantidadDia;?>" />
                                                                  <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td align="left" valign="top">Fecha de Vencimiento:<br />
                                                                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                                                  <td align="left" valign="top"><span id="sprytextfield1">
                                                                    <label>
                                                                      <input readonly="readonly" tabindex="6" class="EstFormularioCajaDeshabilitada" name="CmpFechaVencimiento" type="text" id="CmpFechaVencimiento" value="<?php  echo $InsBoleta->BolFechaVencimiento;?>" size="10" maxlength="10" />
                                                                    </label>
                                                                    </span>
                                                                    <!--<img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaVencimiento" name="BtnFechaVencimiento" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />--></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Descuento:</td>
                                                                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpTotalDescuento" type="text" id="CmpTotalDescuento" size="10" maxlength="10" value="<?php echo number_format($InsBoleta->BolTotalDescuento,2);?>" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">DOCUMENTOS RELACIONADOS</span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top">Almacen/Taller<span class="EstFormularioSubTitulo">
                                                                    <input name="CmpAlmacenMovimientoSalidaIdAux" type="hidden" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoSalidaIdAux"  tabindex="3" value="<?php  echo $InsBoleta->AmoId;?>" size="20" maxlength="20" readonly="readonly" />
                                                                  <input type="hidden" name="CmpArticuloId2" id="CmpArticuloId2" />
                                                                  </span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top"><table>
                                                                    <tr class="EstFormulario">
                                                                      <td align="left" valign="top">Ord. Trabajo:</td>
                                                                      <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsBoleta->FinId;?>" size="20" maxlength="20" readonly="readonly" />
                                                                      <input type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php echo $InsBoleta->FccId;?>" /></td>
                                                                      <td align="left" valign="top">Cotizacion:</td>
                                                                      <td align="left" valign="top"><input name="CmpCotizacionProductoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionProductoId"  tabindex="3" value="<?php  echo $InsBoleta->CprId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                      <td align="left" valign="top">Orden Venta:</td>
                                                                      <td width="5" align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsBoleta->VdiId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                      <td width="5" align="left" valign="top">Abono:</td>
                                                                      <td width="5" align="left" valign="top"><span class="EstFormularioSubTitulo">
                                                                        <input name="CmpPagoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPagoId"  tabindex="3" value="<?php  echo $InsBoleta->PagId;?>" size="20" maxlength="20" readonly="readonly" />
                                                                      </span></td>
                                                                      <td width="5" align="left" valign="top">&nbsp;</td>
                                                                      <td width="5" align="left" valign="top">&nbsp;</td>
                                                                    </tr>
                 </table></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top">Vehiculos</td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="5" align="left" valign="top"><table>
                                                                    <tr class="EstFormulario">
                                                                      <td align="left" valign="top">Proforma Vehiculo:</td>
                                                                      <td align="left" valign="top"><input name="CmpCotizacionVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionVehiculoId"  tabindex="3" value="<?php  echo $InsBoleta->CveId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                      <td align="left" valign="top">Orden Venta Vehiculo:</td>
                                                                      <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsBoleta->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                    </tr>
                 </table></td>
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
                                                                      <td align="left" valign="top"><input name="CmpUsuario" type="text" class="EstFormularioCajaDeshabilitada" id="CmpUsuario"  tabindex="3" value="<?php  echo $InsBoleta->BolUsuario;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                                                      <td align="left" valign="top">Vendedor:</td>
                                                                      <td align="left" valign="top"><input name="CmpVendedor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVendedor"  tabindex="3" value="<?php  echo $InsBoleta->BolVendedor;?>" size="20" maxlength="20" readonly="readonly" />
                                                                        <input type="hidden" name="CmpNumeroPedido" id="CmpNumeroPedido" value="<?php echo $InsBoleta->BolNumeroPedido;?>" /></td>
                                                                    </tr>
                                                                  </table></td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">ABONO</span></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2" align="left" valign="top"><!--<input <?php echo (($InsBoleta->BolProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar"  disabled="disabled" />
                                                                    Procesar comprobante <br />
  <input <?php echo (($InsBoleta->BolEnviarSUNAT==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpEnviarSUNAT" id="CmpEnviarSUNAT" disabled="disabled" />
                                                                  Enviar a SUNAT &nbsp; -->
                                                                  
     <!--                                                             <input <?php echo (($InsBoleta->BolNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
Notificar via email <br />-->

<input disabled="disabled" <?php echo (($InsBoleta->BolProcesar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpProcesar" id="CmpProcesar" />
Procesar comprobante  <br />

<!--<input disabled="disabled" <?php echo (($InsBoleta->BolEnviarSUNAT==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpEnviarSUNAT" id="CmpEnviarSUNAT" />
Enviar a SUNAT <br />   -->



</td>
                                                                  <td align="left" valign="top">&nbsp;</td>
                                                                  <td align="left" valign="top">Monto:</td>
                                                                  <td align="left" valign="top"><input name="CmpAbono" type="text" class="EstFormularioCaja" id="CmpAbono" value="<?php echo number_format($InsBoleta->BolAbono,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td width="818" valign="top"><div class="EstFormularioArea"> 
                                                                  
                                                                    
                                 
                                                                    
                                                                     
                                                                     
                                                                      <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                        <tr>
                                                                          <td>&nbsp;</td>
                                                                          <td colspan="10"><span class="EstFormularioSubTitulo">Items
                                                                      </span>
                                                                            <input type="hidden" name="CmpBoletaDetalleItem" id="CmpBoletaDetalleItem" />
                                                                            <input type="hidden" name="CmpBoletaDetalleId" id="CmpBoletaDetalleId" />
                                                                            <!--           <input readonly="readonly" name="CmpBoletaDetalleProductoId" type="hidden" class="EstFormularioCaja" id="CmpBoletaDetalleProductoId" size="20" maxlength="10" />
                 -->
                                                                            <input readonly="readonly" name="CmpBoletaDetalleTiempoCreacion" type="hidden" class="EstFormularioCaja" id="CmpBoletaDetalleTiempoCreacion" size="20" maxlength="10" />
                                                                            <input readonly="readonly" name="CmpBoletaDetalleVentaDetalleId" type="hidden" class="EstFormularioCaja" id="CmpBoletaDetalleVentaDetalleId" size="20" maxlength="10" />
                                                                          <input type="hidden" name="CmpArticuloId" id="CmpArticuloId" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>&nbsp;</td>
                                                                          <td>&nbsp;</td>
                                                                          <td>Tipo:</td>
                                                                          <td>Codigo:</td>
                                                                          <td>Descripcion:</td>
                                                                          <td>U.M.</td>
                                                                          <td align="left">Precio:</td>
                                                                          <td align="left">Cant.</td>
                                                                          <td align="left">Desc.:</td>
                                                                          <td align="left">Importe:</td>
                                                                          <td>&nbsp;</td>
                                                                        </tr>
                                                                         <tr>
                                                                          <td>&nbsp;</td>
                                                                          <td><a href="javascript:FncBoletaDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                          <td><select  class="EstFormularioCombo" name="CmpBoletaDetalleTipo" id="CmpBoletaDetalleTipo">
                                                                           
                                                                            <option value="">-</option>
                                                                            <option value="R">Repuesto</option>
                                                                            <option value="S">Servicio</option>
                                                                            <option value="M">Material</option>
                                                                             <option value="T">Texto</option>
                                                                            </option>
                                                                          </select></td>
                                                                          <td><input tabindex="11" class="EstFormularioCaja" name="CmpBoletaDetalleCodigo" type="text" id="CmpBoletaDetalleCodigo" size="10" maxlength="45"   /></td>
                                                                          <td><input tabindex="10" class="EstFormularioCaja" name="CmpArticuloDescripcion" type="text" id="CmpArticuloDescripcion" size="45"   /></td>
                                                                          <td><input tabindex="10" class="EstFormularioCaja" name="CmpBoletaDetalleUnidadMedida" type="text" id="CmpBoletaDetalleUnidadMedida" size="10" maxlength="10"  /></td>
                                                                          <td><input tabindex="10" class="EstFormularioCaja" name="CmpBoletaDetallePrecio" type="text" id="CmpBoletaDetallePrecio" size="5" maxlength="10"  /></td>
                                                                          <td><input tabindex="10" class="EstFormularioCaja" name="CmpBoletaDetalleCantidad" type="text" id="CmpBoletaDetalleCantidad" size="5" maxlength="10"  /></td>
                                                                          <td><input name="CmpBoletaDetalleDescuento" type="text" class="EstFormularioCaja" id="CmpBoletaDetalleDescuento" tabindex="12" size="5" maxlength="10"  /></td>
                                                                          <td><input tabindex="12" class="EstFormularioCaja" name="CmpBoletaDetalleImporte" type="text" id="CmpBoletaDetalleImporte" size="5" maxlength="10"  /></td>
                                                                          <td><a href="javascript:FncBoletaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>&nbsp;</td>
                                                                          <td>&nbsp;</td>
                                                                          <td colspan="7" align="right"><input type="checkbox" name="CmpBoletaDetalleGratuito" id="CmpBoletaDetalleGratuito" value="1" />
                   Transf. Grat.
                   <input type="checkbox" name="CmpBoletaDetalleExonerado" id="CmpBoletaDetalleExonerado" value="1" />
                   Exon. Imp.
                   <input type="checkbox" name="CmpBoletaDetalleIncluyeSelectivo" id="CmpBoletaDetalleIncluyeSelectivo" value="1" />
Inc. Select.</td>
                                                                          <td>&nbsp;</td>
                                                                          <td>&nbsp;</td>
                                                                        </tr>
                                                                       
                                                                      </table>
																	                                                                
                                                                      
                                                                    
                                                            </div></td>
                                                            <td width="277" valign="top"><div id="CapBoletaDetalle" class="EstFormularioArea">
                                                          <?php
														  if(!empty($InsBoleta->OvvId)){
														?>
                                                        
                                                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                                                    <tr>
                                                                      <td>&nbsp;</td>
                                                                      <td colspan="2"><span class="EstFormularioSubTitulo">Fichas
                                                                      </span>
                                                                        <input type="hidden" name="CmpBoletaAlmacenMovimientoItem" id="CmpBoletaAlmacenMovimientoItem" />
                                                                        <input type="hidden" name="CmpBoletaAlmacenMovimientoId" id="CmpBoletaAlmacenMovimientoId" />
                                                                        
                                                                        
                                                                        
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
                                                                      <td><a href="javascript:FncBoletaAlmacenMovimientoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td><input name="CmpAlmacenMovimiento" type="text" class="EstFormularioCaja" id="CmpAlmacenMovimiento" tabindex="11" size="20" maxlength="20" readonly="readonly"  /></td>
                                                                      <td><a href="javascript:FncBoletaAlmacenMovimientoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
                                                                        <input type="hidden" name="CmpBoletaAlmacenMovimientoItem" id="CmpBoletaAlmacenMovimientoItem" />
                                                                        <input type="hidden" name="CmpBoletaAlmacenMovimientoId" id="CmpBoletaAlmacenMovimientoId" />
                                                                        
                                                                        
                                                                        
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
                                                                      <td><a href="javascript:FncBoletaAlmacenMovimientoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                                                      <td><input name="CmpAlmacenMovimiento" type="text" class="EstFormularioCaja" id="CmpAlmacenMovimiento" tabindex="11" size="20" maxlength="20"  /></td>
                                                                      <td><a href="javascript:FncBoletaAlmacenMovimientoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                                                    </tr>
                                                                  </table>
                                                            <?php  
														  }
														  ?>
                                                                  
                                                            </div>
                                                            
                                                            </td>
                                                          </tr>
                                                          
                                                          <tr>
                                                            <td rowspan="4" valign="top"><div class="EstFormularioArea" >
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                  <tr>
                                                                    <td width="2%">&nbsp;</td>
                                                                    <td width="48%"><div class="EstFormularioAccion" id="CapBoletaDetalleAccion">Listo
                                                                      para registrar elementos</div></td>
                                                                    <td width="49%" align="right"><a href="javascript:FncBoletaDetalleListar();">
                                                                      <input type="hidden" name="CmpBoletaDetalleAccion" id="CmpBoletaDetalleAccion" value="AccBoletaDetalleRegistrar.php" />
                                                                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncBoletaDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
                                                                    <td width="1%"><div id="CapBoletaDetallesResultado"> </div></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2"><div id="CapBoletaDetalles" class="EstCapBoletaDetalles" > </div></td>
                                                                    <td>&nbsp;</td>
                                                                  </tr>
                                                                </table>
                                                            </div></td>
                                                            <td valign="top"><div class="EstFormularioArea" >
                                                                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                                  <tr>
                                                                    <td width="1%">&nbsp;</td>
                                                                    <td width="48%"><div class="EstFormularioAccion" id="CapBoletaAlmacenMovimientoAccion">Listo
                                                                      para registrar elementos</div></td>
                                                                    <td width="50%" align="right"><a href="javascript:FncBoletaAlmacenMovimientoListar();">
                                                                      <input type="hidden" name="CmpBoletaAlmacenMovimientoAccion" id="CmpBoletaAlmacenMovimientoAccion" value="AccBoletaAlmacenMovimientoRegistrar.php" />
                                                                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> 
                                                                    
                                                                    
                                                                   <!-- <a href="javascript:FncBoletaAlmacenMovimientoEliminarTodo();">
                                                                    
                                                                    
                                                                    <img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a>-->
                                                                    
                                                                    
                                                                    </td>
                                                                    <td width="1%"><div id="CapBoletaAlmacenMovimientosResultado"> </div></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2"><div id="CapBoletaAlmacenMovimientos" class="EstCapBoletaAlmacenMovimientos" > </div></td>
                                                                    <td>&nbsp;</td>
                                                                  </tr>
                                                                </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top"><div id="CapBoletaDetalle" class="EstFormularioArea">
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
                                                                  <td width="48%"><div class="EstFormularioAccion" id="CapBoletaPagoAccion">Listo
                                                                    para registrar elementos</div></td>
                                                                  <td width="50%" align="right"><a href="javascript:FncBoletaPagoListar();">
                                                                    <input type="hidden" name="CmpBoletPagoAccion" id="CmpBoletaPagoAccion" value="AccBoletaPagoRegistrar.php" />
                                                                    <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                                                                    <!-- <a href="javascript:FncBoletaAlmacenMovimientoEliminarTodo();">
                                                                    
                                                                    
                                                                    <img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a>--></td>
                                                                  <td width="1%"><div id="CapBoletaPagosResultado"> </div></td>
                                                                </tr>
                                                                <tr>
                                                                  <td>&nbsp;</td>
                                                                  <td colspan="2"><div id="CapBoletaPagos" class="EstCapBoletaPagos" > </div></td>
                                                                  <td>&nbsp;</td>
                                                                </tr>
                                                              </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top"></td>
                                                          </tr>
                                                          
              </table>
        
      
   </div>

	<div id="tab2" class="tab_content">

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
                    <td colspan="3" align="left" valign="top"><input tabindex="5" class="EstFormularioCaja" name="CmpRegimenComprobanteNumero" type="text" id="CmpRegimenComprobanteNumero" size="20" maxlength="50" value="<?php echo $InsBoleta->BolRegimenComprobanteNumero;?>"  /></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Fecha de Comprobante:<br />
                      <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                    <td align="left" valign="top"><span id="sprytextfield7">
                    <input tabindex="6" class="EstFormularioCajaFecha" name="CmpRegimenComprobanteFecha" type="text" id="CmpRegimenComprobanteFecha" value="<?php echo $InsBoleta->BolRegimenComprobanteFecha;?>" size="15" maxlength="10" />
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
                      <option value="<?php echo $DatRegimen->RegId?>" <?php if($InsBoleta->RegId==$DatRegimen->RegId){ echo 'selected="selected"';} ?> ><?php echo $DatRegimen->RegNombre?></option>
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
                        <span id="sprytextfield5">
                        <label for="label"></label>
                        <span id="sprytextfield3">
                        <label for="label2"></label>
                        <input  class="EstFormularioCaja" name="CmpRegimenPorcentaje" type="text" id="CmpRegimenPorcentaje" value="<?php if (empty($InsBoleta->BolRegimenPorcentaje)){ echo "";}else{ echo $InsBoleta->BolRegimenPorcentaje; } ?>" size="10" maxlength="10"  />
                        </span>
                        </span></span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Monto (<span class="EstMonedaSimbolo"> <span id="CapMonedaRegimenMonto"></span></span>):</td>
                    <td colspan="3" align="left" valign="top"><input  class="EstFormularioCaja" name="CmpRegimenMonto" type="text" id="CmpRegimenMonto" size="15" maxlength="10" value="<?php if (empty($InsBoleta->BolRegimenMonto)){ echo "";}else{ echo number_format($InsBoleta->BolRegimenMonto,2); } ?>" /></td>
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
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaTicket" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaTicket" tabindex="5" value="<?php echo $InsBoleta->BolSunatRespuestaTicket;?>" size="20" maxlength="50" readonly="readonly"  /></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Fecha de Respuesta:<br />
                  (dd/mm/yyyy)</td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaFecha" tabindex="6" value="<?php echo $InsBoleta->BolSunatRespuestaFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td align="left" valign="top">Hora de Respuesta:<br />
(00:00)</td>
                <td align="left" valign="top"><input name="CmpSunatRespuestaHora" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaHora" tabindex="6" value="<?php echo $InsBoleta->BolSunatRespuestaHora;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Codigo de Respuesta:<br /></td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaCodigo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaCodigo" tabindex="6" value="<?php echo $InsBoleta->BolSunatRespuestaCodigo;?>" size="15" maxlength="10" readonly="readonly" /></td>
                <td align="left" valign="top">Descripcion de Respuesta:</td>
                <td align="left" valign="top"><textarea name="CmpSunatRespuestaContenido" cols="45" rows="2" readonly="readonly" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaContenido" tabindex="6"><?php echo $InsBoleta->BolSunatRespuestaContenido;?></textarea></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Estado de Ticket</td>
                <td colspan="3" align="left" valign="top"><input name="CmpSunatRespuestaEstado" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSunatRespuestaEstado" tabindex="5" value="<?php echo $InsBoleta->BolSunatRespuestaEstado;?>" size="20" maxlength="50" readonly="readonly"  /></td>
                <td align="left" valign="top">Observaciones:</td>
                <td align="left" valign="top"><textarea name="CmpSunatRespuestaObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCajaFecha" id="CmpSunatRespuestaObservacion" tabindex="6"><?php echo $InsBoleta->BolSunatRespuestaObservacion;?></textarea></td>
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


<?php
	if($PrivilegioEditarEspecial){
	?>
	
		Calendar.setup({ 
		inputField : "CmpFechaEmision",  // id del campo de texto 
		ifFormat   : "%d/%m/%Y",  //  
		button     : "BtnFechaEmision",// el id del bot&oacute;n que 
		onUpdate	:    FncBoletaCalcularFechaVencimiento 
		}); 
		
<?php
	}
?>

	Calendar.setup({ 
	inputField : "CmpComprobanteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnComprobanteFecha"// el id del botón que  
	});
	
</script>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {isRequired:false});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "integer");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
</script>
<?php
}elseif(!empty($InsBoleta->BolCierre)){
echo ERR_BOL_401;
}
?>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
