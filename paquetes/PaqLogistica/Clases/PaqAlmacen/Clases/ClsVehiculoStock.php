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

    public $VesId;
	public $SucId;
	
	public $VprId;
	public $CliId;
	public $VehId;
	public $OncId;
	
	public $VesVIN;
	public $VesFechaVenta;
	
	public $VmaId;
	public $VmoId;
	public $VveId;
	public $VtiId;
	
    public $VesAnoFabricacion;
	public $VesAnoModelo;
	public $VesAnoVehiculo;
	public $VesNumeroMotor;

	public $VesTransmision;
	
	public $VesDUA;
	public $VesGuiaTransporte;
	public $VesGuiaRemision;
	public $VesPlaca;
	public $VesPoliza;
	public $VesZofra;
	public $VesNacionalizado;
	
	public $VesColor;
	
	public $VesTipo;
	
	public $VesNumeroProforma;
	public $VesAnoProforma;
	public $VesMesProforma;
	
	public $PerId;
	public $VesArchivoDAM;
	public $VesArchivoDAM2;
	public $VesArchivoDAM3;
	
	public $VesFechaSalidaDAM;
	public $VesFechaRetornoDAM;
	public $VesEstadoVehicular;
	public $VesSolicitud;
	public $VesEstadoVehicularFechaSalida;
	public $VesEstadoVehicularFechaLlegada;
	public $VesNumeroViaje;
	public $VesUbicacion;
	public $VesManualPropietario;
	public $VesManualGarantia;
	
	public $VesFoto;
	
	public $VesKilometraje;
	public $VesNombre;
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
	public $VesTipoCambio;
	public $VesDescuentoGerencia;
	public $VesClaveAlarma;
	
	public $VesEstado;
    public $VesTiempoCreacion;
    public $VesTiempoModificacion;
    public $VesEliminado;
	
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

	
    public function MtdObtenerVehiculoStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VesId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL) {

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
				
				 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				 
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				vve.VveFoto,
				
				vve.VveId,
				vve.VmoId,
				vmo.VmaId,
				
				/*(
					SELECT 
					COUNT(ein.EinId) 
					FROM tbleinvehiculoingreso ein
						LEFT JOIN tblvvevehiculoversion vve2
						ON ein.VveId = vve2.VveId
							LEFT JOIN tblvmovehiculomodelo vmo2
							ON vve2.VmoId = vmo2.VmoId
								LEFT JOIN tblvmavehiculomarca vma2
								ON vmo2.VmaId = vma2.VmaId
					
					WHERE vve2.VmoId = vmo.VmoId
					
					AND ein.EinEstadoVehicular = "STOCK"
					'.$vmarca.$vmodelo.$color.$sucursal.$afabricacion.$amodelo.'
					LIMIT 1
				) AS VesStockModelo,*/
												
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
					
					WHERE ein.VveId = vve.VveId
					
					AND ein.EinEstadoVehicular = "STOCK"
					'.$vmarca.$vmodelo.$color.$sucursal.$afabricacion.$amodelo.'
					LIMIT 1
				) AS VesStockVersion

				FROM tblvvevehiculoversion vve
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
					
					$VehiculoStock->VveNombre = $fila['VveNombre'];
					$VehiculoStock->VmaNombre = $fila['VmaNombre'];
					$VehiculoStock->VmoNombre = $fila['VmoNombre'];
					
					$VehiculoStock->VveId = $fila['VveId'];
					$VehiculoStock->VmoId = $fila['VmoId'];
					$VehiculoStock->VmaId = $fila['VmaId'];
					
					$VehiculoStock->VveFoto = $fila['VveFoto'];
					$VehiculoStock->VesStockVersion = $fila['VesStockVersion'];

                    $VehiculoStock->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoStock;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		public function MtdObtenerVehiculoColores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VesId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL,$oColor=NULL,$oSucursal=NULL) {

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