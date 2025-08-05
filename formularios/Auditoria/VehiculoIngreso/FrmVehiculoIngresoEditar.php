<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoMarcaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoFotoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoArchivoDAMFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoArchivoDAM2Funciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoArchivoDAM3Funciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoIngreso.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$Edito = false;
//deb($_GET);
//deb($_SESSION['SesVehiculoIngresoId']);
//$GET_id = (empty($_SESSION['SesVehiculoIngresoId'])?$_GET['Id']:$_SESSION['SesVehiculoIngresoId']);

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoIngreso.php');


//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsConcesionario.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

//INSTANCIAS
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsTipoDocumento = new ClsTipoDocumento();
$InsConcesionario = new ClsConcesionario();
$InsTipoDocumento = new ClsTipoDocumento();
$InsPersonal = new ClsPersonal();

$InsMoneda = new ClsMoneda();



if (!isset($_SESSION['InsVehiculoIngresoCliente'.$Identificador])){	
	$_SESSION['InsVehiculoIngresoCliente'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsVehiculoIngresoCliente'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoIngresoCliente'.$Identificador]);
}


if (!isset($_SESSION['InsVehiculoIngresoFoto'.$Identificador])){	
	$_SESSION['InsVehiculoIngresoFoto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsVehiculoIngresoFoto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoIngresoFoto'.$Identificador]);
}
		
		

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoIngresoEditar.php');
//DATOS

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResConcesionario = $InsConcesionario->MtdObtenerConcesionarios(NULL,NULL,'OncNombre',"ASC",NULL,1);
$ArrConcesionarios = $ResConcesionario['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL) 
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,0,0,1);
$ArrResponsables = $ResPersonal['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

//deb($ArrConcesionarios);
//ALERTAS
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
var VehiculoMarcaHabilitado = 1;
var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;

var VehiculoColorHabilitado = 1;

var VehiculoIngresoClienteEditar = 1;
var VehiculoIngresoClienteEliminar = 1;

var VehiculoIngresoFotoEditar = 1;
var VehiculoIngresoFotoEliminar = 1;

var VehiculoIngresoArchivoDAMEditar = 1;
var VehiculoIngresoArchivoDAMEliminar = 1;

var VehiculoIngresoArchivoDAM2Editar = 1;
var VehiculoIngresoArchivoDAM2Eliminar = 1;

var VehiculoIngresoArchivoDAM3Editar = 1;
var VehiculoIngresoArchivoDAM3Eliminar = 1;

$().ready(function() {
	
	FncVehiculoMarcasCargar();
	
	FncVehiculoIngresoClienteListar();
	
	FncVehiculoIngresoFotoListar();
	
	FncVehiculoIngresoArchivoDAMListar();
	FncVehiculoIngresoArchivoDAM2Listar();
	FncVehiculoIngresoArchivoDAM3Listar();
	
	FncVehiculoIngresoEstablecerMoneda();
	
});
</script>


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">



<div class="EstCapMenu">


<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

	

<!--
<div class="EstSubMenuBoton"><a href="javascript:FncPopUp('formularios/VehiculoIngreso/FrmVehiculoIngresoCodigoBarra.php?o=1&t=40&r=1&text=<?php echo ($InsVehiculoIngreso->EinId);?>&f=2&a1=&a2=',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/codigo_barra.png" alt="[GCBarra]" title="Imprimir Codigo de Barras" />Cod. Barra</a></div>
-->
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">EDITAR INGRESO DE VEHICULO</span></td>
      </tr>
      <tr>
        <td>
        
        
                              
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoIngreso->EinTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoIngreso->EinTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div>
        
          <br />
        

		
	
		
<ul class="tabs">
	<li><a href="#tab1"> Ingreso de Vehiculo</a></li>
    <li><a href="#tab2"> Declaracion Aduana</a></li>
   
    
    <li><a href="#tab3"> Estado Vehicular</a></li>
    <li><a href="#tab4"> Propietarios</a></li>
    
    <li><a href="#tab5"> Gerencia</a></li>
    <li><a href="#tab6">Fotos OT</a></li>

</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

	   
     
       
       <table border="0" cellpadding="2" cellspacing="2">
       <tr>
         <td valign="top">
         
          <div class="EstFormularioArea" >
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Datos del Ingreso	de	Vehiculo	</span>			<input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Codigo Interno:</td>
            <td valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoIngreso->EinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td>VIN: </td>
            <td><span id="sprytextfield4">
              <input name="CmpVIN" type="text" class="EstFormularioCaja" id="CmpVIN" value="<?php echo $InsVehiculoIngreso->EinVIN;?>" size="20" maxlength="40"  />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Concesionario:</td>
            <td valign="top"><select class="EstFormularioCombo" name="CmpConcesionario" id="CmpConcesionario" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrConcesionarios as $DatConcesionario){
			?>
              <option <?php echo $DatConcesionario->OncId;?> <?php echo ($DatConcesionario->OncId==$InsVehiculoIngreso->OncId)?'selected="selected"':"";?> value="<?php echo $DatConcesionario->OncId?>"><?php echo $DatConcesionario->OncNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Marca:
              <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsVehiculoIngreso->VmaId;?>" size="3" /></td>
            <td valign="top">
            
            
            <table>
            <tr>
            <td>
            <span id="spryselect1">
              <select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                <option value="">Escoja una opcion</option>
                <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoIngreso->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                <?php
			}
			?>
              </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
              </td>
              <td>
              
