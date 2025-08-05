<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsObsequioFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssObsequio.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
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


<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsObsequio->ObsId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
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
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsObsequio->ObsId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo:</td>
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
              <select disabled="disabled"  class="EstFormularioCombo" id="CmpTipo" name="CmpTipo">
                <option <?php echo $OpcTipo1;?> value="1">Obsequio</option>
                <option <?php echo $OpcTipo2;?> value="2">Accesorio</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsObsequio->ObsNombre;?>" size="45" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descripcion:</td>
            <td align="left" valign="top"><textarea name="CmpDescripcion" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsObsequio->ObsDescripcion;?></textarea></td>
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
              <select  disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Activo</option>
                <option <?php echo $OpcEstado2;?> value="2">Inactivo</option>
              </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2" align="left" valign="top">Notas:<br />
              <span class="EstFormularioSubEtiqueta">Los obsequios no aparecen en los comprobantes de pago</span></td>
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


