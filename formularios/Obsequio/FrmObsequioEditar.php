<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsObsequioFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssObsequio.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$Registro = false;
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjObsequio.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsObsequio.php');


//INSTANCIAS
$InsObsequio = new ClsObsequio();


//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccObsequioEditar.php');



?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
$(document).ready(function (){
	
/*
CARGAS INICIALES
*/	
	
	
});

</script>




<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" >
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        OBSEQUIOS Y ACCESORIOS</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsObsequio->ObsTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsObsequio->ObsTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
         <br />
         
          
        	<ul class="tabs">
        <li><a href="#tab1">Obsequio</a></li>
		

	</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
      
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">
           
           
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsObsequio->ObsId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo</td>
            <td align="left" valign="top"><?php
			switch($InsObsequio->ObsTipo){
				case 1:
					$OpcTipo1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcTipo2 = 'selected="selected"';
				break;
				
				
			}
			?>
              <select  class="EstFormularioCombo" id="CmpTipo" name="CmpTipo">
                <option <?php echo $OpcTipo1;?> value="1">Obsequio</option>
                <option <?php echo $OpcTipo2;?> value="2">Accesorio</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td width="309" align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsObsequio->ObsNombre;?>" size="45" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descripcion:</td>
            <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="45" rows="4"><?php echo $InsObsequio->ObsDescripcion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Producto Relacionado:</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsObsequio->ObsEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;
				
				
			}
			?>
              <select class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Activo</option>
                <option <?php echo $OpcEstado2;?> value="2">Inactivo</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">Notas:<br />
              <span class="EstFormularioSubEtiqueta">Los obsequios no aparecen en los comprobantes de pago</span></td>
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

</script>

<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}

?>

