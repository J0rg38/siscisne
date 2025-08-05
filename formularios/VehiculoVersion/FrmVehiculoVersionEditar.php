<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionCaracteristicaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionArchivoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionFotoLateralFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionFotoPosteriorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoVersionFotoCaracteristicaFunciones.js" ></script>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoVersion.css');
</style>

<?php
//VARIABLES
$Edito = false;
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoVersion.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

//INSTANCIAS
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoCaracteristica = new ClsVehiculoCaracteristica();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();


if (isset($_SESSION['InsVehiculoVersionCaracteristica'.$Identificador])){	
	$_SESSION['InsVehiculoVersionCaracteristica'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoVersionCaracteristica'.$Identificador]);
}

//ACCIONES

$InsVehiculoVersion->VveId = $GET_id;
$InsVehiculoVersion->MtdObtenerVehiculoVersion();		

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoVersionEditar.php');
//DATOS
$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
<script type="text/javascript" >

var VehiculoModeloHabilitado = 1;
var VehiculoModeloId = "<?php echo $InsVehiculoVersion->VmoId;?>";

$().ready(function() {
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
	//FncVehiculoModelosCargar(VehiculoModeloHabilitado,$("#CmpVehiculoMarcaId").val(),$("#CmpVehiculoModeloId").val());
	FncVehiculoModelosCargar();

	FncVehiculoVersionFotoListar();
	FncVehiculoVersionArchivoListar();
	
	FncVehiculoVersionFotoLateralListar();
	FncVehiculoVersionFotoPosteriorListar();	
	FncVehiculoVersionFotoCaracteristicaListar();	
	
	FncVehiculoVersionCaracteristicaListar();
	
});

var VehiculoVersionArchivoEditar = 1;
var VehiculoVersionArchivoEliminar = 1;

var VehiculoVersionFotoEditar = 1;
var VehiculoVersionFotoEliminar = 1;

var VehiculoVersionFotoLateralEditar = 1;
var VehiculoVersionFotoLateralEliminar = 1;

var VehiculoVersionFotoPosteriorEditar = 1;
var VehiculoVersionFotoPosteriorEliminar = 1;


var VehiculoVersionFotoCaracteristicaEditar = 1;
var VehiculoVersionFotoCaracteristicaEliminar =  1;

var VehiculoVersionCaracteristicaEditar = 1;
var VehiculoVersionCaracteristicaEliminar = 1;
</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">
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
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        VERSION DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
                                      
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoVersion->VveTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoVersion->VveTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div>
          <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="4">&nbsp;</td>
            <td width="136"><span class="EstFormularioSubTitulo">
              <input type="hidden" name="Guardar" id="Guardar"   />
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
            </span></td>
            <td width="695">&nbsp;</td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">C&oacute;digo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoVersion->VveId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Marca:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoVersion->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Modelo
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoVersion->VmoId;?>" size="3" />
              :</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja"   name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsVehiculoVersion->VveNombre;?>" size="40" maxlength="250" /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Vigencia de Venta:</td>
            <td align="left" valign="top">
              
              <?php
			switch($InsVehiculoVersion->VveVigenciaVenta){
				case 1:
					$OpcVigenciaVenta1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcVigenciaVenta2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpVigenciaVenta" id="CmpVigenciaVenta">
                <option <?php echo $OpcVigenciaVenta1;?> value="1">Si</option>
                <option <?php echo $OpcVigenciaVenta2;?> value="2">No</option>
                </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Foto Archivo:</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Foto de Caracteristicas:</td>
            <td align="left" valign="top"><div class="EstFormularioArea" >
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td width="1%">&nbsp;</td>
                  <td width="48%"><a href="javascript:FncVehiculoVersionFotoCaracteristicaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoVersionFotoCaracteristicaEliminarTodo();"></a></td>
                  <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoVersionFotoCaracteristicasAccion">Listo
                    para registrar elementos</div></td>
                  <td width="1%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                    <tr>
                      <td width="275" colspan="2" align="left" valign="top"><div id="fileUploadVehiculoVersionFotoCaracteristica">Escoger Archivo</div>
                        <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoVersionFotoCaracteristica").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg",
											url:"formularios/VehiculoVersion/acc/AccVehiculoVersionSubirFotoCaracteristica.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncVehiculoVersionFotoCaracteristicaListar();
											}
							
										});
									});
									  
									</script></td>
                      <td width="4" align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoVersionFotoCaracteristicas" id="CapVehiculoVersionFotoCaracteristicas"></div></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                  </table></td>
                  <td><div id="CapVehiculoVersionFotoCaracteristicasResultado"> </div></td>
                </tr>
              </table>
            </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Foto Delantera:</td>
            <td align="left" valign="top">
            
            
            <div class="EstFormularioArea" > 
               
               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncVehiculoVersionFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoVersionFotoEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoVersionFotosAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top">
                           
                             <div id="fileUploadVehiculoVersionFoto">Escoger Archivo</div>
                             
                             <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoVersionFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg",
											url:"formularios/VehiculoVersion/acc/AccVehiculoVersionSubirFoto.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncVehiculoVersionFotoListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoVersionFotos" id="CapVehiculoVersionFotos"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapVehiculoVersionFotosResultado"> </div></td>
             </tr>
             </table>
             
               </div>
               
               </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Foto Lateral: </td>
            <td align="left" valign="top">
            
            <div class="EstFormularioArea" > 
               
               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncVehiculoVersionFotoLateralListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoVersionFotoLateralEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoVersionFotoLateralsAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top">
                           
                             <div id="fileUploadVehiculoVersionFotoLateral">Escoger Archivo</div>
                             
                             <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoVersionFotoLateral").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg",
											url:"formularios/VehiculoVersion/acc/AccVehiculoVersionSubirFotoLateral.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncVehiculoVersionFotoLateralListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoVersionFotoLaterals" id="CapVehiculoVersionFotoLaterals"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapVehiculoVersionFotoLateralsResultado"> </div></td>
             </tr>
             </table>
             
               </div>
               
               
               </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Foto Posterior:</td>
            <td align="left" valign="top"><div class="EstFormularioArea" > 
               
               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncVehiculoVersionFotoPosteriorListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoVersionFotoPosteriorEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoVersionFotoPosteriorsAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top">
                           
                             <div id="fileUploadVehiculoVersionFotoPosterior">Escoger Archivo</div>
                             
                             <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoVersionFotoPosterior").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg",
											url:"formularios/VehiculoVersion/acc/AccVehiculoVersionSubirFotoPosterior.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncVehiculoVersionFotoPosteriorListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoVersionFotoPosteriors" id="CapVehiculoVersionFotoPosteriors"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapVehiculoVersionFotoPosteriorsResultado"> </div></td>
             </tr>
             </table>
             
               </div></td>
            <td>&nbsp;</td>
          </tr>
     
         
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Archivo de Especificaciones:</td>
            <td align="left" valign="top"><div class="EstFormularioArea" > 
               
               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncVehiculoVersionArchivoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoVersionArchivoEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoVersionArchivosAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top">
                           
                             <div id="fileUploadVehiculoVersionArchivo">Escoger Archivo</div>
                             
                             <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoVersionArchivo").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/VehiculoVersion/acc/AccVehiculoVersionSubirArchivo.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncVehiculoVersionArchivoListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoVersionArchivos" id="CapVehiculoVersionArchivos"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapVehiculoVersionArchivosResultado"> </div></td>
             </tr>
             </table>
             
               </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
			
	<div class="EstFormularioArea">
                  
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="98%">
                        
                        
                        
                        
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="6"><span class="EstFormularioSubTitulo">CARACTERISTICAS GENERALES</span><span class="EstFormularioSubTitulo">
                            
                            <input type="hidden" name="CmpServicioRepuestoId"    id="CmpServicioRepuestoId"  />
							<input type="hidden" name="CmpServicioRepuestoItem" id="CmpServicioRepuestoItem" />
                       
                              </span></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>Seccion:</td>
                            <td>Año:</td>
                            <td>Descripcion:</td>
                            <td>Contenido:</td>
                            <td>&nbsp;</td>
                            </tr>
                        
                          <tr>
                            <td>&nbsp;</td>
                            <td>
                              <a href="javascript:FncVehiculoVersionCaracteristicaNuevo('');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                             </td>
                            <td>
                            
                            
