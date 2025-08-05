<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

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
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoVersion.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');


if (isset($_SESSION['InsVehiculoVersionCaracteristica'.$Identificador])){	
	$_SESSION['InsVehiculoVersionCaracteristica'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoVersionCaracteristica'.$Identificador]);
}

//INSTANCIAS
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoCaracteristica = new ClsVehiculoCaracteristica();
$InsVehiculoCaracteristicaSeccion = new ClsVehiculoCaracteristicaSeccion();

//ACCIONES
$ResVehiculoCaracteristicaSeccion = $InsVehiculoCaracteristicaSeccion->MtdObtenerVehiculoCaracteristicaSecciones(NULL,NULL,'VcsId','ASC',NULL);
$ArrVehiculoCaracteristicaSecciones = $ResVehiculoCaracteristicaSeccion['Datos'];


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoVersionEditar.php');
//DATOS
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];
//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<script type="text/javascript" >

var VehiculoModeloHabilitado = 2;
var VehiculoModeloId = "<?php echo $InsVehiculoVersion->VmoId;?>";

$().ready(function() {

	//FncVehiculoModelosCargar(VehiculoModeloHabilitado,$("#CmpVehiculoMarcaId").val(),$("#CmpVehiculoModeloId").val());
	FncVehiculoModelosCargar();
	FncVehiculoVersionFotoListar();
	FncVehiculoVersionArchivoListar();
	
	FncVehiculoVersionFotoLateralListar();
	FncVehiculoVersionFotoPosteriorListar();	
	FncVehiculoVersionFotoCaracteristicaListar();	
		
	FncVehiculoVersionCaracteristicaListar();

});

var VehiculoVersionArchivoEditar = 2;
var VehiculoVersionArchivoEliminar = 2;

var VehiculoVersionFotoEditar = 2;
var VehiculoVersionFotoEliminar = 2;

var VehiculoVersionFotoLateralEditar =  2;
var VehiculoVersionFotoLateralEliminar = 2;

var VehiculoVersionFotoPosteriorEditar = 2;
var VehiculoVersionFotoPosteriorEliminar =  2;


var VehiculoVersionFotoCaracteristicaEditar = 2;
var VehiculoVersionFotoCaracteristicaEliminar =  2;

var VehiculoVersionCaracteristicaEditar = 2;
var VehiculoVersionCaracteristicaEliminar = 2;
</script>
<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculoVersion->VveId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">VER
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
        </div> <br />
        
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="4">&nbsp;</td>
            <td width="137"><span class="EstFormularioSubTitulo">
              <input type="hidden" name="Guardar" id="Guardar"   />
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
            </span></td>
            <td width="717">&nbsp;</td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoVersion->VveId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">Marca:</td>
            <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" disabled="disabled" >
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
            <td valign="top">Modelo:
              <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoVersion->VmoId;?>" size="3" /></td>
            <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><input value="<?php echo $InsVehiculoVersion->VveNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Vigencia de Venta:</td>
            <td><?php
			switch($InsVehiculoVersion->VveVigenciaVenta){
				case 1:
					$OpcVigenciaVenta1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcVigenciaVenta2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpVigenciaVenta" id="CmpVigenciaVenta" disabled="disabled">
                <option <?php echo $OpcVigenciaVenta1;?> value="1">Si</option>
                <option <?php echo $OpcVigenciaVenta2;?> value="2">No</option>
              </select></td>
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
                      <td width="275" colspan="2" align="left" valign="top">
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
            <td align="left" valign="top"><div class="EstFormularioArea" >
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
                      <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
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
									  
									</script></td>
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
            </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Foto Lateral: </td>
            <td align="left" valign="top"><div class="EstFormularioArea" >
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
                      <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
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
									  
									</script></td>
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
            </div></td>
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
                      <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
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
									  
									</script></td>
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
                      <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
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
									  
									</script></td>
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
            <td colspan="2"><div class="EstFormularioArea">
                  
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
                            <td>Caracteristica:</td>
                            <td>Descripcion:</td>
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
$AnoHoy = date("Y");
?>
<select class="EstFormularioCombo" name="CmpVehiculoVersionCaracteristicaAno" id="CmpVehiculoVersionCaracteristicaAno" >
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
                  </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">
            

            <div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%"><input type="hidden" name="CmpVehiculoVersionCaracteristicaAccion" id="CmpVehiculoVersionCaracteristicaAccion" value="AccVehiculoVersionCaracteristicaRegistrar.php" /></td>
                    <td width="49%"><div class="EstFormularioAccion" id="CapServicioRepuestoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right">
                      
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
                </div>
            



            </td>
            <td>&nbsp;</td>
          </tr> <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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


	
	
    



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

