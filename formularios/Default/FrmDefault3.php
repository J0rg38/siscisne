
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
	
	
});

</script>

 <div class="EstCapContenido">
   <table width="100%" border="0" cellpadding="0" cellspacing="2" class="EstPrincipalTabla">
     <tr>
       <td align="center">&nbsp;</td>
     </tr>
     <tr>
      <td valign="top" align="center">
      <span class="EstFormularioTitulo">RECEPCION</span>
      </td>
    </tr>
    <tr>
      <td valign="top" align="center">

      
      <div class="EstMenuGrande">
      
		<a class="EstMenuGrandeLink" href="principal3.php?Mod=VehiculoRecepcion&amp;Form=Registrar"><img src="imagenes/nicono/recepcion_vehicular.png" alt="[Recepcion Vehicular]" title="Recepcion Vehicular" border="0" align="absmiddle" width="40" height="40" /> Recepcion Vehicular</a> 
      
      </div>
      


      </td>
    </tr>
    <tr>
      <td valign="top" align="center">&nbsp;</td>
    </tr>
  </table>

</div>