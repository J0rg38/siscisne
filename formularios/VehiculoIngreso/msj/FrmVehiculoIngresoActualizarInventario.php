<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioGenerarExcel = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"GenerarExcel"))?true:false;?>
<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoActualizarInventario.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoActualizarEntrega.js"></script>
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
		$('input[type=checkbox]').each(function () {

			if($(this).attr('etiqueta')=="sucursal"){
				//FncVehiculoIngresoActualizarInventarioCargar($(this).val(),1);
				var Id = $(this).val();
				//console.log(Id);
				FncVehiculoIngresoActualizarInventarioCargarListadov2(Id);

			}			 
	
		});


	FncVehiculoIngresoActualizarInventarioOtrosCargarListado("OTRO");
	
	FncVehiculoIngresoActualizarEntregaCargarListadov2("ENTREGA");
	
});

</script>
<div class="EstCapContenido">
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">ACTUALIZAR INVENTARIO DE VEHICULOS</span></td>
  <td width="2%"><a href="formularios/VehiculoIngreso/inf/InfVehiculoIngresoActualizarInventario.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
    <!--<form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Cliente/IfrVehiculoIngresoActualizarInventario.php" target="IfrVehiculoIngresoActualizarInventario" method="post" name="FrmVehiculoIngresoActualizarInventario" id="FrmVehiculoIngresoActualizarInventario">
      -->
<!--<form enctype="multipart/form-data" action="#" method="post" name="FrmVehiculoIngresoActualizarInventario" id="FrmVehiculoIngresoActualizarInventario"  onsubmit="return false">
            
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de Filtrado</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td class="EstFormulario">Sucursal:</td>
                <td colspan="3" class="EstFormulario"><select <?php echo ((!$PrivilegioMultisucursal)?'disabled="disabled"':'');?>  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                  <option value="">Escoja una opcion</option>
                  <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                  <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                  <?php
    }
    ?>
                </select></td>
                <td>Marca:</td>
                <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca">
                  <option value="">Escoja una opcion</option>
                  <?php
				foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
								?>
                  <option value="<?php echo $DatVehiculoMarca->VmaId;?>"><?php echo $DatVehiculoMarca->VmaNombre;?></option>
                  <?php	
				}
				?>
                </select></td>
                <td>&nbsp;</td>
                </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" onclick="FncVehiculoIngresoActualizarInventarioCargarListado();" />           </td>
                <td>
                  <?php
           /* if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncVehiculoIngresoActualizarInventarioImprimir('');" />           
                  <?php	  
            }*/
            ?>                  </td>
                <td>
                  
                  <?php
           /* if($PrivilegioGenerarExcel){
            ?>
                  <input name="BtnExcel"   id="BtnExcel" type="image" border="0" src="imagenes/reporte_iconos/excel.png" alt="[GExcel]" title="Generar Excel" onclick="FncVehiculoIngresoActualizarInventarioGenerarExcel('');" />           
                  <?php	  
            }*/
            ?>                  </td>
                </tr>
            </table>          </td>
        </tr>
          </table>
      </form> -->   </td>
</tr>
<tr>
  <td colspan="2" align="center">
<!--
<div style="flex:1;overflow: auto;">-->
<!--<iframe class="autoHeight"  src="<?php echo $InsProyecto->MtdRutFormularios();?>Cliente/IfrVehiculoIngresoActualizarInventario.php" target="IfrVehiculoIngresoActualizarInventario" id="IfrVehiculoIngresoActualizarInventario" name="IfrVehiculoIngresoActualizarInventario" scrolling="auto"  frameborder="0"  height="420" width="100%" onload='javascript:resizeIframe(this);'></iframe>
  
  -->
  
  
<!--  <div class="EstFormularioCapaListado" id="CapVehiculoIngresoActualizarInventario"></div>
  
  -->
  
  
		
