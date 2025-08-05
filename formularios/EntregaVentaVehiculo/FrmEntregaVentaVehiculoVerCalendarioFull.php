<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Listado")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsEntregaVentaVehiculoVerCalendarioFullFunciones.js"></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssEntregaVentaVehiculoCalendario.css');
</style>

<?php
$GET_Personal = $_GET['Personal'];
$POST_Sucursal = $_SESSION['SesionSucursal'];

$GET_FechaInicio = (empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio']);
$GET_FechaFin = (empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin']);

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsPersonal = new ClsPersonal();
$InsSucursal = new ClsSucursal();

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,1);
$ArrAsesores = $ResPersonal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1);
$ArrTecnicos = $ResPersonal['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];
?>

<script type="text/javascript">

	function init(oPersonal,oPersonalMecanico,oSucursal,oDate) {
	//function init() {
		scheduler.clearAll();
		scheduler.config.multi_day = true;
		scheduler.config.readonly = true;
	 
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.config.first_hour = 8;
		scheduler.config.last_hour = 19;
		scheduler.config.limit_time_select = true;
		scheduler.config.prevent_cache = true;
//		scheduler.config.details_on_dblclick = false;
//		scheduler.config.details_on_click = false;
		//scheduler.init('scheduler_here',new Date(2017,2,1),"week");
		//scheduler.init('scheduler_here',"<?php echo date("Y-m-d");?>","week");

		//scheduler.init('scheduler_here',new Date(<?php echo date("Y")?>,<?php echo date("n")-1?>,<?php echo date("j")?>),"week");
		scheduler.init('scheduler_here',oDate,"week");
		
		scheduler.attachEvent("onClick", function (id, e){
			//any custom logic here
			
			var event = scheduler.getEvent(id);
  			//alert(event.text);
  				
				/*dhtmlx.alert({
					title:"Entrega de Vehiculo Programada",
					type:"alert",
					text: event.details,
					callback: function(result){
						
					}
				});
				*/
				
				tb_show(this.title,'formularios/EntregaVentaVehiculo/DiaEntregaVentaVehiculoAtender.php?EvvId='+event.subid+'&Dia=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=890&modal=false',this.rel);		



			return true;
  		});
  
//		function block_readonly(id){
//			if (!id) return true;
//			return !this.getEvent(id).readonly;
//		}
//		scheduler.attachEvent("onClick",block_readonly)
		
//		scheduler.locale.labels.dhx_cal_today_button = "Hoy";
		//allow edit operations only for own events
	//	function allow_own(id){
			
		//	alert(":3");
			//var ev = this.getEvent(id);
			//return ev.userId == 1;
		//}
		
		//scheduler.attachEvent("onDblClick",allow_own);
		//scheduler.load("formularios/EntregaVentaVehiculo/data/events.xml");
		scheduler.load("formularios/EntregaVentaVehiculo/data/entregas.php?Personal="+oPersonal+"&PersonalMecanico="+oPersonalMecanico+"&Sucursal="+oSucursal);
		//scheduler.load("formularios/EntregaVentaVehiculo/data/citas.php");
		
		//scheduler.showLightbox("2");
		
	}
	
	function show_minical(){
		if (scheduler.isCalendarVisible())
			scheduler.destroyCalendar();
		else
			scheduler.renderCalendar({
				position:"dhx_minical_icon",
				date:scheduler._date,
				navigation:true,
				handler:function(date,calendar){
					scheduler.setCurrentView(date);
					scheduler.destroyCalendar()
				}
			});
	}
	
/*
//Desactivando tecla ENTER
*/

/*
//Configuracion carga de datos y animacion
*/
$(document).ready(function (){

//alert(new Date(2017,2,1));

//	$('#CmpProductoCodigoOriginal').focus();
	var PersonalMecanico = $("#CmpPersonalMecanico").val();
	var Personal = $("#CmpPersonal").val();
	var Sucursal = $("#CmpSucursal").val();
	var FechaHoy = new Date(<?php echo date("Y")?>,<?php echo date("n")-1?>,<?php echo date("j")?>);
	
	init(Personal,PersonalMecanico,Sucursal,FechaHoy);
	//init();
		
});

/*
Configuracion Formulario
*/

</script>

<div class="EstCapMenu">
<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>

</div>


<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">VER CALENDARIO DE ENTREGA DE VEHICULOS</span></td>
  <td width="2%"><a href="formularios/Reporte/inf/InfProductoConsulta.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center"><table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Filtro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Sucursal:</td>
                <td><select  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                  <option value="">Escoja una opcion</option>
                  <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                  <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                  <?php
    }
    ?>
                </select></td>
                <td>Asesor</td>
                <td><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                  <option value="">Escoja una opcion</option>
                  <?php
					foreach($ArrAsesores as $DatAsesor){
					?>
                  <option <?php echo ($DatAsesor->PerId==$POST_Personal)?'selected="selected"':'';?>  value="<?php echo $DatAsesor->PerId;?>"><?php echo $DatAsesor->PerNombre ?> <?php echo $DatAsesor->PerApellidoPaterno; ?> <?php echo $DatAsesor->PerApellidoMaterno; ?></option>
                  <?php
					}
					?>
                </select></td>
                <td>Tecnico:</td>
                <td><select  class="EstFormularioCombo" name="CmpPersonalMecanico" id="CmpPersonalMecanico" <?php echo (!empty($GET_Personal)?'disabled="disabled"':'');?>  >
                  <option value="">Escoja una opcion</option>
                  <?php
					foreach($ArrTecnicos as $DatTecnico){
					?>
                  <option <?php echo ($DatTecnico->PerId==$GET_Personal)?'selected="selected"':'';?>  value="<?php echo $DatTecnico->PerId;?>"><?php echo $DatTecnico->PerNombre ?> <?php echo $DatTecnico->PerApellidoPaterno; ?> <?php echo $DatTecnico->PerApellidoMaterno; ?></option>
                  <?php
					}
					?>
                </select></td>
              </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
           </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver"  />           </td>
                </tr>
              </table>          </td>
        </tr>
        </table></td>
</tr>
<tr>
  <td colspan="2" align="center">
    
    
 
    
    
    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:600px;'>
      <div class="dhx_cal_navline">
        <div class="dhx_cal_prev_button">&nbsp;</div>
        <div class="dhx_cal_next_button">&nbsp;</div>
        <div class="dhx_cal_today_button"></div>
        <div class="dhx_cal_date"></div>
        <div class="dhx_minical_icon" id="dhx_minical_icon" onClick="show_minical()">&nbsp;</div>
        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
        </div>
      <div class="dhx_cal_header">
        </div>
      <div class="dhx_cal_data">
        </div>
      </div>
      
      <div class="CapEventos">
      	<div class="CapEventosFila">
        <div class="CapEventoEtiqueta">
        Leyenda:
        </div>
          <div class="CapEventoTipo1">
          Pendiente
          </div>
            <div class="CapEventoTipo2">
            Realizado
          </div>
          
           <div class="CapEventoTipo3">
            Anulado
          </div>
          </div>
      </div>
    </td>
</tr>
</table>
</div>



<script type="text/javascript">
<!--
//-->

//Calendar.setup({ 
//	inputField : "CmpFechaInicio",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaInicio"// el id del botón que  
//	});
//	
//	
//	
//Calendar.setup({ 
//	inputField : "CmpFechaFin",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaFin"// el id del botón que  
//	});
</script>





<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

