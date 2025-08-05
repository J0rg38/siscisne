<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
         
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletarv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteNotaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoColorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionVehiculoFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCotizacionVehiculoFotoSoloFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCotizacionVehiculo.css');
</style>


<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCotizacionVehiculo.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
require_once($InsPoo->MtdPaqLogistica().'ClsObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoReferido.php');

$InsCotizacionVehiculo = new ClsCotizacionVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal = new ClsPersonal();
$InsCondicionVenta = new ClsCondicionVenta();
$InsCondicionPago = new ClsCondicionPago();
$InsObsequio = new ClsObsequio();
$InsTipoReferido = new ClsTipoReferido();



$ResCondicionVenta = $InsCondicionVenta->MtdObtenerCondicionVentas(NULL,NULL,'CovId','DESC',NULL,1);
$ArrCondicionVentas = $ResCondicionVenta['Datos'];

$InsCotizacionVehiculo->UsuId = $_SESSION['SesionId'];	

if (isset($_SESSION['InsCotizacionVehiculoFoto'.$Identificador])){	
	$_SESSION['InsCotizacionVehiculoFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsCotizacionVehiculoFoto'.$Identificador]);
}

$ResAccesorio = $InsObsequio->MtdObtenerObsequios(NULL,NULL,'ObsOrden','ASC',NULL,2);
$ArrAccesorios = $ResAccesorio['Datos'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCotizacionVehiculoEditar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1,NULL,$InsCotizacionVehiculo->SucId,NULL,NULL,true);
$ArrPersonales = $ResPersonal['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonalReferente = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,true);
$ArrPersonalReferentes = $ResPersonalReferente['Datos'];
//function MtdObtenerCondicionPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];


$ResTipoReferido = $InsTipoReferido->MtdObtenerTipoReferidos(NULL,NULL,"TrfNombre","ASC",NULL,NULL,NULL);
$ArrTipoReferidos = $ResTipoReferido['Datos'];
//deb($InsCotizacionVehiculo->CotizacionVehiculoObsequio);
?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	//FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){
	
	$('#CmpFecha').focus();	

	FncCotizacionVehiculoFotoListar();
	
	FncCotizacionVehiculoFotoSoloListar();
	
	FncCotizacionVehiculoEstablecerMoneda();
	
	FncVehiculoModelosCargar();
	
	//FncVehiculoVersionesCargar();
	
	//FncVehiculoIngresoListar();
	
	<?php
	if($Edito or $Registro){
	?>
		if(confirm("Desea imprimir ahora?")){
			
			FncImprmir("<?php echo $InsCotizacionVehiculo->CveId;?>");
			
		}
	<?php	
	}
	?>
	
});

/*
Configuracion Formulario
*/

var CotizacionVehiculoDetalleEditar = 1;
var CotizacionVehiculoDetalleEliminar = 1;

var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;
var VehiculoColorHabilitado = 1;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 1;
var VehiculoVersionVigencia = 1;


var CotizacionVehiculoFotoSoloEditar = 1;
var CotizacionVehiculoFotoSoloEliminar = 1;


var CotizacionVehiculoFotoEditar = 1;
var CotizacionVehiculoFotoEliminar = 1;

</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">


<div class="EstCapMenu">

           <?php
