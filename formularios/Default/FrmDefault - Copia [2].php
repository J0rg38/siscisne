
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

//$.ajax({
//		type: 'POST',
//		url: 'formularios/TipoCambio/acc/AccTipoCambioActualizar.php',
//		data: '',
//		success: function(respuesta){
//
//			//$('#CapTipoCambio').html("");
////alert(respuesta);
//			if(respuesta == 2){
//				alert("No se ha encontrado el tipo de cambio del dia, se recomienda que registre uno, MENU FINANZAS -> TIPO DE CAMBIO -> TIPO DE CAMBIO COMERCIAL");				
//			}else if(respuesta == 1){
////			}else if(respuesta == 1 || respuesta == 3 || respuesta == 4){
//				//$.ajax({
////					type: 'POST',
////					url: 'menus/MenTipoCambio.php',
////					data: '',
////					success: function(html){
////						$('#CapTipoCambio').html(html);
////					}
////				});
//								
//			}
//		}
//	});
	
	
});

</script>

 <div class="EstCapContenido">
 
 
 <?php
 
 ?>
   <table border="0" cellpadding="0" cellspacing="2" class="EstPrincipalTabla">
     <tr>
       <td colspan="3" align="center">&nbsp;</td>
     </tr>
     <tr>
      <td colspan="3" valign="top" align="center">
      <span class="EstFormularioTitulo">INICIO</span>
      </td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center">

      
      <div class="EstMenuGrande">
      
		<a class="EstMenuGrandeLink" href="principal.php?Mod=FichaIngreso&amp;Form=Registrar"><img src="imagenes/nicono/orden_trabajo_registrar.png" alt="[Registrar]" title="Registrar" border="0" align="absmiddle" width="40" height="40" /> Registrar O.T.</a> 
      
        | 
        
        
		<a class="EstMenuGrandeLink"  href="principal.php?Mod=PreEntrega&amp;Form=Registrar">
        <img src="imagenes/nicono/pre_entrega_registrar.png" alt="[Pre-Entrega]" title="Pre-Entrega" border="0" align="absmiddle" width="40" height="40" /> Registrar PDS</a> 
      
      
          
      | <a class="EstMenuGrandeLink"  href="principal.php?Mod=FichaIngreso&amp;Form=Listado"><img src="imagenes/nicono/orden_trabajo.png" alt="[Listar]" title="Listar" border="0" align="absmiddle" width="40" height="40" /> Ordenes de Trabajo</a> 
      
      
      
      


      
      
      
      
      
      | <a class="EstMenuGrandeLink"  href="principal.php?Mod=TrabajoTerminado&amp;Form=Listado"><img src="imagenes/nicono/orden_trabajo_terminado.png" alt="[Listado de Ord. Trabaj. Terminadas]" title="Listar" border="0" align="absmiddle" width="40" height="40" />  O.T. Terminadas</a> 
      
      | <a class="EstMenuGrandeLink"  href="principal.php?Mod=FichaIngreso&amp;Form=Seguimiento"><img src="imagenes/nicono/seguimiento.png" alt="[Seguimiento]" title="Seguimiento" border="0" align="absmiddle" width="40" height="40" /> Seguimiento de O.T.</a>
      
      | <a class="EstMenuGrandeLink"  href="principal.php?Mod=VehiculoIngreso&Form=Listado"><img src="imagenes/nicono/vehiculos.png" alt="[Ingreso de Vehiculos]" title="Listar Ingreso de Vehiculos" border="0" align="absmiddle" width="40" height="40" /> Vehiculos Ingresados</a>
      
       |
       
       <a class="EstMenuGrandeLink"  href="principal.php?Mod=PlanMantenimientoPresupuesto&Form=Consulta">
       <img src="imagenes/nicono/consulta.png" alt="[ Consulta Presupuesto/Plan Mant.]" title=" Consulta Presupuesto/Plan Mant." border="0" align="absmiddle" width="40" height="40" /> 
       Consulta Plan Mant.</a>
       
        |
        <a class="EstMenuGrandeLink"  href="principal.php?Mod=VehiculoIngreso&Form=Consulta"><img src="imagenes/nicono/vin.png" alt="[Consulta de VIN]" title="Consulta de VIN" border="0" align="absmiddle" width="40" height="40" /> 
        Consulta VIN/Placa</a>
        
        
         |
         
        <a class="EstMenuGrandeLink"  href="principal.php?Mod=Cita&Form=VerCalendario" ><img src="imagenes/nicono/calendario.png" alt="[Calendario Citas]" title="Calendario Citas" border="0" align="absmiddle" width="40" height="40" /> 
        Calendario Citas
        
        
        </a>
      </div>
      


      </td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center"><span class="EstFormularioTitulo">TALLER</span></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center">
      
	<div class="EstMenuGrande">
	 <a class="EstMenuGrandeLink"  href="principal.php?Mod=FichaAccion&Form=Listado"> <img src="imagenes/nicono/orden_trabajo_taller.png" alt="[Ordenes de Trabajo]" title="Ordenes de Trabajo" border="0" align="absmiddle" width="40" height="40" />   Ord. Trabaj. en Taller</a>
	
     | <a class="EstMenuGrandeLink"  href="principal.php?Mod=PlanMantenimiento&Form=Listado"> <img src="imagenes/nicono/plan_mantenimiento.png" alt="Planes de Mantenimiento" title="Planes de Mantenimiento" border="0" align="absbottom" width="40" height="40" /> Planes de Mantenimiento</a>
      |
      <a class="EstMenuGrandeLink"  href="principal.php?Mod=Campana&Form=Listado"> <img src="imagenes/nicono/campanas.png" alt="[Campañas]" title="Campañas" border="0" align="absmiddle" width="40" height="40" /> Campañas</a> |
    <a class="EstMenuGrandeLink"  href="principal.php?Mod=Campana&Form=VerificarVehiculo"><img src="imagenes/nicono/consulta.png" alt="[Seguimiento]" title="Seguimiento" border="0" align="absmiddle" width="40" height="40" /> Verificar Vehiculo en Campaña</a>
    </div>       
                    
      </td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center"><span class="EstFormularioTitulo">ALMACEN</span></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center"><div class="EstMenuGrande">
      
      
      <a class="EstMenuGrandeLink"  href="principal.php?Mod=CotizacionProducto&Form=Listado"> <img src="imagenes/nicono/cotizacion_repuesto.png" alt="[Cotizaciones]" title="Cotizaciones" border="0" align="absmiddle" width="40" height="40" /> Cotizaciones de Repuesto</a>
      
      
      
      <a class="EstMenuGrandeLink"  href="principal.php?Mod=TallerPedido&amp;Form=Listado"> <img src="imagenes/nicono/taller_pedido.png" alt="[Pedidos de Taller]" title="Pedidos de Taller" border="0" align="absmiddle" width="40" height="40" /> Pedidos de Taller</a> 
      
      
      	| <a class="EstMenuGrandeLink"  href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Listado">
			<img src="imagenes/nicono/movimientos.png" alt="[Movimientos]" title="Listar Movimientos" border="0" align="absmiddle" width="40" height="40" /> Mov. de Entrada</a>
            
            
              | <a class="EstMenuGrandeLink"  href="principal.php?Mod=AlmacenMovimientoSalida&Form=Listado">
        <img src="imagenes/nicono/movimientos.png" alt="[Movimientos]" title="Listar Movimientos" border="0" align="absmiddle" width="40" height="40" /> Fichas de Salida     
        </a>
            
            
        | <a class="EstMenuGrandeLink"  href="principal.php?Mod=Kardex&Form=Ver"><img src="imagenes/nicono/kardex.png" alt="[Kardex]" title="Ver Kardex" border="0" align="absmiddle" width="40" height="40" /> Kardex</a>
            
			| <a class="EstMenuGrandeLink"  href="principal.php?Mod=AlmacenStock&Form=Listado"><img src="imagenes/nicono/almacen.png" alt="[Stock]" title="Listar Stock" border="0" align="absmiddle" width="40" height="40" /> Stock</a>
            
            
                 
      </div></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center"><span class="EstFormularioTitulo">OTROS</span></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center"><div class="EstMenuGrande"> 
      
       <a class="EstMenuGrandeLink"  href="principal.php?Mod=VehiculoMarca&Form=Familia" >
                    <img src="imagenes/nicono/marcas.png" alt="[Familia de Marcas de Vehiculo]" title="Familia de Marcas de Vehiculo" border="0" align="absmiddle" width="40" height="40" /> Familia de Marcas
                    </a>
                    
                    
                    | <a class="EstMenuGrandeLink"  href="principal.php?Mod=Cliente&Form=Listado">
			<img src="imagenes/nicono/clientes.png" alt="[Clientes]" title="Listar Clientes" border="0" align="absmiddle" width="40" height="40" /> Clientes</a>
            
			| <a class="EstMenuGrandeLink"  href="principal.php?Mod=Proveedor&Form=Listado">
	  <img src="imagenes/nicono/proveedores.png" alt="[Proveedores]" title="Listar Proveedores" border="0" align="absmiddle" width="40" height="40" /> Proveedores</a></div></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center"><span class="EstFormularioTitulo">CHAT Y COLABORACION</span></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center">
      <div class="EstMenuGrande"> 
       <a class="EstMenuGrandeLink" target="_blank"  href="https://app.hibox.co/rooms#org=39717">
        <img src="imagenes/principal/hibox.png" alt="[HiBox]" title="HiBox" border="0" align="absmiddle" width="40" height="40" />
    HiBox</a>
      </div>
      
      </td>
    </tr>
    <tr>
      <td colspan="3" valign="top" align="center">&nbsp;</td>
    </tr>
  </table>

</div>