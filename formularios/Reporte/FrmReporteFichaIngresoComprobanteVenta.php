<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Ver")){
?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>


<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Personal");?>JsPersonalCombo.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsReporteFichaIngresoComprobanteVenta.js"></script>

<?php
$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:"01/".date("m")."/".date("Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");
$POST_Sucursal = $_SESSION['SesionSucursal'];


require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');

$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPersonal = new ClsPersonal();
$InsSucursal = new ClsSucursal();

$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();


$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinOrden","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,1,NULL,NULL,NULL,$_SESSION['SesionSucursal'],NULL,NULL,true);
$ArrTecnicos = $ResPersonal['Datos'];

//MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

//DATOS
$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos($POST_cam,$POST_fil,$POST_ord,$POST_sen,$POST_pag,$POST_Marca);
$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];

?>


<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">REPORTE LISTADO DE ORDENES DE TRABAJO X MODALIDAD</span>  </td>
  <td width="2%"><a href="formularios/Reporte/inf/InfReporteFichaIngresoComprobanteVenta.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <!--<form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteFichaIngresoComprobanteVenta.php" target="IfrReporteFichaIngresoComprobanteVenta" method="post" name="FrmReporteFichaIngresoComprobanteVenta" id="FrmReporteFichaIngresoComprobanteVenta">
      -->
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Fechas</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Fecha Inicio: </td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaInicio" type="text"  id="CmpFechaInicio" value="<?php  echo "01/".date("m")."/".date("Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaInicio" name="BtnFechaInicio" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />                  </td>
              </tr>
              <tr>
                <td>Fecha Fin:</td>
                <td><input class="EstFormularioCajaFecha" name="CmpFechaFin" type="text"  id="CmpFechaFin" value="<?php  echo date("d/m/Y");?>" size="10" maxlength="10"/>
                  <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaFin" name="BtnFechaFin" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /> </td>
                </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
          
          <fieldset  class="EstFormularioContenedor">
            <legend>Opciones de FIltro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Sucursal:</td>
                <td><select <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                  <option value="">Escoja una opcion</option>
                  <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                  <option value="<?php echo $DatSucursal->SucId?>" <?php if($_SESSION['SesionSucursal']==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                  <?php
    }
    ?>
                </select></td>
                <td>Modalidad:</td>
                <td><select name="CmpModalidad" id="CmpModalidad" class="EstFormularioCombo">
                  <option value="" selected="selected">Todos</option>
                  <?php 
				foreach($ArrModalidadIngresos as $DatModalidadIngreso){
				?>
                  <option value="<?php echo $DatModalidadIngreso->MinId;?>" ><?php echo $DatModalidadIngreso->MinNombre;?></option>
                  <?php
				}
				?>
                </select></td>
              </tr>
              <tr>
                <td>Marca:</td>
                <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                  <option value="">Escoja una opcion</option>
                  <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                  <option <?php echo $DatVehiculoMarca->VmaId;?>  value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                  <?php
			}
			?>
                </select></td>
                <td>Modelo:</td>
                <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo" >
                  <option value="">Escoja una opcion</option>
                  <?php
			foreach($ArrVehiculoModelos as $DatVehiculoModelo){
			?>
                  <option <?php echo $DatVehiculoModelo->VmoId;?>  value="<?php echo $DatVehiculoModelo->VmoId?>"><?php echo $DatVehiculoModelo->VmoNombre?></option>
                  <?php
			}
			?>
                </select></td>
              </tr>
              <tr>
                <td>Tecnico:</td>
                <td><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                  <option value="">Escoja una opcion</option>
                  <?php
					foreach($ArrTecnicos as $DatTecnico){
					?>
                  <option <?php if($_SESSION['SesionPersonal']==$DatTecnico->PerId){ echo 'selected="selected"';} ?>  value="<?php echo $DatTecnico->PerId;?>"><?php echo $DatTecnico->PerNombre ?> <?php echo $DatTecnico->PerApellidoPaterno; ?> <?php echo $DatTecnico->PerApellidoMaterno; ?></option>
                  <?php
					}
					?>
                </select></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset> 
          
          
          </td>
          <td align="left" valign="top">
            
            <fieldset class="EstFormularioContenedor">
              <legend>Opciones de Listado</legend>
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>
                    Ordenar por:</td>
                  <td>
                    <select name="CmpOrden" id="CmpOrden" class="EstFormularioCombo">
                     <option value="FinId" selected="selected">Numero de OT</option>
                      <option value="FinFecha" >Fecha de OT</option>
                      <option value="VmaNombre" >Marca</option>
                      <option value="VmoNombre" >Modelo</option>
                      <option value="MinNombre" >Modalidad de Ingreso</option>
                      
                      </select>                    </td>
                  </tr>
                <tr>
                  <td>                    </td>
                  <td>
                    <select name="CmpSentido" id="CmpSentido" class="EstFormularioCombo">
                      <option value="ASC">Ascendente</option>
                      <option value="DESC" selected="selected">Descendente</option>
                      </select>                    </td>
                  </tr>
                </table>
            </fieldset></td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" />           
                  <?php	  
            }
            ?>                  </td>
                <td>
                  
                  <?php
            if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel"  />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
              </table>          </td>
        </tr>
          </table>
     <!-- </form>  -->  </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
<!--  <iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Reporte/IfrReporteFichaIngresoComprobanteVenta.php" target="IfrReporteFichaIngresoComprobanteVenta" id="IfrReporteFichaIngresoComprobanteVenta" name="IfrReporteFichaIngresoComprobanteVenta" scrolling="auto"  frameborder="0"  height="420" width="100%"></iframe>-->
  
   
      <div class="EstReporteCapaListado autoheight" id="CapReporteFichaIngresoComprobanteVenta" ></div>
  
  
  
  
  </td>
</tr>
</table>
</div>

<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "CmpFechaInicio",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
	}); 	
	
	Calendar.setup({ 
	inputField : "CmpFechaFin",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaFin"// el id del bot&oacute;n que  
	}); 
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

