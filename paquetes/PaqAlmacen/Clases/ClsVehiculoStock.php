<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoStock
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoStock {

    public $VstId;
	public $SucId;
	
	public $VprId;
	public $CliId;
	public $VehId;
	public $OncId;
	
	public $VstVIN;
	public $VstFechaVenta;
	
	public $VmaId;
	public $VmoId;
	public $VveId;
	public $VtiId;
	
    public $VstAnoFabricacion;
	public $VstAnoModelo;
	public $VstAnoVehiculo;
	public $VstNumeroMotor;

	public $VstTransmision;
	
	public $VstDUA;
	public $VstGuiaTransporte;
	public $VstGuiaRemision;
	public $VstPlaca;
	public $VstPoliza;
	public $VstZofra;
	public $VstNacionalizado;
	
	public $VstColor;
	
	public $VstTipo;
	
	public $VstNumeroProforma;
	public $VstAnoProforma;
	public $VstMesProforma;
	
	public $PerId;
	public $VstArchivoDAM;
	public $VstArchivoDAM2;
	public $VstArchivoDAM3;
	
	public $VstFechaSalidaDAM;
	public $VstFechaRetornoDAM;
	public $VstEstadoVehicular;
	public $VstSolicitud;
	public $VstEstadoVehicularFechaSalida;
	public $VstEstadoVehicularFechaLlegada;
	public $VstNumeroViaje;
	public $VstUbicacion;
	public $VstManualPropietario;
	public $VstManualGarantia;
	
	public $VstFoto;
	
	public $VstKilometraje;
	public $VstNombre;
	public $VveCaracteristica1;
	public $VveCaracteristica2;
	public $VveCaracteristica3;
	public $VveCaracteristica4;
	public $VveCaracteristica5;
	public $VveCaracteristica6;
	public $VveCaracteristica7;
	public $VveCaracteristica8;
	public $VveCaracteristica9;
	public $VveCaracteristica10;
	
	public $VveCaracteristica11;
	public $VveCaracteristica12;
	public $VveCaracteristica13;
	public $VveCaracteristica14;
	public $VveCaracteristica15;
	public $VveCaracteristica16;
	public $VveCaracteristica17;
	public $VveCaracteristica18;
	public $VveCaracteristica19;
	public $VveCaracteristica20;
	
	public $MonId;
	public $VstTipoCambio;
	public $VstDescuentoGerencia;
	public $VstClaveAlarma;
	
	public $VstEstado;
    public $VstTiempoCreacion;
    public $VstTiempoModificacion;
    public $VstEliminado;
	
//	public $VmoId;
	public $VmoNombre;
	
//	public $VmaId;
	public $VmaNombre;
	
//	public $VtiId;
	public $VtiNombre;
	
//	public $VveId;
	public $VveNombre;

//	public $VehColor;

		
	public $TdoId;
	public $CliNombre;
	public $CliNumeroDocumento;
	
	public $OncNombre;
	
	public $VehiculoStockCliente;
			
    public $InsMysql;
	public $Transaccion;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		
		$this->Transaccion = true;
    }
	
	public function __destruct(){

	}
  public function MtdObtenerVehiculoStock(){

        $sql = 'SELECT 
		veh.VehId,
				
				veh.VehNombre,
				veh.VehCodigoIdentificador,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				vve.VveFoto,
				
				vve.VveId,
				vve.VmoId,
				vmo.VmaId,
				
				ume.UmeNombre

				FROM tblvehvehiculo veh
					LEFT JOIN tblvvevehiculoversion vve
					ON veh.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
							LEFT JOIN tblumeunidadmedida ume
							ON veh.UmeId = ume.UmeId
							
    			    WHERE veh.VehId = "'.$this->VehId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->VehId = $fila['VehId'];
			$this->VehNombre = $fila['VehNombre'];
			$this->VehCodigoIdentificador = $fila['VehCodigoIdentificador'];
			
			$this->VveNombre = $fila['VveNombre'];
			$this->VmaNombre = $fila['VmaNombre'];
			$this->VmoNombre = $fila['VmoNombre'];
			
			$this->VveId = $fila['VveId'];
			$this->VmoId = $fila['VmoId'];
			$this->VmaId = $fila['VmaId'];
			
			$this->VveFoto = $fila['VveFoto'];
			$this->UmeNombre = $fila['UmeNombre'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
    public function MtdObtenerVehiculoStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VstId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL,$oVehiculo=NULL,$oAno=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
		

		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vmo.VmoId = "'.$oVehiculoModelo.'" ';
		}
		
		if(!empty($oVehiculoVersion)){
			$version = ' AND vve.VveId = "'.$oVehiculoVersion.'" ';
		}
			
			
		if(!empty($oAnoModelo)){
			$amodelo = ' AND ein.EinAnoModelo = "'.$oAnoModelo.'" ';
		}

		if(!empty($oAnoFabricacion)){
			$afabricacion = ' AND ein.EinAnoFabricacion = "'.$oAnoFabricacion.'" ';
		}

		
		if(!empty($oColor)){
			$color = ' AND ein.EinColor LIKE "%'.$oColor.'%" ';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ein.SucId = "'.$oSucursal.'" ';
		}	
		
		if(!empty($oEstado)){
			$estado = ' AND veh.VehEstado = "'.$oEstado.'" ';
		}	
		
		
		
		if(!empty($oVehiculo)){
			$vehiculo = ' AND veh.VehId = "'.$oVehiculo.'" ';
		}	
				
		if(!empty($oSucursal)){
			
			$almacen = '

				(
				SELECT 
				SUM(sve.SveStock )
				FROM tblsvesucursalvehiculo sve
					WHERE sve.VehId = veh.VehId
				AND sve.SucId = "'.$oSucursal.'"
				AND sve.SveAno = '.$oAno.'
				) AS SveStock,

			';	
			
		}else{
			
			$almacen = '
				(
				SELECT 
				SUM(sve.SveStock)
				FROM tblsvesucursalvehiculo sve
				
				WHERE sve.VehId = veh.VehId
				AND sve.SveAno =  '.$oAno.'
				) AS SveStock,
			';	
			
		}
		
			if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}
				
				
				 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				veh.VehId,
				
				'.$almacen.'
				
				veh.VehNombre,
				veh.VehCodigoIdentificador,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				vve.VveFoto,
				
				vve.VveId,
				vve.VmoId,
				vmo.VmaId,
				
				(
					SELECT 
					COUNT(ein.EinId) 
					FROM tbleinvehiculoingreso ein
						LEFT JOIN tblvvevehiculoversion vve2
						ON ein.VveId = vve2.VveId
							LEFT JOIN tblvmovehiculomodelo vmo2
							ON vve2.VmoId = vmo2.VmoId
								LEFT JOIN tblvmavehiculomarca vma2
								ON vmo2.VmaId = vma2.VmaId
					
					WHERE ein.VehId = veh.VehId
					AND ein.EinEstadoVehicular = "STOCK"
					AND ein.EinEstadoVehicular = "RESERVADO"
					AND ein.EinEstadoVehicular = "C/INCIDENCIA"
					AND ein.EinEstadoVehicular = "TRAMITE"
					'.$sucursal.$color.$amodelo.$afabricacion.'
					LIMIT 1
				) AS VstStock,
				
				(
					SELECT 
					COUNT(ein.EinId) 
					FROM tbleinvehiculoingreso ein
						LEFT JOIN tblvvevehiculoversion vve2
						ON ein.VveId = vve2.VveId
							LEFT JOIN tblvmovehiculomodelo vmo2
							ON vve2.VmoId = vmo2.VmoId
								LEFT JOIN tblvmavehiculomarca vma2
								ON vmo2.VmaId = vma2.VmaId
					
					WHERE ein.VehId = veh.VehId
					AND ein.EinEstadoVehicular = "STOCK"
					'.$sucursal.$color.$amodelo.$afabricacion.'						
					LIMIT 1
				) AS VstStockReal,
				
				(
					SELECT 
					COUNT(ein.EinId) 
					FROM tbleinvehiculoingreso ein
						LEFT JOIN tblvvevehiculoversion vve2
						ON ein.VveId = vve2.VveId
							LEFT JOIN tblvmovehiculomodelo vmo2
							ON vve2.VmoId = vmo2.VmoId
								LEFT JOIN tblvmavehiculomarca vma2
								ON vmo2.VmaId = vma2.VmaId
					
					WHERE ein.VehId = veh.VehId
					AND ein.EinEstadoVehicular = "RESERVADO"
					'.$sucursal.$color.$amodelo.$afabricacion.'						
					LIMIT 1
				) AS VstStockReservado,
				
				(
					SELECT 
					COUNT(ein.EinId) 
					FROM tbleinvehiculoingreso ein
						LEFT JOIN tblvvevehiculoversion vve2
						ON ein.VveId = vve2.VveId
							LEFT JOIN tblvmovehiculomodelo vmo2
							ON vve2.VmoId = vmo2.VmoId
								LEFT JOIN tblvmavehiculomarca vma2
								ON vmo2.VmaId = vma2.VmaId
					
					WHERE ein.VehId = veh.VehId
					AND ein.EinEstadoVehicular = "C/INCIDENCIA"
					'.$sucursal.$color.$amodelo.$afabricacion.'						
					LIMIT 1
				) AS VstStockCIncidencia,
				
				(
					SELECT 
					COUNT(ein.EinId) 
					FROM tbleinvehiculoingreso ein
						LEFT JOIN tblvvevehiculoversion vve2
						ON ein.VveId = vve2.VveId
							LEFT JOIN tblvmovehiculomodelo vmo2
							ON vve2.VmoId = vmo2.VmoId
								LEFT JOIN tblvmavehiculomarca vma2
								ON vmo2.VmaId = vma2.VmaId
					
					WHERE ein.VehId = veh.VehId
					AND ein.EinEstadoVehicular = "TRAMITE"
					'.$sucursal.$color.$amodelo.$afabricacion.'							
					LIMIT 1
				) AS VstStockTramite,											
			
				
				ume.UmeNombre

				FROM tblvehvehiculo veh
					LEFT JOIN tblvvevehiculoversion vve
					ON veh.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
							LEFT JOIN tblumeunidadmedida ume
							ON veh.UmeId = ume.UmeId
							
				WHERE  1 = 1  '.$filtrar.$vmarca.$estado.$vehiculo.$vmodelo.$version.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoStock = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoStock = new $InsVehiculoStock();
					
					
					$VehiculoStock->VehId = $fila['VehId'];
					$VehiculoStock->VehNombre = $fila['VehNombre'];
					$VehiculoStock->VehCodigoIdentificador = $fila['VehCodigoIdentificador'];
				
					$VehiculoStock->VveNombre = $fila['VveNombre'];
					$VehiculoStock->VmaNombre = $fila['VmaNombre'];
					$VehiculoStock->VmoNombre = $fila['VmoNombre'];
					
					$VehiculoStock->VveId = $fila['VveId'];
					$VehiculoStock->VmoId = $fila['VmoId'];
					$VehiculoStock->VmaId = $fila['VmaId'];
					
					$VehiculoStock->VveFoto = $fila['VveFoto'];
					//$VehiculoStock->VstStockVersion = $fila['VstStockVersion'];
					
					
					$VehiculoStock->VstStock = $fila['VstStock'];
					$VehiculoStock->VstStockReal = $fila['VstStockReal'];
					$VehiculoStock->VstStockReservado = $fila['VstStockReservado'];
					$VehiculoStock->VstStockCIncidencia = $fila['VstStockCIncidencia'];
					$VehiculoStock->VstStockTramite = $fila['VstStockTramite'];
					
					$VehiculoStock->UmeNombre = $fila['UmeNombre'];

                    $VehiculoStock->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoStock;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		public function MtdObtenerVehiculoColores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VstId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
		

		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'" ';
		}
		
		if(!empty($oVehiculoVersion)){
			$version = ' AND ein.VveId = "'.$oVehiculoVersion.'" ';
		}
			
			
		if(!empty($oAnoModelo)){
			$amodelo = ' AND ein.EinAnoModelo = "'.$oAnoModelo.'" ';
		}

		if(!empty($oAnoFabricacion)){
			$afabricacion = ' AND ein.EinAnoFabricacion = "'.$oAnoFabricacion.'" ';
		}

		
		if(!empty($oColor)){
			$color = ' AND ein.EinColor LIKE "%'.$oColor.'%" ';
		}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ein.SucId = "'.$oSucursal.'" ';
		}	
				
				 $sql = 'SELECT
				DISTINCT 
				ein.EinColor
				FROM tbleinvehiculoingreso ein
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
					
				WHERE  1 = 1  '.$filtrar.$vmarca.$vmodelo.$version.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoStock = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoStock = new $InsVehiculoStock();
					
					$VehiculoStock->EinColor = $fila['EinColor'];
					
                    $VehiculoStock->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoStock;
                }
			
			//$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			//$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	
	
}
?>