<select class="EstFormularioCombo" name="CmpVehiculoCaracteristicaSeccion" id="CmpVehiculoCaracteristicaSeccion" >
<option value="">Escoja una opcion</option>
<?php
foreach($ArrVehiculoCaracteristicaSecciones as $DatVehiculoCaracteristicaSeccion){
?>
<option value="<?php echo $DatVehiculoCaracteristicaSeccion->VcsId?>"><?php echo $DatVehiculoCaracteristicaSeccion->VcsNombre;?></option>
<?php
}
?>
</select>                            
                            </td>
                            <td>
                            
                            
<?php
$AnoHoy = date("Y")+1;
?>
<select class="EstFormularioCombo" name="CmpVehiculoVersionCaracteristicaAnoModelo" id="CmpVehiculoVersionCaracteristicaAnoModelo" >
    <option value="">Escoja una opcion</option>
    <?php
    for($ano=2014;$ano<=$AnoHoy;$ano++){
    ?>
    	<option value="<?php echo $ano?>"><?php echo $ano;?></option>
    <?php
    }
    ?>
</select>
                            
                            
                            </td>
                            <td><input name="CmpVehiculoVersionCaracteristicaDescripcion" type="text" class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristicaDescripcion" size="45" /></td>
                            <td><input name="CmpVehiculoVersionCaracteristicaValor" type="text" class="EstFormularioCaja" id="CmpVehiculoVersionCaracteristicaValor" size="45" /></td>
                            <td>
                              
                              
                              
                              <a href="javascript:FncVehiculoVersionCaracteristicaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a>
                              
                            </td>
                          </tr>
                            </table>                      
                        </td>
                      </tr>
                    </table>
                  </div>
                        
            
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%"><input type="hidden" name="CmpVehiculoVersionCaracteristicaAccion" id="CmpVehiculoVersionCaracteristicaAccion" value="AccVehiculoVersionCaracteristicaRegistrar.php" /></td>
                    <td width="49%"><div class="EstFormularioAccion" id="CapServicioRepuestoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right">
                      
                      
                      Año: <?php
$AnoHoy = date("Y")+1;
?>
<select class="EstFormularioCombo" name="CmpAnoModelo" id="CmpAnoModelo" >
    <option value="">Escoja una opcion</option>
    <?php
    for($ano=2014;$ano<=$AnoHoy;$ano++){
    ?>
    	<option <?php echo (($ano==date("Y")?'selected="selected"':''));?>  value="<?php echo $ano?>"><?php echo $ano;?></option>
    <?php
    }
    ?>
</select>
            
            
            
                      <a href="javascript:FncVehiculoVersionCaracteristicaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                      
                     
                      <a href="javascript:FncVehiculoVersionCaracteristicaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                    
                      
                      </td>
                    <td width="1%"><div id="CapVehiculoVersionCaracteristicasResultado"> </div></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapVehiculoVersionCaracteristicas" class="EstCapVehiculoVersionCaracteristicas" > </div></td>
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
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

