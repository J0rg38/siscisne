
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsDefault.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss("Default");?>CssDefault2.css');
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
	


	var notificacion = "";
			
	notificacion += '<br>';					
	notificacion += j[i].NfnDescripcion+ '';
	notificacion += '<br>';
	notificacion += '<a id="'+j[i].NfnId+'" href="'+j[i].NfnEnlace+'&NfnId='+j[i].NfnId +'">'+j[i].NfnEnlaceNombre+'</a>';				

	dhtmlx.message({ type:"info", text:""+notificacion+"",expire: -3 });
	
		
});


var MostrarPanelCallCenter = "Si";
var MostrarPanelAlmacen = "Si";
var MostrarPanelTaller = "Si";
var MostrarPanelPlaneamiento = "Si";
var MostrarPanelPostVenta = "Si";
var MostrarPanelCaja = "Si";

</script>

  
      
 <div class="EstCapContenido">
 
 
 <?php
 
 ?>

  <div style="text-align: center">
    <span class="EstFormularioTitulo">INICIO</span>
  </div><br>

  <div style="text-align: center;">
            <a 
            href="principal.php?Mod=FichaIngreso&amp;Form=Registrar"
            style="
              background: linear-gradient(to right, #EBBF0C, #FEEC6C);
              text-decoration: none;
              color:  #4F4E4B;
              padding: 5px 15px 5px 15px;
              border: none;
              border-radius: 15px;
              margin: 10px;
            "   
          >
            Registrar OT
          </a>
        
            <a 
              href="principal.php?Mod=PreEntrega&amp;Form=Registrar"
              style="
                background: linear-gradient(to right, #EBBF0C, #FEEC6C);
                text-decoration: none;
                color:  #4F4E4B;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin: 10px;
              "   
            >
              Registrar PDS
            </a>
      
            <a 
              href="principal.php?Mod=FichaIngreso&amp;Form=Listado"
              style="
                background: linear-gradient(to right, #375DDC, #7D70FE);
                text-decoration: none;
                color:  #ffffff;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin: 10px;
              "   
            >
              Ordenes de Trabajo
            </a>

            <a 
              href="principal.php?Mod=TrabajoTerminado&amp;Form=Listado"
              style="
                background: linear-gradient(to right, #375DDC, #7D70FE);
                text-decoration: none;
                color:  #ffffff;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin: 10px;
              "   
            >
              O.T. Terminadas
            </a>

            <a 
              href="principal.php?Mod=FichaIngreso&amp;Form=Seguimiento"
              style="
                background: linear-gradient(to right, #1FBD1F, #4CEA79);
                text-decoration: none;
                color:  #616161;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin: 10px;
              "   
            >
              Seguimiento de O.T.
            </a>


            <a 
              href="principal.php?Mod=VehiculoIngreso&Form=Listado"
              style="
                background: linear-gradient(to right, #375DDC, #7D70FE);
                text-decoration: none;
                color:  #ffffff;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin: 10px;
              "   
            >
              Vehiculos Ingresados
            </a>

  </div><br>
  <div style="text-align: center;">
                  <a 
              href="principal.php?Mod=PlanMantenimientoPresupuesto&Form=Consulta"
              style="
                background: linear-gradient(to right, #1FBD1F, #4CEA79);
                text-decoration: none;
                color:  #616161;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin: 10px;
              "   
            >
              Consulta Plan Mant
            </a>

            <a 
              href="principal.php?Mod=VehiculoIngreso&Form=Consulta"
              style="
                background: linear-gradient(to right, #1FBD1F, #4CEA79);
                text-decoration: none;
                color:  #616161;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin: 10px;
              "   
            >
              Consulta VIN/Placa
            </a>

            <a 
              href="principal.php?Mod=Cita&Form=VerCalendario" 
              style="
                background: linear-gradient(to right, #1FBD1F, #4CEA79);
                text-decoration: none;
                color:  #616161;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin: 10px;
              "   
            >
              Calendario Citas
            </a>
  </div><br><br>

  <div style="text-align: center">
    <span class="EstFormularioTitulo">TALLER</span>
  </div><br>

  <div style="text-align: center">
    <a 
      href="principal.php?Mod=FichaAccion&Form=Listado"
      style="
        background: linear-gradient(to right, #375DDC, #7D70FE);
        text-decoration: none;
        color:  #ffffff;
        padding: 5px 15px 5px 15px;
        border: none;
        border-radius: 15px;
        margin: 10px;
      "   
    >
      Ord. Trabaj. en Taller
    </a>

     <a 
      href="principal.php?Mod=PlanMantenimiento&Form=Listado"
      style="
        background: linear-gradient(to right, #375DDC, #7D70FE);
        text-decoration: none;
        color:  #ffffff;
        padding: 5px 15px 5px 15px;
        border: none;
        border-radius: 15px;
        margin: 10px;
      "   
    >
      Planes de Mantenimiento
    </a>

      <a 
        href="principal.php?Mod=Campana&Form=Listado"
        style="
          background: linear-gradient(to right, #375DDC, #7D70FE);
          text-decoration: none;
          color:  #ffffff;
          padding: 5px 15px 5px 15px;
          border: none;
          border-radius: 15px;
          margin: 10px;
        "   
      >
        Campañas
      </a>

      <a 
        href="principal.php?Mod=Campana&Form=VerificarVehiculo" 
        style="
          background: linear-gradient(to right, #1FBD1F, #4CEA79);
          text-decoration: none;
          color:  #616161;
          padding: 5px 15px 5px 15px;
          border: none;
          border-radius: 15px;
          margin: 10px;
        "   
      >
        Verificar Vehiculo en Campaña
      </a>
  </div><br><br>

  <div style="text-align: center;">
    <span class="EstFormularioTitulo">ALMACEN</span>
  </div><br>

  <div style="text-align: center;">
    <a 
        href="principal.php?Mod=CotizacionProducto&Form=Listado"
        style="
          background: linear-gradient(to right, #375DDC, #7D70FE);
          text-decoration: none;
          color:  #ffffff;
          padding: 5px 15px 5px 15px;
          border: none;
          border-radius: 15px;
          margin: 10px;
        "   
    >
      Cotizaciones de Repuesto
    </a>
      
    <a 
        href="principal.php?Mod=TallerPedido&amp;Form=Listado"
        style="
          background: linear-gradient(to right, #375DDC, #7D70FE);
          text-decoration: none;
          color:  #ffffff;
          padding: 5px 15px 5px 15px;
          border: none;
          border-radius: 15px;
          margin: 10px;
        "   
    >
      Pedidos de Taller
    </a>

    <a 
        href="principal.php?Mod=AlmacenMovimientoEntrada&Form=Listado"
        style="
          background: linear-gradient(to right, #375DDC, #7D70FE);
          text-decoration: none;
          color:  #ffffff;
          padding: 5px 15px 5px 15px;
          border: none;
          border-radius: 15px;
          margin: 10px;
        "   
    >
      Mov. de Entrada
    </a>

      <a 
        href="principal.php?Mod=AlmacenMovimientoSalida&Form=Listado"
        style="
          background: linear-gradient(to right, #375DDC, #7D70FE);
          text-decoration: none;
          color:  #ffffff;
          padding: 5px 15px 5px 15px;
          border: none;
          border-radius: 15px;
          margin: 10px;
        "   
      >
        Fichas de Salida
      </a>

      <a 
        href="principal.php?Mod=Kardex&Form=Ver"
        style="
          background: linear-gradient(to right, #375DDC, #7D70FE);
          text-decoration: none;
          color:  #ffffff;
          padding: 5px 15px 5px 15px;
          border: none;
          border-radius: 15px;
          margin: 10px;
        "   
      >
        Kardex
      </a>

     <a 
        href="principal.php?Mod=AlmacenStock&Form=Listado"
        style="
          background: linear-gradient(to right, #375DDC, #7D70FE);
          text-decoration: none;
          color:  #ffffff;
          padding: 5px 15px 5px 15px;
          border: none;
          border-radius: 15px;
          margin: 10px;
        "   
      >
        Stock
      </a>

  </div>


   <table border="0" cellpadding="0" cellspacing="2" class="EstPrincipalTabla" style="display: none">
     <tr>
       <td colspan="3" align="center">&nbsp;</td>
     </tr>
     <tr>
      <td colspan="3" valign="top" align="center">
      <span class="EstFormularioTitulo">INICIO</span>
      </td>
    </tr>
    <tr style="height: 35px;">
      <td colspan="3" valign="top" align="center">

      
    <div class="EstMenuGrande">
      
		<!-- <a class="EstMenuGrandeLink" href="principal.php?Mod=FichaIngreso&amp;Form=Registrar"><img src="imagenes/nicono/orden_trabajo_registrar.png" alt="[Registrar]" title="Registrar" border="0" align="absmiddle" width="40" height="40" /> Registrar O.T.</a>  -->

    <a 
      href="principal.php?Mod=FichaIngreso&amp;Form=Registrar"
      style="
        background: linear-gradient(to right, #EBBF0C, #FEEC6C);
        text-decoration: none;
        color:  #4F4E4B;
        padding: 5px 15px 5px 15px;
        border: none;
        border-radius: 15px;
      "   
    >
      Registrar OT
    </a>
      
        | 
        
        
		    <!-- <a class="EstMenuGrandeLink"  href="principal.php?Mod=PreEntrega&amp;Form=Registrar">
        <img src="imagenes/nicono/pre_entrega_registrar.png" alt="[Pre-Entrega]" title="Pre-Entrega" border="0" align="absmiddle" width="40" height="40" /> Registrar PDS</a> -->

            <a 
              href="principal.php?Mod=PreEntrega&amp;Form=Registrar"
              style="
                background: linear-gradient(to right, #EBBF0C, #FEEC6C);
                text-decoration: none;
                color:  #4F4E4B;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
              "   
            >
              Registrar PDS
            </a>
      
      
          
      |<!--  <a class="EstMenuGrandeLink"  href="principal.php?Mod=FichaIngreso&amp;Form=Listado"><img src="imagenes/nicono/orden_trabajo.png" alt="[Listar]" title="Listar" border="0" align="absmiddle" width="40" height="40" /> Ordenes de Trabajo</a> --> 
      
            <a 
              href="principal.php?Mod=FichaIngreso&amp;Form=Listado"
              style="
                background: linear-gradient(to right, #375DDC, #7D70FE);
                text-decoration: none;
                color:  #ffffff;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
              "   
            >
              Ordenes de Trabajo
            </a>
      
      


      
      
      
      
      
      | <!-- <a class="EstMenuGrandeLink"  href="principal.php?Mod=TrabajoTerminado&amp;Form=Listado"><img src="imagenes/nicono/orden_trabajo_terminado.png" alt="[Listado de Ord. Trabaj. Terminadas]" title="Listar" border="0" align="absmiddle" width="40" height="40" />  O.T. Terminadas</a> -->

            <a 
              href="principal.php?Mod=TrabajoTerminado&amp;Form=Listado"
              style="
                background: linear-gradient(to right, #375DDC, #7D70FE);
                text-decoration: none;
                color:  #ffffff;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
              "   
            >
              O.T. Terminadas
            </a>
      
      | <!-- <a class="EstMenuGrandeLink"  href="principal.php?Mod=FichaIngreso&amp;Form=Seguimiento"><img src="imagenes/nicono/seguimiento.png" alt="[Seguimiento]" title="Seguimiento" border="0" align="absmiddle" width="40" height="40" /> Seguimiento de O.T.</a> -->

            <a 
              href="principal.php?Mod=FichaIngreso&amp;Form=Seguimiento"
              style="
                background: linear-gradient(to right, #1FBD1F, #4CEA79);
                text-decoration: none;
                color:  #6A6A6A;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
              "   
            >
              Seguimiento de O.T.
            </a>
      
      | <!-- <a class="EstMenuGrandeLink"  href="principal.php?Mod=VehiculoIngreso&Form=Listado"><img src="imagenes/nicono/vehiculos.png" alt="[Ingreso de Vehiculos]" title="Listar Ingreso de Vehiculos" border="0" align="absmiddle" width="40" height="40" /> Vehiculos Ingresados</a> -->

            <a 
              href="principal.php?Mod=VehiculoIngreso&Form=Listado"
              style="
                background: linear-gradient(to right, #375DDC, #7D70FE);
                text-decoration: none;
                color:  #ffffff;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
              "   
            >
              Vehiculos Ingresados
            </a>
      
       |
       
       <!-- <a class="EstMenuGrandeLink"  href="principal.php?Mod=PlanMantenimientoPresupuesto&Form=Consulta">
       <img src="imagenes/nicono/consulta.png" alt="[ Consulta Presupuesto/Plan Mant.]" title=" Consulta Presupuesto/Plan Mant." border="0" align="absmiddle" width="40" height="40" /> 
       Consulta Plan Mant.</a> -->

            <a 
              href="principal.php?Mod=PlanMantenimientoPresupuesto&Form=Consulta"
              style="
                background: linear-gradient(to right, #1FBD1F, #4CEA79);
                text-decoration: none;
                color:  #6A6A6A;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
              "   
            >
              Consulta Plan Mant
            </a>
       
        |
        <!-- <a class="EstMenuGrandeLink"  href="principal.php?Mod=VehiculoIngreso&Form=Consulta"><img src="imagenes/nicono/vin.png" alt="[Consulta de VIN]" title="Consulta de VIN" border="0" align="absmiddle" width="40" height="40" /> 
        Consulta VIN/Placa</a> -->

            <a 
              href="principal.php?Mod=VehiculoIngreso&Form=Consulta"
              style="
                background: linear-gradient(to right, #1FBD1F, #4CEA79);
                text-decoration: none;
                color:  #6A6A6A;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
              "   
            >
              Consulta VIN/Placa
            </a>
        
        
         |
         
        <!-- <a class="EstMenuGrandeLink"  href="principal.php?Mod=Cita&Form=VerCalendario" ><img src="imagenes/nicono/calendario.png" alt="[Calendario Citas]" title="Calendario Citas" border="0" align="absmiddle" width="40" height="40" /> 
        Calendario Citas
        </a> -->

            <a 
              href="principal.php?Mod=Cita&Form=VerCalendario" 
              style="
                background: linear-gradient(to right, #1FBD1F, #4CEA79);
                text-decoration: none;
                color:  #6A6A6A;
                padding: 5px 15px 5px 15px;
                border: none;
                border-radius: 15px;
                margin:  5px;
              "   
            >
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
  </table>

</div>