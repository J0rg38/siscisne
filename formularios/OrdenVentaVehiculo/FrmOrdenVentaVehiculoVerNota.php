<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
         

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenVentaVehiculo.css');
</style>

<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenVentaVehiculo.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');



$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenVentaVehiculoEditarNota.php');

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

	
});

/*
Configuracion Formulario
*/

</script>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">


<div class="EstCapMenu">

           <?php
if($Edito){
?>

	

<?php
}
?>    

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        NOTA DE ORDEN DE VENTA DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        <!--       
<ul class="tabs">
	<li><a href="#tab1">Orden de Venta</a></li>
   

</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">-->
        <!--Content-->     
 
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           
           
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Orden
                   <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 </span></td>
               <td>&nbsp;</td>
               </tr>
             
             <tr>
               <td>&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td align="left">&nbsp;</td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenVentaVehiculo->OvvId;?>" size="25" maxlength="20" /></td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsOrdenVentaVehiculo->OvvFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenVentaVehiculo->OvvFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td>&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Notas:</td>
               <td colspan="3" align="left" valign="top"><div class="EstFormularioCajaObservacion"> <?php echo stripslashes($InsOrdenVentaVehiculo->OvvNota);?> </div>
                 <input type="hidden" name="CmpNota" id="CmpNota" value="<?php echo stripslashes($InsOrdenVentaVehiculo->OvvNota);?>" /></td>
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
       </table>
         
		

   <!-- </div>    
    


   
       
    
</div>    		 
		
        
        -->
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
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
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".(!empty($GET_mod)?$GET_mod:$GET_NMod)."&Form=Listado",$Edito,1500);
	}
	
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
