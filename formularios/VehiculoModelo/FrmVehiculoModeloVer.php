<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoModeloFotoCaracteristicaFunciones.js" ></script>


<?php
//VARIABLES
$GET_id = $_GET['Id'];
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoModelo.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoTipo.php');
//INSTANCIAS
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoTipo = new ClsVehiculoTipo();






//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoModeloEditar.php');
//DATOS
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResVehiculoTipo = $InsVehiculoTipo->MtdObtenerVehiculoTipos(NULL,NULL,"VTiNombre","ASC",NULL);
$ArrVehiculoTipos = $ResVehiculoTipo['Datos'];




//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<script type="text/javascript" >

$().ready(function() {
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();

	FncVehiculoModeloFotoCaracteristicaListar();	
	
});

var VehiculoModeloFotoCaracteristicaEditar = 2;
var VehiculoModeloFotoCaracteristicaEliminar =  2;

</script>

<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculoModelo->VmoId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        MODELO DEL VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
                                       
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoModelo->VmoTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoModelo->VmoTiempoModificacion;?></span></td>
          </tr>
        </table>
        </div> <br />
        
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td><span class="EstFormularioSubTitulo">
              <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
            </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoModelo->VmoId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Marca:</td>
            <td><select class="EstFormularioCombo" name="CmpMarca" id="CmpMarca" disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
              <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoModelo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tipo:</td>
            <td><select class="EstFormularioCombo" name="CmpTipo" id="CmpTipo" disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrVehiculoTipos as $DatVehiculoTipo){
			?>
              <option value="<?php echo $DatVehiculoTipo->VtiId?>" <?php if($InsVehiculoModelo->VtiId==$DatVehiculoTipo->VtiId){ echo 'selected="selected"';} ?> ><?php echo $DatVehiculoTipo->VtiNombre?></option>
              <?php
			}
			?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><input value="<?php echo $InsVehiculoModelo->VmoNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Nombre Comercial:</td>
            <td><input   name="CmpNombreComercial" type="text" class="EstFormularioCaja" id="CmpNombreComercial" value="<?php echo $InsVehiculoModelo->VmoNombreComercial;?>" size="30" maxlength="250" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Vigencia de Venta:</td>
            <td><?php
			switch($InsVehiculoModelo->VmoVigenciaVenta){
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
            <td align="left" valign="top">Foto de Caracteristicas Comparativo:</td>
            <td align="left" valign="top"><div class="EstFormularioArea" >
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td width="1%">&nbsp;</td>
                  <td width="48%"><a href="javascript:FncVehiculoModeloFotoCaracteristicaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoModeloFotoCaracteristicaEliminarTodo();"></a></td>
                  <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoModeloFotoCaracteristicasAccion">Listo
                    para registrar elementos</div></td>
                  <td width="1%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                    <tr>
                      <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoModeloFotoCaracteristica").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg",
											url:"formularios/VehiculoModelo/acc/AccVehiculoModeloSubirFotoCaracteristica.php",
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
												FncVehiculoModeloFotoCaracteristicaListar();
											}
							
										});
									});
									  
									</script></td>
                      <td width="4" align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoModeloFotoCaracteristicas" id="CapVehiculoModeloFotoCaracteristicas"></div></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                  </table></td>
                  <td><div id="CapVehiculoModeloFotoCaracteristicasResultado"> </div></td>
                </tr>
              </table>
            </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
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