<a id="BtnVehiculoMarcaRegistrar" onclick="FncVehiculoMarcaCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> 
            
            <a id="BtnVehiculoMarcaEditar" onclick="FncVehiculoMarcaCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a>
              
              </td>
              </tr>
              </table>
              </td>
            <td>Modelo:
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoIngreso->VmoId;?>" size="3" /></td>
            <td>
            
            
                        <table>
            <tr>
            <td>
            
            <span id="spryselect2">
              <select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
              </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
              
              </td>
              <td>
              
                          <a id="BtnVehiculoModeloRegistrar" onclick="FncVehiculoModeloCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> 
            
            <a id="BtnVehiculoModeloEditar" onclick="FncVehiculoModeloCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a>
            

              </td>
              </tr>
              </table>
              
              </td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Version:
              <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculoIngreso->VveId;?>" size="3" /></td>
            <td valign="top">
            
            
            <table>
            <tr>
            <td>
            
            <span id="spryselect3">
              <select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
              </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
              
            </td>
            <td>
                                 <a id="BtnVehiculoVersionRegistrar" onclick="FncVehiculoVersionCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> 
            
            <a id="BtnVehiculoVersionEditar" onclick="FncVehiculoVersionCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a>
            </td>
            </tr>
            </table>  
              
              
              </td>
            <td>Color:
              <input name="CmpVehiculoColorId" type="hidden" id="CmpVehiculoColorId" value="<?php echo $InsVehiculoIngreso->VehId;?>" size="3" /></td>
            <td><input value="<?php echo $InsVehiculoIngreso->EinColor;?>"  class="EstFormularioCaja"  name="CmpColor" type="text" id="CmpColor" size="30" maxlength="50" /></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" valign="top"><span class="EstFormularioSubTitulo">Datos vehiculares</span></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Año de Fabricacion:</td>
            <td valign="top">
              <span id="sprytextfield1">
                <input value="<?php echo $InsVehiculoIngreso->EinAnoFabricacion;?>"  class="EstFormularioCaja"  name="CmpAnoFabricacion" type="text" id="CmpAnoFabricacion" size="10" maxlength="4" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td>Modelo/Año:</td>
            <td><span id="sprytextfield2">
            <input value="<?php echo $InsVehiculoIngreso->EinAnoModelo;?>"  class="EstFormularioCaja"  name="CmpAnoModelo" type="text" id="CmpAnoModelo" size="10" maxlength="4" />