if($Edito){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsCotizacionVehiculo->CveId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsCotizacionVehiculo->CveId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        COTIZACION DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
               
<ul class="tabs">
	<li><a href="#tab1">Cotizacion</a></li>
    <li><a href="#tab2">Foto</a></li>
    <li><a href="#tab3">Notas</a></li>

</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCotizacionVehiculo->CveTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCotizacionVehiculo->CveTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           
           
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de la Cotizacion de Vehiculo
                   <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCotizacionVehiculo->CveId;?>" size="20" maxlength="20" /></td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsCotizacionVehiculo->CveFecha)){ echo date("d/m/Y");}else{ echo $InsCotizacionVehiculo->CveFecha; }?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td rowspan="4" align="left" valign="top"></td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Nivel de Interes:</td>
               <td align="left" valign="top"><?php
					switch($InsCotizacionVehiculo->CveNivelInteres){
						case 1:
							$OpcNivelInteres1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcNivelInteres2 = 'selected = "selected"';						
						break;
						
						case 3:
							$OpcNivelInteres3 = 'selected = "selected"';						
						break;
						
							
						case 4:
							$OpcNivelInteres4 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpNivelInteres" id="CmpNivelInteres">
                   <option <?php echo $OpcNivelInteres1;?> value="1">Normal</option>
                   <option <?php echo $OpcNivelInteres2;?> value="2">Interesado</option>
                   <option <?php echo $OpcNivelInteres3;?> value="3">Muy Interesado</option>
                   <option <?php echo $OpcNivelInteres4;?> value="4">Venta Concluida</option>
                 </select></td>
               <td align="left" valign="top">Hora:<br />
                 <span class="EstFormularioSubEtiqueta">(HH/mm)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpHora" type="text" id="CmpHora" value="<?php if(empty($InsCotizacionVehiculo->CveHora)){ echo date("HH:ii");}else{ echo $InsCotizacionVehiculo->CveHora; }?>" size="15" maxlength="10" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Condicion de Venta:</td>
               <td align="left" valign="top"><?php
			   
			   
//deb($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta);


		foreach($ArrCondicionVentas as $DatCondicionVenta){
			?>
                 <?php
			  	if(!empty($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta)){	
					foreach($InsCotizacionVehiculo->CotizacionVehiculoCondicionVenta as $DatCotizacionVehiculoCondicionVenta ){
						$aux = '';
						$CcvId = '';
						if($DatCotizacionVehiculoCondicionVenta->CovId==$DatCondicionVenta->CovId){
							$aux = 'checked="checked"';						
							$CcvId = $DatCotizacionVehiculoCondicionVenta->CcvId;
							break;
						}					
					}
				}				
				?>
                 <input type="hidden" name="CmpCotizacionVehiculoCondicionVentaId_<?php echo $DatCondicionVenta->CovId;?>" id="CmpCotizacionVehiculoCondicionVentaId_<?php echo $DatCondicionVenta->CovId;?>" value="<?php echo $CcvId;?>" />
                 <input <?php echo $aux;?> type="checkbox" value="<?php echo $DatCondicionVenta->CovId;?>" name="CmpCondicionVenta_<?php echo $DatCondicionVenta->CovId;?>" id="CmpCondicionVenta_<?php echo $DatCondicionVenta->CovId;?>"  />
                 <?php echo $DatCondicionVenta->CovNombre;?><br />
                 <?php	
			}
			?>
                 <textarea name="CmpCondicionVentaOtro" cols="25" class="EstFormularioCaja" id="CmpCondicionVentaOtro"><?php echo $InsCotizacionVehiculo->CveCondicionVentaOtro;?></textarea></td>
               <td align="left" valign="top">Asesor de Ventas:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsCotizacionVehiculo->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Forma de Pago:</td>
               <td align="left" valign="top"><select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                 <option <?php if($InsCotizacionVehiculo->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                 <?php  
					}
					?>
               </select></td>
               <td align="left" valign="top">Asesor Referente: </td>
               <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonalReferente" id="CmpPersonalReferente" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonalReferentes as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsCotizacionVehiculo->PerIdReferente)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos del cliente</span></td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Cliente:                 </td>
               <td colspan="5" align="left" valign="top"><table>
                 <tr>
                   <td><input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsCotizacionVehiculo->CliId;?>" size="3" /></td>
                   <td><select class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento"  disabled="disabled" >
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCotizacionVehiculo->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
			}
			?>
                     </select></td>
                   <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input <?php echo (!empty($InsCotizacionVehiculo->CliId)?'readonly="readonly"':'');?> name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  value="<?php echo $InsCotizacionVehiculo->CliNumeroDocumento;?>" size="20" maxlength="50" /></td>
                   <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                   <td><input name="CmpClienteNombre2" type="hidden" id="CmpClienteNombre2" value="<?php echo $InsCotizacionVehiculo->CliNombre;?>" size="3" />
                     <input name="CmpClienteApellidoPaterno" type="hidden" id="CmpClienteApellidoPaterno" value="<?php echo $InsCotizacionVehiculo->CliId;?>" size="3" />
                     <input name="CmpClienteApellidoMaterno" type="hidden" id="CmpClienteApellidoMaterno" value="<?php echo $InsCotizacionVehiculo->CliId;?>" size="3" />
                     <input name="CmpTipoReferidoId" type="hidden" id="CmpTipoReferidoId" value="<?php echo $InsCotizacionVehiculo->TrfId;?>" size="3" />
                     <input <?php echo (!empty($InsCotizacionVehiculo->CliId)?'readonly="readonly"':'');?> class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" value="<?php echo $InsCotizacionVehiculo->CliNombre;?> <?php echo $InsCotizacionVehiculo->CliApellidoPaterno;?> <?php echo $InsCotizacionVehiculo->CliApellidoMaterno;?>" size="45" maxlength="255"  />                     
                     <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                   <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                   <td><div id="CapClienteBuscar"></div></td>
                   </tr>
                 <tr> </tr>
               </table></td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Direccion:</td>
               <td align="left" valign="top"><input <?php echo (!empty($InsCotizacionVehiculo->CliId)?'readonly="readonly"':'');?> class="EstFormularioCaja" name="CmpClienteDireccion" type="text" id="CmpClienteDireccion" value="<?php echo $InsCotizacionVehiculo->CveDireccion;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">Telefono:</td>
               <td align="left" valign="top"><input <?php echo (!empty($InsCotizacionVehiculo->CliId)?'readonly="readonly"':'');?>  class="EstFormularioCaja" name="CmpClienteTelefono" type="text" id="CmpClienteTelefono" value="<?php echo $InsCotizacionVehiculo->CveTelefono;?>" size="20" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Email:</td>
               <td align="left" valign="top"><input <?php echo (!empty($InsCotizacionVehiculo->CliId)?'readonly="readonly"':'');?>  class="EstFormularioCaja" name="CmpClienteEmail" type="text" id="CmpClienteEmail" value="<?php echo $InsCotizacionVehiculo->CveEmail;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">Celular:</td>
               <td align="left" valign="top"><input <?php echo (!empty($InsCotizacionVehiculo->CliId)?'readonly="readonly"':'');?>  class="EstFormularioCaja" name="CmpClienteCelular" type="text" id="CmpClienteCelular" value="<?php echo $InsCotizacionVehiculo->CveCelular;?>" size="20" maxlength="255"  /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&iquest;Como llego al Concesionario?</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoReferido" id="CmpTipoReferido">
                 <option value="">Escoja una opcion</option>
                 <?php
			foreach($ArrTipoReferidos as $DatReferido){
			?>
                 <option  <?php echo ($DatReferido->TrfId==$InsCotizacionVehiculo->TrfId)?'selected="selected"':"";?> value="<?php echo $DatReferido->TrfId?>"><?php echo $DatReferido->TrfNombre?></option>
                 <?php
			}
			?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de facturacion</span></td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Moneda:</td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                     <option value="">Escoja una opcion</option>
                     <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                     <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCotizacionVehiculo->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                     <?php
			  }
			  ?>
                   </select></td>
                   <td><div id="CapMonedaBuscar"></div></td>
                   </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Tipo de Cambio: <br />
                 <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCotizacionProductoDetalleListar();" value="<?php if (empty($InsCotizacionVehiculo->CveTipoCambio)){ echo "";}else{ echo $InsCotizacionVehiculo->CveTipoCambio; } ?>" size="10" maxlength="10" /></td>
                   <td><a href="javascript:FncCotizacionVehiculoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                   </tr>
                 </table></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Impuesto:<br />
                 <span class="EstFormularioSubEtiqueta">(%)</span></td>
               
               <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta"  value="<?php if(empty($InsCotizacionVehiculo->CvePorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsCotizacionVehiculo->CvePorcentajeImpuestoVenta;}?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">Fecha de Vigencia:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFechaVigencia" type="text" id="CmpFechaVigencia" value="<?php echo $InsCotizacionVehiculo->CveFechaVigencia; ?>" size="15" maxlength="10" />                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaVigencia" name="BtnFechaVigencia" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Accesorios:</span></td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">
               <div class="EstCapaListadoAccesorios">
               
               <?php
					
					$aux = '';
foreach($ArrAccesorios as $DatAccesorio){
?>
                            <?php
$CotizacionVehiculoObsequioId = "";
	
	if(!empty($InsCotizacionVehiculo->CotizacionVehiculoObsequio)){	
		foreach($InsCotizacionVehiculo->CotizacionVehiculoObsequio as $DatCotizacionVehiculoObsequio ){
			$aux = '';
			
			if($DatCotizacionVehiculoObsequio->ObsId==$DatAccesorio->ObsId and !empty($DatCotizacionVehiculoObsequio->CvoId)){
//			if($DatCotizacionVehiculoObsequio->ObsId==$DatAccesorio->ObsId){
				$aux = 'checked="checked"';		
				$CotizacionVehiculoObsequioId = $DatCotizacionVehiculoObsequio->CvoId;				
				break;
			}					
		}
	}				
	?><?php //echo $DatAccesorio->ObsId;?>
                            <input  etiqueta="accesorio"  <?php echo $aux;?> type="checkbox" value="<?php echo $DatAccesorio->ObsId;?>" name="CmpObsequio_<?php echo $DatAccesorio->ObsId;?>" id="CmpObsequio_<?php echo $DatAccesorio->ObsId;?>" />
                            
                             
                 <input  type="hidden" value="<?php echo $CotizacionVehiculoObsequioId;?>" name="CmpCotizacionVehiculoObsequioId_<?php echo $DatAccesorio->ObsId;?>" id="CmpCotizacionVehiculoObsequioId_<?php echo $DatAccesorio->ObsId;?>" />     
                 
                 
                 
                 
                            <?php echo $DatAccesorio->ObsNombre;?>
                            <?php 
					  if(!empty($DatAccesorio->ObsFoto)){
					?>
                            <a target="<?php echo (!empty($DatAccesorio->ObsArchivo)?'_blank'.$DatAccesorio->ObsArchivo:'');?>" href="<?php echo (!empty($DatAccesorio->ObsArchivo)?'subidos/obsequio_archivos/'.$DatAccesorio->ObsArchivo:'#');?>"> <img src="imagenes/avisos/<?php echo $DatAccesorio->ObsFoto?>" alt="<?php echo $DatAccesorio->ObsNombre?>" width="25" height="25" border="0" align="absmiddle" title="<?php echo $DatAccesorio->ObsNombre?>" /></a>
                            <?php
					  }else{
						?>
                            <?php 
					  if(!empty($DatAccesorio->ObsArchivo)){
					?>
                            <a target="<?php echo (!empty($DatAccesorio->ObsArchivo)?'_blank'.$DatAccesorio->ObsArchivo:'');?>" href="<?php echo (!empty($DatAccesorio->ObsArchivo)?'subidos/obsequio_archivos/'.$DatAccesorio->ObsArchivo:'#');?>"> <img src="imagenes/iconos/promocion.png" alt="Promocion" title="Vehiculo con promocion" border="0" width="25" height="25"/></a>
                            <?php  
					  }
					  ?>
                            <?php  
					  }
					  ?>
                            <br />
                            <?php	
}
?>
                            
                            
               
               
               
               </div>
               </td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top">
                 
                 <script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpObservacion",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 400,
	height : 120
});

