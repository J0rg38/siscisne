
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss("Default");?>CssDefault.css');
</style>


<script type="text/javascript">
	$(function(){
	
	});
</script>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
//var ArticuloValidarStock = "1,2";
var ArticuloTipo = "1,2"; 

var Formulario = "FrmEditar";

var FacturaDetalleEditar = 1;
var FacturaDetalleEliminar = 1;

var FacturaAlmacenMovimientoEliminar = 1;

$().ready(function() {
/*
Configuracion carga de datos y animacion
*/	
/*s
$.ajax({
		type: 'POST',
		url: 'formularios/TipoCambio/acc/AccTipoCambioActualizar.php',
		data: '',
		success: function(respuesta){

			//$('#CapTipoCambio').html("");
//alert(respuesta);
			if(respuesta == 2){
				alert("No se ha encontrado el tipo de cambio del dia, se recomienda que registre uno, MENU FINANZAS -> TIPO DE CAMBIO -> TIPO DE CAMBIO COMERCIAL");				
			}else if(respuesta == 1){
//			}else if(respuesta == 1 || respuesta == 3 || respuesta == 4){
				//$.ajax({
//					type: 'POST',
//					url: 'menus/MenTipoCambio.php',
//					data: '',
//					success: function(html){
//						$('#CapTipoCambio').html(html);
//					}
//				});
								
			}
		}
	});
	*/
	
});

</script>

 <div class="EstCapContenido">
   <table width="100%" border="0" cellpadding="0" cellspacing="2" class="EstPrincipalTabla">
     <tr>
       <td colspan="3" align="center">&nbsp;</td>
     </tr>
     <tr>
      <td colspan="3" align="center" valign="top">
      <span class="EstFormularioTitulo">INICIO</span>
      </td>
    </tr>
    <tr>
      <td width="8%" align="left" valign="top">&nbsp;</td>
      <td width="87%" align="left" valign="top"><div class="EstMenuGrande">
        <?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"OrdenVentaVehiculo","Listado")){
?>
        <div class="EstBotonPrincipal">
        <a class="EstMenuGrandeLink" href="principalC.php?Mod=OrdenVentaVehiculo&Form=Listado"><img src="imagenes/principal/vehiculos.png" alt="[Orden de Venta de Vehiculo]" title="Orden de Venta de Vehiculo" border="0" align="absmiddle" width="40" height="40" /> Ordenes de Venta de Vehiculo</a>
       </div>
<?php
}
?>
        <?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaIngreso","Registrar")){
?>
        <div class="EstBotonPrincipal">
        <a class="EstMenuGrandeLink" href="principalC.php?Mod=FichaIngreso&amp;Form=Registrar"><img src="imagenes/nicono/orden_trabajo.png" alt="[Ord. de Trabajo]" title="Ord. de Trabajo" border="0" align="absmiddle" width="40" height="40" /> Ord. de Trabajo</a>
        </div>
        <?php
}
?>
        <?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoRecepcion","Registrar")){
?>
        <div class="EstBotonPrincipal">
        <a class="EstMenuGrandeLink" href="principalC.php?Mod=VehiculoRecepcion&amp;Form=Registrar"><img src="imagenes/nicono/recepcion_vehicular.png" alt="[Recepcion Vehicular]" title="Recepcion Vehicular" border="0" align="absmiddle" width="40" height="40" /> Recepcion Vehicular</a>
        </div>
        <?php
}
?>
        <?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"VehiculoIngreso","Listado")){
?>
         <div class="EstBotonPrincipal">
        <a class="EstMenuGrandeLink" href="principalC.php?Mod=VehiculoIngreso&amp;Form=Listado"><img src="imagenes/nicono/vehiculos.png" alt="[Vehiculos]" title="Vehiculos" border="0" align="absmiddle" width="40" height="40" /> Vehiculos</a>
        </div>
        
        <?php
}
?>
      </div></td>
      <td width="5%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center" valign="top">&nbsp;</td>
    </tr>
  </table>

</div>