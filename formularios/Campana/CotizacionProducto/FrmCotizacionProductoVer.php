<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoFunciones.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoPlanchadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoPintadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoCentradoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionProductoFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCotizacionProducto.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCotizacionProducto.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoPlanchadoPintado.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

$InsCotizacionProducto = new ClsCotizacionProducto();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();

$InsPersonal = new ClsPersonal();
$InsCliente = new ClsCliente();


if (isset($_SESSION['InsCotizacionProductoDetalle'.$Identificador])){	
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoDetalle'.$Identificador]);
}

if (isset($_SESSION['InsCotizacionProductoPlanchado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoPlanchado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoPlanchado'.$Identificador]);
}

if (isset($_SESSION['InsCotizacionProductoPintado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoPintado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoPintado'.$Identificador]);
}

if (isset($_SESSION['InsCotizacionProductoCentrado'.$Identificador])){	
	$_SESSION['InsCotizacionProductoCentrado'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoCentrado'.$Identificador]);
}


if (isset($_SESSION['InsCotizacionProductoTarea'.$Identificador])){	
	$_SESSION['InsCotizacionProductoTarea'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoTarea'.$Identificador]);
}

if (isset($_SESSION['InsCotizacionProductoFoto'.$Identificador])){	
	$_SESSION['InsCotizacionProductoFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionProductoFoto'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCotizacionProductoEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,"contiene",NULL,"LtiNombre","ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

$ResSeguro = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,'CliId','Desc',1,NULL,NULL,NULL,"LTI-10016");
$ArrSeguros = $ResSeguro['Datos'];

?>


<script type="text/javascript">
/*
//Configuracion carga de datos y animacion
*/

$(document).ready(function (){
	
	FncCotizacionProductoEstablecerMoneda();
	
	FncCotizacionProductoFotoListar('A');
	
});

/*
Configuracion Formulario
*/
var CotizacionProductoDetalleEditar = 2;
var CotizacionProductoDetalleEliminar = 2;

var CotizacionProductoPlanchadoEditar = 2;
var CotizacionProductoPlanchadoEliminar = 2;

var CotizacionProductoPintadoEditar = 2;
var CotizacionProductoPintadoEliminar = 2;

var CotizacionProductoCentradoEditar = 2;
var CotizacionProductoCentradoEliminar = 2;

var CotizacionProductoTareaEditar = 2;
var CotizacionProductoTareaEliminar = 2;

var CotizacionProductoFotoEditar = 2;
var CotizacionProductoFotoEliminar = 2;

</script>

<div class="EstCapMenu">

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsCotizacionProducto->CprId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsCotizacionProducto->CprId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    

          	<?php
			if($PrivilegioEditar and $InsCotizacionProducto->CprEstado==1){
			?>           
             
             
             
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsCotizacionProducto->CprId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER COTIZACION  </span></td>
      </tr>
      <tr>
        <td colspan="2">
        
<ul class="tabs">
	<li><a href="#tab1">Cotizacion</a></li>

  <li><a href="#tab2">Documentacion</a></li>

</ul>        
  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
                           

                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCotizacionProducto->CprTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCotizacionProducto->CprTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
   
        
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
          <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		     <tr>
		      <td>&nbsp;</td>
		      <td colspan="9"><span class="EstFormularioSubTitulo">Datos de la Cotizacion  
		        
		        </span></td>
		      <td>&nbsp;</td>
		      </tr>
		     <tr>
		       <td>&nbsp;</td>
		       <td align="left" valign="top">Cliente:</td>
		       <td align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre" value="<?php echo $InsCotizacionProducto->CliNombre;?> <?php echo $InsCotizacionProducto->CliApellidoPaterno;?> <?php echo $InsCotizacionProducto->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" /></td>
		       <td align="left" valign="top">Tipo Doc.:</td>
		       <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento" disabled="disabled">
		         <option value="">Escoja una opcion</option>
		         <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
		         <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCotizacionProducto->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
		         <?php
			}
			?>
		         </select></td>
		       <td align="left" valign="top">Num. Doc:</td>
		       <td colspan="4"><table border="0" cellpadding="0" cellspacing="0">
		         <tr>
		           <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  value="<?php echo $InsCotizacionProducto->CliNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
		           <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"></a>
		             <div id="CapClienteBuscar"></div></td>
		           </tr>
		         </table></td>
		       <td>&nbsp;</td>
		       </tr>
		     <tr>
		       <td>&nbsp;</td>
		       <td align="left" valign="top">Direccion:</td>
		       <td align="left" valign="top"><input name="CmpClienteDireccion" type="text" class="EstFormularioCaja" id="CmpClienteDireccion" value="<?php echo $InsCotizacionProducto->CprDireccion;?>" size="45" maxlength="255" readonly="readonly"  /></td>
		       <td align="left" valign="top">Celular:</td>
		       <td align="left" valign="top"><input name="CmpClienteCelular" type="text" class="EstFormularioCaja" id="CmpClienteCelular" value="<?php echo $InsCotizacionProducto->CprTelefono;?>" size="20" maxlength="255" readonly="readonly"  /></td>
		       <td align="left" valign="top">Email:</td>
		       <td colspan="4"><input name="CmpClienteEmail" type="text" class="EstFormularioCaja" id="CmpClienteEmail" value="<?php echo $InsCotizacionProducto->CprEmail;?>" size="45" maxlength="255" readonly="readonly"  /></td>
		       <td>&nbsp;</td>
		       </tr>
		     <tr>
		       <td>&nbsp;</td>
		       <td align="left" valign="top">Representante:</td>
		       <td align="left" valign="top"><input name="CmpRepresentante" type="text" class="EstFormularioCaja" id="CmpRepresentante" value="<?php echo $InsCotizacionProducto->CprRepresentante;?>" size="45" maxlength="100" readonly="readonly"  /></td>
		       <td align="left" valign="top">Tipo de Cliente:</td>
		       <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipo" id="CmpClienteTipo">
		         <option value="">Escoja una opcion</option>
		         <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
		         <option value="<?php echo $DatClienteTipo->LtiId?>" <?php if($InsCotizacionProducto->LtiId==$DatClienteTipo->LtiId){ echo 'selected="selected"';} ?> ><?php echo $DatClienteTipo->LtiNombre?></option>
		         <?php
			}
			?>
		         </select></td>
		       <td>&nbsp;</td>
		       <td colspan="4">&nbsp;</td>
		       <td>&nbsp;</td>
		       </tr>
		     <tr>
		       <td>&nbsp;</td>
		       <td>Seguro:</td>
		       <td colspan="8"><select class="EstFormularioCombo" name="CmpSeguro" id="CmpSeguro">
		         <option value="">Escoja una opcion</option>
		         <?php
			foreach($ArrSeguros as $DatSeguro){
			?>
		         <option  <?php echo ($DatSeguro->CliId==$InsCotizacionProducto->CliIdSeguro)?'selected="selected"':"";?> value="<?php echo $DatSeguro->CliId?>"><?php echo $DatSeguro->CliNombre?> <?php echo $DatSeguro->CliApellidoPaterno?> <?php echo $DatSeguro->CliApellidoMaterno?></option>
		         <?php
			}
			?>
		         </select></td>
		       <td>&nbsp;</td>
		       </tr>
		     <tr>
		       <td>&nbsp;</td>
		       <td>Asegurado:</td>
		       <td><input name="CmpAsegurado" type="text" class="EstFormularioCaja" id="CmpAsegurado" value="<?php echo $InsCotizacionProducto->CprAsegurado;?>" size="45" maxlength="100" readonly="readonly"  /></td>
		       <td>&nbsp;</td>
		       <td>&nbsp;</td>
		       <td>&nbsp;</td>
		       <td colspan="4">&nbsp;</td>
		       <td>&nbsp;</td>
		       </tr>
		     <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td colspan="4">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		   
              
              </table>
              </div>
              
              
              </td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Cotizacion </span></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">VIN:
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsCotizacionProducto->EinId;?>" size="3" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td>&nbsp;</td>
                   <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsCotizacionProducto->EinVIN;?>" size="20" maxlength="50" /></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   </tr>
                 <tr> </tr>
                 <tr> </tr>
                 <tr> </tr>
               </table></td>
               <td align="left" valign="top">Marca:
                 <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsCotizacionProducto->VmaId;?>" size="3" /></td>
               <td><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoMarca" value="<?php echo $InsCotizacionProducto->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsCotizacionProducto->VmoId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoModelo" value="<?php echo $InsCotizacionProducto->VmoNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Placa:</td>
               <td><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsCotizacionProducto->EinPlaca;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">A&ntilde;o:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoAnoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoAnoModelo" value="<?php echo $InsCotizacionProducto->CprAnoModelo;?>" size="10" maxlength="4" readonly="readonly" /></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
          <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Cotizacion  
		          <input type="hidden" name="Guardar" id="Guardar"   />
                <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
              </span></td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td align="center">&nbsp;</td>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Codigo:</td>
		      <td align="left" valign="top">
		        
		        <input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCotizacionProducto->CprId;?>" size="20" maxlength="20" /></td>
		      <td align="left" valign="top">Fecha:<br />
		        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
		      <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsCotizacionProducto->CprFecha)){ echo date("d/m/Y");}else{ echo $InsCotizacionProducto->CprFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top">OPCIONES ADICIONALES</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Cotizador:</td>
		      <td colspan="3" align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
		        <option value="">Escoja una opcion</option>
		        <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
		        <option <?php echo ($DatPersonal->PerId==$InsCotizacionProducto->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
		        <?php
					}
					?>
		        </select></td>
		      <td rowspan="9" align="left" valign="top"><input disabled="disabled" <?php echo (($InsCotizacionProducto->CprVerificar==1)?'checked="checked"':'');?>  type="checkbox" name="CmpVerificar" id="CmpVerificar" value="1" />
		        Requiere ser verificado <span class="EstFormularioSubEtiqueta">(Seguros)</span><br />
  <input disabled="disabled" <?php echo (($InsCotizacionProducto->CprFirmaDigital==1)?'checked="checked"':'');?>  type="checkbox" name="CmpFirmaDigital" id="CmpFirmaDigital" value="1" />
		        Imprimir Firma Digital de Cotizador<br />
  <input disabled="disabled" <?php echo (($InsCotizacionProducto->CprPlanchado=="Si")?'checked="checked"':'');?> value="Si"   type="checkbox" name="CmpPlanchado" id="CmpPlanchado" />
		        Incluir Planchado<br />
  <input disabled="disabled" <?php echo (($InsCotizacionProducto->CprPintado=="Si")?'checked="checked"':'');?> value="Si"  type="checkbox" name="CmpPintado" id="CmpPintado" />
		        Incluir Pintado <br />
  <input disabled="disabled" <?php echo (($InsCotizacionProducto->CprCentrado=="Si")?'checked="checked"':'');?> value="Si"  type="checkbox" name="CmpCentrado" id="CmpCentrado" />
		        Incluir Centrado <br />
  <input disabled="disabled" <?php echo (($InsCotizacionProducto->CprNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
		        Notificar via email (*)</td>
		      <td>&nbsp;</td>
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
		            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCotizacionProducto->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
		            <?php
			  }
			  ?>
		            </select></td>
		          <td><div id="CapMonedaBuscar"></div></td>
		          </tr>
		        </table></td>
		      <td align="left" valign="top">Tipo de Cambio: <br />
		        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
		      <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCotizacionProductoDetalleListar();" value="<?php if (empty($InsCotizacionProducto->CprTipoCambio)){ echo "";}else{ echo $InsCotizacionProducto->CprTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Incluye Impuesto:</td>
		      <td align="left" valign="top"><?php
					switch($InsCotizacionProducto->CprIncluyeImpuesto){
						case 1:
							$OpcIncluyeImpuesto1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcIncluyeImpuesto2 = 'selected = "selected"';						
						break;

					}
					?>
		        <select  onchange="FncCotizacionProductoDetalleListar();" class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto" disabled="disabled"  >
		          <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
		          <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
		          </select></td>
		      <td align="left" valign="top">Impuesto:<br />
		        <span class="EstFormularioSubEtiqueta">(%)</span></td>
		      <td align="left" valign="top"><input class="EstFormularioCajaDeshabilitada" name="CmpPorcentajeImpuestoVenta" type="text" id="CmpPorcentajeImpuestoVenta" value="<?php if(empty($InsCotizacionProducto->CprPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsCotizacionProducto->CprPorcentajeImpuestoVenta;}?>" size="10" maxlength="5" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Vigencia: <br />
                <span class="EstFormularioSubEtiqueta"> (dias)</span></td>
		      <td align="left" valign="top"><input name="CmpVigencia" type="text" class="EstFormularioCaja" id="CmpVigencia" value="<?php echo $InsCotizacionProducto->CprVigencia;?>" size="10" maxlength="4" readonly="readonly" /></td>
		      <td align="left" valign="top">Tiempo de Entrega: <br />
		        <span class="EstFormularioSubEtiqueta"> (dias)</span></td>
		      <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpTiempoEntrega" type="text" id="CmpTiempoEntrega" value="<?php echo $InsCotizacionProducto->CprTiempoEntrega;?>" size="10" maxlength="4" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Mano de Obra:</td>
		      <td align="left" valign="top"><input name="CmpManoObra" type="text" class="EstFormularioCaja" id="CmpManoObra" value="<?php echo number_format($InsCotizacionProducto->CprManoObra,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top">Descuento: <br />
		        <span class="EstFormularioSubEtiqueta">(%)</span></td>
		      <td align="left" valign="top"><input name="CmpPorcentajeDescuento" type="text" class="EstFormularioCaja" id="CmpPorcentajeDescuento" value="<?php echo number_format($InsCotizacionProducto->CprPorcentajeDescuento,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Margen de Utilidad: <br />
		        <span class="EstFormularioSubEtiqueta">(%)</span></td>
		      <td align="left" valign="top"><input name="CmpClienteMargenUtilidad" type="text" class="EstFormularioCaja" id="CmpClienteMargenUtilidad" value="<?php echo number_format($InsCotizacionProducto->CprMargenUtilidad,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td align="left" valign="top">Otros Costos: <br />
                <span class="EstFormularioSubEtiqueta">(%)</span></td>
		      <td align="left" valign="top"><input name="CmpFlete" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFlete" value="<?php echo number_format($InsCotizacionProducto->CprFlete,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Observacion:</td>
		      <td align="left" valign="top"><!--  
                 <div class="EstFormularioCajaObservacion">
                                      <?php echo stripslashes($InsCotizacionProducto->CprObservacion);?>
                                    </div>-->
		        <textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsCotizacionProducto->CprObservacion;?></textarea></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Orden de Trabajo:</td>
		      <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsCotizacionProducto->FinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Estado: </td>
		      <td align="left" valign="top"><?php
					switch($InsCotizacionProducto->CprEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 4:
							$OpcEstado4 = 'selected = "selected"';						
						break;
						
						case 5:
							$OpcEstado5 = 'selected = "selected"';						
						break;
						
						case 6:
							$OpcEstado6 = 'selected = "selected"';						
						break;
					}
					?>
		        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
		          <option <?php echo $OpcEstado1;?> value="1">Emitido</option>
		          <option <?php echo $OpcEstado2;?> value="2">Almacen [Enviado]</option>
		          <option <?php echo $OpcEstado3;?> value="3">Almacen [Revisando]</option>
		          <option <?php echo $OpcEstado4;?> value="4">Almacen [Por Facturar]</option>
		          <option <?php echo $OpcEstado5;?> value="5">Contabilidad [Facturado]</option>
		          <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
		          </select></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
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
               <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncCotizacionProductoDetalleListar();">
<img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar
</a></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoDetalles" class="EstCapCotizacionProductoDetalles" > </div></td>
               <td><div id="CapCotizacionProductoDetallesResultado"> </div></td>
               </tr>
             </table>
           </div></td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo">PLANCHADO</span></td>
               <td align="right">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoPlanchadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncCotizacionProductoPlanchadoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncCotizacionProductoPlanchadoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoPlanchados" class="EstCapCotizacionProductoPlanchados" > </div></td>
               <td><div id="CapCotizacionProductoPlanchadosResultado"> </div></td>
               </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo">PINTADO</span></td>
               <td align="right">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoPintadoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncCotizacionProductoPintadoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncCotizacionProductoPintadoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoPintados" class="EstCapCotizacionProductoPintados" > </div></td>
               <td><div id="CapCotizacionProductoPintadosResultado"> </div></td>
               </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top">
         
         
         
         <div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo">CENTRADO</span></td>
               <td align="right">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoCentradoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncCotizacionProductoCentradoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncCotizacionProductoCentradoEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoCentrados" class="EstCapCotizacionProductoCentrados" > </div></td>
               <td><div id="CapCotizacionProductoCentradosResultado"> </div></td>
               </tr>
             </table>
           </div>
           
           
         </td>
       </tr>
       <tr>
         <td valign="top">
         <div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo">TAREAS</span></td>
               <td align="right">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapCotizacionProductoTareaAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncCotizacionProductoTareaListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a> <a href="javascript:FncCotizacionProductoTareaEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapCotizacionProductoTareas" class="EstCapCotizacionProductoTareas" > </div></td>
               <td><div id="CapCotizacionProductoTareasResultado"> </div></td>
               </tr>
             </table>
           </div>
         
         </td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
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
		      <td colspan="4"><span class="EstFormularioSubTitulo">Archivo de Referencia</span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Archivos de Seguro</span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><div class="EstFormularioArea" >
		        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
		          <tr>
		            <td width="4" align="left" valign="top">&nbsp;</td>
		            <td width="139" align="left" valign="top">&nbsp;</td>
		            <td width="136" align="right" valign="top">
		              
		              <a href="javascript:FncCotizacionProductoFotoListar('A');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a>
		              
		              </td>
		            <td width="4" align="left" valign="top">&nbsp;</td>
		            </tr>
		          <tr>
		            <td align="left" valign="top">&nbsp;</td>
		            <td colspan="2" align="left" valign="top"><div class="EstCapCotizacionProductoFotos" id="CapCotizacionProductoFotosA"></div></td>
		            <td align="left" valign="top">&nbsp;</td>
		            </tr>
		          <tr>
		            <td align="left" valign="top">&nbsp;</td>
		            <td colspan="2" align="left" valign="top">
		              
		              <div id="CapCotizacionProductoFotosAccionA"></div>
		              </td>
		            <td align="left" valign="top">&nbsp;</td>
		            </tr>
		          </table>
		        </div></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    </table>
		  </div>
        
        
        </td>
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
