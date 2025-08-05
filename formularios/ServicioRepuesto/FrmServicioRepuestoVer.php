<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsServicioRepuestoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsServicioRepuestoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsServicioRepuestoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssServicioRepuesto.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjServicioRepuesto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsServicioRepuesto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoGasto.php');

$InsServicioRepuesto = new ClsServicioRepuesto();
$InsTipoGasto = new ClsTipoGasto();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccServicioRepuestoEditar.php');

$ResTipoGasto = $InsTipoGasto->MtdObtenerTipoGastos(NULL,NULL,"TgaNombre","ASC",NULL,NULL,NULL);
$ArrTipoGastos = $ResTipoGasto['Datos'];
?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){



});

/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncServicioRepuestoDetalleListar";


</script>

<div class="EstCapMenu">
            
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsServicioRepuesto->SreId;?>&Su=<?php echo $InsServicioRepuesto->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER SERVICIOS DE TERCERO</span></td>
      </tr>
      <tr>
        <td colspan="2">
                   <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsServicioRepuesto->SreTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsServicioRepuesto->SreTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
        
<ul class="tabs">
	
	<li><a href="#tab1">Servicio</a></li>


</ul>        
  <div class="tab_container">
   
    
    <div id="tab1" class="tab_content">
      <!--Content-->
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top"><div class="EstFormularioArea">
		  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="2"><span class="EstFormularioSubTitulo">Datos del Servicio</span></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Codigo Interno:</td>
		      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsServicioRepuesto->SreId;?>" size="15" maxlength="20" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Tipo:</td>
		      <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpTipoGasto" id="CmpTipoGasto" >
		        <option value="">Escoja una opcion</option>
		        <?php
					foreach($ArrTipoGastos as $DatTipoGasto){
					?>
		        <option <?php echo ($DatTipoGasto->TgaId==$InsServicioRepuesto->TgaId)?'selected="selected"':'';?>  value="<?php echo $DatTipoGasto->TgaId;?>"><?php echo $DatTipoGasto->TgaNombre;?></option>
		        <?php
					}
					?>
		        </select></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Nombre:</td>
		      <td align="left" valign="top"><input name="CmpNombre" type="text" class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsServicioRepuesto->SreNombre;?>" size="45" maxlength="50" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Descripcion:</td>
		      <td align="left" valign="top"><textarea name="CmpDescripcion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsServicioRepuesto->SreDescripcion;?></textarea></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Estado: </td>
		      <td align="left" valign="top"><?php
					switch($InsServicioRepuesto->SreEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;
					}
					?>
		        <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
		         <option <?php echo $OpcEstado1;?> value="1">Habilitado</option>
                        <option <?php echo $OpcEstado2;?> value="2">Deshabilitado</option>
		          </select></td>
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
    
    
    
    
    
    <div>		
 
  
        
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
