<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsRegistroOperacionUIFFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssRegistroOperacionUIF.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjRegistroOperacionUIF.php');

require_once($InsPoo->MtdPaqAdministracion().'ClsRegistroOperacionUIF.php');


require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


$InsRegistroOperacionUIF = new ClsRegistroOperacionUIF();
$InsTipoOperacion = new ClsTipoOperacion();
$InsClienteTipo = new ClsClienteTipo();

$InsMoneda = new ClsMoneda();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();

$InsTipoDocumento = new ClsTipoDocumento();
$InsPersonal = new ClsPersonal();

if (isset($_SESSION['InsRegistroOperacionUIFDetalle'.$Identificador])){	
	$_SESSION['InsRegistroOperacionUIFDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsRegistroOperacionUIFDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccRegistroOperacionUIFEditar.php');

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
//$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];
?>

<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){
	
	FncRegistroOperacionUIFDetalleListar();
		
});

var RegistroOperacionUIFDetalleEditar = 2;
var RegistroOperacionUIFDetalleEliminar = 2;
var RegistroOperacionUIFDetalleVerEstado = 2;

</script>

<div class="EstCapMenu">
  
  
  	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsRegistroOperacionUIF->RouId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsRegistroOperacionUIF->RouId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    
             
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsRegistroOperacionUIF->RouId;?>&Su=<?php echo $InsRegistroOperacionUIF->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER operacion en efectivo (ROP)</span></td>
      </tr>
      <tr>
        <td colspan="2">
 
 
                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsRegistroOperacionUIF->RouTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsRegistroOperacionUIF->RouTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Operacion en Efectivo (Mayor Cuantia)</a></li>

</ul>        

