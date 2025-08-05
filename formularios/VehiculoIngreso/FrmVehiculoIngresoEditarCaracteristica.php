<?php
//deb($_POST);
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){

?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoMarcaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoAutocompletarFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoCaracteristicaFunciones.js" ></script>

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
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

//INSTANCIAS
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsTipoDocumento = new ClsTipoDocumento();
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
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoIngresoEditarCaracteristica.php');
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


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

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

$().ready(function() {
	
	FncVehiculoMarcasCargar();
	
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
	
    <li><a href="#tab2"> Caracteristicas</a></li>
   
  
</ul>

<div class="tab_container">
   
	

		   
<div id="tab2" class="tab_content">
        <!--Content-->
    
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
<div class="EstFormularioArea" >
  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos vehiculares
        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">Codigo Interno:</td>
      <td valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoIngreso->EinId;?>" size="20" maxlength="20" readonly="readonly" /></td>
      <td>VIN: </td>
      <td><input name="CmpVIN" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVIN" value="<?php echo $InsVehiculoIngreso->EinVIN;?>" size="20" maxlength="40" readonly="readonly"  /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">Marca:
        <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsVehiculoIngreso->VmaId;?>" size="3" /></td>
      <td valign="top"><table>
        <tr>
          <td><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
            <option value="">Escoja una opcion</option>
            <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
            <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoIngreso->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
            <?php
			}
			?>
          </select></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      <td>Modelo:
        <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoIngreso->VmoId;?>" size="3" /></td>
      <td><table>
        <tr>
          <td><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
          </select></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">Version:
        <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculoIngreso->VveId;?>" size="3" /></td>
      <td valign="top"><table>
        <tr>
          <td><select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
          </select></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      <td>Color Ext./Int.:
        <input name="CmpVehiculoColorId" type="hidden" id="CmpVehiculoColorId" value="<?php echo $InsVehiculoIngreso->VehId;?>" size="3" /></td>
      <td><input  name="CmpColor" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpColor" value="<?php echo $InsVehiculoIngreso->EinColor;?>" size="15" maxlength="50" readonly="readonly" />
        /
        <input  name="CmpColorInterior" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpColorInterior" value="<?php echo $InsVehiculoIngreso->EinColorInterior;?>" size="15" maxlength="50" readonly="readonly" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td valign="top">Año de Fabricacion:</td>
      <td valign="top"><input  name="CmpAnoFabricacion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpAnoFabricacion" value="<?php echo $InsVehiculoIngreso->EinAnoFabricacion;?>" size="10" maxlength="4" readonly="readonly" /></td>
      <td>Modelo/Año:</td>
      <td><input  name="CmpAnoModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpAnoModelo" value="<?php echo $InsVehiculoIngreso->EinAnoModelo;?>" size="10" maxlength="4" readonly="readonly" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo"> Datos Declaracion	de Aduana</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">DUA:</td>
      <td align="left" valign="top"><input value="<?php echo $InsVehiculoIngreso->EinDUA;?>"  class="EstFormularioCaja"  name="CmpDUA" type="text" id="CmpDUA" size="30" maxlength="50" /></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Caracteristicas del Vehiculo</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Nombre:</td>
      <td colspan="3"><input  name="CmpVehiculoIngresoNombre" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoNombre" value="<?php echo $InsVehiculoIngreso->EinNombre;?>" size="30" maxlength="50" />
        (Este nombre aparecera en el comprobante)</td>
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
      <td><input  name="CmpVehiculoVersionCaracteristicaNumeroMotor" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristicaNumeroMotor" value="<?php echo $InsVehiculoIngreso->EinNumeroMotor;?>" size="30" maxlength="50" /></td>
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
      <td>Color Interior:</td>
      <td><input  name="CmpColorInterior" type="text"  class="EstFormularioCaja" id="CmpColorInterior" value="<?php echo $InsVehiculoIngreso->EinColorInterno;?>" size="30" maxlength="50" /></td>
      <td>Alto: <span class="EstFormularioSubIndice">(14)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica14);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica14" type="text" id="CmpVehiculoVersionCaracteristica14" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Color Exterior:</td>
      <td><input  name="CmpColor" type="text"  class="EstFormularioCaja" id="CmpColor" value="<?php echo $InsVehiculoIngreso->EinColor;?>" size="30" maxlength="50" /></td>
      <td>Largo: <span class="EstFormularioSubIndice">(15)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica15);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica15" type="text" id="CmpVehiculoVersionCaracteristica15" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Cilindrada: <span class="EstFormularioSubIndice">(3)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica3);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica3" type="text" id="CmpVehiculoVersionCaracteristica3" size="25" maxlength="50" />
        (*)</td>
      <td>Ancho: <span class="EstFormularioSubIndice">(16)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica16);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica16" type="text" id="CmpVehiculoVersionCaracteristica16" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Asientos: <span class="EstFormularioSubIndice">(4)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica4);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica4" type="text" id="CmpVehiculoVersionCaracteristica4" size="25" maxlength="50" />
        (*)</td>
      <td>Dist. Ejes: <span class="EstFormularioSubIndice">(17)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica17);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica17" type="text" id="CmpVehiculoVersionCaracteristica17" size="25" maxlength="50" />
        (*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Cap. Pasajeros: <span class="EstFormularioSubIndice">(5)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica5);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica5" type="text" id="CmpVehiculoVersionCaracteristica5" size="25" maxlength="50" />
        (*)</td>
      <td>Numero de Ruedas: <span class="EstFormularioSubIndice">(18)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica18);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica18" type="text" id="CmpVehiculoVersionCaracteristica18" size="25" maxlength="50" />
(*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>Num. Poliza:</td>
      <td><input  name="CmpVehiculoVersionCaracteristicaDUA" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoVersionCaracteristicaDUA" value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinDUA);?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td>Potencia de Motor: <span class="EstFormularioSubIndice">(19)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica19);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica19" type="text" id="CmpVehiculoVersionCaracteristica19" size="25" maxlength="50" />
(*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Clase: <span class="EstFormularioSubIndice">(20)</span></td>
      <td><input value="<?php echo htmlspecialchars($InsVehiculoIngreso->EinCaracteristica20);?>"  class="EstFormularioCaja"  name="CmpVehiculoVersionCaracteristica20" type="text" id="CmpVehiculoVersionCaracteristica20" size="25" maxlength="50" />
(*)</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">
        
        (*) Estos campos solo deben ser modificados con los datos originales de la DUA.<br />
        (**) Este nombre aparecera en la factura o boleta.<br />
         <a href="javascript:FncCargarCaracteristicasPredeterminadas();">[Cargar Caracteristcas Predeterminadas]</a>
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
