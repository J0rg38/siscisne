<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculo.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculo.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
//INSTANCIAS
$InsVehiculo = new ClsVehiculo();
$InsVehiculoMarca = new ClsVehiculoMarca();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoEditar.php');
//DATOS
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript" >

var VehiculoModeloHabilitado = 2;
var VehiculoVersionHabilitado = 2;

$().ready(function() {
	FncVehiculoModelosCargar();
});

</script>

<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculo->VehId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
            
            
            
<div class="EstSubMenuBoton"><a href="javascript:FncPopUp('formularios/Vehiculo/FrmVehiculoCodigoBarra.php?o=1&t=40&r=1&text=<?php echo ($InsVehiculo->VehId);?>&f=2&a1=&a2=',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/iconos/codigo_barra.png" alt="[GCBarra]" title="Imprimir Codigo de Barras" />Cod. Barra</a></div>



</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25"><span class="EstFormularioTitulo">VER VEHICULO</span></td>
      </tr>
      <tr>
        <td>
        
        
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculo->VehTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculo->VehTiempoModificacion;?></span></td>
          </tr>
        </table>
        
</div>
        
        
                                <br />



 		
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
             <td valign="top">
             <div class="EstFormularioArea" >
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
              <span class="EstFormularioSubTitulo">
                Datos del Vehiculo			
                <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
              </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Codigo:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsVehiculo->VehId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Nombre Comercial:</td>
            <td colspan="3" valign="top"><input  name="CmpNombre" type="text"  class="EstFormularioCaja" id="CmpNombre" value="<?php echo $InsVehiculo->VehNombre;?>" size="50" maxlength="255" readonly="readonly" /></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Marca:</td>
            <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" disabled="disabled" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td valign="top">Modelo:
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculo->VmoId;?>" size="3" /></td>
            <td valign="top"><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo" >
            </select></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Version:
              <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculo->VveId;?>" size="3" /></td>
            <td valign="top"><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
            </select></td>
            <td>Color:</td>
            <td><input  name="CmpColor" type="text"  class="EstFormularioCaja" id="CmpColor" value="<?php echo $InsVehiculo->VehColor;?>" size="30" maxlength="50" readonly="readonly" /></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td><?php
			switch($InsVehiculo->VehEstado){
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
               <td>
			   
			                  <?php              
              
if(!empty($_SESSION['SesVehFoto'.$Identificador])){

	$extension = strtolower(pathinfo($_SESSION['SesVehFoto'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesVehFoto'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />

	<img  src="subidos/vehiculo_fotos/<?php echo $nombre_base.".".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />

<?php	
}else{
?>
No hay FOTO
<?php	
}
?>
			   
			   </td>
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
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             
               <tr>
               <td>&nbsp;</td>
               <td>
			   
			                  <?php              
              
if(!empty($_SESSION['SesVehEspecificacion'.$Identificador])){

	$extension = strtolower(pathinfo($_SESSION['SesVehEspecificacion'.$Identificador], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesVehEspecificacion'.$Identificador], '.'.$extension);  
?>

Vista Previa:<br />

<a target="_blank" href="subidos/vehiculo_especificaciones/<?php echo $nombre_base.".".$extension;?>"><?php echo $nombre_base.".".$extension;?></a>


<?php	
}else{
?>
No hay archivo de ESPECIFICACION
<?php	
}
?>
			   
			   </td>
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


	

	
    


<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