<div class="tab_container">

    <div id="tab1" class="tab_content">
        <!--Content-->     
		             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td width="4">&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Operacion en Efectivo (Mayor Cuantia)
                 
                 
                   <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td width="4">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="216">&nbsp;</td>
               <td width="351">&nbsp;</td>
               <td width="121">&nbsp;</td>
               <td width="110" align="center">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsRegistroOperacionUIF->RouId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Empresa:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoEmpresa" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCodigoEmpresa" value="<?php echo $InsRegistroOperacionUIF->RouCodigoEmpresa;?>" size="25" maxlength="45" /></td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsRegistroOperacionUIF->RouFecha)){ echo date("d/m/Y");}else{ echo $InsRegistroOperacionUIF->RouFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo de Oficial de Cumplimiento:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoOficialCumplimiento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCodigoOficialCumplimiento" value="<?php echo $InsRegistroOperacionUIF->RouCodigoOficialCumplimiento;?>" size="25" maxlength="45" /></td>
               <td align="left" valign="top">Hora:<br />
                 <span class="EstFormularioSubEtiqueta">(hh:mm)</span></td>
               <td align="left" valign="top"><input name="CmpHora" type="text" class="EstFormularioCajaFecha" id="CmpHora" value="<?php echo $InsRegistroOperacionUIF->RouHora?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la compra</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Transaccion:</td>
               <td align="left" valign="top"><input name="CmpTransaccion" type="text" class="EstFormularioCaja" id="CmpTransaccion"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTransaccion;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsRegistroOperacionUIF->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                   </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                 </tr>
                 <tr> </tr>
               </table></td>
               <td align="left" valign="top">Tipo de Cambio:<br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncRegistroOperacionUIFDetalleListar();" value="<?php if (empty($InsRegistroOperacionUIF->RouTipoCambio)){ echo "";}else{ echo $InsRegistroOperacionUIF->RouTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Importe:</td>
               <td align="left" valign="top"><input name="CmpImporte" type="text"  class="EstFormularioCaja" id="CmpImporte"  value="<?php echo number_format($InsRegistroOperacionUIF->RouImporte,2)?>" size="10" maxlength="10" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del solicitante</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Cliente: </td>
               <td colspan="3" align="left" valign="top">
                 
                 <table>
                   <tr>
                     <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsRegistroOperacionUIF->CliId;?>" size="3" /></td>
                     <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                       <option value="">Escoja una opcion</option>
                       <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                       <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsRegistroOperacionUIF->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                       <?php
	}
	?>
                       </select></td>
                     <td><input tabindex="4" class="EstFormularioCajaDeshabilitada" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="20" maxlength="50" value="<?php echo $InsRegistroOperacionUIF->CliNumeroDocumento;?>" /></td>
                     <td><input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteNombreCompleto" type="text" class="EstFormularioCaja" id="CmpClienteNombreCompleto"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliNombre;?>" size="45" maxlength="255"  />
                       <input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteNombre" type="hidden" class="EstFormularioCaja" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliNombre;?>" size="35" maxlength="255"  />
                       <input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteApellidoPaterno" type="hidden" class="EstFormularioCaja" id="CmpClienteApellidoPaterno"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliApellidoPaterno;?>" size="15" maxlength="255"  />
                       <input <?php if(!empty($InsRegistroOperacionUIF->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteApellidoMaterno" type="hidden" class="EstFormularioCaja" id="CmpClienteApellidoMaterno"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliApellidoMaterno;?>" size="15" maxlength="255"  /></td>
                     <td>
                       
                     </td>
                     </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input name="CmpDireccion" type="text" class="EstFormularioCaja" id="CmpDireccion"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouDireccion;?>" size="45" maxlength="255" readonly="readonly"  /></td>
               <td align="left" valign="top">Pais:</td>
               <td align="left" valign="top"><input name="CmpClientePais" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClientePais"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->CliPais;?>" size="25" maxlength="45" readonly="readonly"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Telefono:</td>
               <td align="left" valign="top"><input name="CmpTelefono" type="text" class="EstFormularioCaja" id="CmpTelefono"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTelefono;?>" size="25" maxlength="45" readonly="readonly"  /></td>
               <td align="left" valign="top">Celular:</td>
               <td align="left" valign="top"><input name="CmpCelular" type="text" class="EstFormularioCaja" id="CmpCelular"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouCelular;?>" size="25" maxlength="45" readonly="readonly"  /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del ordenante</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Nombre:</td>
               <td align="left" valign="top"><input name="CmpOrdenanteNombre" type="text" class="EstFormularioCaja" id="CmpOrdenanteNombre"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouOrdenanteNombre;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">DNI:</td>
               <td align="left" valign="top"><input name="CmpOrdenanteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpOrdenanteNumeroDocumento"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouOrdenanteNumeroDocumento;?>" size="25" maxlength="45"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input name="CmpOrdenanteDireccion" type="text" class="EstFormularioCaja" id="CmpOrdenanteDireccion"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouOrdenanteDireccion;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del tramitante</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Nombre:</td>
               <td align="left" valign="top"><input name="CmpTramitanteNombre" type="text" class="EstFormularioCaja" id="CmpTramitanteNombre"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTramitanteNombre;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">DNI:</td>
               <td align="left" valign="top"><input name="CmpTramitanteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpTramitanteNumeroDocumento"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTramitanteNumeroDocumento;?>" size="25" maxlength="45"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input name="CmpTramitanteDireccion" type="text" class="EstFormularioCaja" id="CmpTramitanteDireccion"  tabindex="2" value="<?php echo $InsRegistroOperacionUIF->RouTramitanteDireccion;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Origen de los fondos</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Descripcion:</td>
               <td align="left" valign="top"><textarea name="CmpOrigenFondo" cols="45" rows="4" class="EstFormularioCaja" id="CmpOrigenFondo"><?php echo $InsRegistroOperacionUIF->RouOrigenFondo;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">A solicitud de:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" disabled="disabled" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsRegistroOperacionUIF->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsRegistroOperacionUIF->RouEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsRegistroOperacionUIF->RouObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="50%"><input type="hidden" name="CmpRegistroOperacionUIFDetalleAccion" id="CmpRegistroOperacionUIFDetalleAccion" value="AccRegistroOperacionUIFDetalleRegistrar.php" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncRegistroOperacionUIFDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td width="0%"><div id="CapRegistroOperacionUIFDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapRegistroOperacionUIFDetalles" class="EstCapRegistroOperacionUIFDetalles" > </div></td>
               <td>&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       </table>
    </div>    
    

    
   
    
    
<div>		
 
 
        
        
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>

	
	
	
        

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
