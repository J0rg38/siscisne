<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletarv2.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsServicioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsServicioDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssServicio.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
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
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccServicioEditar.php');
//DATOS

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];
?>


<script type="text/javascript" >


var ServicioDetalleEditar = 2;
var ServicioDetalleEliminar = 2;


$().ready(function() {

	FncServicioDetalleListar();
	


});

</script>

<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsServicio->SerId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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


<!--<div class="EstSubMenuBoton"><a href="javascript:FncPopUp('formularios/Servicio/FrmServicioCodigoBarra.php?o=1&t=40&r=1&text=<?php echo ($InsServicio->SerId);?>&f=2&a1=&a2=',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/codigo_barra.png" alt="[GCBarra]" title="Imprimir Codigo de Barras" />Cod. Barra</a></div>
-->


</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">VER SERVICIO</span></td>
      </tr>
      <tr>
        <td>
        
        
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsServicio->SerTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsServicio->SerTiempoModificacion;?></span></td>
          </tr>
        </table>
        
</div>
       
<br />
 		
<ul class="tabs">
	<li><a href="#tab1">Servicio</a></li>
    <li><a href="#tab4">Productos</a></li>

     
    
</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

    
         <table border="0" cellpadding="2" cellspacing="2">
           <tr>
             <td valign="top">
             <div class="EstFormularioArea" >
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Datos del	Servicio
                <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Codigo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsServicio->SerId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input  name="CmpNombre" type="text"  class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsServicio->SerNombre;?>" size="45" maxlength="255" readonly="readonly" /></td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descripcion:</td>
            <td align="left" valign="top"><textarea name="CmpDescripcion" cols="45" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsServicio->SerDescripcion;?></textarea></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
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
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Importe:</td>
            <td align="left" valign="top"><input  name="CmpImporte" type="text"  class="EstFormularioCaja" id="CmpImporte" value="<?php echo number_format($InsServicio->SerImporte,2);?>" size="10" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td><?php
			switch($InsServicio->SerEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              <select  disabled="disabled" class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
                </select></td>
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
                 <td colspan="2">&nbsp;</td>
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
                       <td width="49%" align="right"><a href="javascript:FncServicioDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncServicioDetalleEliminarTodo();"></a></td>
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
                 <td colspan="2"></td>
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
        <td align="center">&nbsp;</td>
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
