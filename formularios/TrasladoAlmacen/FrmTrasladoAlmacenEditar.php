<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoAlmacenFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoAlmacenDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTrasladoAlmacen.css');
</style>


   
<?php
$GET_id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTrasladoAlmacen.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTrasladoAlmacen.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTrasladoAlmacenDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

//INSTANCIAS
$InsTrasladoAlmacen = new ClsTrasladoAlmacen();
$InsAlmacen = new ClsAlmacen();
$InsPersonal = new ClsPersonal();

if (isset($_SESSION['InsTrasladoAlmacenDetalle'.$Identificador])){	
	$_SESSION['InsTrasladoAlmacenDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrasladoAlmacenDetalle'.$Identificador]);
}

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTrasladoAlmacenEditar.php');

$ResAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmId","ASC",NULL);
$ArrAlmacens = $ResAlmacen['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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

	FncTrasladoAlmacenDetalleListar();
	
});

/*
Configuracion Formulario
*/
var Formulario = "FrmEditar";

var TrasladoAlmacenDetalleEditar = 1;
var TrasladoAlmacenDetalleEliminar = 1;
var TrasladoAlmacenDetalleVerEstado = 2;

var UnidadMedidaTipo = 2;

</script>


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();"> 


<div class="EstCapMenu">

           
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div> 
<?php	
}
?>
	



<?php
if($Edito){
?>

	<?php
  /*  if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsTrasladoAlmacen->TalId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsTrasladoAlmacen->TalId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }*/
    ?>

<?php	
}
?>
            
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        TRANSFERENCIA ENTRE ALMACENES</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
           <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTrasladoAlmacen->TalTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsTrasladoAlmacen->TalTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />     
               
<ul class="tabs">
	<li><a href="#tab1">Transferencia entre Almacenes</a></li>
 

</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        

        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Transferencia entre Almacenes
                 
                 
                 
                 
                 
                 
                 
                   <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
               </span></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td>
               <input type="hidden" name="CmpPorcentajeImpuestoVenta" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsTrasladoAlmacen->TalPorcentajeImpuestoVenta; ?>" />
                        
                        <input type="hidden" name="CmpMonedaId" id="CmpMonedaId"  value="<?php echo $InsTrasladoAlmacen->MonId; ?>" />
                                           
