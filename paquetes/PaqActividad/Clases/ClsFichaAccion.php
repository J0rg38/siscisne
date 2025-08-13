<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccion {

    public $FccId;
	public $FimId;
	public $FccFecha;
    public $FccObservacion;	
	public $FccManoObra;
	
	public $FccCausa;
	public $FccPedido;
	public $FccSolucion;
	public $FccManoObraDetalle;
	
	public $FccComprobanteNumero;
	public $FccComprobanteFecha;
	
	public $FccFacturable;
	public $FccEstado;
	public $FccTiempoCreacion;
	public $FccTiempoModificacion;
    public $FccEliminado;
	
	public $FinId;
	public $FinFecha;
	public $FinTiempoTrabajoTerminado;
	public $LtiNombre;
	public $EinVIN;
	public $VmaId;
	public $VmoId;
	public $VveId;
	public $EinAnoFabricacion;
	public $EinPlaca;
	public $EinColor;

	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $VmaAbreviatura;

	public $MinSigla;
	public $MinNombre;
	public $CliNumeroDocumento;
	public $CliNombre;
	public $CliId;
	public $PerId;
	public $MinId;
	public $EinId;
	public $FinMantenimientoKilometraje;
	public $FinFotoVIN;
	public $FinFotoFrontal;
	public $FinFotoCupon;
	public $FinFotoMantenimiento;

public $AmoId;
	
	public $FccAlmacenMovimientoSalida;
	
	public $FimObsequio;
	
    public $InsMysql;

	public $FichaAccionTarea;
	public $FichaAccionTempario;
	public $FichaIngresoProducto;
	public $FichaAccioSuministro;
	public $FichaAccionFoto;
	public $FichaAccionSalidaExterna;
	
	public $Transaccion;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = false;
    }
	
	public function __destruct(){

	}

	public function MtdGenerarFichaAccionId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(fcc.FccId,5),unsigned)) AS "MAXIMO"
		FROM tblfccfichaaccion fcc;';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FccId = "FCC-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FccId = "FCC-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerFichaAccion($oCompleto=true){

        $sql = 'SELECT 
        fcc.FccId,
		fcc.FimId,
		DATE_FORMAT(fcc.FccFecha, "%d/%m/%Y") AS "NFccFecha",
		fcc.FccObservacion,
		
		fcc.FccCausa,
		fcc.FccPedido,
		fcc.FccSolucion,
		
		fcc.FccManoObra,
		fcc.FccManoObraDetalle,
		
		fcc.FccComprobanteNumero,
		DATE_FORMAT(fcc.FccComprobanteFecha, "%d/%m/%Y") AS "NFccComprobanteFecha",

		fcc.PerId,
		fcc.FccFacturable,
		fcc.FccEstado,
		DATE_FORMAT(fcc.FccTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFccTiempoCreacion",
        DATE_FORMAT(fcc.FccTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFccTiempoModificacion",
		fim.FinId,
		fim.MinId,
		min.MinSigla,
		min.MinNombre,
		
		CASE
				WHEN EXISTS (
					SELECT amo.AmoId FROM tblamoalmacenmovimiento amo WHERE amo.FccId = fcc.FccId
				) THEN "Si"
				ELSE "No"
				END AS FccAlmacenMovimientoSalida,
				
		fin.EinId,
		fin.FinMantenimientoKilometraje,
		
		fim.FimObsequio,
		
		SUBSTR(VmaNombre,1,5) AS VmaAbreviatura,
		
		DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
		
		fin.FinFotoVIN,
		fin.FinFotoFrontal,
		
		fin.FinFotoCupon,
		fin.FinFotoMantenimiento,
		
		fin.CliId,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliNumeroDocumento,
		cli.TdoId,
		
		vve.VmoId,
		
		vve.VveNombre,
		vmo.VmoNombre,
		vma.VmaNombre,
		
		ein.EinVIN,
		
		fin.SucId
		
        FROM tblfccfichaaccion fcc
		
			LEFT JOIN tblfimfichaingresomodalidad fim
			ON fcc.FimId = fim.FimId
			
				LEFT JOIN tblfinfichaingreso fin
				ON fim.FinId = fin.FinId
					
					LEFT JOIN tbleinvehiculoingreso ein
					ON fin.EinId = ein.EinId
						
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
							
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
								
								
						
					LEFT JOIN tblperpersonal per
					ON fin.PerId = per.PerId

						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
											
					
						
				LEFT JOIN tblminmodalidadingreso min
				ON fim.MinId = min.MinId
	        WHERE fcc.FccId = "'.$this->FccId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->FccId = $fila['FccId'];
			$this->FimId = $fila['FimId'];
			$this->FccFecha = $fila['NFccFecha'];
			$this->FccObservacion = $fila['FccObservacion'];
			$this->FccManoObra = $fila['FccManoObra'];
			$this->FccManoObraDetalle = $fila['FccManoObraDetalle'];
			
			$this->FccCausa = $fila['FccCausa'];
			$this->FccPedido = $fila['FccPedido'];
			$this->FccSolucion = $fila['FccSolucion'];
			
			$this->FccComprobanteNumero = $fila['FccComprobanteNumero'];
			$this->FccComprobanteFecha = $fila['NFccComprobanteFecha'];
			
		
			$this->PerId = $fila['PerId'];	
			$this->FccFacturable = $fila['FccFacturable'];	
			$this->FccEstado = $fila['FccEstado'];
			$this->FccTiempoCreacion = $fila['NFccTiempoCreacion']; 
			
			$this->FccTiempoModificacion = $fila['NFccTiempoModificacion']; 	
			
			$this->FinId = $fila['FinId'];
			$this->MinId = $fila['MinId'];
			$this->MinSigla = $fila['MinSigla'];
			$this->MinNombre = $fila['MinNombre'];
			
			$this->FccAlmacenMovimientoSalida = $fila['FccAlmacenMovimientoSalida'];
			
			$this->EinId = $fila['EinId'];
			$this->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
			
			$this->FimObsequio = $fila['FimObsequio'];
			
			$this->VmaAbreviatura = $fila['VmaAbreviatura'];
			
			$this->FinFecha = $fila['NFinFecha'];	
			
			
			$this->FinFotoVIN = $fila['FinFotoVIN'];			
			$this->FinFotoFrontal = $fila['FinFotoFrontal'];
			$this->FinFotoCupon = $fila['FinFotoCupon'];
			$this->FinFotoMantenimiento = $fila['FinFotoMantenimiento'];
			
			$this->CliId = $fila['CliId'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
			
			$this->VmoId = $fila['VmoId'];

				$this->VveNombre = $fila['VveNombre'];
				$this->VmoNombre = $fila['VmoNombre'];
				$this->VmaNombre = $fila['VmaNombre'];

				$this->EinVIN = $fila['EinVIN'];
				
				$this->SucId = $fila['SucId'];
				
			if($oCompleto){

				$InsFichaAccionSalidaExterna = new ClsFichaAccionSalidaExterna();
				$InsFichaAccionTarea = new ClsFichaAccionTarea();
				$InsFichaAccionTempario = new ClsFichaAccionTempario();
				$InsFichaAccionProducto = new ClsFichaAccionProducto();
				$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
				$InsFichaAccionSuministro = new ClsFichaAccionSuministro();
				$InsFichaAccionFoto = new ClsFichaAccionFoto();
				
				$InsTallerPedido = new ClsTallerPedido();
			
			
				$ResFichaAccionSalidaExterna = $InsFichaAccionSalidaExterna->MtdObtenerFichaAccionSalidaExternas(NULL,NULL,'FsxId','Desc',NULL,$this->FccId,NULL);
				$this->FichaAccionSalidaExterna = $ResFichaAccionSalidaExterna['Datos'];


				$ResFichaAccionTarea = $InsFichaAccionTarea->MtdObtenerFichaAccionTareas(NULL,NULL,'FatId','Desc',NULL,$this->FccId,NULL);
				$this->FichaAccionTarea = $ResFichaAccionTarea['Datos'];
				
				//MtdObtenerFichaAccionTemparios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FaeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL)
				$ResFichaAccionTempario = $InsFichaAccionTempario->MtdObtenerFichaAccionTemparios(NULL,NULL,NULL,'FaeId','Desc',NULL,$this->FccId,NULL);
				$this->FichaAccionTempario = $ResFichaAccionTempario['Datos'];
				
				$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','Desc',NULL,$this->FccId,NULL,NULL,1);
				$this->FichaAccionProducto = $ResFichaAccionProducto['Datos'];
				
				$ResFichaAccionMantenimiento = $InsFichaAccionMantenimiento->MtdObtenerFichaAccionMantenimientos(NULL,NULL,'PmtOrden','ASC',NULL,$this->FccId,NULL,NULL,false,NULL);
				$this->FichaAccionMantenimiento = $ResFichaAccionMantenimiento['Datos'];
	
				$ResFichaAccionSuministro = $InsFichaAccionSuministro->MtdObtenerFichaAccionSuministros(NULL,NULL,'FasId','Desc',NULL,$this->FccId,NULL);
				$this->FichaAccionSuministro = $ResFichaAccionSuministro['Datos'];
	
				$ResFichaAccionFoto = $InsFichaAccionFoto->MtdObtenerFichaAccionFotos(NULL,NULL,'FafId','Desc',NULL,$this->FccId,NULL);
				$this->FichaAccionFoto = $ResFichaAccionFoto['Datos'];
				
				//MtdObtenerTallerPedidos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL)
					
							
				$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoId','ASC','1',NULL,NULL,NULL,$this->FccId);
				$this->TallerPedido = $ResTallerPedido['Datos'];

				
			}

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


	public function MtdVerificarExisteFichaAcciones($oCampo,$oDato){
		 
		 $FichaAccionId = "";
		 
		 //($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oIgnorarTotalVacio=false,$oFacturable=NULL,$oGenerarFactura=false,$oTipoFecha="fcc.FccFecha")
		 $ResFichaAccion = $this->MtdObtenerFichaAcciones($oCampo,"esigual",$oDato,'FccId','ASC','1',NULL,NULL,NULL,NULL,NULL,false,false,NULL,false,NULL,false,"fcc.FccFecha");
		 $ArrFichaAcciones = $ResFichaAccion['Datos'];
		 
		 if(!empty($ArrFichaAcciones)){
			 foreach($ArrFichaAcciones as $DatFichaAccion){
				 
				 $FichaAccionId = $DatFichaAccion->FccId;
				 
			 }
		 }
		
		 return $FichaAccionId;
	 }
	 
    public function MtdObtenerFichaAcciones($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oIgnorarTotalVacio=false,$oFacturable=NULL,$oGenerarFactura=false,$oTipoFecha="fcc.FccFecha") {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fecha = '';
		$estado = '';
		$fingresoestado = '';
		$porfacturar = '';
		$porgenerargarantia = '';
		$fingresomodalidadingreso = '';
		$ignorartotalvacio = '';
		$facturable = '';
		$generarfactura = '';

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				
				//$filtrar .= '  OR EXISTS( 
//					
//					SELECT 
//					bde.BdeId
//					FROM tblbdeboletadetalle bde
//						
//					WHERE 
//						bde.BolId = bol.BolId AND
//						bde.BtaId = bol.BtaId AND
//						
//						(
//						bde.BdeDescripcion LIKE "%'.$oFiltro.'%" 
//						
//						)
//						
//					) ';
//					
//					
					
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		/*if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fcc.FccFecha)>="'.$oFechaInicio.'" AND DATE(fcc.FccFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(fcc.FccFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fcc.FccFecha)<="'.$oFechaFin.'"';		
			}			
		}*/
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'" AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		


		if(!empty($oEstado)){
			$estado = ' AND fcc.FccEstado = '.$oEstado;
		}
		
		if(!empty($oFichaIngresoModalidad)){
			$fimodalidad = ' AND fcc.FimId = "'.$oFichaIngresoModalidad.'"';
		}		
		
//		if(!empty($oFichaIngresoEstado)){
//			$festado = ' AND fin.FinEstado = '.$oFichaIngresoEstado;
//		}
		
		if(!empty($oFichaIngresoEstado)){

			$elementos = explode(",",$oFichaIngresoEstado);

			$i=1;
			$festado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$festado .= '  (fin.FinEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$festado .= ' OR ';	
				}
			$i++;		
			}

			$festado .= ' ) 
			)
			';

		}
		
		//$festado = '';
		if(($oPorFacturar)){
			$pfacturar = ' AND (

					(	
						fin.FinEstado = 75
					) 

					OR (fin.FinEstado = 9 
						AND NOT EXISTS ( 
							SELECT 
							bol.BolId 
							FROM tblbolboleta bol 
							WHERE bol.AmoId = amo.AmoId 
							AND bol.BolEstado <> 6
							LIMIT 1
						)
						AND NOT EXISTS ( 
							SELECT fac.FacId 
							FROM tblfacfactura fac 
							WHERE fac.AmoId = amo.AmoId 
							AND fac.FacEstado <> 6
							LIMIT 1
						)
				 	)
				)
			';
		}
		
		if(($oPorGenerarGarantia)){
			$pgarantia = ' AND (
					
					 ( 
					 	(fin.FinEstado = 73 OR fin.FinEstado = 74 OR fin.FinEstado = 75 OR fin.FinEstado = 9  )
						AND NOT EXISTS ( 
							SELECT gar.GarId FROM tblgargarantia gar WHERE gar.FccId = fcc.FccId LIMIT 1
						)
				 	)
				)
			';
		}
		