<ul class="tabs">
<?php
$tab=1;
foreach($ArrSucursales as $DatSucursal){
?>

<li><a href="#tab<?php echo $tab;?>"><?php echo $DatSucursal->SucEtiqueta;?></a></li>
<?php	
$tab++;
}
?>
<li><a href="#tab<?php echo $tab+1;?>">Otros</a></li> 
<li><a href="#tab<?php echo $tab+2;?>">Entregas</a></li>   
</ul>

<div class="tab_container">


  <?php
$tab=1;
foreach($ArrSucursales as $DatSucursal){
?>
 <div id="tab<?php echo $tab;?>" class="tab_content">
        <!--Content-->
     <!--  <h3> Sucursal: <?php echo $DatSucursal->SucNombre;?></h3>
-->
<input style="visibility:hidden;" etiqueta="sucursal" type="checkbox" name="ChkSucursal_<?php echo $DatSucursal->SucId;?>" id="ChkSucursal_<?php echo $DatSucursal->SucId;?>" value="<?php echo $DatSucursal->SucId;?>" />


<input type="hidden" value="<?php echo $DatSucursal->SucId;?>" name="CmpSucursalId_<?php echo $DatSucursal->SucId?>" id="CmpSucursalId_<?php echo $DatSucursal->SucId;?>" />
        
        VIN:
                    
                    <input name="CmpBuscarVIN_<?php echo $DatSucursal->SucId;?>" type="text" class="EstFormularioCaja" id="CmpBuscarVIN_<?php echo $DatSucursal->SucId;?>" placeholder="Ingresa un numero de vin" size="25" maxlength="45"/>
                    <input class="EstFormularioBoton" type="button" name="BtnFiltrar_<?php echo $DatSucursal->SucId;?>" id="BtnFiltrar_<?php echo $DatSucursal->SucId;?>" value="Filtrar" />
                    
                    
                    
        <div class="EstFormularioCapaListado" id="CapVehiculoIngresoActualizarInventario_<?php echo $DatSucursal->SucId;?>"></div>
        
        
        
        </div>
<?php	
$tab++;
}
?> 
    
    <div id="tab<?php echo $tab+1;?>" class="tab_content">
    
       <input name="CmpBuscarVIN_OTROS" type="text" class="EstFormularioCaja" id="CmpBuscarVIN_OTROS" placeholder="Ingresa un numero de vin" size="25" maxlength="45"/>
                    <input class="EstFormularioBoton" type="button" name="BtnFiltrarEntrega_OTROS" id="BtnFiltrarEntrega_OTROS" value="Filtrar" />
                    
                    
     <div class="EstFormularioCapaListado" id="CapVehiculoIngresoActualizarInventarioOtro_OTRO"></div>
     
    </div>
    
    <div id="tab<?php echo $tab+2;?>" class="tab_content">
        <!--Content-->
               <!--<h3> Entregas: </h3>-->
               
         Año:
		<select class="EstFormularioCombo" name="CmpAno_ENTREGA" id="CmpAno_ENTREGA">
                    <?php
				for($i=2016;$i<=date("Y");$i++){
				?>
                    <option <?php echo ($i==date("Y")?'selected="selected"':'')?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php	
				}
				?>
                    </select>
             
             Mes:       
                    
              <select class="EstFormularioCombo" name="CmpMes_ENTREGA" id="CmpMes_ENTREGA">
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
                    
                    <input name="CmpBuscarVIN_ENTREGA" type="text" class="EstFormularioCaja" id="CmpBuscarVIN_ENTREGA" placeholder="Ingresa un numero de vin" size="25" maxlength="45"/>
                    <input class="EstFormularioBoton" type="button" name="BtnFiltrarEntrega_ENTREGA" id="BtnFiltrarEntrega_ENTREGA" value="Filtrar Entregas" />
                    
        <div class="EstFormularioCapaListado" id="CapVehiculoIngresoActualizarEntrega_ENTREGA"></div>
        
        
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