<input type="hidden" name="CmpAlmacenMovimientoIdIngreso" id="CmpAlmacenMovimientoIdIngreso"  value="<?php echo $InsTrasladoAlmacen->AmoIdIngreso; ?>" />
<input type="hidden" name="CmpAlmacenMovimientoIdSalida" id="CmpAlmacenMovimientoIdSalida"  value="<?php echo $InsTrasladoAlmacen->AmoIdSalida; ?>" />     
                        
                      
                      
                      </td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsTrasladoAlmacen->TalId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">Responsable:</td>
               <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsTrasladoAlmacen->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha Salida:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsTrasladoAlmacen->TalFecha;?>" size="10" maxlength="10" readonly="readonly" />
               
              <img src="imagenes/acciones/calendario.png" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
               
               
               </td>
               <td align="left" valign="top">Fecha Llegada:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield2">
                 <label>
                   <input class="EstFormularioCajaFecha" name="CmpFechaLlegada" type="text" id="CmpFechaLlegada" value="<?php  echo $InsTrasladoAlmacen->TalFechaLlegada;?>" size="10" maxlength="10" />
                 </label>
                 <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span>
                 
                 <img src="imagenes/acciones/calendario.png" alt="[Calendario]" id="BtnFechaLlegada" name="BtnFechaLlegada" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                 
                 </td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Almacen Origen:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                 <option value="">Escoja una opcion</option>
                 <?php
			  foreach($ArrAlmacens as $DatAlmacen){
			  ?>
                 <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsTrasladoAlmacen->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';}?> ><?php echo $DatAlmacen->AlmNombre?></option>
                 <?php
			  }
			  ?>
               </select></td>
               <td align="left" valign="top">Almacen Destino:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacenDestino" id="CmpAlmacenDestino">
                 <option value="">Escoja una opcion</option>
                 <?php
			  foreach($ArrAlmacens as $DatAlmacen){
			  ?>
                 <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsTrasladoAlmacen->AlmIdDestino==$DatAlmacen->AlmId){ echo 'selected="selected"';}?> ><?php echo $DatAlmacen->AlmNombre?></option>
                 <?php
			  }
			  ?>
               </select></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Numero Guia de Remisi&oacute;n:</td>
               <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsTrasladoAlmacen->TalComprobanteNumeroSerie;?>" size="10" maxlength="50" />
                 -
                 <input name="CmpComprobanteNumeroNumero" type="text" class="CmpComprobanteNumeroNumero" id="CmpComprobanteNumero" value="<?php echo $InsTrasladoAlmacen->TalComprobanteNumeroNumero;?>" size="20" maxlength="50" /></td>
               <td align="left" valign="top">Fecha de Guia de Remision: <br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><span id="sprytextfield8">
                 <label>
                   <input class="EstComprobanteFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php echo $InsTrasladoAlmacen->TalComprobanteFecha; ?>" size="15" maxlength="10" />
                 </label>
                 <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" title="Formato no valido"  border="0" align="absmiddle"  /></span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]" id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsTrasladoAlmacen->TalObservacion;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsTrasladoAlmacen->TalEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled" >
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                 </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             </table>
           </div></td>
       </tr>
       <tr>
         <td valign="top">
           
                               <?php
					//if($InsTrasladoAlmacen->TalOrigen<>"VDI"){
					?>
           <div class="EstFormularioArea">
             
             <table width="100%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="98%">
                   
                   
                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="11"><span class="EstFormularioSubTitulo">PRODUCTOS</span>
                         <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<!--<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />-->
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpTrasladoAlmacenDetalleId"  class="EstFormularioCaja" id="CmpTrasladoAlmacenDetalleId"  />
                      
                       
                       <input type="hidden" name="CmpPeddoCompraDetalleEstado" id="CmpPeddoCompraDetalleEstado" value="1" />
                       <input type="hidden" name="CmpTrasladoAlmacenDetalleEstado" id="CmpTrasladoAlmacenDetalleEstado" value="3" /></td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td><div id="CapProductoBuscar"></div></td>
                       <td>Cod. Orig.</td>
                       <td>&nbsp;</td>
                       <td>Cod. Alt.</td>
                       <td>&nbsp;</td>
                       <td>Nombre : </td>
                       <td>&nbsp;</td>
                       <td>U.M.</td>
                       <td>Cantidad:</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>
                         
                         
                         
                         <?php
							if(empty($InsTrasladoAlmacen->VdiId)){
							?> 
                         <a href="javascript:FncTrasladoAlmacenDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                         <?php
							}
                       ?>
                         
                       </td>
                       <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                       <td>
                         
                         
                         <?php
							if(empty($InsTrasladoAlmacen->VdiId)){
							?> 
                         <a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
                         
                         <?php
							}
					   ?>
                         
                       </td>
                       <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                       <td><a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
                       <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                       <td>
                         
                         
                         
                         <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a>
                         <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                         
                         
                         
                         
                         
                       </td>
                       <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                       </select></td>
                       <td><input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="7" maxlength="10"  /></td>
                       <td><a href="javascript:FncTrasladoAlmacenDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                       <td><!--<a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>--></td>
                     </tr>
                     </table>             </td>
                 </tr>
               </table>
             </div>        
             <?php
				//	}
			 ?>
             
              </td>
       </tr>
       
       <tr>
         <td valign="top"><div class="EstFormularioArea" >
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                 para registrar elementos</div></td>
               <td width="50%" align="right"><a href="javascript:FncTrasladoAlmacenDetalleListar();">
                 <input type="hidden" name="CmpTrasladoAlmacenDetalleAccion" id="CmpTrasladoAlmacenDetalleAccion" value="AccTrasladoAlmacenDetalleRegistrar.php" />
                 <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                 
  <?php
					if($InsTrasladoAlmacen->TalOrigen<>"VDI" and empty($InsTrasladoAlmacen->OcoId)){
					?>
                 <a href="javascript:FncTrasladoAlmacenDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                 <?php
					}
					?>
                 </td>
               <td width="1%"><div id="CapTrasladoAlmacenDetallesResultado"> </div></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><div id="CapTrasladoAlmacenDetalles" class="EstCapTrasladoAlmacenDetalles" > </div></td>
               <td>&nbsp;</td>
               </tr>
             </table>
           </div></td>
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
inputField : "CmpFecha",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnFecha"// el id del botón que  
});

Calendar.setup({ 
inputField : "CmpFechaLlegada",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnFechaLlegada"// el id del botón que  
});

Calendar.setup({ 
inputField : "CmpComprobanteFecha",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnComprobanteFecha"// el id del botón que  
});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "date", {format:"dd/mm/yyyy", isRequired:false});
</script>
<?php
//}else{
//	echo ERR_TAL_601;
//}
?>


<?php
}else{
	echo ERR_GEN_101;
}



if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}
?>