<span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Numero de Motor:</td>
            <td valign="top"><input value="<?php echo $InsVehiculoIngreso->EinNumeroMotor;?>"  class="EstFormularioCaja"  name="CmpNumeroMotor" type="text" id="CmpNumeroMotor" size="30" maxlength="50" /></td>
            <td>Transmision:</td>
            <td><?php
			switch($InsVehiculoIngreso->EinTransmision){
				case "AT":
					$OpcTransmision1 = 'selected="selected"';
				break;
				
				case "MT":
					$OpcTransmision2 = 'selected="selected"';
				break;
				
			default:
			
			break;
			}
			?>
              <select class="EstFormularioCombo" name="CmpTransmision" id="CmpTransmision">
                <option value="">Escoja una opcion</option>
                <option <?php echo $OpcTransmision1;?> value="AT">AUTOMATICO</option>
                <option <?php echo $OpcTransmision2;?> value="MT">MECANICO</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><span class="EstFormularioSubTitulo">Datos de proforma e ingreso</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Proforma:</td>
            <td><input  name="CmpProformaCodigo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpProformaCodigo" value="<?php echo $InsVehiculoIngreso->VprCodigo;?>" size="30" maxlength="50" readonly="readonly" /></td>
            <td>Año/Mes Proforma</td>
            <td><input  name="CmpProformaAno" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpProformaAno" value="<?php echo $InsVehiculoIngreso->VprAno;?>" size="10" maxlength="4" readonly="readonly" />
              /
              <?php
			switch($InsVehiculoIngreso->VprMes){
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
              <select disabled="disabled" class="EstFormularioCombo" name="CmpProformaMes" id="CmpProformaMes">
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
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Precio Proformado: </td>
            <td><?php echo $InsVehiculoIngreso->MonSimbolo;?>
              <input  name="CmpProformaDetalleCosto" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpProformaDetalleCosto" value="<?php echo $InsVehiculoIngreso->VpdCosto;?>" size="30" maxlength="50" readonly="readonly" />
              <input name="CmpProformaMonedaId" type="hidden" id="CmpProformaMonedaId" value="<?php echo $InsVehiculoIngreso->VehiculoProformaMonId;?>" size="3" />
              <input name="CmpProformaTipoCambio" type="hidden" id="CmpProformaTipoCambio" value="<?php echo $InsVehiculoIngreso->VprTipoCambio;?>" size="3" /></td>
            <td align="left" valign="top">Comprobante:</td>
            <td align="left" valign="top"><input  name="CmpComprobanteCompraNumeroSerie" type="text"  class="EstFormularioCaja" id="CmpComprobanteCompraNumeroSerie" value="<?php echo $InsVehiculoIngreso->EinComprobanteCompraNumeroSerie;?>" size="10" maxlength="20" />
              -
              <input  name="CmpComprobanteCompraNumeroNumero" type="text"  class="EstFormularioCaja" id="CmpComprobanteCompraNumeroNumero" value="<?php echo $InsVehiculoIngreso->EinComprobanteCompraNumeroNumero;?>" size="20" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Zofra:</td>
            <td><?php
			switch($InsVehiculoIngreso->EinZofra){
				case 1:
					$OpcZofra1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcZofra2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpZofra" id="CmpZofra">
                <option value="1" <?php echo $OpcZofra1;?>>Si</option>
                <option <?php echo $OpcZofra2;?> value="2">No</option>
                </select></td>
            <td>Nacionalizado:</td>
            <td><?php
			switch($InsVehiculoIngreso->EinNacionalizado){
				case 1:
					$OpcNacionalizado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcNacionalizado2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpNacionalizado" id="CmpNacionalizado">
                <option <?php echo $OpcNacionalizado1;?> value="1">Si</option>
                <option <?php echo $OpcNacionalizado2;?> value="2">No</option>
                </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Placa:</td>
            <td><input value="<?php echo $InsVehiculoIngreso->EinPlaca;?>"  class="EstFormularioCaja"  name="CmpPlaca" type="text" id="CmpPlaca" size="30" maxlength="50" /></td>
            <td>Origen:</td>
            <td><?php
			switch($InsVehiculoIngreso->EinOrigen){
				case 1:
					$OpcOrigen1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcOrigen2 = 'selected="selected"';
				break;

				case 3:
					$OpcOrigen3 = 'selected="selected"';
				break;
				
			}
			
			?>
              <select class="EstFormularioCombo" name="CmpOrigen" id="CmpOrigen">
                <option <?php echo $OpcOrigen1;?> value="1">Compra</option>
                <option <?php echo $OpcOrigen2;?> value="2">Externo</option>
                <option <?php echo $OpcOrigen3;?> value="3">Cotizacion</option>
              </select>
              
              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><span class="EstFormularioSubTitulo">Otros datos especificos</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Clave de Alarma: </td>
            <td><input value="<?php echo $InsVehiculoIngreso->EinClaveAlarma;?>"  class="EstFormularioCaja"  name="CmpClaveAlarma" type="text" id="CmpClaveAlarma" size="15" maxlength="25" /></td>
            <td>Estado:</td>
            <td><?php
			switch($InsVehiculoIngreso->EinEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          </table>
		</div>
        
         </td>
       </tr>
	   
	   </table>
	   
	   
           </div>
	

		   
<div id="tab2" class="tab_content">
        <!--Content-->
    
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
<div class="EstFormularioArea" >
  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo"> Datos Declaracion	de Aduana</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">DUA:</td>
      <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinDUA;?>"  class="EstFormularioCaja"  name="CmpDUA" type="text" id="CmpDUA" size="30" maxlength="50" /></td>
      <td align="left" valign="top">Responsable</td>
      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpResponsable" id="CmpResponsable" >
        <option value="">Escoja una opcion</option>
        <?php
					foreach($ArrResponsables as $DatResponsable){
					?>
        <option <?php echo ($DatResponsable->PerId==$InsVehiculoIngreso->PerId)?'selected="selected"':'';?>  value="<?php echo $DatResponsable->PerId;?>"><?php echo $DatResponsable->PerNombre ?> <?php echo $DatResponsable->PerApellidoPaterno; ?> <?php echo $DatResponsable->PerApellidoMaterno; ?></option>
        <?php
					}
					?>
        </select></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Fecha Salida:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><span id="sprytextfield6">
        <label>
          <input class="EstFormularioCajaFecha"  name="CmpFechaSalidaDAM" type="text" id="CmpFechaSalidaDAM" value="<?php if(!empty($InsVehiculoIngreso->EinFechaSalidaDAM)){ echo $InsVehiculoIngreso->EinFechaSalidaDAM;}?>" size="15" maxlength="10" />
          </label>
        <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaSalidaDAM" name="BtnFechaSalidaDAM" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
      <td align="left" valign="top">Fecha Retorno:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><span id="sprytextfield3">
        <label>
          <input class="EstFormularioCajaFecha"  name="CmpFechaRetornoDAM" type="text" id="CmpFechaRetornoDAM" value="<?php if(!empty($InsVehiculoIngreso->EinFechaRetornoDAM)){ echo $InsVehiculoIngreso->EinFechaRetornoDAM;}?>" size="15" maxlength="10" />
          </label>
        <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaRetornoDAM" name="BtnFechaRetornoDAM" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Caracteristicas del Vehiculo</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Nombre</td>
      <td colspan="3"><input  name="CmpVehiculoIngresoNombre" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoNombre" value="<?php echo $InsVehiculoIngreso->EinNombre;?>" size="30" maxlength="50" />
        (**)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Marca:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaMarca" value="<?php echo $InsVehiculoIngreso->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Traccion: <span class="EstFormularioSubIndice">(7)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica7);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica7" type="text" id="CmpVehiculoVersionCaracteristica7" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Modelo:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaModelo" value="<?php echo $InsVehiculoIngreso->VmoNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Carroceria: <span class="EstFormularioSubIndice">(8)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica8);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica8" type="text" id="CmpVehiculoVersionCaracteristica8" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Año Fabricacion:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaAnoFabricacion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaAnoFabricacion" value="<?php echo $InsVehiculoIngreso->EinAnoFabricacion;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Num. Puertas: <span class="EstFormularioSubIndice">(9)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica9);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica9" type="text" id="CmpVehiculoVersionCaracteristica9" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Motor:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaNumeroMotor" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristicaNumeroMotor" value="<?php echo $InsVehiculoIngreso->EinNumeroMotor;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Combustible: <span class="EstFormularioSubIndice">(10)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica10" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica10" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica10);?>" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Cilindros: <span class="EstFormularioSubIndice">(1)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica1);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica1" type="text" id="CmpVehiculoVersionCaracteristica1" size="25" maxlength="50" />
        (*)</td>
      <td>Peso Bruto: <span class="EstFormularioSubIndice">(11)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica11);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica11" type="text" id="CmpVehiculoVersionCaracteristica11" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Ejes: <span class="EstFormularioSubIndice">(2)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica2);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica2" type="text" id="CmpVehiculoVersionCaracteristica2" size="25" maxlength="50" />
        (*)</td>
      <td>Carga Util: <span class="EstFormularioSubIndice">(12)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica12" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica12" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica12);?>" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Chasis:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaVIN" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaVIN" value="<?php echo $InsVehiculoIngreso->EinVIN;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Peso Seco: <span class="EstFormularioSubIndice">(13)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica13" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica13" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica13);?>" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Color:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaColor" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaColor" value="<?php echo $InsVehiculoIngreso->EinColor;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Alto: <span class="EstFormularioSubIndice">(14)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica14);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica14" type="text" id="CmpVehiculoVersionCaracteristica14" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Cilindrada: <span class="EstFormularioSubIndice">(3)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica3);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica3" type="text" id="CmpVehiculoVersionCaracteristica3" size="25" maxlength="50" />
        (*)</td>
      <td>Largo: <span class="EstFormularioSubIndice">(15)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica15);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica15" type="text" id="CmpVehiculoVersionCaracteristica15" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Asientos: <span class="EstFormularioSubIndice">(4)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica4);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica4" type="text" id="CmpVehiculoVersionCaracteristica4" size="25" maxlength="50" />
        (*)</td>
      <td>Ancho: <span class="EstFormularioSubIndice">(16)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica16);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica16" type="text" id="CmpVehiculoVersionCaracteristica16" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Cap. Pasajeros: <span class="EstFormularioSubIndice">(5)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica5);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica5" type="text" id="CmpVehiculoVersionCaracteristica5" size="25" maxlength="50" />
        (*)</td>
      <td>Dist. Ejes: <span class="EstFormularioSubIndice">(17)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica17);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica17" type="text" id="CmpVehiculoVersionCaracteristica17" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Poliza:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaDUA" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaDUA" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinDUA);?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td colspan="2">
      
      (*) Estos campos solo deben ser modificados con los datos originales de la DUA.<br /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top">
      
      <input type="checkbox" name="CmpVehiculoVersionCaracteristicaPredeterminar" id="CmpVehiculoVersionCaracteristicaPredeterminar" value="1" />
      
      Predeterminar Nuevas Caracteristicas
      
      |
      
      <a href="javascript:FncCargarCaracteristicasPredeterminadas();">[Cargar Caracteristcas Predeterminadas]</a>
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Archivos de DUA</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Archivo 1:</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top">
      
      
      <!--<iframe src="formularios/VehiculoIngreso/acc/AccVehiculoIngresoSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrVehiculoIngresoSubirArchivo" name="IfrVehiculoIngresoSubirArchivo" scrolling="Auto"  frameborder="0" width="100%" height="200"></iframe>-->
      
      <div class="EstFormularioArea" >
                       <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                         <tr>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           <td width="54" align="left" valign="top">
                             
                             <span class="EstFormularioSubTitulo">Fotos</span></td>
                           <td width="221" align="right" valign="top">
                             
                             <a href="javascript:FncVehiculoIngresoArchivoDAMListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                             
                             </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">

		<div id="fileuploaderDAM">Escoger Archivos</div>
                             
		<script type="text/javascript">
		$(document).ready(function(){

				$("#fileuploaderDAM").uploadFile({
					
				allowedTypes:"png,gif,jpg,jpeg",
				url:"formularios/VehiculoIngreso/acc/AccVehiculoIngresoSubirFotoDAM.php",
				formData: {"Identificador":"<?php echo $Identificador;?>"},
				multiple:false,
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
					FncVehiculoIngresoArchivoDAMListar();
				}
	
	});
});
			</script>
                             
                             
                             
                             
                           </td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoIngresoFotos" id="CapVehiculoIngresoArchivoDAMs"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">
                             
                             <div id="CapVehiculoIngresoArchivoDAMsAccion"></div>
                             </td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">&nbsp;</td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         </table>
                     </div>
                     
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Archivo 2:</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top">
      


