<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsClienteEnviarSMSFunciones.js" ></script>

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

//INSTANCIAS
$InsCliente = new ClsCliente();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClienteEnviarSMS.php');
//DATOS
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

	$("#CmpDestinatarios").focus();
	
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
    <li><a href="#tab1">Enviar SMS</a></li>
   
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
                  <td colspan="3"><span class="EstFormularioSubTitulo">Datos del Cliente</span>
                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                    <input type="hidden" name="Guardar" id="Guardar"   />
                    <input name="CmpBloquear" type="hidden" id="CmpBloquear" value="<?php echo $InsCliente->CliBloquear;?>" size="15" maxlength="20" readonly="readonly" />
                    
                  </td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCliente->CliId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Cliente:</td>
                  <td align="left" valign="top"><input class="EstFormularioCajaDeshabilitada"   name="CmpClienteNombreCompleto" type="text" id="CmpClienteNombreCompleto" value="<?php echo $InsCliente->CliNombreCompleto;?>" size="40" maxlength="255" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Destinatario:</td>
                  <td align="left" valign="top"><input   name="CmpDestinatarios" type="text" class="EstFormularioCajaDeshabilitada" id="CmpDestinatarios" value="<?php echo $InsCliente->CliDestinatarios;?>" size="40" maxlength="255" readonly="readonly" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top"><p>Contenido:</p>
                    <p>&nbsp;</p></td>
                  <td align="left" valign="top"><textarea name="CmpContenido" cols="40" rows="4" class="EstFormularioCaja" id="CmpContenido"><?php echo $InsCliente->CliContenido;?></textarea></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
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