</script>
                 
                 <textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsCotizacionVehiculo->CveObservacion;?></textarea></td>
               <td align="left" valign="top">Observacion para Informe:</td>
               <td align="left" valign="top"><script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpObservacion",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 400,
	height : 120
});

                    </script>
                 <textarea name="CmpObservacionReporte" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionReporte"><?php echo $InsCotizacionVehiculo->CveObservacionReporte;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Descripcion Adicional: <br />
                 <span class="EstFormularioSubEtiqueta">(Va junto al nombre del vehiculo)</span></td>
               <td align="left" valign="top"><input  class="EstFormularioCaja" name="CmpAdicional" type="text" id="CmpAdicional" value="<?php echo $InsCotizacionVehiculo->CveAdicional;?>" size="45" maxlength="255"  /></td>
               <td align="left" valign="top">&iquest;Cotizo en otro Lugar?</td>
               <td align="left" valign="top"><?php
					switch($InsCotizacionVehiculo->CveCotizoOtroLugar){
						case "Si":
							$OpcCotizoOtroLugar1 = 'selected = "selected"';
						break;
						
						case "No":
							$OpcCotizoOtroLugar3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpCotizoOtroLugar" id="CmpCotizoOtroLugar">
                   <option value="">-</option>
                   <option <?php echo $OpcCotizoOtroLugar1;?> value="Si">Si</option>
                   <option <?php echo $OpcCotizoOtroLugar3;?> value="No">No</option>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsCotizacionVehiculo->CveEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
				/*		case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;*/
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 6:
							$OpcEstado6 = 'selected = "selected"';						
						break;
					}
					?>
                      <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                        <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                        <!--   <option <?php echo $OpcEstado2;?> value="2">Atendido</option>-->
                        <option <?php echo $OpcEstado3;?> value="3">Listo</option>
                        <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                        
                        </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             </table>
             
           </div></td>
       </tr>
       <tr>
         <td valign="top">
           <div class="EstFormularioArea">
             
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="11"><span class="EstFormularioSubTitulo">Datos del Vehiculo </span></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left">Marca:</td>
                 <td align="left">Modelo:
                   <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsCotizacionVehiculo->VmoId;?>" size="3" /></td>
                 <td align="left">Version:
                   <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsCotizacionVehiculo->VveId;?>" size="3" /></td>
                 <td align="left">Color:</td>
                 <td align="left" valign="top">A&ntilde;o /Fab.:</td>
                 <td align="left">A&ntilde;o/Mod.:</td>
                 <td align="left" valign="top">GLP</td>
                 <td align="left" valign="top">Cantidad:</td>
                 <td>Precio: </td>
                 <td align="left" valign="top">Descuento:</td>
                 <td align="left"> Total: </td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td><a href="javascript:FncCotizacionVehiculoDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                 <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                   <option value="">Escoja una opcion</option>
                   <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                   <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsCotizacionVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                   <?php
			}
			?>
                 </select></td>
                 <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                 </select></td>
                 <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                 </select></td>
                 <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpColor" type="text" id="CmpColor" value="<?php echo ($InsCotizacionVehiculo->CveColor);?>" size="15" maxlength="15" /></td>
                 <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpAnoFabricacion" type="text" id="CmpAnoFabricacion" value="<?php echo ($InsCotizacionVehiculo->CveAnoFabricacion);?>" size="7" maxlength="4" /></td>
                 <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpAnoModelo" type="text" id="CmpAnoModelo" value="<?php echo ($InsCotizacionVehiculo->CveAnoModelo);?>" size="7" maxlength="4" /></td>
                 <td align="left" valign="top"><?php
					switch($InsCotizacionVehiculo->CveGLP){
						case "Si":
							$OpcGLP1 = 'selected = "selected"';
						break;

						case "No":
							$OpcGLP3 = 'selected = "selected"';						
						break;
					
					}
					?>
                   <select class="EstFormularioCombo" name="CmpGLP" id="CmpGLP">
                     <option <?php echo $OpcGLP1;?> value="Si">Si</option>
                     <option <?php echo $OpcGLP3;?> value="No">No</option>
                   </select></td>
                 <td align="left" valign="top"><input name="CmpCantidad" type="text" class="EstFormularioCaja" id="CmpCantidad" value="<?php echo number_format($InsCotizacionVehiculo->CveCantidad,2);?>" size="10" maxlength="10" /></td>
                 <td align="left" valign="top"><input name="CmpPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPrecio" value="<?php echo number_format($InsCotizacionVehiculo->CvePrecio,2);?>" size="10" maxlength="10" /></td>
                 <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpDescuento" type="text" id="CmpDescuento" value="<?php echo number_format($InsCotizacionVehiculo->CveDescuento,2);?>" size="10" maxlength="10" /></td>
                 <td align="left" valign="top"><input name="CmpTotal" type="text" class="EstFormularioCaja" id="CmpTotal" value="<?php echo number_format($InsCotizacionVehiculo->CveTotal,2);?>" size="10" maxlength="10" /></td>
                 <td align="left" valign="top">
                   
                   <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsCotizacionVehiculo->EinId;?>" size="3" />
                   <input name="CmpPrecioLista" type="hidden" id="CmpPrecioLista" size="3" />
                   <input name="CmpPrecioCierre" type="hidden" id="CmpPrecioCierre" size="3" />
                   
                 </td>
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
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               </table>
           </div>         </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td><span class="EstFormularioSubTitulo">Disponibilidad/Lista de Precio</span></td>
               <td align="right"><a href="javascript:FncVehiculoIngresoListar();"> <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVehiculoIngreso" class="EstCapVehiculoIngreso"></div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
           </table>
         </div></td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
       </tr>        
        </table>
         
		

    </div>    
    