<div class="EstFormularioArea" >
                       <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                         <tr>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           <td width="54" align="left" valign="top">
                             
                             <span class="EstFormularioSubTitulo">Fotos</span></td>
                           <td width="221" align="right" valign="top">
                             
                             <a href="javascript:FncVehiculoIngresoArchivoDAM2Listar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                             
                             </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">
                             <div id="fileuploaderDAM2">Escoger Archivos</div>
                             
                             
                             
		<script type="text/javascript">
		$(document).ready(function(){

				$("#fileuploaderDAM2").uploadFile({
					
				allowedTypes:"png,gif,jpg,jpeg",
				url:"formularios/VehiculoIngreso/acc/AccVehiculoIngresoSubirFotoDAM2.php",
				formData: {"Identificador":"<?php echo $Identificador;?>"},
				multiple:false,
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
					FncVehiculoIngresoArchivoDAM2Listar();
				}
	
	});
});
			</script>
                             
                             
                             
                             
                           </td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoIngresoFotos" id="CapVehiculoIngresoArchivoDAM2s"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">
                             
                             <div id="CapVehiculoIngresoArchivoDAM2sAccion"></div>
                             </td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">&nbsp;</td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         </table>
                     </div>
                     
                     
                     
                     <!--<iframe src="formularios/VehiculoIngreso/acc/AccVehiculoIngresoSubirArchivo2.php?Identificador=<?php echo $Identificador;?>" id="IfrVehiculoIngresoSubirArchivo2" name="IfrVehiculoIngresoSubirArchivo2" scrolling="Auto"  frameborder="0" width="100%" height="200"></iframe>--></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Archivo 3:</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><!--<iframe src="formularios/VehiculoIngreso/acc/AccVehiculoIngresoSubirArchivo3.php?Identificador=<?php echo $Identificador;?>" id="IfrVehiculoIngresoSubirArchivo3" name="IfrVehiculoIngresoSubirArchivo3" scrolling="Auto"  frameborder="0" width="100%" height="200"></iframe>-->
      
      <div class="EstFormularioArea" >
                       <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                         <tr>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           <td width="54" align="left" valign="top">
                             
                             <span class="EstFormularioSubTitulo">Fotos</span></td>
                           <td width="221" align="right" valign="top">
                             
                             <a href="javascript:FncVehiculoIngresoArchivoDAM2Listar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                             
                             </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">
                             <div id="fileuploaderDAM3">Escoger Archivos</div>
                             
                             
                             
		<script type="text/javascript">
		$(document).ready(function(){

				$("#fileuploaderDAM3").uploadFile({
					
				allowedTypes:"png,gif,jpg,jpeg",
				url:"formularios/VehiculoIngreso/acc/AccVehiculoIngresoSubirFotoDAM3.php",
				formData: {"Identificador":"<?php echo $Identificador;?>"},
				multiple:false,
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
					FncVehiculoIngresoArchivoDAM3Listar();
				}
	
	});
});
			</script>
                             
                             
                             
                             
                           </td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoIngresoFotos" id="CapVehiculoIngresoArchivoDAM3s"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">
                             
                             <div id="CapVehiculoIngresoArchivoDAM3sAccion"></div>
                             </td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td align="left" valign="top">&nbsp;</td>
                           <td colspan="2" align="left" valign="top">&nbsp;</td>
                           <td align="left" valign="top">&nbsp;</td>
                           </tr>
                         </table>
                     </div>
                     
                     </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
