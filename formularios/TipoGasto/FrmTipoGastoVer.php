<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTipoGastoFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTipoGasto.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTipoGasto.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsTipoGasto.php');

//INSTANCIAS
$InsTipoGasto = new ClsTipoGasto();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTipoGastoEditar.php');


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


<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsTipoGasto->TgaId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        TIPO DE GASTO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTipoGasto->TgaTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTipoGasto->TgaTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        <br />
        
        	<ul class="tabs">
        <li><a href="#tab1">TipoGasto</a></li>
		

	</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
      
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">
           
           
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" width="200" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="1">&nbsp;</td>
            <td width="93">&nbsp;</td>
            <td width="241">&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsTipoGasto->TgaId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsTipoGasto->TgaNombre;?>" size="45" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descripcion:</td>
            <td align="left" valign="top"><textarea name="CmpDescripcion" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsTipoGasto->TgaDescripcion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Uso:</td>
            <td align="left" valign="top"><?php
			switch($InsTipoGasto->TgaUso){
				case 1:
					$OpcUso1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcUso2 = 'selected="selected"';
				break;
				
				
			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" id="CmpUso" name="CmpUso">
                <option <?php echo $OpcUso1;?> value="1">Normal</option>
                <option <?php echo $OpcUso2;?> value="2">Exclusivo</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsTipoGasto->TgaEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
	
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;
				
				
			}
			?>
              <select  disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Activo</option>
                <option <?php echo $OpcEstado2;?> value="2">Inactivo</option>
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
    


         <div id="tab2" class="tab_content">
    
    
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top" align="center"><!--<div class="EstFormularioArea">-->
                
                        <!--<iframe src="principal2.php?Mod=PlanMantenimientoPresupuesto&Form=Consulta" width="100%" height="1000" frameborder="0" scrolling="no"></iframe>-->
                        
                   <!--<input type="button" name="CmpPresupuesto" id="CmpPresupuesto" onclick="PlanMantenimientoPresupuestoVer();" value="Armar Presupuesto" class="EstFormularioBoton" />-->
                  
                <!--  </div>     -->
                
                
                
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


