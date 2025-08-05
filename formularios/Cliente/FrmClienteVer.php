<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<!-- CONTROL DE PRIVILEGIOS -->
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsDepartamentoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsProvinciaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsDistritoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteVehiculoIngresoFunciones.js" ></script>


<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssCliente.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCliente.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClientePersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoReferido.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

//INSTANCIAS
$InsCliente = new ClsCliente();
$InsClienteTipo = new ClsClienteTipo();
$InsTipoDocumento = new ClsTipoDocumento();
$InsMoneda = new ClsMoneda();
$InsTipoReferido = new ClsTipoReferido();
$InsPersonal = new ClsPersonal();

if (!isset($_SESSION['InsClienteVehiculoIngreso'.$Identificador])){	
	$_SESSION['InsClienteVehiculoIngreso'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsClienteVehiculoIngreso'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsClienteVehiculoIngreso'.$Identificador]);
}

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClienteEditar.php');
//DATOS
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


//MtdObtenerTipoReferidos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TrfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL)
$ResTipoReferido = $InsTipoReferido->MtdObtenerTipoReferidos(NULL,NULL,"TrfNombre","ASC",NULL,NULL,NULL);
$ArrTipoReferidos = $ResTipoReferido['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

?>
<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
	
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	//FncTipoDocumentoEstablecer();
	
	//FncClienteEstablecerMoneda();
	
	FncClienteVehiculoIngresoListar();
	
	FncDepartamentosCargar()
	
});

/*
Configuracion Formulario
*/

var ClienteVehiculoIngresoEditar = 2;
var ClienteVehiculoIngresoEliminar = 2;

</script>

<title>500</title>

