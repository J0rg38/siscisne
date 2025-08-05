<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

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
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoIngreso.php');

//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
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

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,0,0,1);
$ArrResponsables = $ResPersonal['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript" >

var VehiculoMarcaHabilitado = 2;
var VehiculoModeloHabilitado = 2;
var VehiculoVersionHabilitado = 2;

var VehiculoColorHabilitado = 2;

var VehiculoIngresoClienteEditar = 2;
var VehiculoIngresoClienteEliminar = 2;

var VehiculoIngresoFotoEditar = 2;
var VehiculoIngresoFotoEliminar = 2;

var VehiculoIngresoArchivoDAMEditar = 2;
var VehiculoIngresoArchivoDAMEliminar = 2;

var VehiculoIngresoArchivoDAM2Editar = 2;
var VehiculoIngresoArchivoDAM2Eliminar = 2;

var VehiculoIngresoArchivoDAM3Editar = 2;
var VehiculoIngresoArchivoDAM3Eliminar = 2;

$().ready(function() {
	
	FncVehiculoMarcasCargar();
	
	FncVehiculoIngresoClienteListar();
	
	FncVehiculoIngresoFotoListar();
	
		
	FncVehiculoIngresoArchivoDAMListar();
	FncVehiculoIngresoArchivoDAM2Listar();
	FncVehiculoIngresoArchivoDAM3Listar();

});

</script>

<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculoIngreso->EinId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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


<!--<div class="EstSubMenuBoton"><a href="javascript:FncPopUp('formularios/VehiculoIngreso/FrmVehiculoIngresoCodigoBarra.php?o=1&t=40&r=1&text=<?php echo ($InsVehiculoIngreso->EinId);?>&f=2&a1=&a2=',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/codigo_barra.png" alt="[GCBarra]" title="Imprimir Codigo de Barras" />Cod. Barra</a></div>
-->


</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">VER INGRESO DE VEHICULO</span></td>
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
                Datos del Ingreso	de	Vehiculo	
                <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
              </span></td>
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
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Codigo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoIngreso->EinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td valign="top">VIN:              </td>
            <td valign="top"><input name="CmpVIN" type="text" class="EstFormularioCaja" id="CmpVIN" value="<?php echo $InsVehiculoIngreso->EinVIN;?>" size="20" maxlength="40"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Concesionario:</td>
            <td valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpConcesionario" id="CmpConcesionario" >
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
            <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" disabled="disabled" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoIngreso->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td>Modelo:
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoIngreso->VmoId;?>" size="3" /></td>
            <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
            </select></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Version:
              <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculoIngreso->VveId;?>" size="3" /></td>
            <td valign="top"><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
            </select></td>
            <td>Color:
              <input name="CmpVehiculoColorId" type="hidden" id="CmpVehiculoColorId" value="<?php echo $InsVehiculoIngreso->VehId;?>" size="3" /></td>
            <td valign="top"><input value="<?php echo $InsVehiculoIngreso->EinColor;?>"  class="EstFormularioCaja"  name="CmpColor" type="text" id="CmpColor" size="30" maxlength="50" /></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Año de Fabricacion:</td>
            <td valign="top"><input  name="CmpAnoFabricacion" type="text"  class="EstFormularioCaja" id="CmpAnoFabricacion" value="<?php echo $InsVehiculoIngreso->EinAnoFabricacion;?>" size="10" maxlength="4" readonly="readonly" /></td>
            <td>Modelo/Año:</td>
            <td><input  name="CmpAnoModelo" type="text"  class="EstFormularioCaja" id="CmpAnoModelo" value="<?php echo $InsVehiculoIngreso->EinAnoModelo;?>" size="10" maxlength="4" readonly="readonly" /></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Numero de Motor:</td>
            <td><input  name="CmpNumeroMotor" type="text"  class="EstFormularioCaja" id="CmpNumeroMotor" value="<?php echo $InsVehiculoIngreso->EinNumeroMotor;?>" size="30" maxlength="50" readonly="readonly" /></td>
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
              <select class="EstFormularioCombo" name="CmpTransmision" id="CmpTransmision" disabled="disabled">
                <option value="">Escoja una opcion</option>
                <option <?php echo $OpcTransmision1;?> value="AT">AUTOMATICO</option>
                <option <?php echo $OpcTransmision2;?> value="MT">MECANICO</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td><input  name="CmpPlaca" type="text"  class="EstFormularioCaja" id="CmpPlaca" value="<?php echo $InsVehiculoIngreso->EinPlaca;?>" size="30" maxlength="50" readonly="readonly" /></td>
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
              <select class="EstFormularioCombo" name="CmpOrigen" id="CmpOrigen" disabled="disabled">
                <option <?php echo $OpcOrigen1;?> value="1">Compra</option>
                <option <?php echo $OpcOrigen2;?> value="2">Externo</option>
                <option <?php echo $OpcOrigen3;?> value="3">Externo</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
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
              <select  disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
              </select></td>
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
      <td>&nbsp;</td>
      <td colspan="4"><span class="EstFormularioSubTitulo"> Datos Declaracion	de Aduana</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>DUA:</td>
      <td><input  name="CmpDUA" type="text"  class="EstFormularioCaja" id="CmpDUA" value="<?php echo $InsVehiculoIngreso->EinDUA;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Responsable</td>
      <td><select  class="EstFormularioCombo" name="CmpResponsable" id="CmpResponsable" disabled="disabled" >
        <option value="">Escoja una opcion</option>
        <?php
					foreach($ArrResponsables as $DatResponsable){
					?>
        <option <?php echo ($DatResponsable->PerId==$InsVehiculoIngreso->PerId)?'selected="selected"':'';?>  value="<?php echo $DatResponsable->PerId;?>"><?php echo $DatResponsable->PerNombre ?> <?php echo $DatResponsable->PerApellidoPaterno; ?> <?php echo $DatResponsable->PerApellidoMaterno; ?></option>
        <?php
					}
					?>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">Fecha Salida:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><input  name="CmpFechaSalidaDAM" type="text" class="EstFormularioCajaFecha" id="CmpFechaSalidaDAM" value="<?php if(!empty($InsVehiculoIngreso->EinFechaSalidaDAM)){ echo $InsVehiculoIngreso->EinFechaSalidaDAM;}?>" size="15" maxlength="10" readonly="readonly" /></td>
      <td>Fecha Retorno:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td><input  name="CmpFechaRetornoDAM" type="text" class="EstFormularioCajaFecha" id="CmpFechaRetornoDAM" value="<?php if(!empty($InsVehiculoIngreso->EinFechaRetornoDAM)){ echo $InsVehiculoIngreso->EinFechaRetornoDAM;}?>" size="15" maxlength="10" readonly="readonly" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4"><span class="EstFormularioSubTitulo">Caracteristicas del Vehiculo</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nombre</td>
      <td><input  name="CmpVehiculoIngresoNombre" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoNombre" value="<?php echo $InsVehiculoIngreso->EinNombre;?>" size="30" maxlength="50" readonly="readonly" />
        (**)</td>
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
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Marca:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaMarca" value="<?php echo $InsVehiculoIngreso->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Traccion: <span class="EstFormularioSubIndice">(7)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica7" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica7" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica7);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Modelo:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaModelo" value="<?php echo $InsVehiculoIngreso->VmoNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Carroceria: <span class="EstFormularioSubIndice">(8)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica8" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica8" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica8);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Año Fabricacion:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaAnoFabricacion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaAnoFabricacion" value="<?php echo $InsVehiculoIngreso->EinAnoFabricacion;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Num. Puertas: <span class="EstFormularioSubIndice">(9)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica9" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica9" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica9);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Num. Motor:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaNumeroMotor" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaNumeroMotor" value="<?php echo $InsVehiculoIngreso->EinNumeroMotor;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Combustible: <span class="EstFormularioSubIndice">(10)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica10" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica10" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica10);?>" size="25" maxlength="50" readonly="readonly" />
/
  <input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica10);?>"  class="EstFormularioCaja"  name="CmpCaracteristica10" type="text" id="CmpCaracteristica10" size="15" maxlength="50" />
  (**)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Num. Cilindros: <span class="EstFormularioSubIndice">(1)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica1" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica1" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica1);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>Peso Bruto: <span class="EstFormularioSubIndice">(11)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica11" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica11" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica11);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Num. Ejes: <span class="EstFormularioSubIndice">(2)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica2" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica2" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica2);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>Carga Util: <span class="EstFormularioSubIndice">(12)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica12" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica12" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica12);?>" size="25" maxlength="50" readonly="readonly" />
