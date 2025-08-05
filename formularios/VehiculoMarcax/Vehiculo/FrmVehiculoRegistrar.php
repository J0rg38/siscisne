<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculo.css');
</style>

<?php
//VARIABLES
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculo.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
//INSTANCIAS
$InsVehiculo = new ClsVehiculo();
$InsVehiculoMarca = new ClsVehiculoMarca();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoRegistrar.php');
//DATOS
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript" >
//MARCAS - MODELOS - VERSIONES
var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;

$().ready(function() {
	FncVehiculoModelosCargar();
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
        <td width="961" height="25"><span class="EstFormularioTitulo">REGISTRAR VEHICULO</span></td>
      </tr>
      <tr>
        <td>
		
        
        
	
    
<ul class="tabs">
    <li><a href="#tab1">Vehiculo</a></li>
	<li><a href="#tab2">Foto</a></li>
	<li><a href="#tab3">Especificaciones</a></li>
    <li><a href="#tab4">Informacion</a></li>
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
            <td>&nbsp;</td>
            <td colspan="4">
              <span class="EstFormularioSubTitulo">
                Datos del Vehiculo			</span>			
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Nombre Comercial:</td>
            <td colspan="3" valign="top"><input value="<?php echo $InsVehiculo->VehNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="50" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Marca:</td>
            <td valign="top"><span id="spryselect1">
            <select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>Modelo:
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculo->VmoId;?>" size="3" /></td>
            <td><span id="spryselect2">
            <select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
            </select>
            <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Version:
              <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculo->VveId;?>" size="3" /></td>
            <td valign="top"><span id="spryselect3">
              <select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
            <td>Color:</td>
            <td><span id="sprytextfield1">
              <input value="<?php echo $InsVehiculo->VehColor;?>"  class="EstFormularioCaja"  name="CmpColor" type="text" id="CmpColor" size="30" maxlength="50" />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>              </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td>
              
              <?php
			switch($InsVehiculo->VehEstado){
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
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="99%"><span class="EstFormularioSubTitulo">Foto de Referencia del Vehiculo</span></td>
               <td width="0%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td><iframe src="formularios/Vehiculo/acc/AccVehiculoSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrVehiculoSubirArchivo" name="IfrVehiculoSubirArchivo" scrolling="Auto"  frameborder="0" width="100%" height="500"></iframe></td>
               <td>&nbsp;</td>
             </tr>           
             </table>
             
        
	
    
		</div>
	
        
    </td>
    </tr>
    </table>	
	   
	       </div>   
		   
  <div id="tab3" class="tab_content">    
	   			<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="99%"><span class="EstFormularioSubTitulo">Archivo de Especificaciones del Vehiculo</span></td>
               <td width="0%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>* Para consultar al realizar una venta</td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td><iframe src="formularios/Vehiculo/acc/AccVehiculoSubirArchivoEspecificacion.php?Identificador=<?php echo $Identificador;?>" id="IfrVehiculoSubirArchivoEspecificacion" name="IfrVehiculoSubirArchivoEspecificacion" scrolling="Auto"  frameborder="0" width="100%" height="500"></iframe></td>
               <td>&nbsp;</td>
             </tr>           
             </table>
             
        
	
    
		</div>
	
        
    </td>
    </tr>
    </table>	
	   
	       </div>  
           
           
  <div id="tab4" class="tab_content">    
	   			<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
        <div class="EstFormularioArea">
        
        
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="99%"><span class="EstFormularioSubTitulo">Informacion del Vehiculo</span></td>
               <td width="0%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>* Para armar la cotizacion</td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td>
                 <script language="JavaScript" type="text/javascript">
                                var oFCKeditor = new FCKeditor( 'CmpInformacion' ) ;
                                oFCKeditor.BasePath	= "<?php echo $InsProyecto->MtdRutLibrerias();?>fckeditor" ;
                                 oFCKeditor.Height	= 500 ;
								oFCKeditor.ToolbarSet = 'Basic' ;
                                oFCKeditor.Value	= '<?php echo $InsVehiculo->VehInformacion;?>' ;
                                oFCKeditor.Create() ;
                                </script>	
               
               </td>
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

	
	
    

</form>
<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

