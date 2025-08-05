<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsVehiculoRecepcionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsVehiculoRecepcionDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod.'C');?>JsVehiculoRecepcionDetalleFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod.'C');?>CssVehiculoRecepcion.css');
</style>

<?php
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_EinId = $_GET['EinId'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoRecepcion.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalleFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsVehiculoRecepcion = new ClsVehiculoRecepcion();
$InsVehiculoRecepcionDetalle = new ClsVehiculoRecepcionDetalle();

$InsPersonal = new ClsPersonal();

$InsVehiculoRecepcion->UsuId = $_SESSION['SesionId'];	

if (!isset($_SESSION['InsVehiculoRecepcionDetalle'.$Identificador])){	
	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoRecepcionRegistrar.php');

//MtdObtenerPersonales($oCampo=NULL,$oCondicion,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];

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

	$('#CmpFecha').focus();
	
	FncVehiculoRecepcionDetalleListar();
	
});
/*
Configuracion Formulario
*/
var VehiculoRecepcionDetalleEditar = 1;
var VehiculoRecepcionDetalleEliminar = 1;

var VehiculoRecepcionDetalleFotoEditar = 1;
var VehiculoRecepcionDetalleFotoEliminar = 1;


</script>






<form class="EstFormularioPrincipal" id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data"  onsubmit="FncGuardar();">

<div class="EstCapMenu">


<?php
/*if($Registro){
?>

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
}*/
?>    



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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        RECEPCION DE VEHICULO  </span></td>
      </tr>
      <tr>
        <td colspan="2">

          
	<ul class="tabs">
        <li><a href="#tab1">Recepcion</a></li>
 
	</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

		<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
              
			<div class="EstFormularioArea">
              	
              <span class="EstFormularioSubTitulo">Datos de la Recepcion  </span>
                      <input type="hidden" name="Guardar" id="Guardar"   />
                      <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                    
       
       
<div class="EstFormularioAreaCampo">
	<label class="EstFormularioAreaEtiqueta">Codigo Interno:</label>
	<div class="EstFormularioAreaContenido">
	<input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoRecepcion->VreId;?>" size="20" maxlength="20" />
	</div>
</div>
        
        
<div class="EstFormularioAreaCampo">
	<label class="EstFormularioAreaEtiqueta">  
        Fecha:
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></label>
        
	<div class="EstFormularioAreaContenido">
	
      
      <span id="sprytextfield7">
                    <label>
                        <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php echo $InsVehiculoRecepcion->VreFecha;?>" size="15" maxlength="10" />
                        </label>
                      <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
	</div>
