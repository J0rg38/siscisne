<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoFunciones.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsVehiculoRecepcionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsVehiculoRecepcionDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoRecepcionPlanchadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoRecepcionPintadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoRecepcionCentradoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoRecepcionTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoRecepcionFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod.'C');?>CssVehiculoRecepcion.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoRecepcion.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalleFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsVehiculoRecepcion = new ClsVehiculoRecepcion();
$InsPersonal = new ClsPersonal();

if (isset($_SESSION['InsVehiculoRecepcionDetalle'.$Identificador])){	
	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoRecepcionEditar.php');

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];


?>


<script type="text/javascript">
/*
//Configuracion carga de datos y animacion
*/

$(document).ready(function (){

	$('#CmpFecha').focus();
	
	FncVehiculoRecepcionDetalleListar();

});

/*
Configuracion Formulario
*/
var VehiculoRecepcionDetalleEditar = 2;
var VehiculoRecepcionDetalleEliminar = 2;

var VehiculoRecepcionDetalleFotoEditar = 2;
var VehiculoRecepcionDetalleFotoEliminar = 2;


</script>

<div class="EstCapMenu">

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsVehiculoRecepcion->VreId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsVehiculoRecepcion->VreId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    

          	<?php
			if($PrivilegioEditar and $InsVehiculoRecepcion->VreEstado==1){
			?>           
             
             
             
             
             <div class="EstSubMenuBoton"><a href="<?php echo $_SERVER['PHP_SELF'];?>?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculoRecepcion->VreId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER RECEPCION DE VEHICULO  </span></td>
      </tr>
      <tr>
        <td colspan="2">
        
<ul class="tabs">
	<li><a href="#tab1">Recepcion</a></li>


</ul>        
  <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
                           

                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoRecepcion->VreTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoRecepcion->VreTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
   
        
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
          <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Recepcion  
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
		      <td align="center">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Codigo:</td>
		      <td align="left" valign="top">
		        
		        <input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoRecepcion->VreId;?>" size="20" maxlength="20" /></td>
		      <td align="left" valign="top">Fecha:<br />
		        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
		      <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsVehiculoRecepcion->VreFecha)){ echo date("d/m/Y");}else{ echo $InsVehiculoRecepcion->VreFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Responsable:</td>
		      <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
		        <option value="">Escoja una opcion</option>
		        <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
		        <option <?php echo ($DatPersonal->PerId==$InsVehiculoRecepcion->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
		        <?php
					}
					?>
		        </select></td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td align="left" valign="top">&nbsp;</td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">&iquest;Tiene Guia de Remision?:</td>
		      <td align="left" valign="top"><?php
					switch($InsVehiculoRecepcion->VreTieneGuia){
						case "Si":
							$OpcTieneGuia1 = 'selected = "selected"';
						break;
						
						case "No":
							$OpcTieneGuia2 = 'selected = "selected"';						
						break;

					}
					?>
		        <select disabled="disabled" class="EstFormularioCombo" name="CmpTieneGuia" id="CmpTieneGuia"  >
		          <option <?php echo $OpcTieneGuia1;?> value="Si">Si</option>
		          <option <?php echo $OpcTieneGuia2;?> value="No">No</option>
		          </select></td>
		      <td align="left" valign="top">Num. Guia de Remision:<span class="EstFormularioSubEtiqueta"></span></td>
		      <td align="left" valign="top"><input name="CmpGuiaRemisionNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumero"  tabindex="3" value="<?php  echo $InsVehiculoRecepcion->VreGuiaRemisionNumero;?>" size="25" maxlength="25" readonly="readonly" /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Observacion:</td>
		      <td align="left" valign="top"><!--  
                 <div class="EstFormularioCajaObservacion">
                                      <?php echo stripslashes($InsVehiculoRecepcion->VreObservacion);?>
                                    </div>-->
		        <textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsVehiculoRecepcion->VreObservacion;?></textarea></td>
		      <td align="left" valign="top">OPCIONES:</td>
		      <td align="left" valign="top"><input disabled="disabled" <?php echo (($InsVehiculoRecepcion->VreNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
		        Notificar via email <br /></td>
		      <td>&nbsp;</td>
		      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td align="left" valign="top">Estado: </td>
		      <td align="left" valign="top"><?php
					switch($InsVehiculoRecepcion->VreEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						
						case 6:
							$OpcEstado6 = 'selected = "selected"';						
						break;
					}
					?>
                <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" >
                  <option <?php echo $OpcEstado1;?> value="1">Sin Reclamo</option>
                        <option <?php echo $OpcEstado3;?> value="3">Con Reclamo</option>
                        <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                </select></td>
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
		      <td>&nbsp;</td>
		      </tr>
		    </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Cotizacion </span></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">VIN:
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsVehiculoRecepcion->EinId;?>" size="3" /></td>
               <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td>&nbsp;</td>
                   <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsVehiculoRecepcion->EinVIN;?>" size="20" maxlength="50" /></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   </tr>
                 <tr> </tr>
                 <tr> </tr>
                 <tr> </tr>
                 </table></td>
               <td align="left" valign="top">Marca:
                 <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsVehiculoRecepcion->VmaId;?>" size="3" /></td>
               <td><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoMarca" value="<?php echo $InsVehiculoRecepcion->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Modelo:
                 <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsVehiculoRecepcion->VmoId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoModelo" value="<?php echo $InsVehiculoRecepcion->VmoNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Color:</td>
               <td><input  name="CmpVehiculoIngresoColor" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoColor" value="<?php echo $InsVehiculoRecepcion->EinColor;?>" size="30" maxlength="50" readonly="readonly" /></td>
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
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
               <td width="1%">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td width="49%"><div class="EstFormularioAccion" id="CapVehiculoRecepcionDetalleAccion">Listo
                 para registrar elementos</div></td>
               <td width="49%" align="right"><a href="javascript:FncVehiculoRecepcionDetalleListar();">
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapVehiculoRecepcionDetalles" class="EstCapVehiculoRecepcionDetalles" > </div></td>
               <td><div id="CapVehiculoRecepcionDetallesResultado"> </div></td>
               </tr>
             </table>
           </div></td>
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