</div>
        
        
           </td>
         </tr>
		 
		 
		 
		 </table> 
           

	</div>
    
  
    

    	<div id="tab3" class="tab_content">
        <!--Content-->
    
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
<div class="EstFormularioArea" >
  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo"> Datos Estado Vehicular</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Estado:</td>
      <td align="left" valign="top"><?php
			switch($InsVehiculoIngreso->EinEstadoVehicular){
				case "STOCK":
					$OpcEstadoVehicular1 = 'selected="selected"';
				break;
				
				case "VENDIDO":
					$OpcEstadoVehicular2 = 'selected="selected"';
				break;
				
				
				case "RESERVADO":
					$OpcEstadoVehicular3 = 'selected="selected"';
				break;
				
				case "EXTERNO":
					$OpcEstadoVehicular4 = 'selected="selected"';
				break;
				
				default:
				
				break;

			}
			?>
        <select class="EstFormularioCombo" name="CmpEstadoVehicular" id="CmpEstadoVehicular">
          <option value="">Escoja una opcion</option>
          <option <?php echo $OpcEstadoVehicular1;?> value="STOCK">STOCK</option>
          <option <?php echo $OpcEstadoVehicular2;?> value="VENDIDO">VENDIDO</option>
          <option <?php echo $OpcEstadoVehicular3;?> value="RESERVADO">RESERVADO</option>
          <option <?php echo $OpcEstadoVehicular4;?> value="EXTERNO">EXTERNO</option>
          </select></td>
      <td align="left" valign="top">Solicitud:</td>
      <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinSolicitud;?>"  class="EstFormularioCaja"  name="CmpSolicitud" type="text" id="CmpSolicitud" size="30" maxlength="50" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Fecha Salida:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><span id="sprytextfield7">
        <label>
          <input class="EstFormularioCajaFecha"  name="CmpEstadoVehicularFechaSalida" type="text" id="CmpEstadoVehicularFechaSalida" value="<?php if(!empty($InsVehiculoIngreso->EinEstadoVehicularFechaSalida)){ echo $InsVehiculoIngreso->EinEstadoVehicularFechaSalida;}?>" size="15" maxlength="10" />
        </label>
        <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnEstadoVehicularFechaSalida" name="BtnEstadoVehicularFechaSalida" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
      <td align="left" valign="top">Fecha Llegada:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><span id="sprytextfield8">
        <label>
          <input class="EstFormularioCajaFecha"  name="CmpEstadoVehicularFechaLlegada" type="text" id="CmpEstadoVehicularFechaLlegada" value="<?php if(!empty($InsVehiculoIngreso->EinEstadoVehicularFechaLlegada)){ echo $InsVehiculoIngreso->EinEstadoVehicularFechaLlegada;}?>" size="15" maxlength="10" />
        </label>
        <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnEstadoVehicularFechaLlegada" name="BtnEstadoVehicularFechaLlegada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Guia de Transporte:</td>
      <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinGuiaTransporte;?>"  class="EstFormularioCaja"  name="CmpGuiaTransporte" type="text" id="CmpGuiaTransporte" size="30" maxlength="50" /></td>
      <td align="left" valign="top">Guia de Remision</td>
      <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinGuiaRemision;?>"  class="EstFormularioCaja"  name="CmpGuiaRemision" type="text" id="CmpGuiaRemision" size="30" maxlength="50" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Num. Viaje:</td>
      <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinNumeroViaje;?>"  class="EstFormularioCaja"  name="CmpNumeroViaje" type="text" id="CmpNumeroViaje" size="30" maxlength="50" /></td>
      <td align="left" valign="top">Ubicacion:</td>
      <td align="left" valign="top">
      
      
                  <?php
			switch($InsVehiculoIngreso->EinUbicacion){
				
				case "SAVAR":
					$OpcEstadoVehicular1 = 'selected="selected"';
				break;
				
				case "HUACHIPA":
					$OpcEstadoVehicular2 = 'selected="selected"';
				break;
				
				case "TRANSITO":
					$OpcEstadoVehicular3 = 'selected="selected"';
				break;
				
				case "TACNA PRINCIPAL":
					$OpcEstadoVehicular4 = 'selected="selected"';
				break;
				
				case "TACNA SUCURSAL":
					$OpcEstadoVehicular5 = 'selected="selected"';
				break;
				
				default:
				
				break;

			}
			?>