//		if(!empty($oFichaIngresoModalidadIngreso)){
//			$mingreso = ' AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"';
//		}	
//		
		//deb($oFichaIngresoModalidadIngreso);
		if(!empty($oFichaIngresoModalidadIngreso)){

			$elementos = explode(",",$oFichaIngresoModalidadIngreso);

			$i=1;
			$mingreso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$mingreso .= '  (fim.MinId = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$mingreso .= ' OR ';	
				}
			$i++;		
			}

			$mingreso .= ' ) 
			)
			';

		}

		if($oIgnorarTotalVacio){
		///	$itvacio = '  AND ( amo.AmoTotal <> 0 OR fcc.FccManoObra <> 0) ';
		}
		
		
		
		if($oFacturable){
			$facturable = '  AND fcc.FccFacturable = '.$oFacturable;
		}
				
		if($oGenerarFactura){
			
			$gfactura = '
			
				AND
			
				(
				
					(
			
					IF( (
					
						SELECT 
	
							@CantidadPendiente:=IFNULL((
							
									IFNULL(amd.AmdCantidad,0) 
									
									- IFNULL(
		
										(
											SELECT 
											SUM(bde.BdeCantidad)
											FROM tblbdeboletadetalle bde
											
												LEFT JOIN tblbolboleta bol
												ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
													
											WHERE bde.AmdId = amd.AmdId
												AND bol.BolEstado <> 6
											LIMIT 1
										)
															
									,0)
									
										- IFNULL(
				
												(
													SELECT 
													SUM(fde.FdeCantidad)
													FROM tblfdefacturadetalle fde
													
														LEFT JOIN tblfacfactura fac
														ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
															
													WHERE fde.AmdId = amd.AmdId
														AND fac.FacEstado <> 6
													LIMIT 1
												)
			
										,0)
								
							),0)  AS AmdCantidadPendiente
	
						FROM tblamdalmacenmovimientodetalle amd
							
						WHERE amd.AmoId = amo.AmoId
							AND amd.AmdEstado = 3
							AND amo.AmoFecha > "2014-09-18"
						
						LIMIT 1
					)>0,"SI","NO") = "SI"
					
					AND (fin.FinEstado = 75 OR fin.FinEstado = 9) 
					)
					
					
					OR (
					
					
							NOT 
							
								EXISTS(
	
									SELECT
									fac.FacId
									FROM tblfacfactura fac
										
										LEFT JOIN tblamoalmacenmovimiento amo
										ON fac.AmoId = amo.AmoId
										
									WHERE amo.FccId = fcc.FccId			
									AND fac.FacEstado <> 6
									
								)

							AND

								NOT EXISTS(
								
									SELECT
									bol.BolId
									FROM tblbolboleta bol
										
										LEFT JOIN tblamoalmacenmovimiento amo
										ON bol.AmoId = amo.AmoId
										
									WHERE amo.FccId = fcc.FccId			
									AND bol.BolEstado<>6
								)
								
							AND 
							
								NOT EXISTS(
									SELECT 
									fam.FamId
									FROM tblfamfacturaalmacenmovimiento fam
										
										LEFT JOIN tblamoalmacenmovimiento amo
										ON fam.AmoId = amo.AmoId
											
											LEFT JOIN tblfacfactura fac
											ON (fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId)
											
									WHERE amo.FccId = fcc.FccId
									AND fac.FacEstado<>6
								)
								
							AND 
							
								NOT EXISTS(
									SELECT 
									bam.BamId
									FROM tblbamboletaalmacenmovimiento bam
										
										LEFT JOIN tblamoalmacenmovimiento amo
										ON bam.AmoId = amo.AmoId
											
											LEFT JOIN tblbolboleta bol
											ON (bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId)
											
									WHERE amo.FccId = fcc.FccId
									AND bol.BolEstado<>6
								)
								
							AND 

							(
								fcc.FccManoObra>0
								OR fcc.FccFecha <= "2014-09-18"
							)
							
							AND (fin.FinEstado = 75 OR fin.FinEstado = 9) 
							
							
							
					
					)
					
					
				
				)
				
			';
			
		}
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fcc.FccId,
				fcc.FimId,				
				DATE_FORMAT(fcc.FccFecha, "%d/%m/%Y") AS "NFccFecha",
				fcc.FccObservacion,	
				fcc.FccCausa,
				fcc.FccPedido,
				fcc.FccSolucion,	
					
				fcc.FccManoObra,	
				fcc.FccManoObraDetalle,
				
				fcc.FccComprobanteNumero,	
				DATE_FORMAT(fcc.FccComprobanteFecha, "%d/%m/%Y") AS "NFccComprobanteFecha",
				
				fcc.PerId,
				fcc.FccEstado,
				DATE_FORMAT(fcc.FccTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFccTiempoCreacion",
	        	DATE_FORMAT(fcc.FccTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFccTiempoModificacion",
				fim.FinId,
				fim.MinId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",

				lti.LtiNombre,

				ein.EinVIN,
				ein.VmaId,
				ein.VmoId,
				ein.VveId,
				ein.EinAnoFabricacion,
				ein.EinPlaca,
				ein.EinColor,

				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,

				min.MinSigla,
				min.MinNombre,
				cli.CliNumeroDocumento,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombre,
				CASE
				WHEN EXISTS (
					SELECT amo.AmoId FROM tblamoalmacenmovimiento amo WHERE amo.FccId = fcc.FccId
				) THEN "Si"
				ELSE "No"
				END AS FccAlmacenMovimientoSalida,
				
				fin.FinPrioridad,
				fin.FinConductor,
				fin.FinVehiculoKilometraje,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				DATE_FORMAT(fin.FinTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoCreacion",
				
				fim.FimObsequio,
				
				fin.FinPlaca,
				onc.OncNombre,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				amo.AmoId,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				
				
						(
		SELECT 
			cpr.CprId
				FROM tblcprcotizacionproducto cpr
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprId,
		
		
		
		(
		SELECT 
		CONCAT(IFNULL(seg.CliNombre,"")," ",IFNULL(seg.CliApellidoPaterno,"")," ",IFNULL(seg.CliApellidoMaterno,""))
        FROM tblcprcotizacionproducto cpr
		
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						
						
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprSeguro,
		
		
		(
		SELECT 
		seg.CliArchivo
        FROM tblcprcotizacionproducto cpr
		
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						
						
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprSeguroFoto
		
		
				
				FROM tblfccfichaaccion fcc

					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId

						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
						
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
							
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId = fin.FinId
									
									
										LEFT JOIN tbleinvehiculoingreso ein
										ON fin.EinId = ein.EinId
											LEFT JOIN tblvehvehiculo veh
											ON ein.VehId = veh.VehId
											
												LEFT JOIN tblvvevehiculoversion vve
												ON ein.VveId = vve.VveId
													LEFT JOIN tblvmovehiculomodelo vmo
													ON ein.VmoId = vmo.VmoId
														LEFT JOIN tblvmavehiculomarca vma
														ON vmo.Vmaid = vma.VmaId	
														
										LEFT JOIN tblclicliente cli
										ON fin.CliId = cli.CliId
										
											LEFT JOIN tbllticlientetipo lti
												ON cli.LtiId = lti.LtiId
												
												LEFT JOIN tblperpersonal per
												ON fin.PerId = per.PerId
												
													LEFT JOIN tbloncconcesionario onc
													ON ein.OncId = onc.OncId
							
				WHERE 1 = 1 '.$filtrar.$fimodalidad.$fecha.$estado.$festado.$pfacturar.$pgarantia.$mingreso.$facturable.$gfactura.$itvacio.$orden."".$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsFichaAccion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccion = new $InsFichaAccion();
                    $FichaAccion->FccId = $fila['FccId'];
					$FichaAccion->FimId = $fila['FimId'];
					$FichaAccion->FccFecha = $fila['NFccFecha'];
					$FichaAccion->FccObservacion = $fila['FccObservacion'];
					$FichaAccion->FccCausa = $fila['FccCausa'];
					$FichaAccion->FccPedido = $fila['FccPedido'];
					$FichaAccion->FccSolucion = $fila['FccSolucion'];
					
					$FichaAccion->FccManoObra = $fila['FccManoObra'];
					$FichaAccion->FccManoObraDetalle = $fila['FccManoObraDetalle'];
					
					$FichaAccion->FccComprobanteNumero = $fila['FccComprobanteNumero'];
					$FichaAccion->FccComprobanteFecha = $fila['NFccComprobanteFecha'];
					
					$FichaAccion->PerId = $fila['PerId'];
					$FichaAccion->FccFacturable = $fila['FccFacturable'];
					$FichaAccion->FccEstado = $fila['FccEstado'];
					$FichaAccion->FccTiempoCreacion = $fila['NFccTiempoCreacion'];  
					$FichaAccion->FccTiempoModificacion = $fila['NFccTiempoModificacion']; 
					
					$FichaAccion->FinId = $fila['FinId']; 
					$FichaAccion->MinId = $fila['MinId']; 
					$FichaAccion->FinFecha = $fila['NFinFecha']; 
					$FichaAccion->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado']; 
					
					$FichaAccion->LtiNombre = $fila['LtiNombre']; 
					
					$FichaAccion->EinVIN = $fila['EinVIN']; 
					$FichaAccion->VmaId = $fila['VmaId']; 
					$FichaAccion->VmoId = $fila['VmoId']; 
					$FichaAccion->VveId = $fila['VveId']; 
					$FichaAccion->EinAnoFabricacion = $fila['EinAnoFabricacion']; 
					$FichaAccion->EinPlaca = $fila['EinPlaca']; 
					$FichaAccion->EinColor = $fila['EinColor']; 
					$FichaAccion->VmaNombre = $fila['VmaNombre']; 
					$FichaAccion->VmoNombre = $fila['VmoNombre']; 
					$FichaAccion->VveNombre = $fila['VveNombre'];
					
					$FichaAccion->MinSigla = $fila['MinSigla']; 
					$FichaAccion->MinNombre = $fila['MinNombre']; 
					
					$FichaAccion->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
					$FichaAccion->CliNombre = $fila['CliNombre']; 
					
					$FichaAccion->FccAlmacenMovimientoSalida = $fila['FccAlmacenMovimientoSalida']; 
					
					$FichaAccion->FinPrioridad = $fila['FinPrioridad']; 
					$FichaAccion->FinConductor = $fila['FinConductor']; 
					$FichaAccion->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje']; 
					$FichaAccion->PerNombre = $fila['PerNombre']; 
					$FichaAccion->PerApellidoPaterno = $fila['PerApellidoPaterno']; 
					$FichaAccion->PerApellidoMaterno = $fila['PerApellidoMaterno']; 
					$FichaAccion->FinTiempoCreacion = $fila['NFinTiempoCreacion']; 
					
					$FichaAccion->FimObsequio = $fila['FimObsequio']; 
					
					$FichaAccion->FinPlaca = $fila['FinPlaca'];
					
					$FichaAccion->OncNombre = $fila['OncNombre']; 
					
					
					$FichaAccion->CliNombre = $fila['CliNombre']; 
					$FichaAccion->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$FichaAccion->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
		
					$FichaAccion->AmoId = $fila['AmoId']; 
					$FichaAccion->AmoFecha = $fila['NAmoFecha']; 
					
					$FichaAccion->CprId = $fila['CprId']; 
					$FichaAccion->CprSeguro = $fila['CprSeguro']; 
					$FichaAccion->CprSeguroFoto = $fila['CprSeguroFoto']; 
				
				
                    $FichaAccion->InsMysql = NULL;                    
	
					$Respuesta['Datos'][]= $FichaAccion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		



    public function MtdObtenerFichaAccionesValor($oFuncion,$oParametro,$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL,$oPersonal=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fcc.FccFecha)>="'.$oFechaInicio.'" AND DATE(fcc.FccFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(fcc.FccFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fcc.FccFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND fcc.FccEstado = '.$oEstado;
		}
		
		if(!empty($oFichaIngresoModalidad)){
			$fimodalidad = ' AND fcc.FimId = "'.$oFichaIngresoModalidad.'"';
		}		
		
//		if(!empty($oFichaIngresoEstado)){
//			$festado = ' AND fin.FinEstado = '.$oFichaIngresoEstado;
//		}
		
		if(!empty($oFichaIngresoEstado)){

			$elementos = explode(",",$oFichaIngresoEstado);

			$i=1;
			$festado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$festado .= '  (fin.FinEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$festado .= ' OR ';	
				}
			$i++;		
			}

			$festado .= ' ) 
			)
			';

		}
		
		//$festado = '';
		if(($oPorFacturar)){
			$pfacturar = ' AND (

					(	
						fin.FinEstado = 75
					) 

					OR (fin.FinEstado = 9 
						AND NOT EXISTS ( 
							SELECT 
							bol.BolId 
							FROM tblbolboleta bol 
							WHERE bol.AmoId = amo.AmoId 
							AND bol.BolEstado <> 6
							LIMIT 1
						)
						AND NOT EXISTS ( 
							SELECT fac.FacId 
							FROM tblfacfactura fac 
							WHERE fac.AmoId = amo.AmoId 
							AND fac.FacEstado <> 6
							LIMIT 1
						)
				 	)
				)
			';
		}
		
		if(($oPorGenerarGarantia)){
			$pgarantia = ' AND (
					
					 ( 
					 	(fin.FinEstado = 73 OR fin.FinEstado = 74 OR fin.FinEstado = 75 OR fin.FinEstado = 9  )
						AND NOT EXISTS ( 
							SELECT gar.GarId FROM tblgargarantia gar WHERE gar.FccId = fcc.FccId LIMIT 1
						)
				 	)
				)
			';
		}
		
//		if(!empty($oFichaIngresoModalidadIngreso)){
//			$mingreso = ' AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"';
//		}	
//		
		//deb($oFichaIngresoModalidadIngreso);
		if(!empty($oFichaIngresoModalidadIngreso)){

			$elementos = explode(",",$oFichaIngresoModalidadIngreso);

			$i=1;
			$mingreso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$mingreso .= '  (fim.MinId = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$mingreso .= ' OR ';	
				}
			$i++;		
			}

			$mingreso .= ' ) 
			)
			';

		}
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
			
		if(!empty($oSucursal)){
			$sucursal = ' AND fin.SucId = "'.$oSucursal.'"';
		}	
		
				
		if(!empty($oPersonal)){
			$personal = ' AND fin.PerId = "'.$oPersonal.'"';
		}	
		
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fin.FinFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(fin.FinFecha) ="'.($oAno).'"';
		}
		
		if(!empty($oDia)){
			$dia = ' AND DAY(fin.FinFecha) ="'.($oDia).'"';
		}
		


				$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"
				
				FROM tblfccfichaaccion fcc

					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId

						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId = fin.FinId
									
									
										LEFT JOIN tbleinvehiculoingreso ein
										ON fin.EinId = ein.EinId
											LEFT JOIN tblvehvehiculo veh
											ON ein.VehId = veh.VehId
											
												LEFT JOIN tblvvevehiculoversion vve
												ON ein.VveId = vve.VveId
													LEFT JOIN tblvmovehiculomodelo vmo
													ON ein.VmoId = vmo.VmoId
														LEFT JOIN tblvmavehiculomarca vma
														ON vmo.Vmaid = vma.VmaId	
														
										LEFT JOIN tblclicliente cli
										ON fin.CliId = cli.CliId
										
											LEFT JOIN tbllticlientetipo lti
												ON cli.LtiId = lti.LtiId
												
												LEFT JOIN tblperpersonal per
												ON fin.PerId = per.PerId
							
				WHERE 1 = 1 '.$mes.$ano.$dia.$filtrar.$fecha.$personal.$sucursal.$fimodalidad.$estado.$festado.$pfacturar.$pgarantia.$mingreso.$vmarca.$orden.$paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}
	


    public function MtdObtenerFichaAccionesTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fcc.FccFecha)>="'.$oFechaInicio.'" AND DATE(fcc.FccFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(fcc.FccFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fcc.FccFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND fcc.FccEstado = '.$oEstado;
		}
		
		if(!empty($oFichaIngresoModalidad)){
			$fimodalidad = ' AND fcc.FimId = "'.$oFichaIngresoModalidad.'"';
		}		
		
//		if(!empty($oFichaIngresoEstado)){
//			$festado = ' AND fin.FinEstado = '.$oFichaIngresoEstado;
//		}
		
		if(!empty($oFichaIngresoEstado)){

			$elementos = explode(",",$oFichaIngresoEstado);

			$i=1;
			$festado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$festado .= '  (fin.FinEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$festado .= ' OR ';	
				}
			$i++;		
			}

			$festado .= ' ) 
			)
			';

		}
		
		//$festado = '';
		if(($oPorFacturar)){
			$pfacturar = ' AND (

					(	
						fin.FinEstado = 75
					) 

					OR (fin.FinEstado = 9 
						AND NOT EXISTS ( 
							SELECT 
							bol.BolId 
							FROM tblbolboleta bol 
							WHERE bol.AmoId = amo.AmoId 
							AND bol.BolEstado <> 6
							LIMIT 1
						)
						AND NOT EXISTS ( 
							SELECT fac.FacId 
							FROM tblfacfactura fac 
							WHERE fac.AmoId = amo.AmoId 
							AND fac.FacEstado <> 6
							LIMIT 1
						)
				 	)
				)
			';
		}
		
		if(($oPorGenerarGarantia)){
			$pgarantia = ' AND (
					
					 ( 
					 	(fin.FinEstado = 73 OR fin.FinEstado = 74 OR fin.FinEstado = 75 OR fin.FinEstado = 9  )
						AND NOT EXISTS ( 
							SELECT gar.GarId FROM tblgargarantia gar WHERE gar.FccId = fcc.FccId LIMIT 1
						)
				 	)
				)
			';
		}
		
