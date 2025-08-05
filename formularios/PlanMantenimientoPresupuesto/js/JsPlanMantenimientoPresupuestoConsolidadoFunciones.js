// JavaScript Document

/*
*** EVENTOS
*/


$().ready(function() {

/*
* EVENTOS - INICIALES
*/
	$("select#CmpVehiculoMarca").change(function(){
		FncVehiculoModelosCargar();
		
	//	FncFichaIngresoMantenimientoKilometrajeEstablecer();
	});

	

});





function FncPlanMantenimientoPresupuestoConsolidadoImprimir(oIndice){
	var Accion = document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).action;
	
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).target = '_blank';
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).submit();
	
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).target = 'IfrPlanMantenimientoPresupuestoConsolidado'+oIndice;
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).action = Accion;
	
}

function FncPlanMantenimientoPresupuestoConsolidadoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).action;
	
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).target = '_blank';
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).submit();
	
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).target = 'IfrPlanMantenimientoPresupuestoConsolidado'+oIndice;
	document.getElementById('FrmPlanMantenimientoPresupuestoConsolidado'+oIndice).action = Accion;
	
}



function FncPlanMantenimientoPresupuestoConsolidadoNuevo(){


	
				
}