<select class="EstFormularioCombo" name="CmpUbicacion" id="CmpUbicacion">
<option value="">Escoja una opcion</option>
<option <?php echo $OpcEstadoVehicular1;?> value="SAVAR">SAVAR</option>
<option <?php echo $OpcEstadoVehicular2;?> value="HUACHIPA">HUACHIPA</option>
<option <?php echo $OpcEstadoVehicular3;?> value="TRANSITO">TRANSITO</option>
<option <?php echo $OpcEstadoVehicular4;?> value="TACNA PRINCIPAL">TACNA PRINCIPAL</option>
<option <?php echo $OpcEstadoVehicular5;?> value="TACNA SUCURSAL">TACNA SUCURSAL</option>
</select>



      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">Manual Propietario:</td>
      <td align="left" valign="top"><?php
			switch($InsVehiculoIngreso->EinEstadoVehicularManualPropietario){
				case 1:
					$OpcEstadoVehicularManualPropietario1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstadoVehicularManualPropietario2 = 'selected="selected"';
				break;

			}
			?>
        <select class="EstFormularioCombo" name="CmpManualPropietario" id="CmpManualPropietario">
          <option <?php echo $OpcEstadoVehicularManualCliente1;?> value="1">Si</option>
          <option <?php echo $OpcEstadoVehicularManualCliente2;?> value="2">No</option>
        </select></td>
      <td align="left" valign="top">Manual Garantia:</td>
      <td align="left" valign="top"><?php
			switch($InsVehiculoIngreso->EinEstadoVehicularManualGarantia){
				case 1:
					$OpcEstadoVehicularManualGarantia1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstadoVehicularManualGarantia2 = 'selected="selected"';
				break;

			}
			?>
        <select class="EstFormularioCombo" name="CmpManualGarantia" id="CmpManualGarantia">
          <option <?php echo $OpcEstadoVehicularManualGarantia1;?> value="1">Si</option>
          <option <?php echo $OpcEstadoVehicularManualGarantia2;?> value="2">No</option>
        </select></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr> </tr>
  </table>