<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsCliente->CliId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        CLIENTE</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCliente->CliTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCliente->CliTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
         <br />
    
    
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
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="5"><span class="EstFormularioSubTitulo">Datos del Cliente</span>                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                  
                     <input type="hidden" name="CmpClienteUso" id="CmpClienteUso"  value="<?php echo $InsCliente->CliUso;?>" />
                    <input name="CmpClienteBloquear" type="hidden" id="CmpClienteBloquear" value="<?php echo $InsCliente->CliBloquear;?>" size="15" maxlength="20" readonly="readonly" />
                    
                    
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
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                    <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsCliente->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td>Nombre:</td>
                  <td><input   name="CmpRepresentanteNombre" type="text" class="EstFormularioCaja" id="CmpRepresentanteNombre" value="<?php echo $InsCliente->CliRepresentanteNombre;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Numero de Documento:</td>
                  <td align="left" valign="top"><input  name="CmpNumeroDocumento" type="text"  class="EstFormularioCaja" id="CmpNumeroDocumento" value="<?php echo $InsCliente->CliNumeroDocumento;?>" size="40" maxlength="50" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td>Num. Documento:</td>
                  <td><input   name="CmpRepresentanteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpRepresentanteNumeroDocumento" value="<?php echo $InsCliente->CliRepresentanteNumeroDocumento;?>" size="40" maxlength="45" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombres/Razón Social:</td>
                  <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo stripslashes($InsCliente->CliNombre);?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nacionalidad:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpRepresentanteNacionalidad" type="text" id="CmpRepresentanteNacionalidad" value="<?php echo $InsCliente->CliRepresentanteNacionalidad;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Paterno:</td>
                  <td align="left" valign="top"><input name="CmpApellidoPaterno" type="text" class="EstFormularioCaja" id="CmpApellidoPaterno" value="<?php echo stripslashes($InsCliente->CliApellidoPaterno);?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Profesion/Ocupacion:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpRepresentanteActividadEconomica" type="text" id="CmpRepresentanteActividadEconomica" value="<?php echo $InsCliente->CliRepresentanteActividadEconomica;?>" size="40" maxlength="250" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Materno:</td>
                  <td align="left" valign="top"><input name="CmpApellidoMaterno" type="text" class="EstFormularioCaja" id="CmpApellidoMaterno" value="<?php echo stripslashes($InsCliente->CliApellidoMaterno);?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">CONTACTO 1</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">NombreComercial:</td>
                  <td align="left" valign="top"><input name="CmpNombreComercial" type="text" class="EstFormularioCaja" id="CmpNombreComercial" value="<?php echo stripslashes($InsCliente->CliNombreComercial);?>" size="40" maxlength="250" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input   name="CmpContactoNombre1" type="text" class="EstFormularioCaja" id="CmpContactoNombre1" value="<?php echo $InsCliente->CliContactoNombre1;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha Nac.:</td>
                  <td align="left" valign="top"><input  name="CmpFechaNacimiento" type="text" class="EstFormularioCajaFecha" id="CmpFechaNacimiento" value="<?php if(!empty($InsCliente->CliFechaNacimiento)){ echo $InsCliente->CliFechaNacimiento;}?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input   name="CmpContactoCelular1" type="text" class="EstFormularioCaja" id="CmpContactoCelular1" value="<?php echo $InsCliente->CliContactoCelular1;?>" size="40" maxlength="15" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado Civil:</td>
                  <td align="left" valign="top"><?php
			switch($InsCliente->CliEstadoCivil){
				case "Soltero":
					$OpcEstadoCivil1 = 'selected="selected"';
				break;
				
				case "Casado":
					$OpcEstadoCivil2 = 'selected="selected"';
				break;
				
				case "Viudo":
					$OpcEstadoCivil3 = 'selected="selected"';
				break;
				
				case "Divorciado":
					$OpcEstadoCivil4 = 'selected="selected"';
				break;

			}
			?>
                    <select disabled="disabled" class="EstFormularioCombo" name="CmpEstadoCivil" id="CmpEstadoCivil">
                      <option <?php echo $OpcEstadoCivil1;?> value="Soltero">Soltero</option>
                      <option <?php echo $OpcEstadoCivil2;?> value="Casado">Casado</option>
                      <option <?php echo $OpcEstadoCivil3;?> value="Viudo">Viudo</option>
                      <option <?php echo $OpcEstadoCivil4;?> value="Divorciado">Divorciado</option>
                    </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input   name="CmpContactoEmail1" type="text" class="EstFormularioCaja" id="CmpContactoEmail1" value="<?php echo $InsCliente->CliContactoEmail1;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Sexo:</td>
                  <td align="left" valign="top"><?php
			switch($InsCliente->CliSexo){
				case "Hombre":
					$OpcSexo1 = 'selected="selected"';
				break;
				
				case "Mujer":
					$OpcSexo2 = 'selected="selected"';
				break;

			}
			?>
                    <select disabled="disabled" class="EstFormularioCombo" name="CmpSexo" id="CmpSexo">
                      <option <?php echo $OpcSexo1;?> value="Hombre">Hombre</option>
                      <option <?php echo $OpcSexo2;?> value="Mujer">Mujer</option>
                    </select></td>
                  <td>&nbsp;</td>
                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">CONTACTO 2</span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Actividad Economica / Profesión / Ocupación</td>
                  <td align="left" valign="top"><input  name="CmpActividadEconomica" type="text"  class="EstFormularioCaja" id="CmpActividadEconomica" value="<?php echo $InsCliente->CliActividadEconomica;?>" size="40" maxlength="500" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input   name="CmpContactoNombre2" type="text" class="EstFormularioCaja" id="CmpContactoNombre2" value="<?php echo $InsCliente->CliContactoNombre2;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tipo de Cliente:</td>
                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpTipo" id="CmpTipo" disabled="disabled">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrClienteTipos as $DatClienteTipo){
			?>
                    <option <?php echo $DatClienteTipo->LtiId;?> <?php echo ($DatClienteTipo->LtiId==$InsCliente->LtiId)?'selected="selected"':"";?> value="<?php echo $DatClienteTipo->LtiId?>"><?php echo $DatClienteTipo->VmaNombre;?> - <?php echo $DatClienteTipo->LtiNombre?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input   name="CmpContactoCelular2" type="text" class="EstFormularioCaja" id="CmpContactoCelular2" value="<?php echo $InsCliente->CliContactoCelular2;?>" size="40" maxlength="15" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Direccion:</td>
                  <td align="left" valign="top"><input  name="CmpDireccion" type="text"  class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsCliente->CliDireccion;?>" size="40" maxlength="200" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input   name="CmpContactoEmail2" type="text" class="EstFormularioCaja" id="CmpContactoEmail2" value="<?php echo $InsCliente->CliContactoEmail2;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Departamento:</td>
                  <td align="left" valign="top"><input name="CmpDepartamentoId" type="hidden" class="CmpDepartamentoux" id="CmpDepartamentoId" value="<?php echo $InsCliente->CliDepartamento;?>" size="20" maxlength="10" readonly="readonly" />
                    <select disabled="disabled" class="EstFormularioCombo" id="CmpDepartamento" name="CmpDepartamento">
                    </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">CONTACTO 3</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Provincia:</td>
                  <td align="left" valign="top"><input name="CmpProvinciaId" type="hidden" class="CmpDepartamentoux" id="CmpProvinciaId" value="<?php echo $InsCliente->CliProvincia;?>" size="20" maxlength="10" readonly="readonly" />
                    <select  disabled="disabled" class="EstFormularioCombo" id="CmpProvincia" name="CmpProvincia">
                    </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombre:</td>
                  <td align="left" valign="top"><input   name="CmpContactoNombre3" type="text" class="EstFormularioCaja" id="CmpContactoNombre3" value="<?php echo $InsCliente->CliContactoNombre3;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Distrito:</td>
                  <td align="left" valign="top"><input name="CmpDistritoId" type="hidden" class="CmpDepartamentoux" id="CmpDistritoId" value="<?php echo $InsCliente->CliDistrito;?>" size="20" maxlength="10" readonly="readonly" />
                    <select  disabled="disabled" class="EstFormularioCombo" id="CmpDistrito" name="CmpDistrito">
                    </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input   name="CmpContactoCelular3" type="text" class="EstFormularioCaja" id="CmpContactoCelular3" value="<?php echo $InsCliente->CliContactoCelular3;?>" size="40" maxlength="15" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Pais:</td>
                  <td align="left" valign="top"><input  name="CmpPais" type="text"  class="EstFormularioCaja" id="CmpPais" value="<?php echo $InsCliente->CliPais;?>" size="40" maxlength="200" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input   name="CmpContactoEmail3" type="text" class="EstFormularioCaja" id="CmpContactoEmail3" value="<?php echo $InsCliente->CliContactoEmail3;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tel&eacute;fono:</td>
                  <td align="left" valign="top"><input  name="CmpTelefono" type="text"  class="EstFormularioCaja" id="CmpTelefono" value="<?php echo $InsCliente->CliTelefono;?>" size="40" maxlength="15" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input  name="CmpCelular" type="text"  class="EstFormularioCaja" id="CmpCelular" value="<?php echo $InsCliente->CliCelular;?>" size="40" maxlength="15" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input   name="CmpEmail" type="text" class="EstFormularioCaja" id="CmpEmail" value="<?php echo $InsCliente->CliEmail;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">OBSERVACIONES Y OTRAS REFERENCIAS</span></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Registrado por:</td>
                  <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                    <option value="">Escoja una opcion</option>
                    <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                    <option <?php echo ($DatPersonal->PerId==$InsCliente->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                    <?php
					}
					?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">¿Como llego al Concesionario?</td>
                  <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoReferido" id="CmpTipoReferido">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrTipoReferidos as $DatReferido){
			?>
                    <option  <?php echo ($DatReferido->TrfId==$InsCliente->TrfId)?'selected="selected"':"";?> value="<?php echo $DatReferido->TrfId?>"><?php echo $DatReferido->TrfNombre?></option>
                    <?php
			}
			?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Abreviatura:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpAbreviatura" type="text" id="CmpAbreviatura" value="<?php echo stripslashes($InsCliente->CliAbreviatura);?>" size="10" maxlength="4" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Observaciones:</td>
                  <td align="left" valign="top"><textarea name="CmpObservacion" cols="40" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo stripslashes($InsCliente->CliObservacion);?></textarea></td>
                  <td>&nbsp;</td>
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
                    <select disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                      <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                      <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
                    </select></td>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
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
                  <td colspan="2" align="left" valign="top">
                  
                  
                  
                  <?php              
              