/
  <input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica12);?>"  class="EstFormularioCaja"  name="CmpCaracteristica12" type="text" id="CmpCaracteristica12" size="15" maxlength="50" />
  (**)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Num. Chasis:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaVIN" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaVIN" value="<?php echo $InsVehiculoIngreso->EinVIN;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Peso Seco: <span class="EstFormularioSubIndice">(13)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica13" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica13" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica13);?>" size="25" maxlength="50" readonly="readonly" />
        /
        <input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica13);?>"  class="EstFormularioCaja"  name="CmpCaracteristica13" type="text" id="CmpCaracteristica13" size="15" maxlength="50" />
        (**)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Color:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaColor" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaColor" value="<?php echo $InsVehiculoIngreso->EinColor;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Alto: <span class="EstFormularioSubIndice">(14)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica14" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica14" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica14);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Cilindrada: <span class="EstFormularioSubIndice">(3)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica3" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica3" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica3);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>Largo: <span class="EstFormularioSubIndice">(15)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica15" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica15" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica15);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Num. Asientos: <span class="EstFormularioSubIndice">(4)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica4" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica4" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica4);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>Ancho: <span class="EstFormularioSubIndice">(16)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica16" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica16" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica16);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Cap. Pasajeros: <span class="EstFormularioSubIndice">(5)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica5" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica5" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica5);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>Dist. Ejes: <span class="EstFormularioSubIndice">(17)</span></td>
      <td><input  name="CmpVehiculoVersionCaracteristica17" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristica17" value="<?php echo htmlspecialchars($InsVehiculoIngreso->VveCaracteristica17);?>" size="25" maxlength="50" readonly="readonly" />
        (*)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Num. Poliza:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaDUA" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaDUA" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinDUA);?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td colspan="2">
      
        
      (*) Estos campos solo deben ser modificados con los datos originales de la DUA.<br />
      (**) Estos campos reemplazarán los datos originales del vehiculo en la facturación. (Ejem.: Vehiculos con sistema GLP)
      
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4"><span class="EstFormularioSubTitulo">Archivos de DUA</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Archivo 1:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">
      

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
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Archivo 2:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">
	  
      
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
                     
                     
                     </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Archivo 3:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">
	  
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
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
    
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
<div class="EstFormularioArea" >
  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td>&nbsp;</td>
      <td colspan="4"><span class="EstFormularioSubTitulo"> Datos Estado Vehicular</span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
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
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">Fecha Salida:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><input  name="CmpEstadoVehicularFechaSalida" type="text" class="EstFormularioCajaFecha" id="CmpEstadoVehicularFechaSalida" value="<?php if(!empty($InsVehiculoIngreso->EinEstadoVehicularFechaSalida)){ echo $InsVehiculoIngreso->EinEstadoVehicularFechaSalida;}?>" size="15" maxlength="10" readonly="readonly" /></td>
      <td align="left" valign="top">Fecha Llegada:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><input  name="CmpEstadoVehicularFechaLlegada" type="text" class="EstFormularioCajaFecha" id="CmpEstadoVehicularFechaLlegada" value="<?php if(!empty($InsVehiculoIngreso->EinEstadoVehicularFechaLlegada)){ echo $InsVehiculoIngreso->EinEstadoVehicularFechaLlegada;}?>" size="15" maxlength="10" readonly="readonly" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">Guia de Transporte:</td>
      <td align="left" valign="top"><input  name="CmpGuiaTransporte" type="text"  class="EstFormularioCaja" id="CmpGuiaTransporte" value="<?php echo $InsVehiculoIngreso->EinGuiaTransporte;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td align="left" valign="top">Guia de Remision</td>
      <td align="left" valign="top"><input  name="CmpGuiaRemision" type="text"  class="EstFormularioCaja" id="CmpGuiaRemision" value="<?php echo $InsVehiculoIngreso->EinGuiaRemision;?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left" valign="top">Num. Viaje:</td>
      <td align="left" valign="top"><input  name="CmpNumeroViaje" type="text"  class="EstFormularioCaja" id="CmpNumeroViaje" value="<?php echo $InsVehiculoIngreso->EinNumeroViaje;?>" size="30" maxlength="50" readonly="readonly" /></td>
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
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
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
        <select class="EstFormularioCombo" name="CmpManualPropietario" id="CmpManualPropietario" disabled="disabled">
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
        <select class="EstFormularioCombo" name="CmpManualGarantia" id="CmpManualGarantia" disabled="disabled">
          <option <?php echo $OpcEstadoVehicularManualGarantia1;?> value="1">Si</option>
          <option <?php echo $OpcEstadoVehicularManualGarantia2;?> value="2">No</option>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> </tr>
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
                 <td colspan="2">&nbsp;</td>
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
                       <td width="49%" align="right"><a href="javascript:FncVehiculoIngresoClienteListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoIngresoClienteEliminarTodo();"></a></td>
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
                       <td><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                         <option value="">Escoja una opcion</option>
                         <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                         <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVehiculoIngreso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
                   <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                       <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio"  value="<?php  echo $InsVehiculoIngreso->EinTipoCambio;?>" size="10" maxlength="10" readonly="readonly" /></td>
                       <td><a href="javascript:FncClienteEstablecerMoneda();"></a></td>
                     </tr>
                   </table></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td align="left" valign="top">Descuento de Gerencia:                     </td>
                   <td align="left" valign="top"><input name="CmpDescuentoGerencia" type="text" class="EstFormularioCaja" id="CmpDescuentoGerencia" value="<?php echo number_format($InsVehiculoIngreso->EinDescuentoGerencia,2);?>" size="20" maxlength="20" readonly="readonly" /></td>
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
        <td align="center">&nbsp;</td>
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