</div>
        
        
           </td>
         </tr>
		 
		 
		 
		 </table> 
           

	</div>   
    
    
    
    
    
    	<div id="tab4" class="tab_content">
        <!--Content-->
    
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
           <div class="EstFormularioArea" >
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2"><span class="EstFormularioSubTitulo">PROPIETARIOS</span></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2"><div class="EstFormularioArea">
                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="3"><input type="hidden" name="CmpVehiculoIngresoClienteItem" id="CmpVehiculoIngresoClienteItem" />
                         <input type="hidden" name="CmpClienteId" id="CmpClienteId" /></td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>Tipo Doc.</td>
                       <td>Num. Documento</td>
                       <td>Nombre:</td>
                       <td>Fecha Vigencia:</td>
                       <td>Vigente</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><select disabled="disabled"  class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                         <option value="">Escoja una opcion</option>
                         <?php
foreach($ArrTipoDocumentos as $DatTipoDocumento){
?>
                         <option <?php echo $DatTipoDocumento->TdoId;?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                         <?php
}
?>
                       </select></td>
                       <td><table border="0" cellpadding="0" cellspacing="0">
                         <tr>
                           <td><a id="BtnClienteNuevo" href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                           <td><input tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="15" maxlength="50"   /></td>
                           <td><a id="BtnClienteBuscarNumeroDocumento" href="javascript:FncClienteBuscar('NumeroDocumento');"> <img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                           <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                           <td><div id="CapClienteBuscar"></div></td>
                         </tr>
                         <tr> </tr>
                       </table></td>
                       <td><input  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="40" maxlength="255"  /></td>
                       <td><input class="EstFormularioCajaFecha"  name="CmpVehiculoIngresoClienteFecha" type="text" id="CmpVehiculoIngresoClienteFecha" size="10" maxlength="10" />
                       <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnVehiculoIngresoClienteFecha" name="BtnVehiculoIngresoClienteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                       <td><select  class="EstFormularioCombo" name="CmpVehiculoIngresoClienteEstado" id="CmpVehiculoIngresoClienteEstado">
                         
                         <option value="1">Vigente</option>
                         <option value="2">Antiguo</option>
                       </select></td>
                       <td><a href="javascript:FncVehiculoIngresoClienteGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                     </tr>
                   </table>
                 </div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2"><div class="EstFormularioArea" >
                   <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                     <tr>
                       <td>&nbsp;</td>
                       <td><input type="hidden" name="CmpVehiculoIngresoClienteAccion" id="CmpVehiculoIngresoClienteAccion" value="AccVehiculoIngresoClienteRegistrar.php" /></td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td width="1%">&nbsp;</td>
                       <td width="49%"><div class="EstFormularioAccion" id="CapVehiculoIngresoClienteAccion">Listo
                         para registrar elementos</div></td>
                       <td width="49%" align="right"><a href="javascript:FncVehiculoIngresoClienteListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoIngresoClienteEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
                       <td width="1%"><div id="CapVehiculoIngresoClientesResultado"> </div></td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="2"><div id="CapVehiculoIngresoClientes" class="EstCapVehiculoIngresoClientes" > </div></td>
                       <td>&nbsp;</td>
                     </tr>
                   </table>
                 </div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="2"></td>
                 <td>&nbsp;</td>
               </tr>
             </table>
           </div>
        
        
           </td>
         </tr>
		 
		 
		 
		 </table> 
           

	</div>
    
    
     <div id="tab5" class="tab_content">
        <!--Content-->
    
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
           <div class="EstFormularioArea" >
           



              
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">GERENCIA</td>
            <td>&nbsp;</td>
          </tr>
          
           <tr>
             <td>&nbsp;</td>
             <td colspan="2"><div class="EstFormularioArea">
               <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                 <tr>
                   <td>&nbsp;</td>
                   <td colspan="5">&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td align="left" valign="top">Moneda:
                     <input type="hidden" name="CmpTipoCambioFecha" id="CmpTipoCambioFecha" value="<?php echo $InsCliente->CliTipoCambioFecha;?>" /></td>
                   <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                       <td><span id="spryselect3">
                         <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                           <option value="">Escoja una opcion</option>
                           <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                           <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVehiculoIngreso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                           <?php
			  }
			  ?>
                           </select>
                         <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                       <td><div id="CapMonedaBuscar"></div></td>
                       </tr>
                     <tr> </tr>
                   </table></td>
                   <td align="left" valign="top">Tipo de Cambio:<br />
                     <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                   <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                       <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio"  value="<?php  echo $InsVehiculoIngreso->EinTipoCambio;?>" size="10" maxlength="10" readonly="readonly" /></td>
                       <td><a href="javascript:FncVehiculoIngresoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                     </tr>
                   </table></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td align="left" valign="top">Descuento de Gerencia:                     </td>
                   <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpDescuentoGerencia" type="text" id="CmpDescuentoGerencia" value="<?php echo number_format($InsVehiculoIngreso->EinDescuentoGerencia,2);?>" size="20" maxlength="20" /></td>
                   <td>&nbsp;</td>
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
                   </tr>
                 </table>
               </div></td>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
             <td colspan="2">
               
               </td>
             <td>&nbsp;</td>
           </tr>
          </table>
           
            </div>
        
        
           </td>
         </tr>
		 
		 
		 
		 </table> 
           

	</div>
    
    
                   <div id="tab6" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
              
              
              <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto VIN</span></td>
                      </tr>
                    <tr>
                      <td>
                      
                      
                      
                      
                      
                      <div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="93" align="left" valign="top">
                                  
                                  <span class="EstFormularioSubTitulo">Fotos</span></td>
                                  <td width="168" align="right" valign="top">

									<a href="javascript:FncFichaAccionFotoVINListar();"></a>

                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                  

