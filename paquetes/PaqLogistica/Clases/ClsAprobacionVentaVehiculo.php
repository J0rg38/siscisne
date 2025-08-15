<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAprobacionVentaVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAprobacionVentaVehiculo {

    public $AovId;
	
	public $OvvId;
	public $AovFecha;
	public $AovHora;
	
	public $EinId;
	public $AovSolicitante;
	public $AovVehiculoMarca;
	public $AovVehiculoModelo;
	public $AovVehiculoVersion;
	
	public $AovColor;
	public $AovAnoModelo;
	
	public $AovObservacion;
	public $AovEstado;
	public $AovTiempoCreacion;
	public $AovTiempoModificacion;
    public $AovEliminado;
	
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

	public function MtdGenerarAprobacionVentaVehiculoId() {


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(aov.AovId,10),unsigned)) AS "MAXIMO"
		FROM tblaovaprobacionventavehiculo aov
			WHERE YEAR(aov.AovFecha) = '.$this->AovAno.';';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->AovId = "AOV-".$this->AovAno."-00001";
		}else{
			$fila['MAXIMO']++;
			$this->AovId = "AOV-".$this->AovAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
		}
				
	}
		
    public function MtdObtenerAprobacionVentaVehiculo($oCompleto=true){

        $sql = 'SELECT 
        aov.AovId,
		aov.PerId,
		
		aov.OvvId,
		ovv.EinId,
		
		DATE_FORMAT(aov.AovFecha, "%d/%m/%Y") AS "NAovFecha",
		aov.AovHora,

		aov.AovSolicitante,
		aov.AovObservacion,
		
		aov.AovAprobacion,
		aov.AovEstado,
		DATE_FORMAT(aov.AovTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAovTiempoCreacion",
        DATE_FORMAT(aov.AovTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAovTiempoModificacion",

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
		
        FROM tblaovaprobacionventavehiculo aov
			
			LEFT JOIN tblovvordenventavehiculo ovv
			ON aov.OvvId = ovv.OvvId		
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
					ON aov.PerId = per.PerId
					
					LEFT JOIN tblperpersonal per2
					ON ovv.PerId = per2.PerId
					
						LEFT JOIN tblsucsucursal suc
						ON ovv.SucId = suc.SucId
							LEFT JOIN tblsucsucursal suc2
							ON ein.SucId = suc2.SucId
					
        WHERE aov.AovId = "'.$this->AovId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			$this->AovId = $fila['AovId'];
			$this->PerId = $fila['PerId'];
			$this->OvvId = $fila['OvvId'];
			$this->EinId = $fila['EinId'];
			
			$this->AovFecha = $fila['NAovFecha'];
			$this->AovHora = $fila['AovHora'];

			$this->AovObservacion = $fila['AovObservacion'];
			$this->AovSolicitante = $fila['AovSolicitante'];
			
			
			$this->AovAprobacion = $fila['AovAprobacion'];
			$this->AovEstado = $fila['AovEstado'];
			$this->AovTiempoCreacion = $fila['NAovTiempoCreacion']; 
			$this->AovTiempoModificacion = $fila['NAovTiempoModificacion']; 
			
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
				$this->AprobacionVentaVehiculoPropietario = $ResOrdenVentaVehiculoPropietario['Datos'];
		
			}



			switch($this->AovEstado){

				case 1:
					$this->AovEstadoDescripcion = "Pendiente";
				break;

				case 3:
					$this->AovEstadoDescripcion = "Revisado";
				break;	
				
				case 6:
					$this->AovEstadoDescripcion = "Anulado";
				break;	

				default:
					$this->AovEstadoDescripcion = "";
				break;

			}	
				

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


    public function MtdObtenerAprobacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AovId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL) {

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
//						ood.AovId = aov.AovId
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
				$fecha = ' AND DATE(aov.AovFecha)>="'.$oFechaInicio.'" AND DATE(aov.AovFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(aov.AovFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(aov.AovFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND aov.AovEstado = '.$oEstado;
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND aov.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}

	
	
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				aov.AovId,
				aov.PerId,
				
				aov.OvvId,	
				ovv.EinId,
				
				DATE_FORMAT(aov.AovFecha, "%d/%m/%Y") AS "NAovFecha",
				aov.AovHora,
				
				aov.AovObservacion,
				aov.AovSolicitante,
					
				aov.AovAprobacion,
				aov.AovEstado,
				DATE_FORMAT(aov.AovTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAovTiempoCreacion",
	        	DATE_FORMAT(aov.AovTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAovTiempoModificacion",
				
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
		
				FROM tblaovaprobacionventavehiculo aov
			
					LEFT JOIN tblovvordenventavehiculo ovv
					ON aov.OvvId = ovv.OvvId	
									
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
							ON aov.PerId = per.PerId
							LEFT JOIN tblperpersonal per2
							ON ovv.PerId = per2.PerId
								LEFT JOIN tblsucsucursal suc
								ON ovv.SucId = suc.SucId
					
				WHERE 1 = 1 '.$filtrar.$fecha.$ovvehiculo.$tipo.$stipo.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAprobacionVentaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AprobacionVentaVehiculo = new $InsAprobacionVentaVehiculo();
                    $AprobacionVentaVehiculo->AovId = $fila['AovId'];
					
					$AprobacionVentaVehiculo->PerId = $fila['PerId'];
					$AprobacionVentaVehiculo->OvvId = $fila['OvvId'];
					$AprobacionVentaVehiculo->EinId = $fila['EinId'];
					
					$AprobacionVentaVehiculo->AovFecha = $fila['NAovFecha'];
					$AprobacionVentaVehiculo->AovHora = $fila['AovHora'];
					
					$AprobacionVentaVehiculo->AovObservacion = $fila['AovObservacion'];
					
					$AprobacionVentaVehiculo->AovSolicitante = $fila['AovSolicitante'];
					


					$AprobacionVentaVehiculo->AovAprobacion = $fila['AovAprobacion'];
					$AprobacionVentaVehiculo->AovEstado = $fila['AovEstado'];
					$AprobacionVentaVehiculo->AovTiempoCreacion = $fila['NAovTiempoCreacion'];  
					$AprobacionVentaVehiculo->AovTiempoModificacion = $fila['NAovTiempoModificacion']; 

					$AprobacionVentaVehiculo->VmaNombre = $fila['VmaNombre'];
					$AprobacionVentaVehiculo->VmoNombre = $fila['VmoNombre'];
					$AprobacionVentaVehiculo->VveNombre = $fila['VveNombre'];
					
					$AprobacionVentaVehiculo->EinVIN = $fila['EinVIN'];
					$AprobacionVentaVehiculo->EinNumeroMotor = $fila['EinNumeroMotor'];
					$AprobacionVentaVehiculo->EinAnoModelo = $fila['EinAnoModelo'];
					$AprobacionVentaVehiculo->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$AprobacionVentaVehiculo->EinColor = $fila['EinColor'];
					
					
				
				$AprobacionVentaVehiculo->TdoId = $fila['TdoId'];
					$AprobacionVentaVehiculo->PerNombre = $fila['PerNombre'];
					$AprobacionVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$AprobacionVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$AprobacionVentaVehiculo->PerEmail = $fila['PerEmail'];
					
					
					$AprobacionVentaVehiculo->PerNombreVendedor = $fila['PerNombreVendedor'];
					$AprobacionVentaVehiculo->PerApellidoPaternoVendedor = $fila['PerApellidoPaternoVendedor'];
					$AprobacionVentaVehiculo->PerApellidoMaternoVendedor = $fila['PerApellidoMaternoVendedor'];
					$AprobacionVentaVehiculo->PerEmailVendedor = $fila['PerEmailVendedor'];
					
					$AprobacionVentaVehiculo->SucNombre = $fila['SucNombre'];
					
					$AprobacionVentaVehiculo->OvvAprobacion1 = $fila['OvvAprobacion1'];
					$AprobacionVentaVehiculo->OvvAprobacion2 = $fila['OvvAprobacion2'];
					$AprobacionVentaVehiculo->OvvAprobacion3 = $fila['OvvAprobacion3'];
				
					$AprobacionVentaVehiculo->CliId = $fila['CliId'];
					$AprobacionVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$AprobacionVentaVehiculo->CliNombre = $fila['CliNombre'];
					$AprobacionVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$AprobacionVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$AprobacionVentaVehiculo->TdoNombre = $fila['TdoNombre'];
			
					switch($AprobacionVentaVehiculo->AovEstado){
					
					case 1:
							$AprobacionVentaVehiculo->AovEstadoDescripcion = "Pendiente";
						break;
					
						case 3:
							$AprobacionVentaVehiculo->AovEstadoDescripcion = "Revisado";
						break;	
					
						case 6:
							$AprobacionVentaVehiculo->AovEstadoDescripcion = "Anulado";
						break;	
					
						default:
							$AprobacionVentaVehiculo->AovEstadoDescripcion = "";
						break;
					
					}
						

                    $AprobacionVentaVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AprobacionVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}

	//Accion eliminar	 
	public function MtdEliminarAprobacionVentaVehiculo($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();


		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){

					//$aux = explode("%",$elemento);	
					
						
						$sql = 'DELETE FROM tblaovaprobacionventavehiculo WHERE  (AovId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarAprobacionVentaVehiculo(3,"Se elimino el Asiganacion Venta de Vehiculo",$elemento);		
						}
						
						if(!$error){
						
							$this->AovId = $elemento;
							$this->MtdObtenerAprobacionVentaVehiculo(false);
							
							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
							$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",3,$this->OvvId);
								
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
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoAprobacionVentaVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsAprobacionVentaVehiculo = new ClsAprobacionVentaVehiculo();
		

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblaovaprobacionventavehiculo SET AovEstado = '.$oEstado.' WHERE AovId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarAprobacionVentaVehiculo(2,"Se actualizo el Estado de la Asignacion Venta de Vehiculo",$elemento);
				
					}
					
					
					if(!$error){
						
						$this->AovId = $elemento;
						$this->MtdObtenerAprobacionVentaVehiculo(false);
					
						if($oEstado == 6){
							
							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
							$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",3,$this->OvvId);
							
						}else if($oEstado == 1){
	
							$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
							$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",3,$this->OvvId);
							
						}else if($oEstado == 3){
							
							if($this->AovAprobacion == 1){
								
								$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
								$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",1,$this->OvvId);
								
							}else if($this->AovAprobacion == 2){
								
								$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
								$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",2,$this->OvvId);
								
							}else{
							
								$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
								$InsOrdenVentaVehiculo->MtdEditarOrdenVentaVehiculoDato("OvvAprobacion2",3,$this->OvvId);
								
							}
							
						}
			
			
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
	
	
	public function MtdRegistrarAprobacionVentaVehiculo($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarAprobacionVentaVehiculoId();
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
				
			
			$sql = 'INSERT INTO tblaovaprobacionventavehiculo (
			AovId,
			PerId,			
			OvvId,
			
			AovFecha,
			AovHora,
			
			AovObservacion,
			AovSolicitante,
			
			AovAprobacion,
			AovEstado,			
			AovTiempoCreacion,
			AovTiempoModificacion) 
			VALUES (
			"'.($this->AovId).'", 
			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			'.(empty($this->OvvId)?"NULL,":'"'.$this->OvvId.'",').'
			
			"'.($this->AovFecha).'", 
			"'.($this->AovHora).'", 
			
			"'.($this->AovObservacion).'",
			"'.($this->AovSolicitante).'", 
			
					
					
			'.($this->AovAprobacion).',
			'.($this->AovEstado).',
			"'.($this->AovTiempoCreacion).'", 				
			"'.($this->AovTiempoModificacion).'");';			
				
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
				$this->MtdAuditarAprobacionVentaVehiculo(1,"Se registro el Asiganacion Venta de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarAprobacionVentaVehiculo() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblaovaprobacionventavehiculo SET
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->OvvId)?'OvvId = NULL, ':'OvvId = "'.$this->OvvId.'",').'
			
			AovFecha = "'.($this->AovFecha).'",
			AovHora = "'.($this->AovHora).'",
			
			AovObservacion = "'.($this->AovObservacion).'",		
			AovSolicitante = "'.($this->AovSolicitante).'",
		
			AovAprobacion = '.($this->AovAprobacion).',
			AovEstado = '.($this->AovEstado).',
			AovTiempoModificacion = "'.($this->AovTiempoModificacion).'"
			WHERE AovId = "'.($this->AovId).'";';			
		
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
				
				$this->MtdAuditarAprobacionVentaVehiculo(2,"Se edito el Asiganacion Venta de Vehiculo",$this);		
				return true;
			}	
				
		}	
		
		
		public function MtdEditarAprobacionVentaVehiculoDato($oCampo,$oDato,$oAprobacionVentaVehiculoId) {

			$error = false;

			$sql = 'UPDATE tblaovaprobacionventavehiculo SET
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			AovTiempoModificacion = NOW()
			WHERE AovId = "'.($oAprobacionVentaVehiculoId).'";';			

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
		
	
	
		private function MtdAuditarAprobacionVentaVehiculo($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->AovId;

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
		
		
		
		
		
		 
		
		public function MtdNotificarAprobacionVentaVehiculoRegistro($oAprobacionVentaVehiculo,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->AovId = $oAprobacionVentaVehiculo;
			$this->MtdObtenerAprobacionVentaVehiculo();

			$mensaje = "";
			
			$mensaje .= "<b><u>ASIGNACION DE VIN</u></b>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<i>Asignacion de VIN aprobada para Orden de Venta de Vehiculo.</i>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->OvvId."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Fecha de Aprobacion:</b> ".$this->AovFecha."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Revisado por:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Vendedor:</b> ".$this->PerNombreVendedor." ".$this->PerApellidoPaternoVendedor." ".$this->PerApellidoMaternoVendedor."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Cliente:</b>";
			
			$clientes = "";
			
			$clientes .= $this->TdoNombre." ".$this->CliNumeroDocumento." / ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno;
			
			if(!empty($this->AprobacionVentaVehiculoPropietario)){
				foreach($this->AprobacionVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($this->CliId<>$DatOrdenVentaVehiculoPropietario->CliId){
						$clientes .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
					}
					
				}
			}
			
		
			$mensaje .= $clientes;
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Sucursal:</b> ".$this->SucNombre."";	
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
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"ASIGNACION VIN: ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje,NULL);
			
		}
		
		
		








		
		public function MtdNotificarAprobacionVentaVehiculoAprobado($oAprobacionVentaVehiculo,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->AovId = $oAprobacionVentaVehiculo;
			$this->MtdObtenerAprobacionVentaVehiculo();

			$mensaje = "";
			
			$mensaje .= "<b><u>APROBACION DE ORDEN DE VENTA DE VEHICULO</u></b>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<i>Aprobacion para Orden de Venta de Vehiculo.</i>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->OvvId."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Fecha de Aprobacion:</b> ".$this->AovFecha."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Aprobado por:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Vendedor:</b> ".$this->PerNombreVendedor." ".$this->PerApellidoPaternoVendedor." ".$this->PerApellidoMaternoVendedor."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Cliente:</b>";
			
			$clientes = "";
			
			$clientes .= $this->TdoNombre." ".$this->CliNumeroDocumento." / ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno;
			
			if(!empty($this->AprobacionVentaVehiculoPropietario)){
				foreach($this->AprobacionVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($this->CliId<>$DatOrdenVentaVehiculoPropietario->CliId){
						$clientes .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
					}
					
				}
			}
			
		
			$mensaje .= $clientes;
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Sucursal:</b> ".$this->SucNombre."";	
			$mensaje .= "<br>";	
			
				
			$mensaje .= "<b>Observaciones:</b> ".$this->AovObservacion."";	
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
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"APROBADO: ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje,NULL);
			
		}
		
		
	
	
		
		public function MtdNotificarAprobacionVentaVehiculoDesaprobado($oAprobacionVentaVehiculo,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->AovId = $oAprobacionVentaVehiculo;
			$this->MtdObtenerAprobacionVentaVehiculo();

			$mensaje = "";
			
			$mensaje .= "<b><u>DESAPROBACION DE ORDEN DE VENTA DE VEHICULO</u></b>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<i>Desaprobacion de Orden de Venta de Vehiculo.</i>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->OvvId."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Fecha de Aprobacion:</b> ".$this->AovFecha."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Desaprobado por:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Vendedor:</b> ".$this->PerNombreVendedor." ".$this->PerApellidoPaternoVendedor." ".$this->PerApellidoMaternoVendedor."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Cliente:</b>";
			
			$clientes = "";
			
			$clientes .= $this->TdoNombre." ".$this->CliNumeroDocumento." / ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno;
			
			if(!empty($this->AprobacionVentaVehiculoPropietario)){
				foreach($this->AprobacionVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($this->CliId<>$DatOrdenVentaVehiculoPropietario->CliId){
						$clientes .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
					}
					
				}
			}
			
		
			$mensaje .= $clientes;
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Sucursal:</b> ".$this->SucNombre."";	
			$mensaje .= "<br>";	
			
				
			$mensaje .= "<b>Observaciones:</b> ".$this->AovObservacion."";	
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
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"DESAPROBADO: ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje,NULL);
			
		}	
}
?>