if(!empty($_SESSION['SesCliArchivo'.$Identificador])){
	
	$extension = strtolower(pathinfo($_SESSION['SesCliArchivo'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesCliArchivo'.$Identificador], '.'.$extension);  
?>
              Archivo Adjunto:<br />


<!-- <a target="_blank" href="subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?></a>
   -->           

  <a target="_blank" href="subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>">
		<img  src="subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>" width="300" height="177" border="0" title="<?php echo $nombre_base.".".$extension;?>" />
  </a>
  
              
              <?php	
}else{
?>
              No hay ARCHIVO ADJUNTO
              <?php	
}
?>



</td>
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
                    <select  class="EstFormularioCombo" name="CmpCSIIncluir" id="CmpCSIIncluir" disabled="disabled" >
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcCSIIncluir1;?> value="1">Si</option>
                      <option <?php echo $OpcCSIIncluir2;?> value="2">No</option>
                    </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Motivo Exclusion:</td>
                  <td align="left" valign="top"><textarea name="CmpCSIExcluirMotivo" cols="40" readonly="readonly" class="EstFormularioCaja" id="CmpCSIExcluirMotivo"><?php echo stripslashes($InsCliente->CliCSIExcluirMotivo);?></textarea></td>
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
                  <td colspan="2"><span class="EstFormularioSubTitulo">Datos de Linea de Credito</span></td>
                  <td>&nbsp;</td>
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
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Linea de Credito:
                    <input type="hidden" name="CmpTipoCambioFecha" id="CmpTipoCambioFecha" value="<?php echo $InsCliente->CliTipoCambioFecha;?>" /></td>
                  <td align="left" valign="top"><input name="CmpLineaCredito" type="text" class="EstFormularioCaja" id="CmpLineaCredito" value="<?php echo number_format($InsCliente->CliLineaCredito,2);?>" size="20" maxlength="20" readonly="readonly" /></td>
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCliente->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                  </select></td>
                  <td align="left" valign="top">Tipo de Cambio:<br />
                    <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                  <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio"  value="<?php if (empty($InsCliente->CliTipoCambio)){ echo "";}else{ echo $InsCliente->CliTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
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
                  <td align="left" valign="top"><input name="CmpClaveElectronica" type="text" class="EstFormularioCaja" id="CmpClaveElectronica" value="<?php echo ($InsCliente->CliClaveElectronica);?>" size="20" maxlength="20" readonly="readonly" /></td>
                  <td>Email de Recepcion:</td>
                  <td><input name="CmpEmailFacturacion" type="text" class="EstFormularioCaja" id="CmpEmailFacturacion" value="<?php echo ($InsCliente->CliEmailFacturacion);?>" size="45" maxlength="255" readonly="readonly" /></td>
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
	
	
	
    


<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