<?php              
              
if(!empty($_SESSION['SesEinFotoVIN'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesEinFotoVIN'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesEinFotoVIN'.$Identificador], '.'.$extension);  
?>
		        
		        Vista Previa:<br />
		        
		        <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  <?php	
}else{
?>
		        No hay FOTO
  <?php	
}
?>
		        
		        
  
  
  
  
  
  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioNota">* Fotos del VIN del vehiculo </span>
                                    
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                            
                      <!--<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="96%" colspan="2"><iframe src="formularios/FichaAccion/acc/AccFichaAccionSubirFotoVIN.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoVin" name="IfrFichaAccionSubirFotoVin" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div>--></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Frontal</span></td>
                    </tr>
                    <tr>
                      <td>
                      
                      
                      
                      <div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="93" align="left" valign="top">
                                  
                                  <span class="EstFormularioSubTitulo">Fotos</span></td>
                                  <td width="168" align="right" valign="top">

									<a href="javascript:FncFichaAccionFotoDelanteraListar();"></a>

                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                  


<?php              
              
if(!empty($_SESSION['SesEinFotoFrontal'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesEinFotoFrontal'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesEinFotoFrontal'.$Identificador], '.'.$extension);  
?>
		        
		        Vista Previa:<br />
		        
		        <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  <?php	
}else{
?>
		        No hay FOTO
  <?php	
}
?>
		        
		   
           
           
           </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioNota">* Fotos de la Delantera del vehiculo </span>
                                    
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                            
                            
                      <!--<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="96%" colspan="2"><iframe src="formularios/FichaAccion/acc/AccFichaAccionSubirFotoDelantera.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoDelantera" name="IfrFichaAccionSubirFotoDelantera" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Cupon</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                            <td width="139" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span></td>
                            <td width="136" align="right" valign="top"><a href="javascript:FncFichaAccionFotoCuponListar();"></a></td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top"><?php              
              
if(!empty($_SESSION['SesEinFotoCupon'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesEinFotoCupon'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesEinFotoCupon'.$Identificador], '.'.$extension);  
?>
		        
		        Vista Previa:<br />
		        
		        <img  src="subidos/ficha_ingreso_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
  <?php	
}else{
?>
		        No hay FOTO
  <?php	
}
?>
		</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
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
        <td align="center"></td>
      </tr>
    </table>
    
    
</div>


	
	
	
    

</form>


<script type="text/javascript">
//Calendar.setup({ 
//	inputField : "CmpRecepcionFecha",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnRecepcionFecha"// el id del botón que  
//	}); 
//	
	
Calendar.setup({ 
	inputField : "CmpFechaSalidaDAM",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaSalidaDAM"// el id del botón que  
	}); 
	
Calendar.setup({ 
	inputField : "CmpFechaRetornoDAM",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaRetornoDAM"// el id del botón que  
	}); 
	
	
	
	Calendar.setup({ 
	inputField : "CmpEstadoVehicularFechaSalida",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnEstadoVehicularFechaSalida"// el id del botón que  
	}); 
	
Calendar.setup({ 
	inputField : "CmpEstadoVehicularFechaLlegada",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnEstadoVehicularFechaLlegada"// el id del botón que  
	}); 
	
	

	Calendar.setup({ 
	inputField : "CmpVehiculoIngresoClienteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnVehiculoIngresoClienteFecha"// el id del botón que  
	}); 
	
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "date", {format:"dd/mm/yyyy", isRequired:false});
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
?>
