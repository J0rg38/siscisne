<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso",$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoMarcaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoAutocompletarFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoSimpleClienteFunciones.js" ></script>



<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoIngresoSimple.css');
</style>



<?php
//VARIABLES
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_VehiculoIngresoVIN = $_GET['VehiculoIngresoVIN'];
$GET_VehiculoMarcaId = $_GET['VehiculoMarcaId'];
$GET_VehiculoModeloId = $_GET['VehiculoModeloId'];
$GET_VehiculoVersionId = $_GET['VehiculoVersionId'];

$GET_VehiculoIngresoColor = (($_GET['VehiculoIngresoColor']=="undefined")?'':$_GET['VehiculoIngresoColor']);
$GET_VehiculoIngresoAnoFabricacion = (($_GET['VehiculoIngresoAnoFabricacion']=="undefined")?'':$_GET['VehiculoIngresoAnoFabricacion']);
$GET_VehiculoIngresoAnoModelo = (($_GET['VehiculoIngresoAnoModelo']=="undefined")?'':$_GET['VehiculoIngresoAnoModelo']);

$GET_VehiculoIngresoNumeroMotor = (($_GET['VehiculoIngresoNumeroMotor']=="undefined")?'':$_GET['VehiculoIngresoNumeroMotor']);



//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoIngresoSimple.php');
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
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

