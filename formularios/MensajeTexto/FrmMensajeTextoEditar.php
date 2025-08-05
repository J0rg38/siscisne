<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"MensajeTexto","Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsMensajeTextoFunciones.js" ></script>
<!-- ARCHIVO DE FUNCIONES JS -->

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$GET_CmtId = $_GET['CmtId'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$Edito = false;
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjMensajeTexto.php');
//CLASES
require_once($InsPoo->MtdPaqAcceso().'ClsMensajeTexto.php');

//INSTANCIAS
$InsMensajeTexto = new ClsMensajeTexto();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccMensajeTextoEditar.php');

?>




<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        MENSAJE DE TEXTO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsMensajeTexto->MteTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsMensajeTexto->MteTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
         <br />
         
         
         
  
               
<ul class="tabs">
    <li><a href="#tab1">Mensaje</a></li>
   

</ul>
<div class="tab_container">
    <div id="tab1" class="tab_content">
    <!--Content-->     
    

         
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><span class="EstFormularioSubTitulo">Datos del Mensaje de Texto
                <input type="hidden" name="Guardar" id="Guardar"   />
                <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
            </span></td>
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
            <td align="left" valign="top">C&oacute;digo Interno:              </td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsMensajeTexto->MteId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield1">
              <label>
                <input tabindex="6" class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php echo $InsMensajeTexto->MteFecha; ?>" size="10" maxlength="10" />
                </label>
              </span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Destinatario:</td>
            <td align="left" valign="top"><input <?php if(!empty($InsMensajeTexto->CmtId)){ echo 'readonly="readonly"';} ?>   tabindex="2" class="EstFormularioCaja" name="CmpDestino" type="text" id="CmpDestino" size="45" maxlength="255" value="<?php echo $InsMensajeTexto->MteDestino;?>"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Contenido:</td>
            <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpContenido" id="CmpContenido" cols="45" rows="4"><?php echo $InsMensajeTexto->MteContenido;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top">
			
			<?php
			switch($InsMensajeTexto->MteEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
	
				case 3:
					$OpcEstado3 = 'selected="selected"';
				break;
				
			}
			?>
              <select  class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Expirado</option>
                <option <?php echo $OpcEstado3;?> value="3">Vigente</option>
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
	
</script>

<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado&VdiId=".$_GET['VdiId'],$Edito,1500);
	}

}

?>

