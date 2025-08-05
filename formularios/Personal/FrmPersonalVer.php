<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsDepartamentoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsProvinciaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Ubigeo');?>JsDistritoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPersonalFunciones.js" ></script>  
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPersonaFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPersonaFotoFirmaFunciones.js" ></script>  
  
  

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPersonal.css');
</style>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPersonal.php');
//CLASES
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonalTipo.php');
require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsArea.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
//INSTANCIAS
$InsPersonal = new ClsPersonal();
$InsPersonalTipo = new ClsPersonalTipo();
$InsUsuario = new ClsUsuario();
$InsTipoDocumento = new ClsTipoDocumento();
$InsArea = new ClsArea();
$InsSucursal = new ClsSucursal();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPersonalEditar.php');
//DATOS
$ResUsuario = $InsUsuario->MtdObtenerUsuarios(NULL,NULL,NULL,"UsuUsuario","ASC",1,NULL,NULL);
$ArrUsuarios = $ResUsuario['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResPersonalTipo = $InsPersonalTipo->MtdObtenerPersonalTipos(NULL,NULL,'PtiNombre','ASC',NULL);
$ArrPersonalTipos = $ResPersonalTipo['Datos'];


$ResArea = $InsArea->MtdObtenerAreas(NULL,NULL,"AreId","Desc",NULL,NULL);
$ArrAreas = $ResArea['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
<script type="text/javascript">
$().ready(function() {
	
	FncPersonalFotoListar();
	FncPersonalFotoFirmaListar();
	FncDepartamentosCargar()
	
});

var PersonalFotoEditar = 2;
var PersonalFotoEliminar = 2;
var PersonalFotoFirmaEditar = 2;
var PersonalFotoFirmaEliminar = 2;

</script>
<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsPersonal->PerId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        EMPLEADO</span></td>
      </tr>
      <tr>
        <td colspan="2">
      
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPersonal->PerTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsPersonal->PerTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
          <br />
 
 
  		<ul class="tabs">
            <li><a href="#tab1">Empleado</a></li>
           
          </ul>
          <div class="tab_container">
            <div id="tab1" class="tab_content"> 
              <!--Content-->
              
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td colspan="2" valign="top">
				         
		<div class="EstFormularioArea">
        
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
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
            <td align="left" valign="top">C&oacute;digo Interno:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPersonal->PerId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td rowspan="29" align="left" valign="top">
            
            
            <table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>Foto:</td>
            </tr>
            <tr>
            <td>
             <div class="EstFormularioArea" > 
               
               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncPersonalFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncPersonalFotoEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapPersonalFotosAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadPersonalFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/Personal/acc/AccPersonalSubirFoto.php",
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
												FncPersonalFotoListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapPersonalFotos" id="CapPersonalFotos"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapPersonalFotosResultado"> </div></td>
             </tr>
             </table>
             
               </div>
            </td>
            </tr>
             <tr>
               <td>Firma:</td>
             </tr>
             <tr>
            <td>
            
            <div class="EstFormularioArea" > 
               
               <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
             <tr>
               <td width="1%">&nbsp;</td>
               <td width="48%"><a href="javascript:FncPersonalFotoFirmaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncPersonalFotoFirmaEliminarTodo();"></a></td>
               <td width="50%" align="right"><div class="EstFormularioAccion" id="CapPersonalFotoFirmasAccion">Listo
                 para registrar elementos</div></td>
               <td width="1%">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                         <tr>
                           <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadPersonalFotoFirma").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/Personal/acc/AccPersonalSubirFotoFirma.php",
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
												FncPersonalFotoFirmaListar();
											}
							
										});
									});
									  
									</script>
                             
                             
                             
                             
                           </td>
                           <td width="4" align="left" valign="top">&nbsp;</td>
                           </tr>
                         <tr>
                           <td colspan="2" align="left" valign="top"><div class="EstCapPersonalFotoFirmas" id="CapPersonalFotoFirmas"></div></td>
                           <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         </table></td>
               <td><div id="CapPersonalFotoFirmasResultado"> </div></td>
             </tr>
             </table>
             
               </div>
               
            </td>
            </tr>
            </table>
            
            
                       </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Sucursal:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsPersonal->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Area Asignada:</td>
            <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpAreaId" id="CmpAreaId">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrAreas as $DatArea){
				?>
              <option <?php echo ($InsPersonal->AreId == $DatArea->AreId)?'selected="selected"':''; ?>  value="<?php echo $DatArea->AreId?>"><?php echo $DatArea->AreNombre ?></option>
              <?php
			  }
			  
			  ?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cargo:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" disabled="disabled" name="CmpPersonalTipo" id="CmpPersonalTipo">
              <option value="">Escoja una opcion</option>
              <?php
							foreach($ArrPersonalTipos as $DatPersonalTipo){
							?>
              <option value="<?php echo $DatPersonalTipo->PtiId;?>" <?php echo ($DatPersonalTipo->PtiId==$InsPersonal->PtiId)?'selected="selected"':'';?>><?php echo $DatPersonalTipo->PtiNombre;?></option>
              <?php	
							}
							?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Apellido Paterno:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerApellidoPaterno;?>"  class="EstFormularioCaja"  name="CmpApellidoPaterno" type="text" id="CmpApellidoPaterno" size="40" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Apellido Materno:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerApellidoMaterno;?>"  class="EstFormularioCaja"  name="CmpApellidoMaterno" type="text" id="CmpApellidoMaterno" size="40" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha Nac.:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top">
            
            <input class="EstFormularioCajaFecha" name="CmpFechaNacimiento" type="text"  id="CmpFechaNacimiento" value="<?php if(!empty($InsPersonal->PerFechaNacimiento)){ echo $InsPersonal->PerFechaNacimiento; }?>" size="15" maxlength="10" readonly="readonly"/></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Sexo:</td>
            <td align="left" valign="top"><?php
			switch($InsPersonal->PerSexo){
				case "H":
					$OpcSexo1 = 'selected="selected"';
				break;
				
				case "M":
					$OpcSexo2 = 'selected="selected"';
				break;

			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpSexo" id="CmpSexo">
                <option <?php echo $OpcSexo1;?> value="H">H</option>
                <option <?php echo $OpcSexo2;?>  value="M">M</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado Civil:</td>
            <td align="left" valign="top"><?php
			switch($InsPersonal->PerEstadoCivil){
				case "S":
					$OpcEstadoCivil1 = 'selected="selected"';
				break;
				
				case "C":
					$OpcEstadoCivil2 = 'selected="selected"';
				break;

			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpEstadoCivil" id="CmpEstadoCivil">
                <option <?php echo $OpcEstadoCivil1; ?> value="S">SOLTERO</option>
                <option <?php echo $OpcEstadoCivil2; ?> value="C">CASADO</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Num.de Hijos:</td>
            <td align="left" valign="top"><input name="CmpCantidadHijo" type="text" class="EstFormularioCaja" id="CmpCantidadHijo" value="<?php if(empty($InsPersonal->PerCantidadHijo)){ echo "0";}else{ echo ($InsPersonal->PerCantidadHijo); }?>" size="10" maxlength="2" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top"><select  disabled="disabled" class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
              <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento ){
			?>
               <option <?php echo (($DatTipoDocumento->TdoId==$InsPersonal->TdoId)?'selected="selected"':'')?>  value="<?php echo $DatTipoDocumento->TdoId; ?>"><?php echo $DatTipoDocumento->TdoNombre; ?></option>
              <?php
			}			
			?>
            </select>
              :</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerNumeroDocumento;?>"  class="EstFormularioCaja"  name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="40" maxlength="50" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Email:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerEmail;?>"  class="EstFormularioCaja"  name="CmpEmail" type="text" id="CmpEmail" size="40" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tel&eacute;fono:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerTelefono;?>"  class="EstFormularioCaja"  name="CmpTelefono" type="text" id="CmpTelefono" size="40" maxlength="50" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Celular:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerCelular;?>"  class="EstFormularioCaja"  name="CmpCelular" type="text" id="CmpCelular" size="40" maxlength="50" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Pa&iacute;s:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerPais;?>"  class="EstFormularioCaja"  name="CmpPais" type="text" id="CmpPais" size="40" maxlength="100" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Ciudad:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerCiudad;?>"  class="EstFormularioCaja"  name="CmpCiudad" type="text" id="CmpCiudad" size="40" maxlength="100" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Direcci&oacute;n:</td>
            <td align="left" valign="top"><input value="<?php echo $InsPersonal->PerDireccion;?>"  class="EstFormularioCaja"  name="CmpDireccion" type="text" id="CmpDireccion" size="40" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Departamento:</td>
            <td align="left" valign="top"><input  name="CmpDepartamento" type="text"  class="EstFormularioCaja" id="CmpDepartamento" value="<?php echo $InsPersonal->PerDepartamento;?>" size="40" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Provincia:</td>
            <td align="left" valign="top"><input  name="CmpProvincia" type="text"  class="EstFormularioCaja" id="CmpProvincia" value="<?php echo $InsPersonal->PerProvincia;?>" size="40" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Distrito:</td>
            <td align="left" valign="top"><input  name="CmpDistrito" type="text"  class="EstFormularioCaja" id="CmpDistrito" value="<?php echo $InsPersonal->PerDistrito;?>" size="40" maxlength="255" readonly="readonly" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&iquest;Tecnico en OT?</td>
            <td align="left" valign="top"><?php
			switch($InsPersonal->PerTaller){
				case 1:
					$OpcTaller1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcTaller2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpTaller" id="CmpTaller" disabled="disabled">
                <option <?php echo $OpcTaller1;?> value="1">Si</option>
                <option <?php echo $OpcTaller2;?> value="2">No</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&iquest;Asesor en OT?</td>
            <td align="left" valign="top"><?php
			switch($InsPersonal->PerRecepcion){
				case 1:
					$OpcRecepcion1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcRecepcion2 = 'selected="selected"';
				break;
			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpRecepcion" id="CmpRecepcion">
                <option <?php echo $OpcRecepcion1;?> value="1">Si</option>
                <option <?php echo $OpcRecepcion2;?> value="2">No</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&iquest;Asesor de Ventas?</td>
            <td align="left" valign="top"><?php
			switch($InsPersonal->PerVenta){
				case 1:
					$OpcVenta1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcVenta2 = 'selected="selected"';
				break;
			}
			?>
              <select class="EstFormularioCombo" name="CmpVenta" id="CmpVenta" disabled="disabled">
                <option <?php echo $OpcVenta1;?> value="1">Si</option>
                <option <?php echo $OpcVenta2;?> value="2">No</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&iquest;Almacen?</td>
            <td align="left" valign="top"><?php
			switch($InsPersonal->PerAlmacen){
				case 1:
					$OpcAlmacen1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcAlmacen2 = 'selected="selected"';
				break;
			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                <option <?php echo $OpcAlmacen1;?> value="1">Si</option>
                <option <?php echo $OpcAlmacen2;?> value="2">No</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&iquest;Firmante?</td>
            <td align="left" valign="top"><?php
			switch($InsPersonal->PerFirmante){
				case 1:
					$OpcFirmante1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcFirmante2 = 'selected="selected"';
				break;
			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" name="CmpFirmante" id="CmpFirmante">
                <option <?php echo $OpcFirmante1;?> value="1">Si</option>
                <option <?php echo $OpcFirmante2;?> value="2">No</option>
              </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Abreviatura:</td>
            <td align="left" valign="top"><input  name="CmpAbreviatura" type="text"  class="EstFormularioCaja" id="CmpAbreviatura" value="<?php echo $InsPersonal->PerAbreviatura;?>" size="10" maxlength="10" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top">
              
              <?php
			switch($InsPersonal->PerEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
              
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                <option <?php echo $OpcEstado1;?> value="1">En Actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">De Baja</option>
              </select>            </td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Usuario:</td>
            <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpUsuario" id="CmpUsuario">
              <option value="">Sin usuario</option>
              <?php
			  foreach($ArrUsuarios as $DatUsuario){
			?>
              <option <?php if($InsPersonal->UsuId == $DatUsuario->UsuId){ echo 'selected="selected"';}?> value="<?php echo $DatUsuario->UsuId;?>"><?php echo $DatUsuario->UsuUsuario;?></option>
              <?php
			}
			?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="hidden" name="CmpFirma" id="CmpFirma"  value="<?php echo $InsPersonal->PerFirma;?>" /></td>
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