</div>

    
    <div class="EstFormularioAreaCampo">
        <label class="EstFormularioAreaEtiqueta">Responsable:</label>
        <div class="EstFormularioAreaContenido">
         <span id="spryselect1">
                          <select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                            <option value="">Escoja una opcion</option>
                            <?php
                        foreach($ArrPersonales as $DatPersonal){
                        ?>
                            <option <?php echo ($DatPersonal->PerId==$InsVehiculoRecepcion->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                            <?php
                        }
                        ?>
                            </select>
                          <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
        </div>
    </div>
        
            
            
    <div class="EstFormularioAreaCampo">
        <label class="EstFormularioAreaEtiqueta"> &iquest;Tiene Guia de Remision?:</label>
        <div class="EstFormularioAreaContenido">
        <?php
                        switch($InsVehiculoRecepcion->VreTieneGuia){
                            case "Si":
                                $OpcTieneGuia1 = 'selected = "selected"';
                            break;
                            
                            case "No":
                                $OpcTieneGuia2 = 'selected = "selected"';						
                            break;
    
                        }
                        ?>
                          <select class="EstFormularioCombo" name="CmpTieneGuia" id="CmpTieneGuia"  >
                            <option <?php echo $OpcTieneGuia1;?> value="Si">Si</option>
                            <option <?php echo $OpcTieneGuia2;?> value="No">No</option>
                          </select>
        </div>
    </div>       
         
    <div class="EstFormularioAreaCampo">
        <label class="EstFormularioAreaEtiqueta">Num. Guia de Remision:</label>
        <div class="EstFormularioAreaContenido">
         <input name="CmpGuiaRemisionNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumero"  tabindex="3" value="<?php  echo $InsVehiculoRecepcion->VreGuiaRemisionNumero;?>" size="25" maxlength="25" />
        </div>
    </div>
    
    
    <div class="EstFormularioAreaCampo">
        <label class="EstFormularioAreaEtiqueta">Num. Guia de Remision:</label>
        <div class="EstFormularioAreaContenido">
         <input name="CmpGuiaRemisionNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumero"  tabindex="3" value="<?php  echo $InsVehiculoRecepcion->VreGuiaRemisionNumero;?>" size="25" maxlength="25" />
        </div>
    </div>
    
    
    <div class="EstFormularioAreaCampo">
        <label class="EstFormularioAreaEtiqueta">Observacion:</label>
        <div class="EstFormularioAreaContenido">
        <textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsVehiculoRecepcion->VreObservacion;?></textarea>
        </div>
    </div>
    
    
    <div class="EstFormularioAreaCampo">
        <label class="EstFormularioAreaEtiqueta"> Estado:</label>
        <div class="EstFormularioAreaContenido">
        
                          
            <?php
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
            </select>
                        
        </div>
    </div>
    
    
        
    <div class="EstFormularioAreaCampo">
        <label class="EstFormularioAreaEtiqueta"> OPCIONES:</label>
        <div class="EstFormularioAreaContenido">
         <input <?php echo (($InsVehiculoRecepcion->VreNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
                          Notificar via email
        </div>
    </div>   

</div>
                      
                      
                      
                 </td>
            </tr>
            <tr>
              <td valign="top">
                
               
                
                <div class="EstFormularioArea">
                
                
                 <span class="EstFormularioSubTitulo">Datos del Vehiculo
                        
                      </span>
                      
<input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsVehiculoRecepcion->EinId;?>" size="3" />
<input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsVehiculoRecepcion->CliId;?>" size="3" />

    <div class="EstFormularioAreaCampo">
   		<label class="EstFormularioAreaEtiqueta"> VIN:</label>
    	<div class="EstFormularioAreaContenido">
        
           
             
              <a href="javascript:FncVehiculoIngresoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
              
              <span id="sprytextfield1">
              
                <input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsVehiculoRecepcion->EinVIN;?>" size="20" maxlength="50" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                
                
                <a href="javascript:FncVehiculoIngresoBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                
                <a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                
		</div>
	</div>   
    
           
        <div class="EstFormularioAreaCampo">
          <label class="EstFormularioAreaEtiqueta"> Marca:</label>
          <div class="EstFormularioAreaContenido">
            
           <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsVehiculoRecepcion->VmaId;?>" size="3" />
                          
                          <input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoMarca" value="<?php echo $InsVehiculoRecepcion->VmaNombre;?>" size="30" maxlength="50" />
                          
          </div>
        </div>        
                
              
        <div class="EstFormularioAreaCampo">
            <label class="EstFormularioAreaEtiqueta"> Modelo:</label>
            <div class="EstFormularioAreaContenido">
            
             <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsVehiculoRecepcion->VmoId;?>" size="3" />
                    <input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoModelo" value="<?php echo $InsVehiculoRecepcion->VmoNombre;?>" size="30" maxlength="50" />
                    
            </div>
        </div>                  
 


        <div class="EstFormularioAreaCampo">
            <label class="EstFormularioAreaEtiqueta"> Color:</label>
            <div class="EstFormularioAreaContenido">
            
             <input  name="CmpVehiculoIngresoColor" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoColor" value="<?php echo $InsVehiculoRecepcion->EinColor;?>" size="30" maxlength="50" readonly="readonly" />
                    
            </div>
        </div>     
                  
                
                  
                  </div>
                </td>
            </tr>
            <tr>
              <td valign="top">
                <div class="EstFormularioArea">
                  
		<span class="EstFormularioSubTitulo">DETALLES</span>
                  
                  
        <input type="hidden" name="CmpVehiculoRecepcionDetalleItem" id="CmpVehiculoRecepcionDetalleItem" />
        <input type="hidden" name="CmpVehiculoRecepcionDetalleId"    id="CmpVehiculoRecepcionDetalleId"    />
        <input type="hidden" name="CmpVehiculoRecepcionDetalleAccion" id="CmpVehiculoRecepcionDetalleAccion" value="AccVehiculoRecepcionDetalleRegistrar.php" />
                        
                  
		<div class="EstFormularioAreaCampo">
            <label class="EstFormularioAreaEtiqueta">  Zona Comprometida:</label>
            <div class="EstFormularioAreaContenido">
            
          
                   <input name="CmpVehiculoRecepcionDetalleZonaComprometida" type="text" class="EstFormularioCaja" id="CmpVehiculoRecepcionDetalleZonaComprometida" size="30" />
                    
            </div>
        </div>   
                   
        <div class="EstFormularioAreaCampo">
            <label class="EstFormularioAreaEtiqueta"> Detalle de Repuesto:</label>
            <div class="EstFormularioAreaContenido">
                
                  <input name="CmpVehiculoRecepcionDetalleRepuestoDetalle" type="text" class="EstFormularioCaja" id="CmpVehiculoRecepcionDetalleRepuestoDetalle" size="30" />
                    
            </div>
        </div>   
        
		<div class="EstFormularioAreaCampo">
            <label class="EstFormularioAreaEtiqueta">  Solucion:</label>
            <div class="EstFormularioAreaContenido">
            
                 <input name="CmpVehiculoRecepcionDetalleSolucion" type="text" class="EstFormularioCaja" id="CmpVehiculoRecepcionDetalleSolucion" size="30" />
                    
            </div>
        </div> 
        
        <div class="EstFormularioAreaCampo">
            <label class="EstFormularioAreaEtiqueta"> Observacion:</label>
            <div class="EstFormularioAreaContenido">
            
                 <input name="CmpVehiculoRecepcionDetalleObservacion" type="text" class="EstFormularioCaja" id="CmpVehiculoRecepcionDetalleObservacion" size="30" />
                    
            </div>
        </div> 
                                     
		<div class="EstFormularioAreaCampo">
            <label class="EstFormularioAreaEtiqueta"></label>
            <div class="EstFormularioAreaContenido">
            
                <a href="javascript:FncVehiculoRecepcionDetalleNuevo();">
                <img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                
                <a href="javascript:FncVehiculoRecepcionDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a>
                    
            </div>
        </div>                
                   
                   
                   
                  
                  
                  </div>              </td>
            </tr>
            
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="48%"><div class="EstFormularioAccion" id="CapVehiculoRecepcionDetalleAccion">Listo
                      para registrar elementos</div></td>
                    <td width="50%" align="right">
                      
                      <a href="javascript:FncVehiculoRecepcionDetalleListar();">
                        <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoRecepcionDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                      
                      </td>
                    <td width="1%">&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapVehiculoRecepcionDetalles" class="EstCapVehiculoRecepcionDetalles" > </div></td>
                    <td><div id="CapVehiculoRecepcionDetallesResultado"> </div></td>
                    </tr>
                  </table>
                </div></td>
            </tr>
            <tr>
              <td valign="top">&nbsp;</td>
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
	
	
	
  


<!--  -->
  
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
</script>

<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
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




?>
