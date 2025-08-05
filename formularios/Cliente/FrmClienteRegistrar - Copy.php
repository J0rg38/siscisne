<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCliente.css');
</style>
<?php
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_ClienteNombre = $_GET['ClienteNombre'];
$GET_TipoDocumentoId = $_GET['TipoDocumentoId'];
$GET_ClienteNumeroDocumento = $_GET['ClienteNumeroDocumento'];
$GET_ClienteDireccion = $_GET['ClienteDireccion'];
$GET_ClienteCelular = $_GET['ClienteCelular'];
$GET_ClienteTelefono = $_GET['ClienteTelefono'];

$GET_ClienteEmail = $_GET['ClienteEmail'];
$GET_ClienteTipoId = $_GET['ClienteTipoId'];

$GET_Tipo = $_GET['Tipo'];


//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCliente.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
//INSTANCIAS
$InsCliente = new ClsCliente();
$InsClienteTipo = new ClsClienteTipo();
$InsTipoDocumento = new ClsTipoDocumento();
$InsMoneda = new ClsMoneda();


if (!isset($_SESSION['InsClienteVehiculoIngreso'.$Identificador])){	
	$_SESSION['InsClienteVehiculoIngreso'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsClienteVehiculoIngreso'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsClienteVehiculoIngreso'.$Identificador]);
}


//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClienteRegistrar.php');
//DATOS
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$("#CmpNumeroDocumento").focus();

	FncTipoDocumentoEstablecer();
	
	FncClienteEstablecerMoneda();
	
	FncClienteVehiculoIngresoListar();
	
});

/*
Configuracion Formulario
*/

var ClienteVehiculoIngresoEditar = 2;
var ClienteVehiculoIngresoEliminar = 2;

</script>



<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">
<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        CLIENTE</span></td>
      </tr>
      <tr>
        
        <td colspan="2">
        
        
        
        
        
<ul class="tabs">
    <li><a href="#tab1">Cliente</a></li>
    <li><a href="#tab2">Documento Escaneado</a></li>
    <li><a href="#tab3">CSI</a></li>
    <li><a href="#tab4">Credito</a></li>
    <li><a href="#tab5">Facturacion</a></li>
    <li><a href="#tab6">Vehiculos</a></li>
</ul>




