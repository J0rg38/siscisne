<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>
<!-- ARCHIVO DE FUNCIONES JS -->

<!-- ARCHIVO DE ESTILOS CSS -->
<?php
//VARIABLES
$Edito = false;
$GET_id = $_GET['Id'];
$GET_CSIIncluir = $_GET['CSIIncluir'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCliente.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

//INSTANCIAS
$InsCliente = new ClsCliente();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccClienteCSIEditar.php');
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

	$("#CmpCSIExcluirMotivo").focus();
	
	
});

/*
Configuracion Formulario
*/
</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">ACTUALIZAR INCLUIR
        CLIENTE EN CSI</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCliente->CliTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsCliente->CliTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
         <br />
        
        
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="Guardar" id="Guardar"   />
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente:</td>
            <td align="left" valign="top">
              <input type="hidden" name="CmpId" id="CmpId" value="<?php echo $InsCliente->CliId;?>" />
              <?php echo $InsCliente->CliNombre;?>
              <?php echo $InsCliente->CliApelidoPaterno;?>
              <?php echo $InsCliente->CliApellidoMaterno;?>
              
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Incluir CSI:</td>
            <td>
              
              <?php
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
                </select>
              
              
            </td>
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
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
        </table>
            </div>
            
            </td>
        </tr>
      </table>
      
      
        </td>
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
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>