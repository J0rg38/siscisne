<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"Cliente",$GET_form)){
?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteSimpleFunciones.js" ></script>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssClienteSimple.css');
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
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjClienteSimple.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
//INSTANCIAS
$InsCliente = new ClsCliente();
$InsClienteTipo = new ClsClienteTipo();
$InsTipoDocumento = new ClsTipoDocumento();
$InsMoneda = new ClsMoneda();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClienteSimpleRegistrar.php');
//DATOS
//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$("#CmpNumeroDocumento").focus();

//	FncTipoDocumentoEstablecer();
	
});

/*
Configuracion Formulario
*/
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        CLIENTE</span></td>
      </tr>
      <tr>
        
        <td colspan="2">
        
        
        
        
        
<ul class="tabs">
    <li><a href="#tab1">Cliente</a></li>
    
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
                  <td colspan="2"><span class="EstFormularioSubTitulo">Datos del Cliente</span>
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
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Numero de Documento:</td>
                  <td align="left" valign="top"><input value="<?php echo $InsCliente->CliNumeroDocumento;?>"  class="EstFormularioCaja"  name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="40" maxlength="50" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Nombres/Razón Social:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo stripslashes($InsCliente->CliNombre);?>" size="40" maxlength="250" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Paterno:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpApellidoPaterno" type="text" id="CmpApellidoPaterno" value="<?php echo stripslashes($InsCliente->CliApellidoPaterno);?>" size="40" maxlength="250" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Apellido Materno:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpApellidoMaterno" type="text" id="CmpApellidoMaterno" value="<?php echo stripslashes($InsCliente->CliApellidoMaterno);?>" size="40" maxlength="250" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">NombreComercial:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpNombreComercial" type="text" id="CmpNombreComercial" value="<?php echo stripslashes($InsCliente->CliNombreComercial);?>" size="40" maxlength="250" /></td>
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
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Direccion:</td>
                  <td align="left" valign="top"><input  name="CmpDireccion" type="text"  class="EstFormularioCaja" id="CmpDireccion" value="<?php echo $InsCliente->CliDireccion;?>" size="40" maxlength="200" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tel&eacute;fono:</td>
                  <td align="left" valign="top"><input value="<?php echo $InsCliente->CliTelefono;?>"  class="EstFormularioCaja"  name="CmpTelefono" type="text" id="CmpTelefono" size="40" maxlength="50" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Celular:</td>
                  <td align="left" valign="top"><input value="<?php echo $InsCliente->CliCelular;?>"  class="EstFormularioCaja"  name="CmpCelular" type="text" id="CmpCelular" size="40" maxlength="50" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Email:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpEmail" type="text" id="CmpEmail" value="<?php echo $InsCliente->CliEmail;?>" size="40" maxlength="255" /></td>
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
                  <td>&nbsp;</td>
                </tr>
                <tr>
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
    
</div>
        
       
        
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>
	

	
    

</form>
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