<div id="tab2" class="tab_content">    
	   			<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="98%"><span class="EstFormularioSubTitulo">Foto de Referencia del Vehiculo</span></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>
               
               
               <div class="EstFormularioArea" > 
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncCotizacionVehiculoFotoSoloListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncCotizacionVehiculoFotoEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapCotizacionVehiculoFotoSoloAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top">
                           
                             <div id="fileUploadCotizacionVehiculoFotoSolo">Escoger Archivo</div>
                             
                             <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadCotizacionVehiculoFotoSolo").uploadFile({
												
											allowedTypes:"png,jpg,jpeg",
											url:"formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoSubirFotoSolo.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncCotizacionVehiculoFotoSoloListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapCotizacionVehiculoFotoSolos" id="CapCotizacionVehiculoFotoSolos"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapCotizacionVehiculoFotosResultado"> </div></td>
             </tr>
             </table>   
                 </div>
               
                         
                         
                         
                         </td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
                 <td>&nbsp;</td>
                  <td><span class="EstFormularioSubTitulo">Fotos Adicionales</span></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>
                 
                <div class="EstFormularioArea" > 
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncCotizacionVehiculoFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncCotizacionVehiculoFotoEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapCotizacionVehiculoFotoAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                 <tr>
                   <td width="275" colspan="2" align="left" valign="top">
                     <div id="FupCotizacionVehiculoFotos">Escoger Archivos</div>
                     
                     
                     
                     <script type="text/javascript">
                                $(document).ready(function(){
                        
                                    $("#FupCotizacionVehiculoFotos").uploadFile({
                                            
                                        allowedTypes:"png,jpg,jpeg",
                                        url:"formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoSubirFoto.php",
                                        formData: {"Identificador":"<?php echo $Identificador;?>","Tipo":"F"},
                                        multiple:true,
                                        autoSubmit:true,
                                        fileName:"Filedata",
                                        showStatusAfterSuccess:false,
                                        dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
                                        abortStr:"Abortar",
                                        cancelStr:"Cancelar",
                                        doneStr:"Hecho",
                                        multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
                                        extErrorStr:"Extension de archivo no permitido",
                                        sizeErrorStr:"Tamaño no permitido",
                                        uploadErrorStr:"No se pudo subir el archivo",
                                        dragdropWidth: 500,
                                        onSuccess:function(files,data,xhr){
                                            FncCotizacionVehiculoFotoListar("F");
                                        }
                            
                            });
                        });
                        </script>
                     
                     
                     
                     
                     </td>
                   <td width="4" align="left" valign="top">&nbsp;</td>
                   </tr>
                 <tr>
                   <td colspan="2" align="left" valign="top"><div class="EstCapCotizacionVehiculoFotos" id="CapCotizacionVehiculoFotos"></div></td>
                   <td align="left" valign="top">&nbsp;</td>
                   </tr>
                 </table></td>
               <td><div id="CapCotizacionVehiculoFotosResultado"> </div></td>
             </tr>
             </table>   
                 </div>
                 
                 </td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               </table>
             
        
	
    
		</div>
	
        
    </td>
    </tr>
    </table>	
	   
	       </div>     

        <div id="tab3" class="tab_content">
        <!--Content-->
        
        
        

<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                
                
                
                
           
               
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2"><span class="EstFormularioSubTitulo">Notas Adicionales</span></td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="left" valign="top">Notas:</td>
                          <td align="left" valign="top">
                          
                          
          <script type="text/javascript">


//tinymce.init({
//	selector: "textarea#CmpNota",
//	theme: "modern",
//	menubar : false,
//	toolbar1: "bold italic | bullist numlist",
//	width : 700,
//	height : 180
//});

</script>

          <textarea name="CmpNota" cols="60" rows="5" class="EstFormularioCaja" id="CmpNota"><?php echo stripslashes($InsCotizacionVehiculo->CveNota);?></textarea>
          
          
          
            
                          </td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          
                          </tr>
                          
                          </table>     
                
                
                
                
                </div>
                </td>
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

	
	
	
    
       


     
</form>
<script type="text/javascript">

Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
Calendar.setup({ 
	inputField : "CmpFechaVigencia",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaVigencia"// el id del botón que  
	});

</script>
<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
	
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
