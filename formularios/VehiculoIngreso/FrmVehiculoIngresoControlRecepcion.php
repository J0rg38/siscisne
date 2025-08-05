<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoControlRecepcion.js"></script>


<?php

$POST_Sucursal = $_SESSION['SesionSucursal'];

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');


$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();
$InsVehiculoMarca = new ClsVehiculoMarca();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL,"VEN");
$ArrSucursales = $RepSucursal['Datos'];
$InsSucursal = new ClsSucursal();

// MtdObtenerVehiculoMarcas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VmaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVigenciaVenta=NULL,$oEstado=NULL)
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1,NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];


?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

$(document).ready(function() {
/*
Configuracion carga de datos y animacion
*/	
	
	FncVehiculoIngresoControlRecepcionCargarListado();
	
	
});

</script>
<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">CONTROL DE RECEPCION DE VEHICULOS</span></td>
  <td width="2%"><a href="formularios/VehiculoIngreso/inf/InfVehiculoIngresoControlRecepcion.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
  
  
    </td>
</tr>
<tr>
  <td colspan="2" align="center">


  
		
<ul class="tabs">

<li><a href="#tab1">Unidades Vehiculares</a></li> 
 
</ul>

<div class="tab_container">

    
    <div id="tab1" class="tab_content">
        <!--Content-->
               <!--<h3> Entregas: </h3>-->
               
         Año:
		<select class="EstFormularioCombo" name="CmpAno" id="CmpAno">
                    <?php
				for($i=2016;$i<=date("Y");$i++){
				?>
                    <option <?php echo ($i==date("Y")?'selected="selected"':'')?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php	
				}
				?>
                    </select>
             
             Mes:       
                    
              <select class="EstFormularioCombo" name="CmpMes" id="CmpMes">
                  <option <?php echo ((date("m")=="01")?'selected="selected"':'');?>  value="01">Enero</option>
                  <option <?php echo ((date("m")=="02")?'selected="selected"':'');?>  value="02">Febrero</option>
                  <option <?php echo ((date("m")=="03")?'selected="selected"':'');?>  value="03">Marzo</option>
                  <option <?php echo ((date("m")=="04")?'selected="selected"':'');?>  value="04">Abril</option>
                  <option <?php echo ((date("m")=="05")?'selected="selected"':'');?>  value="05">Mayo</option>
                  <option <?php echo ((date("m")=="06")?'selected="selected"':'');?>  value="06">Junio</option>
                  <option <?php echo ((date("m")=="07")?'selected="selected"':'');?>  value="07">Julio</option>
                  <option <?php echo ((date("m")=="08")?'selected="selected"':'');?>  value="08">Agosto</option>
                  <option <?php echo ((date("m")=="09")?'selected="selected"':'');?>  value="09">Setiembre</option>
                  <option <?php echo ((date("m")=="10")?'selected="selected"':'');?>  value="10">Octubre</option>
                  <option <?php echo ((date("m")=="11")?'selected="selected"':'');?>  value="11">Noviembre</option>
                  <option <?php echo ((date("m")=="12")?'selected="selected"':'');?>  value="12">Diciembre</option>
                </select>
                    
                    VIN:
                    
                    <input name="CmpBuscarVIN" type="text" class="EstFormularioCaja" id="CmpBuscarVIN" placeholder="Ingresa un numero de vin" size="25" maxlength="45"/>
                   
                    <input class="EstFormularioBoton" type="button" name="BtnFiltrarEntrega" id="BtnFiltrarEntrega" value="Filtrar" />
                     <input class="EstFormularioBoton" type="button" name="BtnLimpiar" id="BtnLimpiar" value="Limpiar" />
                    
        <div class="EstFormularioCapaListado" id="CapVehiculoIngresoControlRecepcion"></div>
        
        
        </div>

        </div>


<!--</div>-->   
  </td>
</tr>
</table>
</div>

<script type="text/javascript"> 
//	Calendar.setup({ 
//	inputField : "CmpFechaInicio",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaInicio"// el id del bot&oacute;n que  
//	}); 	
//	
//	Calendar.setup({ 
//	inputField : "CmpFechaFin",  // id del campo de texto 
//	ifFormat   : "%d/%m/%Y",  //  
//	button     : "BtnFechaFin"// el id del bot&oacute;n que  
//	}); 
</script>



<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

