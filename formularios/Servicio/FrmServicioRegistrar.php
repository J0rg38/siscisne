<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletarv2.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsServicioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsServicioDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssServicio.css');
</style>

<?php
//VARIABLES
$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjServicio.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsServicio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsServicioDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

//INSTANCIAS
$InsServicio = new ClsServicio();
$InsMoneda = new ClsMoneda();
if (!isset($_SESSION['InsServicioDetalle'.$Identificador])){	
	$_SESSION['InsServicioDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsServicioDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsServicioDetalle'.$Identificador]);
}

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccServicioRegistrar.php');
//DATOS

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/

var ServicioDetalleEditar = 1;
var ServicioDetalleEliminar = 1;


$().ready(function() {
	
	FncServicioDetalleListar();
	
	$("#CmpNombre").focus();
	
});
</script>



<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">

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
        <td width="961" height="25"><span class="EstFormularioTitulo">REGISTRAR SERVICIO</span></td>
      </tr>
      <tr>
        <td>
		
        
        
	
    
<ul class="tabs">
    <li><a href="#tab1">Servicio</a></li>
    <li><a href="#tab4">Productos</a></li>
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

		
		 
		
     
        
	   
       
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
           <div class="EstFormularioArea" >
         
         
          
 

              
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="1">&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Datos del	Servicio</span>			
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="123" align="left" valign="top">Codigo Interno:</td>
            <td width="352" align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsServicio->SerId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input  name="CmpNombre" type="text"  class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsServicio->SerNombre;?>" size="45" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descripcion:</td>
            <td align="left" valign="top"><textarea name="CmpDescripcion" cols="45" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsServicio->SerDescripcion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsServicio->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Importe:</td>
            <td align="left" valign="top"><input  name="CmpImporte" type="text"  class="EstFormularioCaja" id="CmpImporte" value="<?php echo number_format($InsServicio->SerImporte,2);?>" size="10" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsServicio->SerEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
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





    
    

    
    
	<div id="tab4" class="tab_content">
        <!--Content-->
    
         <table border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td colspan="2" valign="top">
           
           <div class="EstFormularioArea" >
           



              
		<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
            <td>&nbsp;</td>
          </tr>
          
           <tr>
             <td>&nbsp;</td>
             <td colspan="2"><div class="EstFormularioArea">
               <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                 <tr>
                   <td><div id="CapProductoBuscar"></div></td>
                   <td>C&oacute;digo Orig.</td>
                   <td>&nbsp;</td>
                   <td>Nombre : <span class="EstFormularioSubTitulo">
                     <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
                     <input type="hidden" name="CmpServicioDetalleItem"    id="CmpServicioDetalleItem"   />
                   </span></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>U.M.</td>
                   <td>Cantidad:</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td>
                     <a href="javascript:FncServicioDetalleNuevo('');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                    </td>
                   <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                   <td>
                     <a href="javascript:FncProductoBuscar('CodigoOriginal','');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                    </td>
                   <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="30" /></td>
                   <td>
                     <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                    </td>
                   <td>
                   <a id="BtnProductoConsulta" onclick="FncProductoCargarFormulario('Consulta');" href="javascript:void(0)"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Consulta]" width="20" height="20" border="0" align="absmiddle" title="Consulta" /></a></td>
                   <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                   </select></td>
                   <td><input name="CmpServicioDetalleCantidad" type="text" class="EstFormularioCaja" id="CmpServicioDetalleCantidad" size="8" maxlength="10"  /></td>
                   <td><a href="javascript:FncServicioDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                   </tr>
                 </table>
               </div></td>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td>&nbsp;</td>
             <td colspan="2"><div class="EstFormularioArea" >
               <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                 <tr>
                   <td>&nbsp;</td>
                   <td><input type="hidden" name="CmpServicioDetalleAccion" id="CmpServicioDetalleAccion" value="AccServicioDetalleRegistrar.php" /></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td width="1%">&nbsp;</td>
                   <td width="49%"><div class="EstFormularioAccion" id="CapServicioDetalleAccion">Listo
                     para registrar elementos</div></td>
                   <td width="49%" align="right"><a href="javascript:FncServicioDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncServicioDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
                   <td width="1%"><div id="CapServicioDetallesResultado"> </div></td>
                   </tr>
                 <tr>
                   <td>&nbsp;</td>
                   <td colspan="2"><div id="CapServicioDetalles" class="EstCapServicioDetalles" > </div></td>
                   <td>&nbsp;</td>
                   </tr>
                 </table>
             </div></td>
             <td>&nbsp;</td>
           </tr>
           <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              
            </td>
            <td>&nbsp;</td>
          </tr>
          </table>
           
            </div>
        
        
           </td>
         </tr>
		 
		 
		 
		 </table> 
           

	</div>
    
    <div id="tab5" class="tab_content">
        <!--Content--></div>
    
    
    
</div>      
               
        
        
        
        
        </td>
      </tr>

      <tr>
        <td align="center">&nbsp;</td>
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
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}
?>

