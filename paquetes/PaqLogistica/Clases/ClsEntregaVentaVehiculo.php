<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsEntregaVentaVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsEntregaVentaVehiculo {

    public $EvvId;
	
	public $OvvId;
	public $EvvFecha;
	public $EvvHora;
	
	public $EinId;
	public $EvvSolicitante;
	public $EvvVehiculoMarca;
	public $EvvVehiculoModelo;
	public $EvvVehiculoVersion;
	
	public $EvvColor;
	public $EvvAnoModelo;
	
	public $EvvObservacion;
	public $EvvEstado;
	public $EvvTiempoCreacion;
	public $EvvTiempoModificacion;
    public $EvvEliminado;
	
	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $EinVIN;

	
    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}

	public function MtdGenerarEntregaVentaVehiculoId() {


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(evv.EvvId,10),unsigned)) AS "MAXIMO"
		FROM tblevventregaventavehiculo evv
			WHERE YEAR(evv.EvvFecha) = '.$this->EvvAno.';';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->EvvId = "EVV-".$this->EvvAno."-00001";
		}else{
			$fila['MAXIMO']++;
			$this->EvvId = "EVV-".$this->EvvAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
		}
				
	}
		
    public function MtdObtenerEntregaVentaVehiculo($oCompleto=true){

        $sql = 'SELECT 
        evv.EvvId,
		evv.PerId,
		
		evv.OvvId,
		ovv.EinId,
		
		DATE_FORMAT(evv.EvvFecha, "%d/%m/%Y") AS "NEvvFecha",
		evv.EvvHora,
		
		evv.EvvDuracion,
		
		DATE_FORMAT(evv.EvvFechaProgramada, "%d/%m/%Y") AS "NEvvFechaProgramada",
		evv.EvvHoraProgramada,

		evv.EvvSolicitante,
		evv.EvvObservacion,
		evv.EvvObservacionSalida,
		
		evv.EvvAprobacion,
		evv.EvvEstado,
		DATE_FORMAT(evv.EvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEvvTiempoCreacion",
        DATE_FORMAT(evv.EvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEvvTiempoModificacion",

		ein.EinVIN,
		ein.EinNumeroMotor,
		ein.EinColor,
		ein.EinAnoFabricacion,
		ein.EinAnoModelo,
		ein.EinEstadoVehicular,
		
		ein.VveId,
		vve.VmoId,
		vmo.VmaId,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerEmail,
		
		ovv.PerId AS PerIdVendedor,
		per2.PerNombre AS PerNombreVendedor,
		per2.PerApellidoPaterno AS PerApellidoPaternoVendedor,
		per2.PerApellidoMaterno AS PerApellidoMaternoVendedor,
		per2.PerEmail AS PerEmailVendedor,
		
		suc.SucNombre,
		suc2.SucNombre AS EinUbicacion,
		
		cli.CliNumeroDocumento,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		tdo.TdoNombre,
		
		DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
		DATE_FORMAT(ovv.OvvFechaEntrega, "%d/%m/%Y") AS "NOvvFechaEntrega",
		ovv.OvvObservacion,
		ovv.MonId,
		ovv.OvvTipoCambio,
		
		ovv.OvvAprobacion1,
		ovv.OvvAprobacion2,
		ovv.OvvAprobacion3,
		
		ovv.OvvPrecio,
		ovv.OvvTotal,
		ovv.OvvDescuento,
		ovv.OvvDescuentoGerencia,
		ovv.OvvSubTotal,
		ovv.OvvImpuesto
		
        FROM tblevventregaventavehiculo evv
			
			LEFT JOIN tblovvordenventavehiculo ovv
			ON evv.OvvId = ovv.OvvId		
				LEFT JOIN tblclicliente cli
				ON ovv.CliId = cli.CliId
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
				LEFT JOIN tbleinvehiculoingreso ein
				ON ovv.EinId = ein.EinId				
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
						
					LEFT JOIN tblperpersonal per
					ON evv.PerId = per.PerId
					
					LEFT JOIN tblperpersonal per2
					ON ovv.PerId = per2.PerId
					
						LEFT JOIN tblsucsucursal suc
						ON ovv.SucId = suc.SucId
							LEFT JOIN tblsucsucursal suc2
							ON ein.SucId = suc2.SucId
					
        WHERE evv.EvvId = "'.$this->EvvId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			$this->EvvId = $fila['EvvId'];
			$this->PerId = $fila['PerId'];
			$this->OvvId = $fila['OvvId'];
			$this->EinId = $fila['EinId'];
			
			$this->EvvFecha = $fila['NEvvFecha'];
			$this->EvvHora = $fila['EvvHora'];
			
			$this->EvvDuracion = $fila['EvvDuracion'];
			
			$this->EvvFechaProgramada = $fila['NEvvFechaProgramada'];
			$this->EvvHoraProgramada = $fila['EvvHoraProgramada'];

			$this->EvvObservacion = $fila['EvvObservacion'];
			$this->EvvObservacionSalida = $fila['EvvObservacionSalida'];
			
			$this->EvvSolicitante = $fila['EvvSolicitante'];
			
			
			$this->EvvAprobacion = $fila['EvvAprobacion'];
			$this->EvvEstado = $fila['EvvEstado'];
			$this->EvvTiempoCreacion = $fila['NEvvTiempoCreacion']; 
			$this->EvvTiempoModificacion = $fila['NEvvTiempoModificacion']; 
			
			$this->VveId = $fila['VveId']; 
			$this->VmoId = $fila['VmoId']; 
			$this->VmaId = $fila['VmaId']; 	
	
		
			$this->VmaNombre = $fila['VmaNombre'];		
			$this->VmoNombre = $fila['VmoNombre'];
			$this->VveNombre = $fila['VveNombre'];
			
			$this->EinVIN = $fila['EinVIN'];
			$this->EinNumeroMotor = $fila['EinNumeroMotor'];
			$this->EinColor = $fila['EinColor'];
			$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$this->EinAnoModelo = $fila['EinAnoModelo'];
			$this->EinEstadoVehicular = $fila['EinEstadoVehicular'];
		
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerEmail = $fila['PerEmail'];
			
			
			$this->PerIdVendedor = $fila['PerIdVendedor'];
			$this->PerNombreVendedor = $fila['PerNombreVendedor'];
			$this->PerApellidoPaternoVendedor = $fila['PerApellidoPaternoVendedor'];
			$this->PerApellidoMaternoVendedor = $fila['PerApellidoMaternoVendedor'];
			$this->PerEmailVendedor = $fila['PerEmailVendedor'];
			
			$this->SucNombre = $fila['SucNombre'];		
			$this->EinUbicacion = $fila['EinUbicacion'];			
			
			
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->TdoNombre = $fila['TdoNombre'];
			
			$this->OvvFecha = $fila['NOvvFecha'];
			$this->OvvFechaEntrega = $fila['NOvvFechaEntrega'];
			$this->OvvObservacion = $fila['OvvObservacion'];
			$this->MonId = $fila['MonId'];
			$this->OvvTipoCambio = $fila['OvvTipoCambio'];
			
			
		
			$this->OvvAprobacion1 = $fila['OvvAprobacion1'];
			$this->OvvAprobacion2 = $fila['OvvAprobacion2'];
			$this->OvvAprobacion3 = $fila['OvvAprobacion3'];
		
		
			$this->OvvPrecio = $fila['OvvPrecio'];
			$this->OvvTotal = $fila['OvvTotal'];
			$this->OvvDescuento = $fila['OvvDescuento'];
			$this->OvvDescuentoGerencia = $fila['OvvDescuentoGerencia'];
			$this->OvvSubTotal = $fila['OvvSubTotal'];
			$this->OvvImpuesto = $fila['OvvImpuesto'];

			if($oCompleto){

				$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario($this->InsMysql);
				$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId','ASC',NULL,$this->OvvId);
				$this->EntregaVentaVehiculoPropietario = $ResOrdenVentaVehiculoPropietario['Datos'];
		
			}



			switch($this->EvvEstado){

				case 1:
					$this->EvvEstadoDescripcion = "Pendiente";
				break;

				case 3:
					$this->EvvEstadoDescripcion = "Revisado";
				break;	
				
				case 6:
					$this->EvvEstadoDescripcion = "Anulado";
				break;	

				default:
					$this->EvvEstadoDescripcion = "";
				break;

			}	
				

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


    public function MtdObtenerEntregaVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'EvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oSucursal=NULL,$oFecha="EvvFechaProgramada") {

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
				
				//
//				$filtrar .= '  OR EXISTS( 
//					
//					SELECT 
//					ood.OodId
//					
//					FROM tbloodordencotizaciondetalle ood
//						
//						LEFT JOIN tblproproducto pro
//						ON ood.ProId = pro.ProId
//						
//							
//								
//								
//					WHERE 
//					
//						ood.EvvId = evv.EvvId
//						AND
//						(
//							pro.ProNombre LIKE "%'.$oFiltro.'%" OR
//							pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%"  OR
//							pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 
//						)
//						
//
//					) ';
					
					
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
				$fecha = ' AND DATE(evv.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(evv.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(evv.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(evv.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND evv.EvvEstado = '.$oEstado;
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND evv.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}

	
	
			if(!empty($oSucursal)){
			$sucursal = ' AND ovv.SucId = "'.$oSucursal.'"';
		}

		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				evv.EvvId,
				evv.PerId,
				
				evv.OvvId,	
				ovv.EinId,
				
				DATE_FORMAT(evv.EvvFecha, "%d/%m/%Y") AS "NEvvFecha",
				evv.EvvHora,
				
				DATE_FORMAT(evv.EvvFechaProgramada, "%d/%m/%Y") AS "NEvvFechaProgramada",
				evv.EvvHoraProgramada,

				evv.EvvDuracion,
				DATE_FORMAT(CONCAT(evv.EvvFechaProgramada," ",evv.EvvHoraProgramada), "%d/%m/%Y %H:%m:%s") AS "EvvFechaHoraInicio",
				DATE_FORMAT(DATE_ADD(CONCAT(evv.EvvFechaProgramada," ",evv.EvvHoraProgramada), INTERVAL IFNULL(evv.EvvDuracion,0) HOUR)  , "%d/%m/%Y %H:%m:%s")AS "EvvFechaHoraFin",
		
				evv.EvvObservacion,
				evv.EvvSolicitante,
					
				evv.EvvAprobacion,
				evv.EvvEstado,
				DATE_FORMAT(evv.EvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEvvTiempoCreacion",
	        	DATE_FORMAT(evv.EvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEvvTiempoModificacion",
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,

				ein.EinVIN,
				ein.EinNumeroMotor,
				ein.EinAnoModelo,
				ein.EinAnoFabricacion,
				ein.EinColor,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerEmail,
				
				per2.PerNombre AS PerNombreVendedor,
				per2.PerApellidoPaterno AS PerApellidoPaternoVendedor,
				per2.PerApellidoMaterno AS PerApellidoMaternoVendedor,
				
				per2.PerEmail AS PerEmailVendedor,
				
				suc.SucNombre,
				ovv.CliId,
				ovv.OvvAprobacion1,
				ovv.OvvAprobacion2,
				ovv.OvvAprobacion3,
				
								cli.CliNumeroDocumento,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		tdo.TdoNombre
		
				FROM tblevventregaventavehiculo evv
			
					LEFT JOIN tblovvordenventavehiculo ovv
					ON evv.OvvId = ovv.OvvId	
					
						LEFT JOIN tblclicliente cli
						ON ovv.CliId = cli.CliId
							LEFT JOIN tbltdotipodocumento tdo
							ON cli.TdoId = tdo.TdoId
					
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON ovv.EinId = ein.EinId				
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
								
							LEFT JOIN tblperpersonal per
							ON evv.PerId = per.PerId
							LEFT JOIN tblperpersonal per2
							ON ovv.PerId = per2.PerId
								LEFT JOIN tblsucsucursal suc
								ON ovv.SucId = suc.SucId
					
				WHERE 1 = 1 '.$filtrar.$fecha.$ovvehiculo.$sucursal.$tipo.$stipo.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsEntregaVentaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$EntregaVentaVehiculo = new $InsEntregaVentaVehiculo();
                    $EntregaVentaVehiculo->EvvId = $fila['EvvId'];
					
					$EntregaVentaVehiculo->PerId = $fila['PerId'];
					$EntregaVentaVehiculo->OvvId = $fila['OvvId'];
					$EntregaVentaVehiculo->EinId = $fila['EinId'];
					
					$EntregaVentaVehiculo->EvvFecha = $fila['NEvvFecha'];
					$EntregaVentaVehiculo->EvvHora = $fila['EvvHora'];
					
					$EntregaVentaVehiculo->EvvFechaProgramada = $fila['NEvvFechaProgramada'];
					$EntregaVentaVehiculo->EvvHoraProgramada = $fila['EvvHoraProgramada'];
					
					$EntregaVentaVehiculo->EvvDuracion = $fila['EvvDuracion'];
					$EntregaVentaVehiculo->EvvFechaHoraInicio = $fila['EvvFechaHoraInicio'];
					$EntregaVentaVehiculo->EvvFechaHoraFin = $fila['EvvFechaHoraFin'];
					
					$EntregaVentaVehiculo->EvvObservacion = $fila['EvvObservacion'];
					
					$EntregaVentaVehiculo->EvvSolicitante = $fila['EvvSolicitante'];
					


					$EntregaVentaVehiculo->EvvAprobacion = $fila['EvvAprobacion'];
					$EntregaVentaVehiculo->EvvEstado = $fila['EvvEstado'];
					$EntregaVentaVehiculo->EvvTiempoCreacion = $fila['NEvvTiempoCreacion'];  
					$EntregaVentaVehiculo->EvvTiempoModificacion = $fila['NEvvTiempoModificacion']; 

					$EntregaVentaVehiculo->VmaNombre = $fila['VmaNombre'];
					$EntregaVentaVehiculo->VmoNombre = $fila['VmoNombre'];
					$EntregaVentaVehiculo->VveNombre = $fila['VveNombre'];
					
					$EntregaVentaVehiculo->EinVIN = $fila['EinVIN'];
					$EntregaVentaVehiculo->EinNumeroMotor = $fila['EinNumeroMotor'];
					$EntregaVentaVehiculo->EinAnoModelo = $fila['EinAnoModelo'];
					$EntregaVentaVehiculo->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$EntregaVentaVehiculo->EinColor = $fila['EinColor'];
					
					
				
				$EntregaVentaVehiculo->TdoId = $fila['TdoId'];
					$EntregaVentaVehiculo->PerNombre = $fila['PerNombre'];
					$EntregaVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$EntregaVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$EntregaVentaVehiculo->PerEmail = $fila['PerEmail'];
					
					
					$EntregaVentaVehiculo->PerNombreVendedor = $fila['PerNombreVendedor'];
					$EntregaVentaVehiculo->PerApellidoPaternoVendedor = $fila['PerApellidoPaternoVendedor'];
					$EntregaVentaVehiculo->PerApellidoMaternoVendedor = $fila['PerApellidoMaternoVendedor'];
					$EntregaVentaVehiculo->PerEmailVendedor = $fila['PerEmailVendedor'];
					
					$EntregaVentaVehiculo->SucNombre = $fila['SucNombre'];
					
					$EntregaVentaVehiculo->OvvAprobacion1 = $fila['OvvAprobacion1'];
					$EntregaVentaVehiculo->OvvAprobacion2 = $fila['OvvAprobacion2'];
					$EntregaVentaVehiculo->OvvAprobacion3 = $fila['OvvAprobacion3'];
				
					$EntregaVentaVehiculo->CliId = $fila['CliId'];
					$EntregaVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$EntregaVentaVehiculo->CliNombre = $fila['CliNombre'];
					$EntregaVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$EntregaVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$EntregaVentaVehiculo->TdoNombre = $fila['TdoNombre'];
			
					switch($EntregaVentaVehiculo->EvvEstado){
					
					case 1:
							$EntregaVentaVehiculo->EvvEstadoDescripcion = "Pendiente";
						break;
					
						case 3:
							$EntregaVentaVehiculo->EvvEstadoDescripcion = "Revisado";
						break;	
					
						case 6:
							$EntregaVentaVehiculo->EvvEstadoDescripcion = "Anulado";
						break;	
					
						default:
							$EntregaVentaVehiculo->EvvEstadoDescripcion = "";
						break;
					
					}
						

                    $EntregaVentaVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $EntregaVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}

	//Accion eliminar	 
	public function MtdEliminarEntregaVentaVehiculo($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();


		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){

					//$aux = explode("%",$elemento);	
					
						
						$sql = 'DELETE FROM tblevventregaventavehiculo WHERE  (EvvId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarEntregaVentaVehiculo(3,"Se elimino el Asiganacion Venta de Vehiculo",$elemento);		
						}
						
//						if(!$error){
//						
//							$this->EvvId = $elemento;
//							$this->MtdObtenerEntregaVentaVehiculo(false);
//							
//							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
//							$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",3,$this->OvvId);
//								
//						}
						
					
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoEntregaVentaVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsEntregaVentaVehiculo = new ClsEntregaVentaVehiculo();
		

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
					
					$sql = 'UPDATE tblevventregaventavehiculo SET EvvEstado = '.$oEstado.' WHERE EvvId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarEntregaVentaVehiculo(2,"Se actualizo el Estado de la Asignacion Venta de Vehiculo",$elemento);
				
					}
				
				}
			$i++;
	
			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
	
	
	public function MtdRegistrarEntregaVentaVehiculo($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarEntregaVentaVehiculoId();
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
				
			
			$sql = 'INSERT INTO tblevventregaventavehiculo (
			EvvId,
			PerId,			
			OvvId,
			
			EvvFecha,
			EvvHora,
			
			EvvFechaProgramada,
			EvvHoraProgramada,
			
			EvvObservacion,
			EvvObservacionSalida,
			EvvSolicitante,
			
			EvvAprobacion,
			EvvDuracion,
			EvvEstado,			
			EvvTiempoCreacion,
			EvvTiempoModificacion) 
			VALUES (
			"'.($this->EvvId).'", 
			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			'.(empty($this->OvvId)?"NULL,":'"'.$this->OvvId.'",').'
			
			"'.($this->EvvFecha).'", 
			"'.($this->EvvHora).'", 
			
			"'.($this->EvvFechaProgramada).'", 
			"'.($this->EvvHoraProgramada).'", 
			
			"'.($this->EvvObservacion).'",
			"'.($this->EvvObservacionSalida).'",
			
			
			
			"'.($this->EvvSolicitante).'", 
			
					
			'.($this->EvvAprobacion).',
			'.($this->EvvDuracion).',
			'.($this->EvvEstado).',
			"'.($this->EvvTiempoCreacion).'", 				
			"'.($this->EvvTiempoModificacion).'");';			
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
				
			//	deb($this->InsMysql->MtdObtenerErrorCodigo());
				
				switch($this->InsMysql->MtdObtenerErrorCodigo()){
				
						case 1452:
							
							$cadena_error = $this->InsMysql->MtdObtenerError();
							$pos = strpos($cadena_error, "tblovvordenventavehiculo");

							if ($pos !== false) {
								$Resultado.="#ERR_OOT_1000";	
							}
							
						break;

				}
					
			} 
					
				
			if($error) {	
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}
				return false;
			} else {		
				if($oTransaccion){		
					$this->InsMysql->MtdTransaccionHacer();		
				}
				$this->MtdAuditarEntregaVentaVehiculo(1,"Se registro el Asiganacion Venta de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarEntregaVentaVehiculo() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblevventregaventavehiculo SET
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->OvvId)?'OvvId = NULL, ':'OvvId = "'.$this->OvvId.'",').'
			
			EvvFecha = "'.($this->EvvFecha).'",
			EvvHora = "'.($this->EvvHora).'",
			
				EvvFechaProgramada = "'.($this->EvvFechaProgramada).'",
			EvvHoraProgramada = "'.($this->EvvHoraProgramada).'",
			
			EvvObservacion = "'.($this->EvvObservacion).'",		
			EvvSolicitante = "'.($this->EvvSolicitante).'",
		
		
			EvvDuracion = '.($this->EvvDuracion).',
			EvvEstado = '.($this->EvvEstado).',
			EvvTiempoModificacion = "'.($this->EvvTiempoModificacion).'"
			WHERE EvvId = "'.($this->EvvId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarEntregaVentaVehiculo(2,"Se edito el Asiganacion Venta de Vehiculo",$this);		
				return true;
			}	
				
		}	
		
		public function MtdActualizarCalendarioEntregaVentaVehiculo() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblevventregaventavehiculo SET
			
			EvvObservacionSalida = "'.($this->EvvObservacionSalida).'",	
			EvvDuracion = '.($this->EvvDuracion).',
			EvvTiempoModificacion = "'.($this->EvvTiempoModificacion).'"
			WHERE EvvId = "'.($this->EvvId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarEntregaVentaVehiculo(2,"Se edito el Asiganacion Venta de Vehiculo",$this);		
				return true;
			}	
				
		}
		
		
		
		public function MtdEditarEntregaVentaVehiculoDato($oCampo,$oDato,$oEntregaVentaVehiculoId) {

			$error = false;

			$sql = 'UPDATE tblevventregaventavehiculo SET
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			EvvTiempoModificacion = NOW()
			WHERE EvvId = "'.($oEntregaVentaVehiculoId).'";';			

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
		
	
	
		private function MtdAuditarEntregaVentaVehiculo($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->EvvId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		
		
		
		public function MtdNotificarEntregaVentaVehiculoRegistro($oEntregaVentaVehiculo,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->EvvId = $oEntregaVentaVehiculo;
			$this->MtdObtenerEntregaVentaVehiculo();

			$mensaje = "";
			
			$mensaje .= "<b><u>PROGRAMACION DE ENTREGA DE VEHICULO</u></b>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<i>Programacion de entrega de vehiculo a cliente.</i>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->EvvId."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Sucursal:</b> ".$this->SucNombre."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Fecha Programada:</b> ".$this->EvvFechaProgramada."";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Hora Programada:</b> ".$this->EvvHoraProgramada."";	
			$mensaje .= "<br>";
			
			$mensaje .= "<b>Orden de Venta:</b> ".$this->OvvId."";	
			$mensaje .= "<br>";		
			
			$mensaje .= "<b>Asesor de Ventas:</b> ".$this->PerNombreVendedor." ".$this->PerApellidoPaternoVendedor." ".$this->PerApellidoMaternoVendedor."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Entrega Inmediata:</b> ".(($this->EvvInmediata==1)?"Si":"No")."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Observaciones:</b> ".$this->EvvObservacion."";	
			$mensaje .= "<br>";	
			
			
			
			$mensaje .= "<b>Cliente:</b>";
			
			$clientes = "";
			
			$clientes .= $this->TdoNombre." ".$this->CliNumeroDocumento." / ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno;
			
			if(!empty($this->EntregaVentaVehiculoPropietario)){
				
				$clientes .= "<br>";
								
				foreach($this->EntregaVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($this->CliId<>$DatOrdenVentaVehiculoPropietario->CliId){
						$clientes .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
										$clientes .= "<br>";
					}
					
				}
			}
			
		
			$mensaje .= $clientes;
			$mensaje .= "<br>";	
			
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					
						$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>VIN</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinVIN;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Vehiculo:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Color:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinColor;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Año Fabricacion:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinAnoFabricacion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Año Modelo:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinAnoModelo;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Estado:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinEstadoVehicular;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";

					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Ubicacion del vehiculo</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinUbicacion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
									
					
			$mensaje .= "</table>";
			$mensaje .= "<br>";
		
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
				
			//	echo $mensaje;
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"PROG. ENTREGA: ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje,NULL);
			
		}
		 
	
	
	public function MtdNotificarEntregaVentaVehiculoReprogramacion($oEntregaVentaVehiculo,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->EvvId = $oEntregaVentaVehiculo;
			$this->MtdObtenerEntregaVentaVehiculo();

			$mensaje = "";
			
			$mensaje .= "<b><u>REPROGRAMACION DE ENTREGA DE VEHICULO</u></b>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<i>Reprogramacion de entrega de vehiculo a cliente.</i>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->EvvId."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Sucursal:</b> ".$this->SucNombre."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Fecha Reprogramada:</b> ".$this->EvvFechaProgramada."";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Hora Reprogramada:</b> ".$this->EvvHoraProgramada."";	
			$mensaje .= "<br>";
			
			$mensaje .= "<b>Orden de Venta:</b> ".$this->OvvId."";	
			$mensaje .= "<br>";		
			
			$mensaje .= "<b>Asesor de Ventas:</b> ".$this->PerNombreVendedor." ".$this->PerApellidoPaternoVendedor." ".$this->PerApellidoMaternoVendedor."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Entrega Inmediata:</b> ".(($this->EvvInmediata==1)?"Si":"No")."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Observaciones:</b> ".$this->EvvObservacion."";	
			$mensaje .= "<br>";	
			
			
			
			$mensaje .= "<b>Cliente:</b>";
			
			$clientes = "";
			
			$clientes .= $this->TdoNombre." ".$this->CliNumeroDocumento." / ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno;
			
			if(!empty($this->EntregaVentaVehiculoPropietario)){
				$clientes .= "<br>";
				foreach($this->EntregaVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($this->CliId<>$DatOrdenVentaVehiculoPropietario->CliId){
						
						$clientes .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
						$clientes .= "<br>";
						
					}
					
				}
			}
			
		
			$mensaje .= $clientes;
			$mensaje .= "<br>";	
			
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					
						$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>VIN</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinVIN;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Vehiculo:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Color:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinColor;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Año Fabricacion:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinAnoFabricacion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Año Modelo:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinAnoModelo;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Estado:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinEstadoVehicular;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";

					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Ubicacion del vehiculo</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinUbicacion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
									
					
			$mensaje .= "</table>";
			$mensaje .= "<br>";
		
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
				
			//	echo $mensaje;
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"REPROG. ENTREGA: ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje,NULL);
			
		}
		 
			
}
?>