<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->
        
        
          <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="5"><span class="EstFormularioSubTitulo">Datos del Cliente</span>
                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                    <input type="hidden" name="Guardar" id="Guardar"   />
                    <input name="CmpBloquear" type="hidden" id="CmpBloquear" value="<?php echo $InsCliente->CliBloquear;?>" size="15" maxlength="20" readonly="readonly" />
                    
                    </td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCliente->CliId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td colspan="2"><span class="EstFormularioSubTitulo">REPRESENTANTE LEGAL</span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tipo de Documento:</td>
                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCliente->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td align="left" valign="top">&nbsp; </td>
                  <td>Nombre:</td>
                  <td><input class="EstFormularioCaja"   name="CmpRepresentanteNombre" type="text" id="CmpRepresentanteNombre" value="<?php echo $InsCliente->CliRepresentanteNombre;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Numero de Documento:</td>
                  <td align="left" valign="top"><input value="<?php echo $InsCliente->CliNumeroDocumento;?>"  class="EstFormularioCaja"  name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="40" maxlength="50" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>Num. Documento:</td>
                  <td><input class="EstFormularioCaja"   name="CmpRepresentanteNumeroDocumento" type="text" id="CmpRepresentanteNumeroDocumento" value="<?php echo $InsCliente->CliRepresentanteNumeroDocumento;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombres/Razón Social:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo stripslashes($InsCliente->CliNombre);?>" size="40" maxlength="250" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Nacionalidad</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpRepresentanteNacionalidad" type="text" id="CmpRepresentanteNacionalidad" value="<?php echo $InsCliente->CliRepresentanteNacionalidad;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Paterno:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpApellidoPaterno" type="text" id="CmpApellidoPaterno" value="<?php echo stripslashes($InsCliente->CliApellidoPaterno);?>" size="40" maxlength="250" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Profesion/Ocupacion</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpRepresentanteActividadEconomica" type="text" id="CmpRepresentanteActividadEconomica" value="<?php echo $InsCliente->CliRepresentanteActividadEconomica;?>" size="40" maxlength="250" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Materno:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpApellidoMaterno" type="text" id="CmpApellidoMaterno" value="<?php echo stripslashes($InsCliente->CliApellidoMaterno);?>" size="40" maxlength="250" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">CONTACTO 1</span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">NombreComercial:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpNombreComercial" type="text" id="CmpNombreComercial" value="<?php echo stripslashes($InsCliente->CliNombreComercial);?>" size="40" maxlength="250" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoNombre1" type="text" id="CmpContactoNombre1" value="<?php echo $InsCliente->CliContactoNombre1;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha Nac.:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input class="EstFormularioCajaFecha"  name="CmpFechaNacimiento" type="text" id="CmpFechaNacimiento" value="<?php if(!empty($InsCliente->CliFechaNacimiento)){ echo $InsCliente->CliFechaNacimiento;}?>" size="15" maxlength="10" />                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaNacimiento" name="BtnFechaNacimiento" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoCelular1" type="text" id="CmpContactoCelular1" value="<?php echo $InsCliente->CliContactoCelular1;?>" size="40" maxlength="15" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Actividad Economica / Profesión / Ocupación</td>
                  <td align="left" valign="top"><input  name="CmpActividadEconomica" type="text"  class="EstFormularioCaja" id="CmpActividadEconomica" value="<?php echo $InsCliente->CliActividadEconomica;?>" size="40" maxlength="500" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoEmail1" type="text" id="CmpContactoEmail1" value="<?php echo $InsCliente->CliContactoEmail1;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tipo de Cliente:</td>
                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpTipo" id="CmpTipo">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                    <option <?php echo $DatClienteTipo->LtiId;?> <?php echo ($DatClienteTipo->LtiId==$InsCliente->LtiId)?'selected="selected"':"";?> value="<?php echo $DatClienteTipo->LtiId?>"><?php echo $DatClienteTipo->VmaNombre;?> - <?php echo $DatClienteTipo->LtiNombre?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">CONTACTO 2</span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Direccion:</td>
                  <td align="left" valign="top"><input  name="CmpDireccion" type="text"  class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsCliente->CliDireccion;?>" size="40" maxlength="200" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoNombre2" type="text" id="CmpContactoNombre2" value="<?php echo $InsCliente->CliContactoNombre2;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Distrito:</td>
                  <td align="left" valign="top"><input  name="CmpDistrito" type="text"  class="EstFormularioCaja" id="CmpDistrito" value="<?php echo $InsCliente->CliDistrito;?>" size="40" maxlength="200" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoCelular2" type="text" id="CmpContactoCelular2" value="<?php echo $InsCliente->CliContactoCelular2;?>" size="40" maxlength="15" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Provincia:</td>
                  <td align="left" valign="top"><input  name="CmpProvincia" type="text"  class="EstFormularioCaja" id="CmpProvincia" value="<?php echo $InsCliente->CliProvincia;?>" size="40" maxlength="200" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoEmail2" type="text" id="CmpContactoEmail2" value="<?php echo $InsCliente->CliContactoEmail2;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Departamento:</td>
                  <td align="left" valign="top"><input  name="CmpDepartamento" type="text"  class="EstFormularioCaja" id="CmpDepartamento" value="<?php echo $InsCliente->CliDepartamento;?>" size="40" maxlength="200" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">CONTACTO 3</span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Pais:</td>
                  <td align="left" valign="top"><input  name="CmpPais" type="text"  class="EstFormularioCaja" id="CmpPais" value="<?php echo $InsCliente->CliPais;?>" size="40" maxlength="200" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoNombre3" type="text" id="CmpContactoNombre3" value="<?php echo $InsCliente->CliContactoNombre3;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tel&eacute;fono:</td>
                  <td align="left" valign="top"><input value="<?php echo $InsCliente->CliTelefono;?>"  class="EstFormularioCaja"  name="CmpTelefono" type="text" id="CmpTelefono" size="40" maxlength="15" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoCelular3" type="text" id="CmpContactoCelular3" value="<?php echo $InsCliente->CliContactoCelular3;?>" size="40" maxlength="15" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input value="<?php echo $InsCliente->CliCelular;?>"  class="EstFormularioCaja"  name="CmpCelular" type="text" id="CmpCelular" size="40" maxlength="15" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpContactoEmail3" type="text" id="CmpContactoEmail3" value="<?php echo $InsCliente->CliContactoEmail3;?>" size="40" maxlength="255" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpEmail" type="text" id="CmpEmail" value="<?php echo $InsCliente->CliEmail;?>" size="40" maxlength="255" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">OBSERVACIONES Y OTRAS REFERENCIAS</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Clasificacion de Ventas:</td>
                  <td align="left" valign="top"><?php
			switch($InsCliente->CliClasificacion){
				case 1:
					$OpcClasificacion1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcClasificacion2 = 'selected="selected"';
				break;

			}
			?>
                    <select class="EstFormularioCombo" name="CmpClasificacion" id="CmpClasificacion">
                      <option <?php echo $OpcClasificacion1;?> value="1">Normal</option>
                      <option <?php echo $OpcClasificacion2;?> value="2">Mayorista</option>
                    </select></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">Abreviatura:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpAbreviatura" type="text" id="CmpAbreviatura" value="<?php echo stripslashes($InsCliente->CliAbreviatura);?>" size="10" maxlength="4" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Observaciones:</td>
                  <td align="left" valign="top"><textarea name="CmpObservacion" cols="40" rows="4" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsCliente->CliObservacion);?></textarea></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado:</td>
                  <td align="left" valign="top"><?php
			switch($InsCliente->CliEstado){
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
                  <td align="left" valign="top">&nbsp;</td>
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
                  <td align="left" valign="top">&nbsp;</td>
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
        
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2">Documento Escaneado</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" align="left" valign="top"><iframe src="formularios/Cliente/acc/AccClienteSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrClienteSubirArchivo" name="IfrClienteSubirArchivo" scrolling="Auto"  frameborder="0" width="550" height="260"></iframe></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
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
        
        
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><span class="EstFormularioSubTitulo">CSI - Post Venta</span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Incluir CSI:</td>
                  <td><?php
					switch($InsCliente->CliCSIIncluir){

						case 1:
							$OpcCSIIncluir1 = 'selected = "selected"';
						break;

						case 2:
							$OpcCSIIncluir2 = 'selected = "selected"';						
						break;

					}
					?>
                    <select  class="EstFormularioCombo" name="CmpCSIIncluir" id="CmpCSIIncluir" >
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcCSIIncluir1;?> value="1">Si</option>
                      <option <?php echo $OpcCSIIncluir2;?> value="2">No</option>
                    </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Motivo Exclusion:</td>
                  <td align="left" valign="top"><textarea name="CmpCSIExcluirMotivo" cols="40" class="EstFormularioCaja" id="CmpCSIExcluirMotivo"><?php echo stripslashes($InsCliente->CliCSIExcluirMotivo);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><span class="EstFormularioSubTitulo">CSI - Venta</span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Incluir CSI Venta:</td>
                  <td><?php
					switch($InsCliente->CliCSIVentaIncluir){

						case 1:
							$OpcCSIVentaIncluir1 = 'selected = "selected"';
						break;

						case 2:
							$OpcCSIVentaIncluir2 = 'selected = "selected"';						
						break;

					}
					?>
                    <select  class="EstFormularioCombo" name="CmpCSIVentaIncluir" id="CmpCSIVentaIncluir" >
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcCSIVentaIncluir1;?> value="1">Si</option>
                      <option <?php echo $OpcCSIVentaIncluir2;?> value="2">No</option>
                    </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Motivo Exclusion:</td>
                  <td align="left" valign="top"><textarea name="CmpCSIVentaExcluirMotivo" cols="40" class="EstFormularioCaja" id="CmpCSIVentaExcluirMotivo"><?php echo stripslashes($InsCliente->CliCSIVentaExcluirMotivo);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
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
    
    
	<div id="tab4" class="tab_content">
        <!--Content-->
        
        
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="5"><span class="EstFormularioSubTitulo">Datos de Linea de Credito</span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Linea de Credito:
                    <input type="hidden" name="CmpTipoCambioFecha" id="CmpTipoCambioFecha" value="<?php echo $InsCliente->CliTipoCambioFecha;?>" /></td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpLineaCredito" type="text" id="CmpLineaCredito" value="<?php echo number_format($InsCliente->CliLineaCredito,2);?>" size="20" maxlength="20" /></td>
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                        <option value="">Escoja una opcion</option>
                        <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                        <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCliente->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
                      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio"  value="<?php if (empty($InsCliente->CliTipoCambio)){ echo "";}else{ echo $InsCliente->CliTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td><a href="javascript:FncClienteEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                      </tr>
                    </table></td>
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
            </div>
            
            </td>
            </tr>
            </table>
	</div> 
    
         <div id="tab5" class="tab_content">
        <!--Content-->
        
        
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="6"><span class="EstFormularioSubTitulo">Datos de Facturacion</span></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Clave Electronica:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpClaveElectronica" type="text" id="CmpClaveElectronica" value="<?php echo ($InsCliente->CliClaveElectronica);?>" size="20" maxlength="20" /></td>
                  <td>Email de Recepcion:</td>
                  <td><input class="EstFormularioCaja" name="CmpEmailFacturacion" type="text" id="CmpEmailFacturacion" value="<?php echo ($InsCliente->CliEmailFacturacion);?>" size="45" maxlength="255" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
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
            </div>
            
            </td>
            </tr>
            </table>
	</div>
    
    
    <div id="tab6" class="tab_content">
        <!--Content-->
    
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
           <div class="EstFormularioArea" >
           
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><span class="EstFormularioSubTitulo">VEHICULO RELACIONADOS</span></td>
            <td>&nbsp;</td>
          </tr>
          
           <tr>
             <td>&nbsp;</td>
             <td colspan="2"><div class="EstFormularioArea" >
               <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                 <tr>
                   <td>&nbsp;</td>
                   <td><input type="hidden" name="CmpClienteVehiculoIngresoAccion" id="CmpClienteVehiculoIngresoAccion" value="AccClienteVehiculoIngresoRegistrar.php" /></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   </tr>
                 <tr>
                   <td width="1%">&nbsp;</td>
                   <td width="49%"><div class="EstFormularioAccion" id="CapClienteVehiculoIngresoAccion">Listo
                     para registrar elementos</div></td>
                   <td width="49%" align="right"><a href="javascript:FncClienteVehiculoIngresoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncClienteVehiculoIngresoEliminarTodo();"></a></td>
                   <td width="1%"><div id="CapClienteVehiculoIngresosResultado"> </div></td>
                   </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td colspan="2"><div id="CapClienteVehiculoIngresos" class="EstCapClienteVehiculoIngresos" > </div></td>
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
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>
	

	
    

</form>


     
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFechaNacimiento",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaNacimiento"// el id del botón que  
	});
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



//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