//		if(!empty($oFichaIngresoModalidadIngreso)){
//			$mingreso = ' AND fim.MinId = "'.$oFichaIngresoModalidadIngreso.'"';
//		}	
//		
		//deb($oFichaIngresoModalidadIngreso);
		if(!empty($oFichaIngresoModalidadIngreso)){

			$elementos = explode(",",$oFichaIngresoModalidadIngreso);

			$i=1;
			$mingreso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$mingreso .= '  (fim.MinId = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$mingreso .= ' OR ';	
				}
			$i++;		
			}

			$mingreso .= ' ) 
			)
			';

		}
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
			
		if(!empty($oSucursal)){
			$sucursal = ' AND fin.SucId = "'.$oSucursal.'"';
		}	
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fin.FinFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(fin.FinFecha) ="'.($oAno).'"';
		}
		
		if(!empty($oDia)){
			$dia = ' AND DAY(fin.FinFecha) ="'.($oDia).'"';
		}
		


				$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"
				
				FROM tblfccfichaaccion fcc

					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId

						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId = fin.FinId
									
									
										LEFT JOIN tbleinvehiculoingreso ein
										ON fin.EinId = ein.EinId
											LEFT JOIN tblvehvehiculo veh
											ON ein.VehId = veh.VehId
											
												LEFT JOIN tblvvevehiculoversion vve
												ON ein.VveId = vve.VveId
													LEFT JOIN tblvmovehiculomodelo vmo
													ON ein.VmoId = vmo.VmoId
														LEFT JOIN tblvmavehiculomarca vma
														ON vmo.Vmaid = vma.VmaId	
														
														
									
										LEFT JOIN tblclicliente cli
										ON fin.CliId = cli.CliId
										
											LEFT JOIN tbllticlientetipo lti
												ON cli.LtiId = lti.LtiId
												
												LEFT JOIN tblperpersonal per
												ON fin.PerId = per.PerId
							
				WHERE 1 = 1 '.$mes.$ano.$dia.$filtrar.$fecha.$sucursal.$fimodalidad.$estado.$festado.$pfacturar.$pgarantia.$mingreso.$vmarca.$orden.$paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}
	
	
	//Accion eliminar	 
	public function MtdEliminarFichaAccion($oElementos) {

		//$this->InsMysql->MtdTransaccionIniciar();
		//$InsFichaAccionTarea = new ClsFichaAccionTarea();
		$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();
		$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
	
		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					//$aux = explode("%",$elemento);	
					//$sql = 'DELETE FROM tblfccfichaaccion WHERE  (FccId = "'.($aux[0]).'" ) ';

//MtdObtenerAlmacenMovimientoSalidas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConFactura=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL) 

					$ResAlmacenMovimientoSalida = $InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalidas(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$elemento,NULL,0,0,NULL,NULL,false,NULL);
					$ArrAlmacenMovimientoSalidas = $ResAlmacenMovimientoSalida['Datos'];

					$eliminar = '';
					if(!empty($ArrAlmacenMovimientoSalidas)){

						foreach($ArrAlmacenMovimientoSalidas as $DatAlmacenMovimientoSalida){
							$eliminar = '#'.$DatAlmacenMovimientoSalida->AmdId;
						}

						if(!$InsAlmacenMovimientoSalida->MtdEliminarAlmacenMovimientoSalida($eliminar)){								
							$error = true;
						}

					}

					if(!$error) {	
					
						$sql = 'DELETE FROM tblfccfichaaccion WHERE  (FccId = "'.($elemento).'" ) ';
						
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
						if(!$resultado) {						
							$error = true;
						}else{
	//							$this->MtdAuditarFichaAccion(3,"Se elimino la SUB ORDEN DE TRABAJO",$aux);		
							$this->MtdAuditarFichaAccion(3,"Se elimino la SUB ORDEN DE TRABAJO",$elemento);		
						}
						
					}
					

				}
			$i++;

			}

			if($error) {	
				//$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				//$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoFichaAccion($oElementos,$oEstado) {

		$error = false;

		//$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				

					$sql = 'UPDATE tblfccfichaaccion SET FccEstado = '.$oEstado.' WHERE FccId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarFichaAccion(2,"Se actualizo el Estado de la SUB ORDEN DE TRABAJO",$elemento);
				
					}

					
				}
			$i++;
	
			}

		

	
			if($error) {	
				//$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				//$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
	
	
	
	public function MtdActualizarFacturableFichaAccion($oElementos,$oFacturable) {

		$error = false;
		
		
		$elementos = explode("#",$oElementos);


			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				

					$sql = 'UPDATE tblfccfichaaccion SET FccFacturable = '.$oFacturable.' WHERE FccId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarFichaAccion(2,"Se actualizo el Estado Facturable de la SUB ORDEN DE TRABAJO",$elemento);
				
					}

					
				}
			$i++;
	
			}

			if($error) {	
				return false;
			} else {	
				return true;
			}									
	}
	
	
	public function MtdRegistrarFichaAccion() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarFichaAccionId();

		if($this->Transaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}
			
			
			$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = $this->FimId;
			$InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidad();
			
			$InsModalidadIngreso = new ClsModalidadIngreso();
			$InsModalidadIngreso->MinId = $InsFichaIngresoModalidad->MinId;
			$InsModalidadIngreso->MtdObtenerModalidadIngreso();
			
			$sql = 'INSERT INTO tblfccfichaaccion (
			FccId,
			FimId,
			FccFecha,
			FccObservacion,		
			FccCausa,
			FccPedido,
			FccSolucion,
			FccManoObra,
			FccManoObraDetalle,
			PerId,
			
			FccComprobanteNumero,
			FccComprobanteFecha,
			FccFacturable,
			FccEstado,			
			FccTiempoCreacion,
			FccTiempoModificacion
			) 
			VALUES (
			"'.($this->FccId).'",
			"'.($this->FimId).'",			
			"'.($this->FccFecha).'",
			"'.($this->FccObservacion).'",
			"'.($this->FccCausa).'",
			"'.($this->FccPedido).'",
			"'.($this->FccSolucion).'",
			
			'.($this->FccManoObra).',
			"'.($this->FccManoObraDetalle).'",
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			
			"'.($this->FccComprobanteNumero).'",
			'.(empty($this->FccComprobanteFecha)?'NULL, ':'"'.$this->FccComprobanteFecha.'",').'
			1,
			'.($this->FccEstado).',
			"'.($this->FccTiempoCreacion).'", 				
			"'.($this->FccTiempoModificacion).'");';
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			}
			
			$Resultado2.='#::: Modalidad de Ingreso: '.strtoupper($InsModalidadIngreso->MinNombre);
					


			if(!$error){
			
				if (!empty($this->FichaAccionMantenimiento)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
					
					$validar = 0;	
					$item = 1;
					$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
							
					foreach ($this->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
										
						$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
						$InsPlanMantenimientoTarea->PmtId = $DatFichaAccionMantenimiento->PmtId;
						$InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTarea();
						
						$InsFichaAccionMantenimiento->FccId = $this->FccId;
						$InsFichaAccionMantenimiento->PmtId = $DatFichaAccionMantenimiento->PmtId;

						$InsFichaAccionMantenimiento->FiaId = $DatFichaAccionMantenimiento->FiaId;
						
						$InsFichaAccionMantenimiento->ProId = $DatFichaAccionMantenimiento->ProId;
						$InsFichaAccionMantenimiento->UmeId = $DatFichaAccionMantenimiento->UmeId;
						$InsFichaAccionMantenimiento->FaaCantidad = $DatFichaAccionMantenimiento->FaaCantidad;
						
						
						$InsFichaAccionMantenimiento->FaaAccion = $DatFichaAccionMantenimiento->FaaAccion;
						$InsFichaAccionMantenimiento->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
						$InsFichaAccionMantenimiento->FaaVerificar1 = $DatFichaAccionMantenimiento->FaaVerificar1;
						$InsFichaAccionMantenimiento->FaaVerificar2 = $DatFichaAccionMantenimiento->FaaVerificar2;
						$InsFichaAccionMantenimiento->FaaEstado = $DatFichaAccionMantenimiento->FaaEstado;
						$InsFichaAccionMantenimiento->FaaTiempoCreacion = $DatFichaAccionMantenimiento->FaaTiempoCreacion;
						$InsFichaAccionMantenimiento->FaaTiempoModificacion = $DatFichaAccionMantenimiento->FaaTiempoModificacion;
						$InsFichaAccionMantenimiento->FaaEliminado = $DatFichaAccionMantenimiento->FaaEliminado;
						
						if($InsFichaAccionMantenimiento->MtdRegistrarFichaAccionMantenimiento()){
							$validar++;	
						}else{
							//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.') - No se pudo registrar';
							$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' - No se pudo registrar';
							//$Resultado2.='#ERR_FCC_281';
						}
						
						$item++;

					}
					
					if(count($this->FichaAccionMantenimiento) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
				/*
	201 TAREAS
	281 MANTENIMIENTO
	211 PRODUCTOS
	221 FOTOS
	231 SUMINISTROS
	241 PROVEEDORES SALDIAS EXTERNAS
	251  FOTOS
	271 TEMPARIO
	*/
			
			if(!$error){			
			
				if (!empty($this->FichaAccionTarea)){		
					
					$validar = 0;	
					$item = 1;
					$InsFichaAccionTarea = new ClsFichaAccionTarea();		
					
					foreach ($this->FichaAccionTarea as $DatFichaAccionTarea){
						
					
						$InsFichaAccionTarea->FccId = $this->FccId;
						$InsFichaAccionTarea->FitId = $DatFichaAccionTarea->FitId;
						$InsFichaAccionTarea->FatDescripcion = $DatFichaAccionTarea->FatDescripcion;
						
						$InsFichaAccionTarea->FatEspecificacion = $DatFichaAccionTarea->FatEspecificacion;
						$InsFichaAccionTarea->FatCosto = $DatFichaAccionTarea->FatCosto;
						
						$InsFichaAccionTarea->FatAccion = $DatFichaAccionTarea->FatAccion;
						$InsFichaAccionTarea->FatVerificar1 = $DatFichaAccionTarea->FatVerificar1;
						$InsFichaAccionTarea->FatVerificar2 = $DatFichaAccionTarea->FatVerificar2;

						$InsFichaAccionTarea->FatEstado = $DatFichaAccionTarea->FatEstado;		
						$InsFichaAccionTarea->FatTiempoCreacion = $DatFichaAccionTarea->FatTiempoCreacion;
						$InsFichaAccionTarea->FatTiempoModificacion = $DatFichaAccionTarea->FatTiempoModificacion;
						$InsFichaAccionTarea->FatEliminado = $DatFichaAccionTarea->FatEliminado;
						
						
						
//						$InsFichaAccionTarea->FccId = $this->FccId;
//						$InsFichaAccionTarea->FitId = $DatFichaAccionTarea->FitId;
//						$InsFichaAccionTarea->FatDescripcion = $DatFichaAccionTarea->FatDescripcion;
//						$InsFichaAccionTarea->FatAccion = $DatFichaAccionTarea->FatAccion;
//						$InsFichaAccionTarea->FatVerificar1 = $DatFichaAccionTarea->FatVerificar1;
//						$InsFichaAccionTarea->FatVerificar2 = $DatFichaAccionTarea->FatVerificar2;
//						$InsFichaAccionTarea->FatEstado = $DatFichaAccionTarea->FatEstado;
//						$InsFichaAccionTarea->FatTiempoCreacion = $DatFichaAccionTarea->FatTiempoCreacion;
//						$InsFichaAccionTarea->FatTiempoModificacion = $DatFichaAccionTarea->FatTiempoModificacion;						
//						$InsFichaAccionTarea->FatEliminado = $DatFichaAccionTarea->FatEliminado;
						
						if($InsFichaAccionTarea->MtdRegistrarFichaAccionTarea()){
							$validar++;	
						}else{
							$Resultado2.='#Tarea: '.($DatFichaAccionTarea->FatDescripcion).'('.$item.')';
							$Resultado2.='#ERR_FCC_201';							
						}
						
						$item++;
					}					
					
					if(count($this->FichaAccionTarea) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if(!$error){			
			
				if (!empty($this->FichaAccionSalidaExterna)){		
						
					
					
					$validar = 0;	
					$item = 1;
					$InsFichaAccionSalidaExterna = new ClsFichaAccionSalidaExterna();		
					
					foreach ($this->FichaAccionSalidaExterna as $DatFichaAccionSalidaExterna){
						
						$InsFichaAccionSalidaExterna->FccId = $this->FccId;
						$InsFichaAccionSalidaExterna->PrvId = $DatFichaAccionSalidaExterna->PrvId;
						$InsFichaAccionSalidaExterna->FsxFechaSalida = $DatFichaAccionSalidaExterna->FsxFechaSalida;
						$InsFichaAccionSalidaExterna->FsxFechaFinalizacion = $DatFichaAccionSalidaExterna->FsxFechaFinalizacion;
						$InsFichaAccionSalidaExterna->FsxEstado = $DatFichaAccionSalidaExterna->FsxEstado;
						$InsFichaAccionSalidaExterna->FsxTiempoCreacion = $DatFichaAccionSalidaExterna->FsxTiempoCreacion;
						$InsFichaAccionSalidaExterna->FsxTiempoModificacion = $DatFichaAccionSalidaExterna->FsxTiempoModificacion;						
						$InsFichaAccionSalidaExterna->FsxEliminado = $DatFichaAccionSalidaExterna->FsxEliminado;
						
						if($InsFichaAccionSalidaExterna->MtdRegistrarFichaAccionSalidaExterna()){
							$validar++;	
						}else{
							$Resultado2.='#Salida Externa: '.($DatFichaAccionSalidaExterna->PrvId).'('.$item.')';
							$Resultado2.='#ERR_FCC_241';							
						}
						
						$item++;
					}					
					
					if(count($this->FichaAccionSalidaExterna) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if(!$error){
			
				if (!empty($this->FichaAccionProducto)){		
						
					$validar = 0;	
					$item = 1;
					$InsFichaAccionProducto = new ClsFichaAccionProducto();
							
					foreach ($this->FichaAccionProducto as $DatFichaAccionProducto){
						
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatFichaAccionProducto->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						$InsFichaAccionProducto->FccId = $this->FccId;
						$InsFichaAccionProducto->ProId = $DatFichaAccionProducto->ProId;
						$InsFichaAccionProducto->UmeId = $DatFichaAccionProducto->UmeId;
						
						$InsFichaAccionProducto->FaaId = $DatFichaAccionProducto->FaaId;

						$InsFichaAccionProducto->FapCantidad = $DatFichaAccionProducto->FapCantidad;
						$InsFichaAccionProducto->FapCantidadReal = $DatFichaAccionProducto->FapCantidadReal;

						$InsFichaAccionProducto->FapAccion = $DatFichaAccionProducto->FapAccion;

						$InsFichaAccionProducto->FapVerificar1 = $DatFichaAccionProducto->FapVerificar1;
						$InsFichaAccionProducto->FapVerificar2 = $DatFichaAccionProducto->FapVerificar2;

						$InsFichaAccionProducto->FapEstado = $DatFichaAccionProducto->FapEstado;
						$InsFichaAccionProducto->FapTiempoCreacion = $DatFichaAccionProducto->FapTiempoCreacion;
						$InsFichaAccionProducto->FapTiempoModificacion = $DatFichaAccionProducto->FapTiempoModificacion;
						$InsFichaAccionProducto->FapEliminado = $DatFichaAccionProducto->FapEliminado;
						
						if($InsFichaAccionProducto->MtdRegistrarFichaAccionProducto()){
							$validar++;	
						}else{
							$Resultado2.='#Producto: '.($InsProducto->ProNombre).'('.$item.')';
							$Resultado2.='#ERR_FCC_211';										
						}
					
						$item++;
						
					}
					
					if(count($this->FichaAccionProducto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
						
						
						
			if(!$error){
			
				if (!empty($this->FichaAccionSuministro)){		
				
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionSuministro = new ClsFichaAccionSuministro();
							
					foreach ($this->FichaAccionSuministro as $DatFichaAccionSuministro){

						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatFichaAccionSuministro->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						$InsFichaAccionSuministro->FccId = $this->FccId;
						$InsFichaAccionSuministro->ProId = $DatFichaAccionSuministro->ProId;
						$InsFichaAccionSuministro->UmeId = $DatFichaAccionSuministro->UmeId;
						
						$InsFichaAccionSuministro->FaaId = $DatFichaAccionSuministro->FaaId;

						$InsFichaAccionSuministro->FasCantidad = $DatFichaAccionSuministro->FasCantidad;
						$InsFichaAccionSuministro->FasCantidadReal = $DatFichaAccionSuministro->FasCantidadReal;

						$InsFichaAccionSuministro->FasVerificar1 = $DatFichaAccionSuministro->FasVerificar1;
						$InsFichaAccionSuministro->FasVerificar2 = $DatFichaAccionSuministro->FasVerificar2;

						$InsFichaAccionSuministro->FasEstado = $DatFichaAccionSuministro->FasEstado;
						$InsFichaAccionSuministro->FasTiempoCreacion = $DatFichaAccionSuministro->FasTiempoCreacion;
						$InsFichaAccionSuministro->FasTiempoModificacion = $DatFichaAccionSuministro->FasTiempoModificacion;
						$InsFichaAccionSuministro->FasEliminado = $DatFichaAccionSuministro->FasEliminado;
						
						if($InsFichaAccionSuministro->MtdRegistrarFichaAccionSuministro()){
							$validar++;	
						}else{
							$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
							$Resultado2.='#ERR_FCC_231';
							
						}
						
						$item++;

					}
					
					if(count($this->FichaAccionSuministro) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			

			
			if(!$error){			
			
				if (!empty($this->FichaAccionFoto)){		

					$validar = 0;	
					$item = 1;
					$InsFichaAccionFoto = new ClsFichaAccionFoto();		
					
					foreach ($this->FichaAccionFoto as $DatFichaAccionFoto){
						
						$InsFichaAccionFoto->FccId = $this->FccId;
						$InsFichaAccionFoto->FafArchivo = $DatFichaAccionFoto->FafArchivo;
						$InsFichaAccionFoto->FafEstado = $DatFichaAccionFoto->FafEstado;
						$InsFichaAccionFoto->FafTiempoCreacion = $DatFichaAccionFoto->FafTiempoCreacion;
						$InsFichaAccionFoto->FafTiempoModificacion = $DatFichaAccionFoto->FafTiempoModificacion;						
						$InsFichaAccionFoto->FafEliminado = $DatFichaAccionFoto->FafEliminado;
						
						if($InsFichaAccionFoto->MtdRegistrarFichaAccionFoto()){
							$validar++;	
						}else{
							$Resultado2.='#Foto: '.($DatFichaAccionFoto->FafArchivo).'('.$item.')';
							$Resultado2.='#ERR_FCC_221';							
						}
						
						$item++;
					}					
					
					if(count($this->FichaAccionFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			

			if(!$error){
			
				if (!empty($this->FichaAccionTempario)){		
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionTempario = new ClsFichaAccionTempario();
							
					foreach ($this->FichaAccionTempario as $DatFichaAccionTempario){
										
						$InsFichaAccionTempario->FaeId = $DatFichaAccionTempario->FaeId;
						$InsFichaAccionTempario->FccId = $this->FccId;
						$InsFichaAccionTempario->FaeCodigo = $DatFichaAccionTempario->FaeCodigo;
						$InsFichaAccionTempario->FaeTiempo = $DatFichaAccionTempario->FaeTiempo;
						$InsFichaAccionTempario->FaeEstado = $DatFichaAccionTempario->FaeEstado;		
						$InsFichaAccionTempario->FaeTiempoCreacion = $DatFichaAccionTempario->FaeTiempoCreacion;
						$InsFichaAccionTempario->FaeTiempoModificacion = $DatFichaAccionTempario->FaeTiempoModificacion;
						$InsFichaAccionTempario->FaeEliminado = $DatFichaAccionTempario->FaeEliminado;
			
						if($InsFichaAccionTempario->MtdRegistrarFichaAccionTempario()){
							$validar++;	
						}else{
							$Resultado2.='#Tempario: '.$InsFichaAccionTempario->FaeDescripcion.' ('.$item.')';
							$Resultado2.='#ERR_FCC_271';
						}
							
						$item++;

					}
					
					if(count($this->FichaAccionTempario) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
								
		if($error) {	
		
			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
		
			return false;
		} else {				
		
			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionHacer();		
			}

			$this->MtdAuditarFichaAccion(1,"Se registro la SUB ORDEN DE TRABAJO",$this);			
			return true;
		}			
					
	}
	
	public function MtdEditarFichaAccion() {

		global $Resultado;
		$error = false;

			$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = $this->FimId;
			$InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidad();
			
			$InsModalidadIngreso = new ClsModalidadIngreso();
			$InsModalidadIngreso->MinId = $InsFichaIngresoModalidad->MinId;
			$InsModalidadIngreso->MtdObtenerModalidadIngreso();
			
		if($this->Transaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}
				
			$sql = 'UPDATE tblfccfichaaccion SET
			FccFecha = "'.($this->FccFecha).'",
			FccObservacion = "'.($this->FccObservacion).'",
			FccCausa = "'.($this->FccCausa).'",
			FccPedido = "'.($this->FccPedido).'",
			FccSolucion = "'.($this->FccSolucion).'",
			
			FccComprobanteNumero = "'.($this->FccComprobanteNumero).'",
			'.(empty($this->FccComprobanteFecha)?'FccComprobanteFecha = NULL, ':'FccComprobanteFecha = "'.$this->FccComprobanteFecha.'",').'

			
			FccTiempoModificacion = "'.($this->FccTiempoModificacion).'"
			WHERE FccId = "'.($this->FccId).'";';			
//FccEstado = '.($this->FccEstado).',
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			////$Resultado2.='#\n';
			$Resultado2.='#::: Modalidad de Ingreso: '.strtoupper($InsModalidadIngreso->MinNombre);
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			/*
				FccManoObra = '.($this->FccManoObra).',
			FccManoObraDetalle = "'.($this->FccManoObraDetalle).'",
		PerId
			*/	
			if(!$error){
			
				if (!empty($this->FichaAccionTarea)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
					
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionTarea = new ClsFichaAccionTarea();
							
					foreach ($this->FichaAccionTarea as $DatFichaAccionTarea){
										
						$InsFichaAccionTarea->FatId = $DatFichaAccionTarea->FatId;
						$InsFichaAccionTarea->FccId = $this->FccId;
						$InsFichaAccionTarea->FitId = $DatFichaAccionTarea->FitId;
						$InsFichaAccionTarea->FatDescripcion = $DatFichaAccionTarea->FatDescripcion;
						
						$InsFichaAccionTarea->FatEspecificacion = $DatFichaAccionTarea->FatEspecificacion;
						$InsFichaAccionTarea->FatCosto = $DatFichaAccionTarea->FatCosto;
						
						$InsFichaAccionTarea->FatAccion = $DatFichaAccionTarea->FatAccion;
						$InsFichaAccionTarea->FatVerificar1 = $DatFichaAccionTarea->FatVerificar1;
						$InsFichaAccionTarea->FatVerificar2 = $DatFichaAccionTarea->FatVerificar2;

						$InsFichaAccionTarea->FatEstado = $DatFichaAccionTarea->FatEstado;		
						$InsFichaAccionTarea->FatTiempoCreacion = $DatFichaAccionTarea->FatTiempoCreacion;
						$InsFichaAccionTarea->FatTiempoModificacion = $DatFichaAccionTarea->FatTiempoModificacion;
						$InsFichaAccionTarea->FatEliminado = $DatFichaAccionTarea->FatEliminado;
						
						if(empty($InsFichaAccionTarea->FatId)){
							if($InsFichaAccionTarea->FatEliminado<>2){
								if($InsFichaAccionTarea->MtdRegistrarFichaAccionTarea()){
									$validar++;	
								}else{
									$Resultado2.='#Tarea: '.$InsFichaAccionTarea->FatDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_201';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionTarea->FatEliminado==2){
								if($InsFichaAccionTarea->MtdEliminarFichaAccionTarea($InsFichaAccionTarea->FatId)){
									$validar++;					
								}else{
									$Resultado2.='#Tarea: '.$InsFichaAccionTarea->FatDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_203';
								}
							}else{
								if($InsFichaAccionTarea->MtdEditarFichaAccionTarea()){
									$validar++;	
								}else{
									$Resultado2.='#Tarea: '.$InsFichaAccionTarea->FatDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_202';
								}
							}
						}	
						
						$item++;

					}
					
					if(count($this->FichaAccionTarea) <> $validar ){
						$error = true;
					}					
								
				}				
			}	


				if(!$error){
			
				if (!empty($this->FichaAccionMantenimiento)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
							
					foreach ($this->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
										
										
						$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
						$InsPlanMantenimientoTarea->PmtId = $DatFichaAccionMantenimiento->PmtId;
						$InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTarea();
						
						
						$InsFichaAccionMantenimiento->FaaId = $DatFichaAccionMantenimiento->FaaId;
						$InsFichaAccionMantenimiento->FccId = $this->FccId;
						$InsFichaAccionMantenimiento->PmtId = $DatFichaAccionMantenimiento->PmtId;
						
						$InsFichaAccionMantenimiento->FiaId = $DatFichaAccionMantenimiento->FiaId;

						$InsFichaAccionMantenimiento->ProId = $DatFichaAccionMantenimiento->ProId;
						$InsFichaAccionMantenimiento->UmeId = $DatFichaAccionMantenimiento->UmeId;
						$InsFichaAccionMantenimiento->FaaCantidad = $DatFichaAccionMantenimiento->FaaCantidad;
						
						
						$InsFichaAccionMantenimiento->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
						$InsFichaAccionMantenimiento->FaaAccion = $DatFichaAccionMantenimiento->FaaAccion;
						$InsFichaAccionMantenimiento->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
						$InsFichaAccionMantenimiento->FaaVerificar1 = $DatFichaAccionMantenimiento->FaaVerificar1;
						$InsFichaAccionMantenimiento->FaaVerificar2 = $DatFichaAccionMantenimiento->FaaVerificar2;
						
						$InsFichaAccionMantenimiento->FaaEstado = $DatFichaAccionMantenimiento->FaaEstado;				
						$InsFichaAccionMantenimiento->FaaTiempoCreacion = $DatFichaAccionMantenimiento->FaaTiempoCreacion;
						$InsFichaAccionMantenimiento->FaaTiempoModificacion = $DatFichaAccionMantenimiento->FaaTiempoModificacion;
						$InsFichaAccionMantenimiento->FaaEliminado = $DatFichaAccionMantenimiento->FaaEliminado;
						
						if(empty($InsFichaAccionMantenimiento->FaaId)){
							if($InsFichaAccionMantenimiento->FaaEliminado<>2){
								
								if($InsFichaAccionMantenimiento->MtdRegistrarFichaAccionMantenimiento()){
									$validar++;	
								}else{
									$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									$Resultado2.='#ERR_FCC_281';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionMantenimiento->FaaEliminado==2){
								if($InsFichaAccionMantenimiento->MtdEliminarFichaAccionMantenimiento($InsFichaAccionMantenimiento->FaaId)){
									$validar++;					
								}else{
									$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									$Resultado2.='#ERR_FCC_283';
								}
							}else{
								if($InsFichaAccionMantenimiento->MtdEditarFichaAccionMantenimiento()){
									$validar++;	
								}else{
									$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									$Resultado2.='#ERR_FCC_282';
								}
							}
						}		
						
						
						$item++;
													
					}
					
					if(count($this->FichaAccionMantenimiento) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			

			if(!$error){
			
				if (!empty($this->FichaAccionSalidaExterna)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
					
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionSalidaExterna = new ClsFichaAccionSalidaExterna();
							
					foreach ($this->FichaAccionSalidaExterna as $DatFichaAccionSalidaExterna){
										
						$InsFichaAccionSalidaExterna->FsxId = $DatFichaAccionSalidaExterna->FsxId;
						$InsFichaAccionSalidaExterna->FccId = $this->FccId;
						$InsFichaAccionSalidaExterna->PrvId = $DatFichaAccionSalidaExterna->PrvId;
						$InsFichaAccionSalidaExterna->FsxFechaSalida = $DatFichaAccionSalidaExterna->FsxFechaSalida;
						$InsFichaAccionSalidaExterna->FsxFechaFinalizacion = $DatFichaAccionSalidaExterna->FsxFechaFinalizacion;

						$InsFichaAccionSalidaExterna->FsxEstado = $DatFichaAccionSalidaExterna->FsxEstado;		
						$InsFichaAccionSalidaExterna->FsxTiempoCreacion = $DatFichaAccionSalidaExterna->FsxTiempoCreacion;
						$InsFichaAccionSalidaExterna->FsxTiempoModificacion = $DatFichaAccionSalidaExterna->FsxTiempoModificacion;
						$InsFichaAccionSalidaExterna->FsxEliminado = $DatFichaAccionSalidaExterna->FsxEliminado;
						
						if(empty($InsFichaAccionSalidaExterna->FsxId)){
							if($InsFichaAccionSalidaExterna->FsxEliminado<>2){
								if($InsFichaAccionSalidaExterna->MtdRegistrarFichaAccionSalidaExterna()){
									$validar++;	
								}else{
									$Resultado2.='#Salida Externa: '.$InsFichaAccionSalidaExterna->PrvId.' ('.$item.')';
									$Resultado2.='#ERR_FCC_241';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionSalidaExterna->FsxEliminado==2){
								if($InsFichaAccionSalidaExterna->MtdEliminarFichaAccionSalidaExterna($InsFichaAccionSalidaExterna->FsxId)){
									$validar++;					
								}else{
									$Resultado2.='#Salida Externa: '.$InsFichaAccionSalidaExterna->PrvId.' ('.$item.')';
									$Resultado2.='#ERR_FCC_243';
								}
							}else{
								if($InsFichaAccionSalidaExterna->MtdEditarFichaAccionSalidaExterna()){
									$validar++;	
								}else{
									$Resultado2.='#Salida Externa: '.$InsFichaAccionSalidaExterna->PrvId.' ('.$item.')';
									$Resultado2.='#ERR_FCC_242';
								}
							}
						}	
						
						$item++;

					}
					
					if(count($this->FichaAccionSalidaExterna) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			

			if(!$error){
			
				if (!empty($this->FichaAccionTempario)){		
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionTempario = new ClsFichaAccionTempario();
							
					foreach ($this->FichaAccionTempario as $DatFichaAccionTempario){
										
						$InsFichaAccionTempario->FaeId = $DatFichaAccionTempario->FaeId;
						$InsFichaAccionTempario->FccId = $this->FccId;
						$InsFichaAccionTempario->FaeCodigo = $DatFichaAccionTempario->FaeCodigo;
						$InsFichaAccionTempario->FaeTiempo = $DatFichaAccionTempario->FaeTiempo;
						$InsFichaAccionTempario->FaeEstado = $DatFichaAccionTempario->FaeEstado;		
						$InsFichaAccionTempario->FaeTiempoCreacion = $DatFichaAccionTempario->FaeTiempoCreacion;
						$InsFichaAccionTempario->FaeTiempoModificacion = $DatFichaAccionTempario->FaeTiempoModificacion;
						$InsFichaAccionTempario->FaeEliminado = $DatFichaAccionTempario->FaeEliminado;
						
						if(empty($InsFichaAccionTempario->FaeId)){
							if($InsFichaAccionTempario->FaeEliminado<>2){
								if($InsFichaAccionTempario->MtdRegistrarFichaAccionTempario()){
									$validar++;	
								}else{
									$Resultado2.='#Tempario: '.$InsFichaAccionTempario->FaeDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_271';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionTempario->FaeEliminado==2){
								if($InsFichaAccionTempario->MtdEliminarFichaAccionTempario($InsFichaAccionTempario->FaeId)){
									$validar++;					
								}else{
									$Resultado2.='#Tempario: '.$InsFichaAccionTempario->FaeDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_273';
								}
							}else{
								if($InsFichaAccionTempario->MtdEditarFichaAccionTempario()){
									$validar++;	
								}else{
									$Resultado2.='#Tempario: '.$InsFichaAccionTempario->FaeDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_272';
								}
							}
						}	
						
						$item++;

					}
					
					if(count($this->FichaAccionTempario) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
	
			
			if(!$error){
			
				if (!empty($this->FichaAccionProducto)){								

					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);

					$validar = 0;	
					$item = 1;			
					$InsFichaAccionProducto = new ClsFichaAccionProducto();
							
					foreach ($this->FichaAccionProducto as $DatFichaAccionProducto){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatFichaAccionProducto->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						
						$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
						$InsFichaAccionProducto->FccId = $this->FccId;
						$InsFichaAccionProducto->ProId = $DatFichaAccionProducto->ProId;
						$InsFichaAccionProducto->UmeId = $DatFichaAccionProducto->UmeId;
						
						$InsFichaAccionProducto->FaaId = $DatFichaAccionProducto->FaaId;
						
						$InsFichaAccionProducto->FapCantidad = ($DatFichaAccionProducto->FapCantidad+0);
						$InsFichaAccionProducto->FapCantidadReal = $DatFichaAccionProducto->FapCantidadReal;
						
						$InsFichaAccionProducto->FapAccion = $DatFichaAccionProducto->FapAccion;
						
						$InsFichaAccionProducto->FapVerificar1 = $DatFichaAccionProducto->FapVerificar1;
						$InsFichaAccionProducto->FapVerificar2 = $DatFichaAccionProducto->FapVerificar2;
						$InsFichaAccionProducto->FapEstado = $DatFichaAccionProducto->FapEstado;
						$InsFichaAccionProducto->FapTiempoCreacion = $DatFichaAccionProducto->FapTiempoCreacion;
						$InsFichaAccionProducto->FapTiempoModificacion = $DatFichaAccionProducto->FapTiempoModificacion;
						$InsFichaAccionProducto->FapEliminado = $DatFichaAccionProducto->FapEliminado;
						
							//deb($InsFichaAccionProducto->FapCantidadReal);		
							
									if(empty($InsFichaAccionProducto->FapId)){
										if($InsFichaAccionProducto->FapEliminado<>2){
											
											if(!empty($InsFichaAccionProducto->ProId)){
												
											if($InsFichaAccionProducto->MtdRegistrarFichaAccionProducto()){
												$validar++;	
											}else{
												$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado2.='#ERR_FCC_211';
												//$Resultado2.='#\n';
											}
															
															
/*												if(!empty($InsFichaAccionProducto->UmeId)){
													if(!empty($InsFichaAccionProducto->FapCantidad)){
														if(!empty($InsFichaAccionProducto->FapCantidadReal)){

															if($InsFichaAccionProducto->MtdRegistrarFichaAccionProducto()){
																$validar++;	
															}else{
																$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
																$Resultado2.='#ERR_FCC_211';
																//$Resultado2.='#\n';
															}
											
														}else{
															$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
															$Resultado2.='#ERR_FCC_215';
															//$Resultado2.='#\n';
														}
													}else{
															$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
															$Resultado2.='#ERR_FCC_217';
															//$Resultado2.='#\n';
													}
												}else{
													$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado2.='#ERR_FCC_214';
													//$Resultado2.='#\n';
												}*/
											}else{
												$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado2.='#ERR_FCC_216';
												//$Resultado2.='#\n';
											}
											

											
											
										}else{
											$validar++;
										}
									}else{						
										if($InsFichaAccionProducto->FapEliminado==2){
											if($InsFichaAccionProducto->MtdEliminarFichaAccionProducto($InsFichaAccionProducto->FapId)){
												$validar++;					
											}else{
												$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado2.='#ERR_FCC_213';
												//$Resultado2.='#\n';
												
											}
										}else{
											
											if($InsFichaAccionProducto->FapAccion=="X"){

												if($InsFichaAccionProducto->MtdEditarFichaAccionProducto()){
													$validar++;	
												}else{
													$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado2.='#ERR_FCC_212';
													//$Resultado2.='#\n';
												}
																												
											}else{

												if(!empty($InsFichaAccionProducto->ProId)){
													
													
													if($InsFichaAccionProducto->MtdEditarFichaAccionProducto()){
														$validar++;	
													}else{
														$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
														$Resultado2.='#ERR_FCC_212';
														//$Resultado2.='#\n';
													}
																
																
													/*
													if(!empty($InsFichaAccionProducto->UmeId)){
														if(!empty($InsFichaAccionProducto->FapCantidad)){
															if(!empty($InsFichaAccionProducto->FapCantidadReal)){
																
																if($InsFichaAccionProducto->MtdEditarFichaAccionProducto()){
																	$validar++;	
																}else{
																	$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
																	$Resultado2.='#ERR_FCC_212';
																	//$Resultado2.='#\n';
																}
																
															}else{
																$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
																$Resultado2.='#ERR_FCC_215';
																//$Resultado2.='#\n';
															}
														}else{
																$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
																$Resultado2.='#ERR_FCC_217';
																//$Resultado2.='#\n';
														}
													}else{
														$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
														$Resultado2.='#ERR_FCC_214';
														//$Resultado2.='#\n';
													}
													*/
												}else{
													$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado2.='#ERR_FCC_216';
													//$Resultado2.='#\n';
												}
												
												
													
											}


											
											
										}
									}
									
								

						$item++;							
					}
					
					if(count($this->FichaAccionProducto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			//echo "A: ".count($this->FichaAccionProducto)." - B: ".$validar;
			//echo "<br>";

			
			
			if(!$error){
			
				if (!empty($this->FichaAccionSuministro)){								

					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);

					$validar = 0;	
					$item = 1;			
					$InsFichaAccionSuministro = new ClsFichaAccionSuministro();
							
					foreach ($this->FichaAccionSuministro as $DatFichaAccionSuministro){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatFichaAccionSuministro->ProId;
						$InsProducto->MtdObtenerProducto(false);

						
						$InsFichaAccionSuministro->FasId = $DatFichaAccionSuministro->FasId;
						$InsFichaAccionSuministro->FccId = $this->FccId;
						$InsFichaAccionSuministro->ProId = $DatFichaAccionSuministro->ProId;
						$InsFichaAccionSuministro->UmeId = $DatFichaAccionSuministro->UmeId;
						
						$InsFichaAccionSuministro->FaaId = $DatFichaAccionSuministro->FaaId;
						
						$InsFichaAccionSuministro->FasCantidad = ($DatFichaAccionSuministro->FasCantidad+0);
						$InsFichaAccionSuministro->FasCantidadReal = $DatFichaAccionSuministro->FasCantidadReal;
						$InsFichaAccionSuministro->FasVerificar1 = $DatFichaAccionSuministro->FasVerificar1;
						$InsFichaAccionSuministro->FasVerificar2 = $DatFichaAccionSuministro->FasVerificar2;
						$InsFichaAccionSuministro->FasEstado = $DatFichaAccionSuministro->FasEstado;
						$InsFichaAccionSuministro->FasTiempoCreacion = $DatFichaAccionSuministro->FasTiempoCreacion;
						$InsFichaAccionSuministro->FasTiempoModificacion = $DatFichaAccionSuministro->FasTiempoModificacion;
						$InsFichaAccionSuministro->FasEliminado = $DatFichaAccionSuministro->FasEliminado;
						
						
							
								

									if(empty($InsFichaAccionSuministro->FasId)){
										if($InsFichaAccionSuministro->FasEliminado<>2){
											



										if(!empty($InsFichaAccionSuministro->ProId)){
												if(!empty($InsFichaAccionSuministro->UmeId)){
													if(!empty($InsFichaAccionSuministro->FasCantidad)){
														if(!empty($InsFichaAccionSuministro->FasCantidadReal)){

															if($InsFichaAccionSuministro->MtdRegistrarFichaAccionSuministro()){
																$validar++;	
															}else{
																$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
																$Resultado2.='#ERR_FCC_231';																
															}
											
														}else{
															$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
															$Resultado2.='#ERR_FCC_235';
															//$Resultado2.='#\n';
														}
													}else{
															$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
															$Resultado2.='#ERR_FCC_237';
															//$Resultado2.='#\n';
													}
												}else{
													$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado2.='#ERR_FCC_234';
													//$Resultado2.='#\n';
												}
											}else{
												$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado2.='#ERR_FCC_236';
												//$Resultado2.='#\n';
											}
											
											
										}else{
											$validar++;
										}
									}else{						
										if($InsFichaAccionSuministro->FasEliminado==2){
											if($InsFichaAccionSuministro->MtdEliminarFichaAccionSuministro($InsFichaAccionSuministro->FasId)){
												$validar++;					
											}else{
												$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado2.='#ERR_FCC_233';
											}
										}else{
											
											
										if(!empty($InsFichaAccionSuministro->ProId)){
												if(!empty($InsFichaAccionSuministro->UmeId)){
													if(!empty($InsFichaAccionSuministro->FasCantidad)){
														if(!empty($InsFichaAccionSuministro->FasCantidadReal)){

															if($InsFichaAccionSuministro->MtdEditarFichaAccionSuministro()){
																$validar++;	
															}else{
																$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
																$Resultado2.='#ERR_FCC_232';
															}
															
														}else{
															$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
															$Resultado2.='#ERR_FCC_235';
															//$Resultado2.='#\n';
														}
													}else{
															$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
															$Resultado2.='#ERR_FCC_237';
															//$Resultado2.='#\n';
													}
												}else{
													$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado2.='#ERR_FCC_234';
													//$Resultado2.='#\n';
												}
											}else{
												$Resultado2.='#Suministro: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado2.='#ERR_FCC_236';
												//$Resultado2.='#\n';
											}
											
											
											
										}
									}	
									
									
						
						
						
						$item++;
														
					}
					
					if(count($this->FichaAccionSuministro) <> $validar ){
						$error = true;
					}					
								
				}				
			}	















			if(!$error){
			
				if (!empty($this->FichaAccionFoto)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
					
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionFoto = new ClsFichaAccionFoto();
							
					foreach ($this->FichaAccionFoto as $DatFichaAccionFoto){
										
						$InsFichaAccionFoto->FafId = $DatFichaAccionFoto->FafId;
						$InsFichaAccionFoto->FccId = $this->FccId;
						$InsFichaAccionFoto->FafArchivo = $DatFichaAccionFoto->FafArchivo;
						$InsFichaAccionFoto->FafEstado = $DatFichaAccionFoto->FafEstado;		
						$InsFichaAccionFoto->FafTiempoCreacion = $DatFichaAccionFoto->FafTiempoCreacion;
						$InsFichaAccionFoto->FafTiempoModificacion = $DatFichaAccionFoto->FafTiempoModificacion;
						$InsFichaAccionFoto->FafEliminado = $DatFichaAccionFoto->FafEliminado;
						
						if(empty($InsFichaAccionFoto->FafId)){
							if($InsFichaAccionFoto->FafEliminado<>2){
								if($InsFichaAccionFoto->MtdRegistrarFichaAccionFoto()){
									$validar++;	
								}else{
									$Resultado2.='#Foto: '.$InsFichaAccionFoto->FafArchivo.' ('.$item.')';
									$Resultado2.='#ERR_FCC_221';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionFoto->FafEliminado==2){
								if($InsFichaAccionFoto->MtdEliminarFichaAccionFoto($InsFichaAccionFoto->FafId)){
									$validar++;					
								}else{
									$Resultado2.='#Foto: '.$InsFichaAccionFoto->FafArchivo.' ('.$item.')';
									$Resultado2.='#ERR_FCC_223';
								}
							}else{
								if($InsFichaAccionFoto->MtdEditarFichaAccionFoto()){
									$validar++;	
								}else{
									$Resultado2.='#Foto: '.$InsFichaAccionFoto->FafArchivo.' ('.$item.')';
									$Resultado2.='#ERR_FCC_222';
								}
							}
						}	
						
						$item++;

					}
					
					if(count($this->FichaAccionFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			
			
			
			
			
			
			
			if($error) {		

				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}	
			
				return false;
			} else {			

				
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();								
				}	


				$this->MtdAuditarFichaAccion(2,"Se edito la SUB ORDEN DE TRABAJO",$this);		
				return true;
			}	
				
		}	
		










	public function MtdEditarTrabajoTerminado() {

		global $Resultado;
		$error = false;

			$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = $this->FimId;
			$InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidad();
			
			$InsModalidadIngreso = new ClsModalidadIngreso();
			$InsModalidadIngreso->MinId = $InsFichaIngresoModalidad->MinId;
			$InsModalidadIngreso->MtdObtenerModalidadIngreso();
			
			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}
				
			$sql = 'UPDATE tblfccfichaaccion SET
			FccManoObra = '.($this->FccManoObra).',	
			FccManoObraDetalle = "'.($this->FccManoObraDetalle).'",	
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'

			FccTiempoModificacion = NOW()
			WHERE FccId = "'.($this->FccId).'";';			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			//$Resultado2.='#\n';
			$Resultado2.='#::: Modalidad de Ingreso: '.strtoupper($InsModalidadIngreso->MinNombre);
			
			if(!$resultado) {							
				$error = true;
			} 			
				
			
			if($error) {		

				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}	
			
				return false;
			} else {			

				
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();								
				}	


				$this->MtdAuditarFichaAccion(2,"Se edito la SUB ORDEN DE TRABAJO",$this);		
				return true;
			}	
				
		}	
		



/*
	public function MtdFichaAccionEditarManoObra($oTransaccion=TRUE) {

		global $Resultado;
		$error = false;

			$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = $this->FimId;
			$InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidad();
			
			$InsModalidadIngreso = new ClsModalidadIngreso();
			$InsModalidadIngreso->MinId = $InsFichaIngresoModalidad->MinId;
			$InsModalidadIngreso->MtdObtenerModalidadIngreso();
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}
				
			$sql = 'UPDATE tblfccfichaaccion SET
			FccManoObra = '.($this->FccManoObra).',	
			FccManoObraDetalle = "'.($this->FccManoObraDetalle).'",			
			FccTiempoModificacion = NOW()
			WHERE FccId = "'.($this->FccId).'";';			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			$Resultado2.='#::: Modalidad de Ingreso: '.strtoupper($InsModalidadIngreso->MinNombre);
			
			if(!$resultado) {							
				$error = true;
			} 			
				
			
			if($error) {		

				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}	
			
				return false;
			} else {			

				
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();								
				}	


				$this->MtdAuditarFichaAccion(2,"Se edito la SUB ORDEN DE TRABAJO",$this);		
				return true;
			}	
				
		}	*/
		


	public function MtdTrabajarFichaAccion() {

		global $Resultado;
		$Resultado2 = "";
		
		$error = false;
  
			$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = $this->FimId;
			$InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidad();
			
			$InsModalidadIngreso = new ClsModalidadIngreso();
			$InsModalidadIngreso->MinId = $InsFichaIngresoModalidad->MinId;
			$InsModalidadIngreso->MtdObtenerModalidadIngreso();

			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}
				
			$sql = 'UPDATE tblfccfichaaccion SET
			FccFecha = "'.($this->FccFecha).'",
			FccObservacion = "'.($this->FccObservacion).'",
			FccCausa = "'.($this->FccCausa).'",
			FccPedido = "'.($this->FccPedido).'",
			FccSolucion = "'.($this->FccSolucion).'",
			
			FccSolucion = "'.($this->FccSolucion).'",
			FccComprobanteNumero = "'.($this->FccComprobanteNumero).'",
			'.(empty($this->FccComprobanteFecha)?'FccComprobanteFecha = NULL, ':'FccComprobanteFecha = "'.$this->FccComprobanteFecha.'",').'
			 
			
			FccTiempoModificacion = "'.($this->FccTiempoModificacion).'"
			WHERE FccId = "'.($this->FccId).'";';			

//FccManoObra = '.($this->FccManoObra).',
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			////$Resultado2.='#\n';
			//$Resultado2.='#::: Modalidad de Ingreso: '.strtoupper($InsModalidadIngreso->MinNombre);
			$Resultado2.='#<b>'.strtoupper($InsModalidadIngreso->MinNombre).'</b>';

			if(!$resultado) {							
				$error = true;
			} 			
				
			
			if(!$error){
			
				if (!empty($this->FichaAccionSalidaExterna)){		
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionSalidaExterna = new ClsFichaAccionSalidaExterna();
							
					foreach ($this->FichaAccionSalidaExterna as $DatFichaAccionSalidaExterna){
										
						$InsFichaAccionSalidaExterna->FsxId = $DatFichaAccionSalidaExterna->FsxId;
						$InsFichaAccionSalidaExterna->FccId = $this->FccId;
						$InsFichaAccionSalidaExterna->PrvId = $DatFichaAccionSalidaExterna->PrvId;
						$InsFichaAccionSalidaExterna->FsxFechaSalida = $DatFichaAccionSalidaExterna->FsxFechaSalida;
						$InsFichaAccionSalidaExterna->FsxFechaFinalizacion = $DatFichaAccionSalidaExterna->FsxFechaFinalizacion;
						$InsFichaAccionSalidaExterna->FsxEstado = $DatFichaAccionSalidaExterna->FsxEstado;		
						$InsFichaAccionSalidaExterna->FsxTiempoCreacion = $DatFichaAccionSalidaExterna->FsxTiempoCreacion;
						$InsFichaAccionSalidaExterna->FsxTiempoModificacion = $DatFichaAccionSalidaExterna->FsxTiempoModificacion;
						$InsFichaAccionSalidaExterna->FsxEliminado = $DatFichaAccionSalidaExterna->FsxEliminado;
						
						if(empty($InsFichaAccionSalidaExterna->FsxId)){
							if($InsFichaAccionSalidaExterna->FsxEliminado<>2){
								if($InsFichaAccionSalidaExterna->MtdRegistrarFichaAccionSalidaExterna()){
									$validar++;	
								}else{
									$Resultado2.='#Salida Externa: '.$InsFichaAccionSalidaExterna->PrvId.' ('.$item.')';
									$Resultado2.='#ERR_FCC_241';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionSalidaExterna->FsxEliminado==2){
								if($InsFichaAccionSalidaExterna->MtdEliminarFichaAccionSalidaExterna($InsFichaAccionSalidaExterna->FsxId)){
									$validar++;					
								}else{
									$Resultado2.='#Salida Externa: '.$InsFichaAccionSalidaExterna->PrvId.' ('.$item.')';
									$Resultado2.='#ERR_FCC_243';
								}
							}else{
								if($InsFichaAccionSalidaExterna->MtdEditarFichaAccionSalidaExterna()){
									$validar++;	
								}else{
									$Resultado2.='#Salida Externa: '.$InsFichaAccionSalidaExterna->PrvId.' ('.$item.')';
									$Resultado2.='#ERR_FCC_242';
								}
							}
						}	
						
						$item++;

					}
					
					if(count($this->FichaAccionSalidaExterna) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
						
			//deb("test");
			//deb($this->FichaAccionTarea);
			
			if(!$error){
			
				if (!empty($this->FichaAccionTarea)){		
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionTarea = new ClsFichaAccionTarea();
							
					foreach ($this->FichaAccionTarea as $DatFichaAccionTarea){
										
						$InsFichaAccionTarea->FatId = $DatFichaAccionTarea->FatId;
						$InsFichaAccionTarea->FccId = $this->FccId;
						$InsFichaAccionTarea->FitId = $DatFichaAccionTarea->FitId;
						$InsFichaAccionTarea->FatDescripcion = $DatFichaAccionTarea->FatDescripcion;
						
						$InsFichaAccionTarea->FatEspecificacion = $DatFichaAccionTarea->FatEspecificacion;
						$InsFichaAccionTarea->FatCosto = $DatFichaAccionTarea->FatCosto;
						
						$InsFichaAccionTarea->FatAccion = $DatFichaAccionTarea->FatAccion;
						$InsFichaAccionTarea->FatVerificar1 = $DatFichaAccionTarea->FatVerificar1;
						$InsFichaAccionTarea->FatVerificar2 = $DatFichaAccionTarea->FatVerificar2;

						$InsFichaAccionTarea->FatEstado = $DatFichaAccionTarea->FatEstado;		
						$InsFichaAccionTarea->FatTiempoCreacion = $DatFichaAccionTarea->FatTiempoCreacion;
						$InsFichaAccionTarea->FatTiempoModificacion = $DatFichaAccionTarea->FatTiempoModificacion;
						$InsFichaAccionTarea->FatEliminado = $DatFichaAccionTarea->FatEliminado;
						
						if(empty($InsFichaAccionTarea->FatId)){
							if($InsFichaAccionTarea->FatEliminado<>2){
								if($InsFichaAccionTarea->MtdRegistrarFichaAccionTarea()){
									$validar++;	
								}else{
									$Resultado2.='#Tarea: '.$InsFichaAccionTarea->FatDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_201';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionTarea->FatEliminado==2){
								if($InsFichaAccionTarea->MtdEliminarFichaAccionTarea($InsFichaAccionTarea->FatId)){
									$validar++;					
								}else{
									$Resultado2.='#Tarea: '.$InsFichaAccionTarea->FatDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_203';
								}
							}else{
								if($InsFichaAccionTarea->MtdEditarFichaAccionTarea()){
									$validar++;	
								}else{
									$Resultado2.='#Tarea: '.$InsFichaAccionTarea->FatDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_202';
								}
							}
						}	
						
						$item++;

					}
					
					if(count($this->FichaAccionTarea) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if(!$error){
			
				if (!empty($this->FichaAccionTempario)){		
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionTempario = new ClsFichaAccionTempario();
							
					foreach ($this->FichaAccionTempario as $DatFichaAccionTempario){
										
						$InsFichaAccionTempario->FaeId = $DatFichaAccionTempario->FaeId;
						$InsFichaAccionTempario->FccId = $this->FccId;
						$InsFichaAccionTempario->FaeCodigo = $DatFichaAccionTempario->FaeCodigo;
						$InsFichaAccionTempario->FaeTiempo = $DatFichaAccionTempario->FaeTiempo;
						$InsFichaAccionTempario->FaeEstado = $DatFichaAccionTempario->FaeEstado;		
						$InsFichaAccionTempario->FaeTiempoCreacion = $DatFichaAccionTempario->FaeTiempoCreacion;
						$InsFichaAccionTempario->FaeTiempoModificacion = $DatFichaAccionTempario->FaeTiempoModificacion;
						$InsFichaAccionTempario->FaeEliminado = $DatFichaAccionTempario->FaeEliminado;
						
						if(empty($InsFichaAccionTempario->FaeId)){
							if($InsFichaAccionTempario->FaeEliminado<>2){
								if($InsFichaAccionTempario->MtdRegistrarFichaAccionTempario()){
									$validar++;	
								}else{
									$Resultado2.='#Tempario: '.$InsFichaAccionTempario->FaeDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_271';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionTempario->FaeEliminado==2){
								if($InsFichaAccionTempario->MtdEliminarFichaAccionTempario($InsFichaAccionTempario->FaeId)){
									$validar++;					
								}else{
									$Resultado2.='#Tempario: '.$InsFichaAccionTempario->FaeDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_273';
								}
							}else{
								if($InsFichaAccionTempario->MtdEditarFichaAccionTempario()){
									$validar++;	
								}else{
									$Resultado2.='#Tempario: '.$InsFichaAccionTempario->FaeDescripcion.' ('.$item.')';
									$Resultado2.='#ERR_FCC_272';
								}
							}
						}	
						
						$item++;

					}
					
					if(count($this->FichaAccionTempario) <> $validar ){
						$error = true;
					}					
								
				}				
			}	


			
			if(!$error){
			
				if (!empty($this->FichaAccionProducto)){								

					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);

					$validar = 0;	
					$item = 1;			
					$InsFichaAccionProducto = new ClsFichaAccionProducto();
							
					foreach ($this->FichaAccionProducto as $DatFichaAccionProducto){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatFichaAccionProducto->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
						$InsFichaAccionProducto->FccId = $this->FccId;
						$InsFichaAccionProducto->ProId = $DatFichaAccionProducto->ProId;
						$InsFichaAccionProducto->UmeId = $DatFichaAccionProducto->UmeId;
						
						$InsFichaAccionProducto->FaaId = $DatFichaAccionProducto->FaaId;
						
						$InsFichaAccionProducto->FapCantidad = ($DatFichaAccionProducto->FapCantidad+0);
						$InsFichaAccionProducto->FapCantidadReal = $DatFichaAccionProducto->FapCantidadReal;
						
						$InsFichaAccionProducto->FapAccion = $DatFichaAccionProducto->FapAccion;
						
						$InsFichaAccionProducto->FapVerificar1 = $DatFichaAccionProducto->FapVerificar1;
						$InsFichaAccionProducto->FapVerificar2 = $DatFichaAccionProducto->FapVerificar2;
						$InsFichaAccionProducto->FapEstado = $DatFichaAccionProducto->FapEstado;
						$InsFichaAccionProducto->FapTiempoCreacion = $DatFichaAccionProducto->FapTiempoCreacion;
						$InsFichaAccionProducto->FapTiempoModificacion = $DatFichaAccionProducto->FapTiempoModificacion;
						$InsFichaAccionProducto->FapEliminado = $DatFichaAccionProducto->FapEliminado;
						
							//deb($InsFichaAccionProducto->FapCantidadReal);		
							
									if(empty($InsFichaAccionProducto->FapId)){
										if($InsFichaAccionProducto->FapEliminado<>2){
											
											if(!empty($InsFichaAccionProducto->ProId)){
												
												if($InsFichaAccionProducto->MtdRegistrarFichaAccionProducto()){
													$validar++;	
												}else{
													$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado2.='#ERR_FCC_211';
													//$Resultado2.='#\n';
												}
											
											}else{
												$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado2.='#ERR_FCC_216';
												//$Resultado2.='#\n';
											}
											
										}else{
											$validar++;
										}
									}else{						
										if($InsFichaAccionProducto->FapEliminado==2){
											if($InsFichaAccionProducto->MtdEliminarFichaAccionProducto($InsFichaAccionProducto->FapId)){
												$validar++;					
											}else{
												$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
												$Resultado2.='#ERR_FCC_213';
												//$Resultado2.='#\n';
												
											}
										}else{
											
											if($InsFichaAccionProducto->FapAccion=="X"){

												if($InsFichaAccionProducto->MtdEditarFichaAccionProducto()){
													$validar++;	
												}else{
													$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado2.='#ERR_FCC_212';
													//$Resultado2.='#\n';
												}
																												
											}else{

												if(!empty($InsFichaAccionProducto->ProId)){
													
													
													if($InsFichaAccionProducto->MtdEditarFichaAccionProducto()){
														$validar++;	
													}else{
														$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
														$Resultado2.='#ERR_FCC_212';
														//$Resultado2.='#\n';
													}	
																
												}else{
													$Resultado2.='#Producto: '.($InsProducto->ProNombre).' ('.$item.')';
													$Resultado2.='#ERR_FCC_216';
													//$Resultado2.='#\n';
												}
												
													
											}


											
											
										}
									}
									
								

						$item++;							
					}
					
					if(count($this->FichaAccionProducto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if(!$error){
			
				if (!empty($this->FichaAccionMantenimiento)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
							
					foreach ($this->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
										
										
						$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
						$InsPlanMantenimientoTarea->PmtId = $DatFichaAccionMantenimiento->PmtId;
						$InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTarea();
						
						
						$InsFichaAccionMantenimiento->FaaId = $DatFichaAccionMantenimiento->FaaId;
						$InsFichaAccionMantenimiento->FccId = $this->FccId;
						$InsFichaAccionMantenimiento->PmtId = $DatFichaAccionMantenimiento->PmtId;
						
						$InsFichaAccionMantenimiento->FiaId = $DatFichaAccionMantenimiento->FiaId;
						
						$InsFichaAccionMantenimiento->ProId = $DatFichaAccionMantenimiento->ProId;
						$InsFichaAccionMantenimiento->UmeId = $DatFichaAccionMantenimiento->UmeId;
						$InsFichaAccionMantenimiento->FaaCantidad = $DatFichaAccionMantenimiento->FaaCantidad;

						$InsFichaAccionMantenimiento->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
						$InsFichaAccionMantenimiento->FaaAccion = $DatFichaAccionMantenimiento->FaaAccion;
						$InsFichaAccionMantenimiento->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
						$InsFichaAccionMantenimiento->FaaVerificar1 = $DatFichaAccionMantenimiento->FaaVerificar1;
						$InsFichaAccionMantenimiento->FaaVerificar2 = $DatFichaAccionMantenimiento->FaaVerificar2;
						
						$InsFichaAccionMantenimiento->FaaEstado = $DatFichaAccionMantenimiento->FaaEstado;				
						$InsFichaAccionMantenimiento->FaaTiempoCreacion = $DatFichaAccionMantenimiento->FaaTiempoCreacion;
						$InsFichaAccionMantenimiento->FaaTiempoModificacion = $DatFichaAccionMantenimiento->FaaTiempoModificacion;
						$InsFichaAccionMantenimiento->FaaEliminado = $DatFichaAccionMantenimiento->FaaEliminado;
						
						if(empty($InsFichaAccionMantenimiento->FaaId)){
							if($InsFichaAccionMantenimiento->FaaEliminado<>2){
								
								if($InsFichaAccionMantenimiento->MtdRegistrarFichaAccionMantenimiento()){
									$validar++;	
								}else{
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).'';
									//$Resultado2.='#ERR_FCC_281';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionMantenimiento->FaaEliminado==2){
								if($InsFichaAccionMantenimiento->MtdEliminarFichaAccionMantenimiento($InsFichaAccionMantenimiento->FaaId)){
									$validar++;					
								}else{
									$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).'';
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									//$Resultado2.='#ERR_FCC_283';
								}
							}else{
								if($InsFichaAccionMantenimiento->MtdEditarFichaAccionMantenimiento()){
									$validar++;	
								}else{
									$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).'';
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									//$Resultado2.='#ERR_FCC_282';
								}
							}
						}		
						
						
						$item++;
													
					}
					
					if(count($this->FichaAccionMantenimiento) <> $validar ){
						$error = true;
					}					
								
				}	
							
			}
			
			
			


			if(!$error){
			
				if (!empty($this->FichaAccionFoto)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionFoto = new ClsFichaAccionFoto();
							
					foreach ($this->FichaAccionFoto as $DatFichaAccionFoto){
										
						$InsFichaAccionFoto->FafId = $DatFichaAccionFoto->FafId;
						$InsFichaAccionFoto->FccId = $this->FccId;
						$InsFichaAccionFoto->FafArchivo = $DatFichaAccionFoto->FafArchivo;
						$InsFichaAccionFoto->FafEstado = $DatFichaAccionFoto->FafEstado;		
						$InsFichaAccionFoto->FafTiempoCreacion = $DatFichaAccionFoto->FafTiempoCreacion;
						$InsFichaAccionFoto->FafTiempoModificacion = $DatFichaAccionFoto->FafTiempoModificacion;
						$InsFichaAccionFoto->FafEliminado = $DatFichaAccionFoto->FafEliminado;
						
						if(empty($InsFichaAccionFoto->FafId)){
							if($InsFichaAccionFoto->FafEliminado<>2){
								if($InsFichaAccionFoto->MtdRegistrarFichaAccionFoto()){
									$validar++;	
								}else{
									$Resultado2.='#Foto: '.$InsFichaAccionFoto->FafArchivo.' ('.$item.')';
									$Resultado2.='#ERR_FCC_221';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionFoto->FafEliminado==2){
								if($InsFichaAccionFoto->MtdEliminarFichaAccionFoto($InsFichaAccionFoto->FafId)){
									$validar++;					
								}else{
									$Resultado2.='#Foto: '.$InsFichaAccionFoto->FafArchivo.' ('.$item.')';
									$Resultado2.='#ERR_FCC_223';
								}
							}else{
								if($InsFichaAccionFoto->MtdEditarFichaAccionFoto()){
									$validar++;	
								}else{
									$Resultado2.='#Foto: '.$InsFichaAccionFoto->FafArchivo.' ('.$item.')';
									$Resultado2.='#ERR_FCC_222';
								}
							}
						}	
						
						$item++;

					}
					
					if(count($this->FichaAccionFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			


			if($error) {		
				
				$Resultado = $Resultado2;
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}	
			
				return false;
			}else {	
				
//				$Resultado = ''; 
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();								
				}	

				$this->MtdAuditarFichaAccion(2,"Se adiciono la SUB ORDEN DE TRABAJO",$this);		
				return true;
			}	
				
		}	
		
		
	public function MtdCorregirFichaAccionMantenimiento() {

		global $Resultado;
		$Resultado2 = "";
		
		$error = false;
  
			$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = $this->FimId;
			$InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidad();
			
			$InsModalidadIngreso = new ClsModalidadIngreso();
			$InsModalidadIngreso->MinId = $InsFichaIngresoModalidad->MinId;
			$InsModalidadIngreso->MtdObtenerModalidadIngreso();

			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}
				
			if(!$error){
			
				if (!empty($this->FichaAccionMantenimiento)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
						
					$validar = 0;	
					$item = 1;			
					$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
							
					foreach ($this->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
										
										
						$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
						$InsPlanMantenimientoTarea->PmtId = $DatFichaAccionMantenimiento->PmtId;
						$InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTarea();
						
						
						$InsFichaAccionMantenimiento->FaaId = $DatFichaAccionMantenimiento->FaaId;
						$InsFichaAccionMantenimiento->FccId = $this->FccId;
						$InsFichaAccionMantenimiento->PmtId = $DatFichaAccionMantenimiento->PmtId;
						
						$InsFichaAccionMantenimiento->FiaId = $DatFichaAccionMantenimiento->FiaId;
						
						$InsFichaAccionMantenimiento->ProId = $DatFichaAccionMantenimiento->ProId;
						$InsFichaAccionMantenimiento->UmeId = $DatFichaAccionMantenimiento->UmeId;
						$InsFichaAccionMantenimiento->FaaCantidad = $DatFichaAccionMantenimiento->FaaCantidad;

						$InsFichaAccionMantenimiento->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
						$InsFichaAccionMantenimiento->FaaAccion = $DatFichaAccionMantenimiento->FaaAccion;
						$InsFichaAccionMantenimiento->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
						$InsFichaAccionMantenimiento->FaaVerificar1 = $DatFichaAccionMantenimiento->FaaVerificar1;
						$InsFichaAccionMantenimiento->FaaVerificar2 = $DatFichaAccionMantenimiento->FaaVerificar2;
						
						$InsFichaAccionMantenimiento->FaaEstado = $DatFichaAccionMantenimiento->FaaEstado;				
						$InsFichaAccionMantenimiento->FaaTiempoCreacion = $DatFichaAccionMantenimiento->FaaTiempoCreacion;
						$InsFichaAccionMantenimiento->FaaTiempoModificacion = $DatFichaAccionMantenimiento->FaaTiempoModificacion;
						$InsFichaAccionMantenimiento->FaaEliminado = $DatFichaAccionMantenimiento->FaaEliminado;
						
						if(empty($InsFichaAccionMantenimiento->FaaId)){
							if($InsFichaAccionMantenimiento->FaaEliminado<>2){
								
								if($InsFichaAccionMantenimiento->MtdRegistrarFichaAccionMantenimiento()){
									$validar++;	
								}else{
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).'';
									//$Resultado2.='#ERR_FCC_281';
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsFichaAccionMantenimiento->FaaEliminado==2){
								if($InsFichaAccionMantenimiento->MtdEliminarFichaAccionMantenimiento($InsFichaAccionMantenimiento->FaaId)){
									$validar++;					
								}else{
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).'';
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									//$Resultado2.='#ERR_FCC_283';
								}
							}else{
								if($InsFichaAccionMantenimiento->MtdEditarFichaAccionMantenimiento()){
									$validar++;	
								}else{
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).'';
									//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.')';
									//$Resultado2.='#ERR_FCC_282';
								}
							}
						}		
						
						
						$item++;
													
					}
					
					if(count($this->FichaAccionMantenimiento) <> $validar ){
						$error = true;
					}					
								
				}	
							
			}
			
			
			



			if($error) {		
				
				$Resultado = $Resultado2;
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}	
			
				return false;
			}else {	
				
//				$Resultado = ''; 
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();								
				}	

				$this->MtdAuditarFichaAccion(2,"Se corrigio la SUB ORDEN DE TRABAJO",$this);		
				return true;
			}	
				
		}	
		
		



	public function MtdVerificarExisteFichaAccion($oCampo,$oDato){

		$Respuesta =   NULL;
			
		 $sql = 'SELECT 
        FccId
        FROM tblfccfichaaccion
        WHERE '.$oCampo.' = "'.$oDato.'" LIMIT 1;';

        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['FccId'])){
				$Respuesta = $fila['FccId'];
			}

		}
        
		return $Respuesta;

    }			
		
		private function MtdAuditarFichaAccion($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
//			$InsAuditoria = new ClsAuditoria();
//			$InsAuditoria->AudCodigo = $this->FccId;
//
//			$InsAuditoria->UsuId = $this->UsuId;
//			$InsAuditoria->SucId = $this->SucId;
//			$InsAuditoria->AudAccion = $oAccion;
//			$InsAuditoria->AudDescripcion = $oDescripcion;
//			$InsAuditoria->AudDatos = $oDatos;
//			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
//			
//			if($InsAuditoria->MtdAuditoriaRegistrar()){
//				return true;
//			}else{
//				return false;	
//			}
			
			return true;
			
		}
		
		public function MtdEditarFichaAccionDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblfccfichaaccion SET 
			'.$oCampo.' = "'.($oDato).'",
			FccTiempoModificacion = NOW()
			WHERE FccId = "'.($oId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}
		
	
		public function MtdNotificarFichaAccionPedido($oFichaAccion,$oDestinatario){
		
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->FccId = $oFichaAccion;
			$this->MtdObtenerFichaAccion();
			
			$mensaje .= "NOTIFICACION DE PEDIDO DE TALLER:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Pedido.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->FinId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Cliente: <b>".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Fecha Registro: <b>".$this->FinFecha."</b>";				
			$mensaje .= "<br>";	
			
			$mensaje .= "VIN: <b>".$this->EinVIN."</b>";		
			$mensaje .= "<br>";	
			
			$mensaje .= "Marca/Modelo/Version: <b>".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre."</b>";		
			$mensaje .= "<br>";	
			
			$mensaje .= "Modalidad: <b>".$this->MinNombre."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Mecanico: <b>".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."</b>";	
			$mensaje .= "<br>";
		
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "<p>";
			$mensaje .= $this->FccPedido;
			$mensaje .= "</p>";
					
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"PEDIDO TALLER: O.T. Nro.: ".$this->FinId." - ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PeApellidoMaterno,$mensaje);
			
		}
		
		
		
		public function MtdNotificarFichaAccionMantenimiento($oFichaAccion,$oDestinatario){
			
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->FccId = $oFichaAccion;
			$this->MtdObtenerFichaAccion();
			
			$mensaje .= "NOTIFICACION DE FICHA DE MANTENIMIENTO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de ficha de mantenimiento.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->FinId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Cliente: <b>".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Fecha Registro: <b>".$this->FinFecha."</b>";				
			$mensaje .= "<br>";	
			
			$mensaje .= "VIN: <b>".$this->EinVIN."</b>";		
			$mensaje .= "<br>";	
			
			$mensaje .= "Marca/Modelo/Version: <b>".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre."</b>";		
			$mensaje .= "<br>";	
			
			$mensaje .= "Modalidad: <b>".$this->MinNombre."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Mecanico: <b>".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."</b>";	
			$mensaje .= "<br>";
		
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
		
		
	//		$ResFichaAccionMantenimiento = $InsFichaAccionMantenimiento->MtdObtenerFichaAccionMantenimientos(NULL,NULL,'PmtOrden','ASC',NULL,$this->FccId,NULL,NULL,false,NULL);
			
//			$this->FichaAccionMantenimiento = $ResFichaAccionMantenimiento['Datos'];
			
			$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();			
			$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
			$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

			
			if(!empty($ArrPlanMantenimientoSecciones)){
				foreach($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion){
					
					$MostrarSeccion = false;
					
					$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
					$ResFichaAccionMantenimiento = $InsFichaAccionMantenimiento->MtdObtenerFichaAccionMantenimientos(NULL,NULL,'PmtOrden','ASC',NULL,$this->FccId,NULL,NULL,false,NULL,$DatPlanMantenimientoSeccion->PmsId);
					$ArrFichaAccionMantenimientos = $ResFichaAccionMantenimiento['Datos'];
					
					if(!empty($ArrFichaAccionMantenimientos)){
						foreach($ArrFichaAccionMantenimientos as $DatFichaAccionMantenimiento){
							
							if(
							$DatFichaAccionMantenimiento->FaaAccion == "C" 
							or $DatFichaAccionMantenimiento->FaaAccion == "R" 
							or $DatFichaAccionMantenimiento->FaaAccion == "U" 
							or $DatFichaAccionMantenimiento->FaaAccion == "L"
							){
								
								$MostrarSeccion = true;
								break;
							}
					
						}
					}
					
					
					
					if(!empty($ArrFichaAccionMantenimientos) and $MostrarSeccion){
						
						$mensaje .= "<br><b>".strtoupper($DatPlanMantenimientoSeccion->PmsNombre)."</b>";
						$mensaje .= "<br>";
						
						foreach($ArrFichaAccionMantenimientos as $DatFichaAccionMantenimiento){
							
							if(
							$DatFichaAccionMantenimiento->FaaAccion == "C" 
							or $DatFichaAccionMantenimiento->FaaAccion == "R" 
							or $DatFichaAccionMantenimiento->FaaAccion == "U" 
							or $DatFichaAccionMantenimiento->FaaAccion == "L"
							){
								
								$mensaje .= "- ".$DatFichaAccionMantenimiento->PmtNombre." <b>[ ".$DatFichaAccionMantenimiento->FaaAccion." ]</b> ";
								$mensaje .= "<br>";
							
							}
					
						}
						
					}
					
					
			
				}
			}
			//MtdObtenerFichaAccionMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FaaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oNivel=NULL,$oSevero=false,$oAccion=NULL,$oPlanMantenimientoSeccion=NULL)
			
				
				

			/*if(!empty($this->FichaAccionMantenimiento)){
				foreach($this->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
					
					$mensaje .= $DatFichaAccionMantenimiento->PmtNombre." <b>[ ".$DatFichaAccionMantenimiento->FaaAccion." ]</b> ".$DatFichaAccionMantenimiento->PmsId;
					$mensaje .= "<br>";
							
				}
			}*/
				
		/*
			$mensaje .= "<p>";
			$mensaje .= $this->FccPedido;
			$mensaje .= "</p>";
			
			*/
		
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//echo $mensaje;
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"FICHA MANTENIMIENTO: O.T. Nro.: ".$this->FinId." - ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PeApellidoMaterno,$mensaje);
			
		}
		
		
		
	function FncFichaAccionGenerarTallerPedido($oFichaAccionId){
		
		global $EmpresaImpuestoVenta;
		global $EmpresaMonedaId;
		global $EmpresaMantenimientoPorcentajeManoObra;
		
		$Generar = true;
		//deb($oFichaAccionId);
		if(!empty($oFichaAccionId)){

			$this->FccId = $oFichaAccionId;
			$this->MtdObtenerFichaAccion();

			$InsTallerPedido = new ClsTallerPedido();
			$TallerPedidoId = $InsTallerPedido->MtdVerificarExisteTallerPedido("FccId",$oFichaAccionId);
			//deb($TallerPedidoId);
			if(empty($TallerPedidoId)){
		
		
		//deb(":3");
				$InsTallerPedido = new ClsTallerPedido();
				$InsTallerPedido->UsuId = $_SESSION['SesionId'];
				$InsTallerPedido->AmoId = NULL;
				$InsTallerPedido->SucId = $this->SucId;
				$InsTallerPedido->CliId = $this->CliId;
				$InsTallerPedido->TopId = "TOP-10000";
				
				
				$InsTallerPedido->AlmId = "ALM-10000";
				$InsTallerPedido->AmoFecha = date("Y-m-d");
				$InsTallerPedido->FccId = $this->FccId;
				
				$InsTallerPedido->MonId =  $EmpresaMonedaId;
				$InsTallerPedido->AmoTipoCambio =  NULL;
				
				
				
				if($this->MinSigla == "MA" ){
					$InsTallerPedido->AmoPorcentajeMantenimiento = 000;
				}else{
					$InsTallerPedido->AmoPorcentajeMantenimiento = 0;
				}
				$InsTallerPedido->AmoIncluyeImpuesto = 1;	
				$InsTallerPedido->AmoPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
				$InsTallerPedido->AmoSubTipo = 2;	
				$InsTallerPedido->AmoEstado = 1;
				$InsTallerPedido->AmoDescuento = 0;	
				$InsTallerPedido->AmoObservacion = date("d/m/Y H:i:s")." - Ficha autogenerada por sistema";
				$InsTallerPedido->AmoTiempoModificacion = date("Y-m-d H:i:s");
				$InsTallerPedido->AmoTotal = 0;
				
				$InsTallerPedido->TallerPedidoDetalle = array();
				
		
					if(!empty($this->FichaAccionProducto)){
						foreach($this->FichaAccionProducto as $DatFichaAccionProducto){					
		
						
							if(!empty($DatFichaAccionProducto->ProId) and ($DatFichaAccionProducto->FapAccion=="C" || $DatFichaAccionProducto->FapAccion=="") ){
								
								if(empty($DatFichaAccionProducto->UmeId)){
									
		
									$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();
									$ResProductoTipoUnidadMedida = $InsProductoTipoUnidadMedida->MtdObtenerProductoTipoUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC","1",2,$DatFichaAccionProducto->RtiId);
		$ArrProductoTipoUnidadMedidas = $ResProductoTipoUnidadMedida['Datos'];
		
			
									foreach($ArrProductoTipoUnidadMedidas as $DatProductoTipoUnidadMedida){
										
										$UnidadMedidaEquivalente = 0;
									
										if($DatFichaAccionProducto->UmeIdOrigen == $DatProductoTipoUnidadMedida->UmeId){
											$UnidadMedidaEquivalente = 1;
										}else{
											$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$DatProductoTipoUnidadMedida->UmeId,$DatFichaAccionProducto->UmeIdOrigen);
											
											$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
											
											foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
												$UnidadMedidaEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
											}
										}
										
									}
								   
									if(!empty($UnidadMedidaEquivalente)){
									
										$DatFichaAccionProducto->UmeId = $DatProductoTipoUnidadMedida->UmeId;
										
									}
			
		
								}
								
								
								$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
								
								$InsTallerPedidoDetalle1->FapId = $DatFichaAccionProducto->FapId;//AGREGADO 16-04-14
								
								$InsTallerPedidoDetalle1->ProId = $DatFichaAccionProducto->ProId;
								$InsTallerPedidoDetalle1->UmeId = $DatFichaAccionProducto->UmeId;
								
								
								
									
									$ListaPrecioCosto = 0;
									$InsTallerPedidoDetalle1->AmdUtilidad = 0;
									$InsTallerPedidoDetalle1->AmdValorTotal = 0;
									$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
		
									//OBTENIENDO LISTA DE PRECIOS
								if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){
		
									$InsListaPrecio = new ClsListaPrecio();
									$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
									$ArrListaPrecios = $ResListaPrecio['Datos'];
		
									foreach($ArrListaPrecios as $DatListaPrecio){
		
										$ListaPrecioCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
										$InsTallerPedidoDetalle1->AmdUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
										$InsTallerPedidoDetalle1->AmdValorTotal = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
										$InsTallerPedidoDetalle1->AmdPrecioVenta = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);//AGREGADO-28-02-14
		
									}
		
								}
								
								//EN CASO DE CAMPAÑAS
								//if($this->MinSigla == "GA" or $this->MinSigla == "CA" or $this->MinSigla == "PO"  or $this->MinSigla == "IF" or $this->MinSigla == "AD" or $this->MinSigla == "PP"){			
								if($this->MinSigla == "GA" or 
								$this->MinSigla == "CA" or 
								$this->MinSigla == "PO"  or 
								$this->MinSigla == "IF" or 
								$this->MinSigla == "AD" or 
								$this->MinSigla == "PP" or 
								$this->MinSigla == "OB"){		
								
									$InsTallerPedidoDetalle1->AmdUtilidad = 0;
									$InsTallerPedidoDetalle1->AmdValorTotal = $ListaPrecioCosto;
									$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdValorTotal + (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100) * $InsTallerPedidoDetalle1->AmdValorTotal);
									
								}
										
		
								$InsTallerPedidoDetalle1->AmdCosto = $DatFichaAccionProducto->ProCosto;								
								$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
								
								$InsTallerPedidoDetalle1->AmdCantidad = $DatFichaAccionProducto->FapCantidad;
		
								$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
									$InsProducto = new ClsProducto();
									$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
									$InsProducto->MtdObtenerProducto(false);
									
									$InsUnidadMedida = new ClsUnidadMedida();
									$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
									$InsUnidadMedida->MtdObtenerUnidadMedida();
		
									if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
									  $InsUnidadMedidaConversion->UmcEquivalente = 1;
									}else{
										
										$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
										$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
										$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
									  
										foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
											$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
										}
									}
		
									if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
									  $InsTallerPedidoDetalle1->AmdCantidadReal = round($InsTallerPedidoDetalle1->AmdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
									}else{
									  $InsTallerPedidoDetalle1->AmdCantidadReal = '';
									}
		
								$InsTallerPedidoDetalle1->AmdEstado = 3;
								$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdEliminado = 1;
									
		
								$InsTallerPedidoDetalle1->InsMysql = NULL;
		
								$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;
		
								$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
		
							}
		
						}
					}
					
					
										
					if(!empty($InsFichaAccion->FichaAccionSuministro)){
						foreach($InsFichaAccion->FichaAccionSuministro as $DatFichaAccionSuministro){					
		
		
								$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
		
								$InsTallerPedidoDetalle1->FapId = $DatFichaAccionSuministro->FapId;//AÑADIDO 21-09-15
		
								$InsTallerPedidoDetalle1->ProId = $DatFichaAccionSuministro->ProId;
								$InsTallerPedidoDetalle1->UmeId = $DatFichaAccionSuministro->UmeId;
		
									$ListaPrecioCosto = 0;
									$InsTallerPedidoDetalle1->AmdUtilidad = 0;
									$InsTallerPedidoDetalle1->AmdValorTotal = 0;
									$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
									
								if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){
		
									$InsListaPrecio = new ClsListaPrecio();
									$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
									$ArrListaPrecios = $ResListaPrecio['Datos'];
		
									foreach($ArrListaPrecios as $DatListaPrecio){
										
										$ListaPrecioCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
										$InsTallerPedidoDetalle1->AmdUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
										$InsTallerPedidoDetalle1->AmdValorTotal = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
										$InsTallerPedidoDetalle1->AmdPrecioVenta = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);//AGREGADO-28-02-14
		
									}
									
								}
								
								//EN CASO DE CAMPAÑAS
								if($this->MinSigla == "GA" or $this->MinSigla == "CA" or $this->MinSigla == "PO"  or $this->MinSigla == "IF" or $this->MinSigla == "AD" or $this->MinSigla == "PP" or $this->MinSigla == "OB" ){			
								
									$InsTallerPedidoDetalle1->AmdUtilidad = 0;
									$InsTallerPedidoDetalle1->AmdValorTotal = $ListaPrecioCosto;
									$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdValorTotal + (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100) * $InsTallerPedidoDetalle1->AmdValorTotal);
									
								}
								
								
								
								$InsTallerPedidoDetalle1->AmdCosto = $DatFichaAccionSuministro->ProCosto;
								$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
		
								$InsTallerPedidoDetalle1->AmdCantidad = $DatFichaAccionSuministro->FasCantidad;
		
								$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
									$InsProducto = new ClsProducto();
									$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
									$InsProducto->MtdObtenerProducto(false);
									
									$InsUnidadMedida = new ClsUnidadMedida();
									$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
									$InsUnidadMedida->MtdObtenerUnidadMedida();
		
									if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
									  $InsUnidadMedidaConversion->UmcEquivalente = 1;
									}else{
										
										$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
										$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
										$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
									  
										foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
											$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
										}

									}
		
									if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
									  $InsTallerPedidoDetalle1->AmdCantidadReal = round($InsTallerPedidoDetalle1->AmdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
									}else{
									  $InsTallerPedidoDetalle1->AmdCantidadReal = '';
									}
		
		
								$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
								$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");	
								$InsTallerPedidoDetalle1->AmdEliminado = 1;
		
								$InsTallerPedidoDetalle1->InsMysql = NULL;
		
								$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;
		
								$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
		
							
		
						}
					}
					
							
							if(!empty($InsFichaAccion->FichaAccionMantenimiento)){
								foreach($InsFichaAccion->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){					
			
									if(
									!empty($DatFichaAccionMantenimiento->ProId) and
									!empty($DatFichaAccionMantenimiento->UmeId) and 
									($DatFichaAccionMantenimiento->FaaAccion=="C" || $DatFichaAccionMantenimiento->FaaAccion=="R") ){
										
										$InsTallerPedidoDetalle1 = new ClsTallerPedidoDetalle();
										
										////deb($DatFichaAccionMantenimiento->UmeId);
										$InsTallerPedidoDetalle1->AmdUtilidad = 0;
										$InsTallerPedidoDetalle1->AmdValorTotal = 0;
										$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
										
										$InsTallerPedidoDetalle1->ProId = $DatFichaAccionMantenimiento->ProId;
										//$InsTallerPedidoDetalle1->ProCodigoOriginal = $DatFichaAccionMantenimiento->ProCodigoOriginal;
										//$InsTallerPedidoDetalle1->ProCodigoAltenativo = $DatFichaAccionMantenimiento->ProCodigoAltenativo;
										
										$InsTallerPedidoDetalle1->FapId = $DatFichaAccionMantenimiento->FapId;
										
										$InsTallerPedidoDetalle1->FaaId = $DatFichaAccionMantenimiento->FaaId;								
										$InsTallerPedidoDetalle1->UmeId = $DatFichaAccionMantenimiento->UmeId;
		
											$ListaPrecioCosto = 0;
											$InsTallerPedidoDetalle1->AmdUtilidad = 0;
											$InsTallerPedidoDetalle1->AmdValorTotal = 0;
											$InsTallerPedidoDetalle1->AmdPrecioVenta = 0;
		
		
										if(!empty($InsTallerPedidoDetalle1->ProId) and !empty($InsFichaIngreso->LtiId) and !empty($InsTallerPedidoDetalle1->UmeId)){
		
											$InsListaPrecio = new ClsListaPrecio();
											$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,"LprId",'ASC',"1",$InsTallerPedidoDetalle1->ProId,$InsFichaIngreso->LtiId,$InsTallerPedidoDetalle1->UmeId);
											$ArrListaPrecios = $ResListaPrecio['Datos'];
		
											foreach($ArrListaPrecios as $DatListaPrecio){
												
												$ListaPrecioCosto = (empty($DatListaPrecio->LprCosto)?0:$DatListaPrecio->LprCosto);
												$InsTallerPedidoDetalle1->AmdUtilidad = (empty($DatListaPrecio->LprUtilidad)?0:$DatListaPrecio->LprUtilidad);
												$InsTallerPedidoDetalle1->AmdValorTotal = (empty($DatListaPrecio->LprValorVenta)?0:$DatListaPrecio->LprValorVenta);
												$InsTallerPedidoDetalle1->AmdPrecioVenta = (empty($DatListaPrecio->LprPrecio)?0:$DatListaPrecio->LprPrecio);//AGREGADO-28-02-14
		
											}
											
										}
		
										//EN CASO DE CAMPAÑAS
										if($DatFichaIngresoModalidad->MinSigla == "GA" or $DatFichaIngresoModalidad->MinSigla == "CA" or $DatFichaIngresoModalidad->MinSigla == "PO" or $DatFichaIngresoModalidad->MinSigla == "IF" or $DatFichaIngresoModalidad->MinSigla == "AD" or $DatFichaIngresoModalidad->MinSigla == "PP" or $DatFichaIngresoModalidad->MinSigla == "OB"){			
										
											$InsTallerPedidoDetalle1->AmdUtilidad = 0;
											$InsTallerPedidoDetalle1->AmdValorTotal = $ListaPrecioCosto;
											$InsTallerPedidoDetalle1->AmdPrecioVenta = $InsTallerPedidoDetalle1->AmdValorTotal + (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100) * $InsTallerPedidoDetalle1->AmdValorTotal);
											
										}
										
										
										$InsTallerPedidoDetalle1->AmdCosto = $DatFichaAccionMantenimiento->ProCosto;
										$InsTallerPedidoDetalle1->AmdCostoExtraTotal = 0;
																		
										$InsTallerPedidoDetalle1->AmdCantidad = $DatFichaAccionMantenimiento->FapCantidad;
		
										$InsTallerPedidoDetalle1->AmdImporte = $InsTallerPedidoDetalle1->AmdPrecioVenta * $InsTallerPedidoDetalle1->AmdCantidad;
																					
											$InsProducto = new ClsProducto();													
											$InsProducto->ProId = $InsTallerPedidoDetalle1->ProId;
											$InsProducto->MtdObtenerProducto(false);
											
											$InsUnidadMedida = new ClsUnidadMedida();
											$InsUnidadMedida->UmeId = $InsTallerPedidoDetalle1->UmeId;
											$InsUnidadMedida->MtdObtenerUnidadMedida();
											
											if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
											  $InsUnidadMedidaConversion->UmcEquivalente = 1;
											}else{
												$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
												$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
												$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
											  
												foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
													$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
												}
											}
			
											if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
												$InsTallerPedidoDetalle1->AmdCantidadReal = round($InsTallerPedidoDetalle1->AmdCantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
											}else{
												$InsTallerPedidoDetalle1->AmdCantidadReal = '';
											}
		
										$InsTallerPedidoDetalle1->AmdTiempoCreacion = date("Y-m-d H:i:s");
										$InsTallerPedidoDetalle1->AmdTiempoModificacion = date("Y-m-d H:i:s");
										$InsTallerPedidoDetalle1->AmdEliminado = 1;
				
										$InsTallerPedidoDetalle1->InsMysql = NULL;
													
										$InsTallerPedido->TallerPedidoDetalle[] = $InsTallerPedidoDetalle1;
											
										$InsTallerPedido->AmoTotal += $InsTallerPedidoDetalle1->AmdImporte;
		
									}
		
								}
							}
							
					//deb(":4");
						if(!$InsTallerPedido->MtdRegistrarTallerPedido()){
							$Generar = false;
						}
					
			}else{
				$Generar = false;
			}
			
		}else{
			$Generar = false;
		}
			
					
		return $Generar;					
						
			
	}
	
	
	public function MtdRegistrarFichaAccionMantenimiento() {
	
		global $Resultado;
		$error = false;

		//$this->MtdGenerarFichaAccionId();

		if($this->Transaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}
			
			
			$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			$InsFichaIngresoModalidad->FimId = $this->FimId;
			$InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidad();
			
			$InsModalidadIngreso = new ClsModalidadIngreso();
			$InsModalidadIngreso->MinId = $InsFichaIngresoModalidad->MinId;
			$InsModalidadIngreso->MtdObtenerModalidadIngreso();
		

			if(!$error){
			
				if (!empty($this->FichaAccionMantenimiento)){		
						
					//$Resultado2.='#Modalidad de Ingreso: '.($InsModalidadIngreso->MinNombre);
					
					$validar = 0;	
					$item = 1;
					$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento();
							
					foreach ($this->FichaAccionMantenimiento as $DatFichaAccionMantenimiento){
										
						$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
						$InsPlanMantenimientoTarea->PmtId = $DatFichaAccionMantenimiento->PmtId;
						$InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTarea();
						
						$InsFichaAccionMantenimiento->FccId = $this->FccId;
						$InsFichaAccionMantenimiento->PmtId = $DatFichaAccionMantenimiento->PmtId;

						$InsFichaAccionMantenimiento->FiaId = $DatFichaAccionMantenimiento->FiaId;
						
						$InsFichaAccionMantenimiento->ProId = $DatFichaAccionMantenimiento->ProId;
						$InsFichaAccionMantenimiento->UmeId = $DatFichaAccionMantenimiento->UmeId;
						$InsFichaAccionMantenimiento->FaaCantidad = $DatFichaAccionMantenimiento->FaaCantidad;
						
						
						$InsFichaAccionMantenimiento->FaaAccion = $DatFichaAccionMantenimiento->FaaAccion;
						$InsFichaAccionMantenimiento->FaaNivel = $DatFichaAccionMantenimiento->FaaNivel;
						$InsFichaAccionMantenimiento->FaaVerificar1 = $DatFichaAccionMantenimiento->FaaVerificar1;
						$InsFichaAccionMantenimiento->FaaVerificar2 = $DatFichaAccionMantenimiento->FaaVerificar2;
						$InsFichaAccionMantenimiento->FaaEstado = $DatFichaAccionMantenimiento->FaaEstado;
						$InsFichaAccionMantenimiento->FaaTiempoCreacion = $DatFichaAccionMantenimiento->FaaTiempoCreacion;
						$InsFichaAccionMantenimiento->FaaTiempoModificacion = $DatFichaAccionMantenimiento->FaaTiempoModificacion;
						$InsFichaAccionMantenimiento->FaaEliminado = $DatFichaAccionMantenimiento->FaaEliminado;
						
						if($InsFichaAccionMantenimiento->MtdRegistrarFichaAccionMantenimiento()){
							$validar++;	
						}else{
							//$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' ('.$item.') - No se pudo registrar';
							$Resultado2.='#Tarea: '.($InsPlanMantenimientoTarea->PmtNombre).' - No se pudo registrar';
							//$Resultado2.='#ERR_FCC_281';
						}
						
						$item++;

					}
					
					if(count($this->FichaAccionMantenimiento) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
						
						
						
			
			
								
		if($error) {	
		
			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
		
			return false;
		} else {				
		
			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionHacer();		
			}

			//$this->MtdAuditarFichaAccion(1,"Se registro la SUB ORDEN DE TRABAJO",$this);			
			return true;
		}			
					
	}
		
}
?>