//INSTANCIAS
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsConcesionario = new ClsConcesionario();
$InsTipoDocumento = new ClsTipoDocumento();
$InsPersonal = new ClsPersonal();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();


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
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoIngresoSimpleRegistrar.php');
//DATOS
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];
//MtdObtenerConcesionarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OncId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)
$ResConcesionario = $InsConcesionario->MtdObtenerConcesionarios(NULL,NULL,'OncNombre',"ASC",NULL,1);
$ArrConcesionarios = $ResConcesionario['Datos'];
//MtdObtenerPersonales($oCampo=NULL,$oCondicion,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,0,0,1);
$ArrResponsables = $ResPersonal['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

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
var VehiculoModeloVigencia = 0
$().ready(function() {
	
	
	FncVehiculoMarcasCargar();

	FncVehiculoIngresoSimpleClienteListar();
	
	
});
</script>



<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">
    



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
        <td width="961" height="25"><span class="EstFormularioTitulo">REGISTRAR INGRESO DE VEHICULO EXTERNO</span></td>
      </tr>
      <tr>
        <td>
		
        
        
	
    
<ul class="tabs">
    <li><a href="#tab1"> Ingreso de Vehiculo</a></li>
  
    <li><a href="#tab4"> Clientes</a></li>
 

</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

		
		 
		
     
        
	   
       
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
           <div class="EstFormularioArea" >
         
         
          
 

              
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">
              <span class="EstFormularioSubTitulo">
                Datos del Ingreso	de	Vehiculo	</span>			
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
              <input type="hidden" name="CmpEstadoVehicular" id="CmpEstadoVehicular"  value="<?php echo $InsVehiculoIngreso->EinEstadoVehicular; ?>" />
              <input type="hidden" name="CmpSucursal" id="CmpSucursal"  value="<?php echo $InsVehiculoIngreso->SucId; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoIngreso->EinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">VIN:              </td>
            <td align="left" valign="top"><input name="CmpVIN" type="text" class="EstFormularioCaja" id="CmpVIN" value="<?php echo $InsVehiculoIngreso->EinVIN;?>" size="20" maxlength="40"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Concesionario:</td>
            <td align="left" valign="top">
              
              <select class="EstFormularioCombo" name="CmpConcesionario" id="CmpConcesionario" >
                <option value="">Escoja una opcion</option>
                <?php
			foreach($ArrConcesionarios as $DatConcesionario){
			?>
                <option <?php echo $DatConcesionario->OncId;?> <?php echo ($DatConcesionario->OncId==$InsVehiculoIngreso->OncId)?'selected="selected"':"";?> value="<?php echo $DatConcesionario->OncId?>"><?php echo $DatConcesionario->OncNombre?></option>
                <?php
			}
			?>
              </select></td>
            <td align="left" valign="top">Codigo Identificador:</td>
            <td align="left" valign="top"><input name="CmpVehiculoCodigoIdentificador" type="text" class="EstFormularioCaja" id="CmpVehiculoCodigoIdentificador" value="<?php echo $InsVehiculoIngreso->VehCodigoIdentificador;?>" size="20" maxlength="40" readonly="readonly"  />
              <input name="CmpVehiculoId" type="hidden" id="CmpVehiculoId" value="<?php echo $InsVehiculoIngreso->VehId;?>" size="3" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Marca:
              <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsVehiculoIngreso->VmaId;?>" size="3" /></td>
            <td align="left" valign="top">
            
            <table>
            <tr>
            <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoIngreso->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td>
            

<a id="BtnVehiculoMarcaRegistrar" onclick="FncVehiculoMarcaCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> 
            
            <a id="BtnVehiculoMarcaEditar" onclick="FncVehiculoMarcaCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a>
            
            
            </td>
            </tr>
            </table>
            
            </td>
            <td align="left" valign="top">Modelo:
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoIngreso->VmoId;?>" size="3" /></td>
            <td align="left" valign="top">
            
            <table>
            <tr>
            <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
            </select></td>
            <td>
            
            <a id="BtnVehiculoModeloRegistrar" onclick="FncVehiculoModeloCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> 
            
            <a id="BtnVehiculoModeloEditar" onclick="FncVehiculoModeloCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a>
            
            </td>            
            </tr>
			</table>
            
            
            
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Version:
              <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculoIngreso->VveId;?>" size="3" /></td>
            <td align="left" valign="top"><table>
              <tr>
                <td><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                  </select></td>
                <td><a id="BtnVehiculoVersionRegistrar" onclick="FncVehiculoVersionCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoVersionEditar" onclick="FncVehiculoVersionCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                </tr>
              </table></td>
            <td>Color Ext./Int.:
              <input name="CmpVehiculoColorId" type="hidden" id="CmpVehiculoColorId" value="<?php echo $InsVehiculoIngreso->VehId;?>" size="3" /></td>
            <td><input value="<?php echo $InsVehiculoIngreso->EinColor;?>"  class="EstFormularioCaja"  name="CmpColor" type="text" id="CmpColor" size="15" maxlength="50" />
              /
              <input value="<?php echo $InsVehiculoIngreso->EinColorInterior;?>"  class="EstFormularioCaja"  name="CmpColorInterior" type="text" id="CmpColorInterior" size="15" maxlength="50" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos vehiculares</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Año de Fabricacion:</td>
            <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinAnoFabricacion;?>"  class="EstFormularioCaja"  name="CmpAnoFabricacion" type="text" id="CmpAnoFabricacion" size="10" maxlength="4" /></td>
            <td align="left" valign="top">Modelo/Año:</td>
            <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinAnoModelo;?>"  class="EstFormularioCaja"  name="CmpAnoModelo" type="text" id="CmpAnoModelo" size="10" maxlength="4" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Numero de Motor:</td>
            <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinNumeroMotor;?>"  class="EstFormularioCaja"  name="CmpNumeroMotor" type="text" id="CmpNumeroMotor" size="30" maxlength="50" /></td>
            <td align="left" valign="top">Transmision:</td>
            <td align="left" valign="top"><?php
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
            <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de  ingreso</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Zofra:</td>
            <td align="left" valign="top"><?php
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
            <td align="left" valign="top">Nacionalizado:</td>
            <td align="left" valign="top"><?php
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
            <td align="left" valign="top">Placa:</td>
            <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinPlaca;?>"  class="EstFormularioCaja"  name="CmpPlaca" type="text" id="CmpPlaca" size="30" maxlength="50" /></td>
            <td align="left" valign="top">Origen:</td>
            <td align="left" valign="top"><?php
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
              <select disabled="disabled" class="EstFormularioCombo" name="CmpOrigen" id="CmpOrigen">
                <option <?php echo $OpcOrigen1;?> value="1">Compra</option>
                <option <?php echo $OpcOrigen2;?> value="2">Externo</option>
                <option <?php echo $OpcOrigen3;?> value="3">Cotizacion</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Otros datos especificos</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Clave de Alarma:              </td>
            <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinClaveAlarma;?>"  class="EstFormularioCaja"  name="CmpClaveAlarma" type="text" id="CmpClaveAlarma" size="15" maxlength="25" /></td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
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
                </select>
              <input name="CmpClienteId2" type="hidden" id="CmpClienteId2" value="<?php echo $InsVehiculoIngreso->CliId;?>" size="3" /></td>
            <td>&nbsp;</td>
          </tr>
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
                   <td align="left" valign="top">Tipo Doc.</td>
                   <td align="left" valign="top">Num. Documento</td>
                   <td align="left" valign="top">Nombre:</td>
                   <td align="left" valign="top">Fecha Vigencia:</td>
                   <td align="left" valign="top">Vigente</td>
                   <td align="left" valign="top">&nbsp;</td>
                   </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td align="left" valign="top">
                     
                     
                     
  <select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
  <option value="">Escoja una opcion</option>
  <?php
foreach($ArrTipoDocumentos as $DatTipoDocumento){
?>
  <option <?php echo $DatTipoDocumento->TdoId;?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
  <?php
}
?>
  </select>
                     
                     
                     
                     </td>
                   <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                     <tr>
                       <td><a id="BtnClienteNuevo" href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td><input tabindex="4" class="EstFormularioCaja" name="CmpClienteNumeroDocumento" type="text" id="CmpClienteNumeroDocumento" size="15" maxlength="50"   /></td>
                       <td><a id="BtnClienteBuscarNumeroDocumento" href="javascript:FncClienteBuscar('NumeroDocumento');"> <img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                       <td>
                         
  <a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> 
                         
  <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                         
                         </td>
                       <td><div id="CapClienteBuscar"></div></td>
                       </tr>
                     <tr> </tr>
                     </table></td>
                   <td align="left" valign="top"><input  tabindex="2" class="EstFormularioCaja" name="CmpClienteNombre" type="text" id="CmpClienteNombre" size="35" maxlength="255"  /></td>
                   <td align="left" valign="top"><input class="EstFormularioCajaFecha"  name="CmpVehiculoIngresoClienteFecha" type="text" id="CmpVehiculoIngresoClienteFecha" size="10" maxlength="10" />
                     <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnVehiculoIngresoClienteFecha" name="BtnVehiculoIngresoClienteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                   <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpVehiculoIngresoClienteEstado" id="CmpVehiculoIngresoClienteEstado">
                  
                     <option value="1">Vigente</option>
                     <option value="2">Antiguo</option>
                   </select></td>
                   <td align="left" valign="top"><a href="javascript:FncVehiculoIngresoSimpleClienteGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
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
                   <td><input type="hidden" name="CmpVehiculoIngresoClienteAccion" id="CmpVehiculoIngresoClienteAccion" value="AccVehiculoIngresoSimpleClienteRegistrar.php" /></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td width="1%">&nbsp;</td>
                   <td width="49%"><div class="EstFormularioAccion" id="CapVehiculoIngresoClienteAccion">Listo
                     para registrar elementos</div></td>
                   <td width="49%" align="right"><a href="javascript:FncVehiculoIngresoSimpleClienteListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoIngresoSimpleClienteEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
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
	inputField : "CmpVehiculoIngresoClienteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnVehiculoIngresoClienteFecha"// el id del botón que  
	}); 
	
	
<!--

//-->
</script>
<?php
}else{
	echo ERR_GEN_101;
}

if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}
?>

