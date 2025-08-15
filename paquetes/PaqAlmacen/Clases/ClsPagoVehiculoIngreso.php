<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPagoVehiculoIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPagoVehiculoIngreso {

    public $PviId;
	public $PviTipo;
	public $PviSubTipo;
	public $PerId;
	public $CtiId;
	public $TopId;
	
	public $NpaId;
	public $PviCantidadDia;
	
	public $AlmId;
	public $PviFecha;
	public $PviDocumentoOrigen;
	
	public $PviGuiaRemisionNumero;
	public $PviGuiaRemisionNumeroSerie;
	public $PviGuiaRemisionNumeroNumero;
	public $PviGuiaRemisionFecha;
	public $PviGuiaRemisionFoto;
	
	public $PviComprobanteNumero;
	public $PviComprobanteNumeroSerie;
	public $PviComprobanteNumeroNumero;
	public $PviComprobanteFecha;

	public $MonId;
	public $PviTipoCambio;

	public $PviIncluyeImpuesto;
	public $PviPorcentajeImpuestoVenta;
	
	public $PviFoto;
    public $PviObservacion;
	
		
		
	public $PviSubTotal;
	public $PviImpuesto;
	public $PviTotal;
	

	public $PviCancelado;
	
	public $PviRevisado;
	
	public $PviEstado;
	public $PviTiempoCreacion;
	public $PviTiempoModificacion;
    public $PviEliminado;

	public $CtiNombre;
	
	public $TdoId;
	public $PrvNombre;
	public $PrvNumeroDocumento;
	
	public $TdoNombre;
	
	public $MonSimbolo;
	
	public $PagoVehiculoIngresoDetalle;
	public $PagoVehiculoIngresoExtorno;
	public $OrdenCompraPedido;
	
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

	public function MtdGenerarPagoVehiculoIngresoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(pvi.PviId,5),unsigned)) AS "MAXIMO"
		FROM tblpvipagovehiculoingreso pvi
		WHERE 1 = 1
		';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->PviId = "PVI-10000";
		}else{
			$fila['MAXIMO']++;
			$this->PviId = "PVI-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerPagoVehiculoIngreso(){

        $sql = 'SELECT 
        pvi.PviId,  
		pvi.SucId,
	
		pvi.PerId,
      	pvi.PrvId,
      	pvi.BanId,
				
		DATE_FORMAT(pvi.PviFecha, "%d/%m/%Y") AS "NPviFecha",
			
		pvi.PviNumeroBloque,
		pvi.PviComprobanteNumero,
		DATE_FORMAT(pvi.PviComprobanteFecha, "%d/%m/%Y") AS "NPviComprobanteFecha",
		
		pvi.MonId,
		pvi.PviTipoCambio,
		
		pvi.PviIncluyeImpuesto,
		pvi.PviPorcentajeImpuestoVenta,
	
		pvi.PviFoto,
		pvi.PviObservacion,

		pvi.PviSubTotal,
		pvi.PviImpuesto,
		pvi.PviTotal,
		
		pvi.PviEstado,
		DATE_FORMAT(pvi.PviTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPviTiempoCreacion",
        DATE_FORMAT(pvi.PviTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPviTiempoModificacion",
		
		mon.MonSimbolo,
		
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		prv.PrvNumeroDocumento,
		prv.PrvNombreCompleto,
		prv.TdoId
		
        FROM tblpvipagovehiculoingreso pvi
		
			LEFT JOIN tblmonmoneda mon
			ON pvi.MonId = mon.MonId		
				
				LEFT JOIN tblprvproveedor prv
				ON pvi.PrvId = prv.PrvId
        WHERE pvi.PviId = "'.$this->PviId.'" ';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->PviId = $fila['PviId'];
			$this->SucId = $fila['SucId'];		
			
			$this->PerId = $fila['PerId'];
			$this->PrvId = $fila['PrvId'];
          
			$this->AlmId = $fila['AlmId'];
			$this->PviFecha = $fila['NPviFecha'];
			$this->BanId = $fila['BanId'];
			
			$this->PviNumeroBloque = $fila['PviNumeroBloque'];
			$this->PviComprobanteNumero = $fila['PviComprobanteNumero'];
			list($this->PviComprobanteNumeroSerie,$this->PviComprobanteNumeroNumero) = explode("-",$this->PviComprobanteNumero);
			$this->PviComprobanteFecha = $fila['NPviComprobanteFecha'];

			$this->MonId = $fila['MonId'];
			$this->PviTipoCambio = $fila['PviTipoCambio'];
			$this->PviTipoCambioComercial = $fila['PviTipoCambioComercial'];
			
			$this->PviIncluyeImpuesto = $fila['PviIncluyeImpuesto'];
			$this->PviPorcentajeImpuestoVenta = $fila['PviPorcentajeImpuestoVenta'];
			
			$this->PviFoto = $fila['PviFoto'];
			$this->PviObservacion = $fila['PviObservacion'];
		
			$this->PviSubTotal = $fila['PviSubTotal'];
			$this->PviImpuesto = $fila['PviImpuesto'];
			$this->PviTotal = $fila['PviTotal'];
					
		
			$this->PviEstado = $fila['PviEstado'];
			$this->PviTiempoCreacion = $fila['NPviTiempoCreacion']; 
			$this->PviTiempoModificacion = $fila['NPviTiempoModificacion']; 	
			
			$this->MonSimbolo = $fila['MonSimbolo']; 	
			
			$this->PrvNombre = $fila['PrvNombre']; 	
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 	
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 	
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 	
			$this->PrvNombreCompleto = $fila['PrvNombreCompleto']; 	
			$this->TdoId = $fila['TdoId']; 	


		
		
		
			$InsPagoVehiculoIngresoDetalle = new ClsPagoVehiculoIngresoDetalle();
			//MtdObtenerPagoVehiculoIngresoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oSucursal=NULL)
			$ResPagoVehiculoIngresoDetalle =  $InsPagoVehiculoIngresoDetalle->MtdObtenerPagoVehiculoIngresoDetalles(NULL,NULL,NULL,"PvdId","ASC",NULL,$this->PviId);				
			$this->PagoVehiculoIngresoDetalle = 	$ResPagoVehiculoIngresoDetalle['Datos'];	


			switch($this->PviEstado){
			
				case 1:
					$Estado = "No Realizado";
				break;
			
				case 3:
					$Estado = "Realizado";						
				break;	

				default:
					$Estado = "";
				break;
			
			}
				
			$this->PviEstadoDescripcion = $Estado;
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPagoVehiculoIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PviId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFecha="PviFecha",$oSucursal=NULL) {

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
				
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					pvd.PvdId

					FROM tblpvdpagovehiculoingresodetalle pvd
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON pvd.EinId = ein.EinId

					WHERE 
						pvd.PviId = pvi.PviId  
						
						AND 
						(
						ein.EinVIN LIKE "%'.$oFiltro.'%" OR
						ein.EinNumeroMotor LIKE "%'.$oFiltro.'%"
					
						)
						
					) ';
					
									
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
				$fecha = ' AND DATE(pvi.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(pvi.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(pvi.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pvi.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oEstado)){
			$estado = ' AND pvi.PviEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND pvi.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND pvi.SucId = "'.$oSucursal.'"';
		}
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pvi.PviId,				
				pvi.SucId,
				
				pvi.PerId,
				pvi.BanId,
               
				DATE_FORMAT(pvi.PviFecha, "%d/%m/%Y") AS "NPviFecha",
				
				pvi.PviNumeroBloque,
				pvi.PviComprobanteNumero,
				DATE_FORMAT(pvi.PviComprobanteFecha, "%d/%m/%Y") AS "NPviComprobanteFecha",
				
				pvi.MonId,
				pvi.PviTipoCambio,
				pvi.PviTipoCambioComercial,
				
				pvi.PviIncluyeImpuesto,
				pvi.PviPorcentajeImpuestoVenta,
						
				pvi.PviFoto,
				pvi.PviObservacion,
				
				pvi.PviSubTotal,
				pvi.PviImpuesto,				
				pvi.PviTotal,
				
				pvi.PviEstado,
				DATE_FORMAT(pvi.PviTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPviTiempoCreacion",
	        	DATE_FORMAT(pvi.PviTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPviTiempoModificacion",
				
				(SELECT COUNT(pvd.PvdId) FROM tblpvdpagovehiculoingresodetalle pvd WHERE pvd.PviId = pvi.PviId ) AS "PviTotalItems",
	
				mon.MonSimbolo,	
				suc.SucNombre,
				
				
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.PrvNombreCompleto,
				prv.TdoId,
				
				ban.BanNombre

				FROM tblpvipagovehiculoingreso pvi
					
					LEFT JOIN tblmonmoneda mon
					ON pvi.MonId = mon.MonId
						LEFT JOIN tblsucsucursal suc
						ON pvi.SucId = suc.SucId
							LEFT JOIN tblprvproveedor prv
							ON pvi.PrvId = prv.PrvId
									LEFT JOIN tblbanbanco ban
									ON pvi.BanId = ban.BanId
				WHERE 1 = 1 '.$filtrar.$sucursal.$fecha.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPagoVehiculoIngreso = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PagoVehiculoIngreso = new $InsPagoVehiculoIngreso();
                    $PagoVehiculoIngreso->PviId = $fila['PviId'];
					$PagoVehiculoIngreso->SucId = $fila['SucId'];
					
					$PagoVehiculoIngreso->PerId = $fila['PerId'];	
					$PagoVehiculoIngreso->PrvId = $fila['PrvId'];	
					$PagoVehiculoIngreso->BanId = $fila['BanId'];
					
					$PagoVehiculoIngreso->PviFecha = $fila['NPviFecha'];
					
					$PagoVehiculoIngreso->PviNumeroBloque = $fila['PviNumeroBloque'];
					$PagoVehiculoIngreso->PviComprobanteNumero = $fila['PviComprobanteNumero'];
					list($PagoVehiculoIngreso->PviComprobanteNumeroSerie,$PagoVehiculoIngreso->PviComprobanteNumeroNumero) = explode("-",$PagoVehiculoIngreso->PviComprobanteNumero);					
					$PagoVehiculoIngreso->PviComprobanteFecha = $fila['NPviComprobanteFecha'];
					
					$PagoVehiculoIngreso->MonId = $fila['MonId'];
					$PagoVehiculoIngreso->PviTipoCambio = $fila['PviTipoCambio'];
					$PagoVehiculoIngreso->PviTipoCambioComercial = $fila['PviTipoCambioComercial'];
					
					$PagoVehiculoIngreso->PviIncluyeImpuesto = $fila['PviIncluyeImpuesto'];
					$PagoVehiculoIngreso->PviPorcentajeImpuestoVenta = $fila['PviPorcentajeImpuestoVenta'];
					
					$PagoVehiculoIngreso->PviFoto = $fila['PviFoto'];
					$PagoVehiculoIngreso->PviObservacion = $fila['PviObservacion'];
		
					$PagoVehiculoIngreso->PviSubTotal = $fila['PviSubTotal'];			
					$PagoVehiculoIngreso->PviImpuesto = $fila['PviImpuesto'];
					$PagoVehiculoIngreso->PviTotal = $fila['PviTotal'];
			
					$PagoVehiculoIngreso->PviEstado = $fila['PviEstado'];
					$PagoVehiculoIngreso->PviTiempoCreacion = $fila['NPviTiempoCreacion'];  
					$PagoVehiculoIngreso->PviTiempoModificacion = $fila['NPviTiempoModificacion']; 

					$PagoVehiculoIngreso->PviTotalItems = $fila['PviTotalItems']; 
					
					$PagoVehiculoIngreso->MonSimbolo = $fila['MonSimbolo']; 
									
					$PagoVehiculoIngreso->SucNombre = $fila['SucNombre']; 
					
					$PagoVehiculoIngreso->PrvNombre = $fila['PrvNombre']; 
					$PagoVehiculoIngreso->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
					$PagoVehiculoIngreso->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					$PagoVehiculoIngreso->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
					$PagoVehiculoIngreso->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
					$PagoVehiculoIngreso->TdoId = $fila['TdoId']; 
					
					$PagoVehiculoIngreso->BanNombre = $fila['BanNombre']; 
		
		
					switch($PagoVehiculoIngreso->PviEstado){
					
						case 1:
							$Estado = "No Realizado";
						break;
					
						case 3:
							$Estado = "Realizado";						
						break;	
		
						default:
							$Estado = "";
						break;
					
					}
						
					$PagoVehiculoIngreso->PviEstadoDescripcion = $Estado;
					
					switch($PagoVehiculoIngreso->PviRevisado){
					
						case 1:
							$Revisado = "Revisado";
						break;
					
						case 3:
							$Revisado = "No Revisado";						
						break;	
		
						default:
							$Revisado = "";
						break;
					
					}
						
					$PagoVehiculoIngreso->PviRevisadoDescripcion = $Revisado;
					
                    $PagoVehiculoIngreso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PagoVehiculoIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		



    public function MtdObtenerPagoVehiculoIngresosValor($oFuncion="SUM",$oParametro="PviTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PviId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFecha="PviFecha",$oSucursal=NULL) {

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
				
				

				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					pvd.PvdId

					FROM tblpvdpagovehiculoingresodetalle pvd
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON pvd.EinId = ein.EinId

							LEFT JOIN tblpcdpedidocompradetalle pcd
							ON pvd.PcdId = pcd.PcdId
								
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
								
									LEFT JOIN tblclicliente cli
									ON pco.CliId = cli.CliId

					WHERE 
						pvd.PviId = pvi.PviId AND 
						(
						ein.ProNombre LIKE "%'.$oFiltro.'%" OR
						ein.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						ein.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" OR
						
						cli.CliNombreCompleto  LIKE "%'.$oFiltro.'%" OR
						cli.CliNombre  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoPaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoMaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliNumeroDocumento  LIKE "%'.$oFiltro.'%"
						
						)
						
						
						
					) ';
					
									
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
				$fecha = ' AND DATE(pvi.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(pvi.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(pvi.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pvi.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		

		if(!empty($oEstado)){
			$estado = ' AND pvi.PviEstado = '.$oEstado;
		}
		

	
		

		if(!empty($oMoneda)){
			$moneda = ' AND pvi.MonId = "'.$oMoneda.'"';
		}
		
	
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND pvi.SucId = "'.$oSucursal.'"';
		}
		
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(pvi.PviFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(pvi.PviFecha) ="'.($oAno).'"';
		}
		
		
		
			 $sql = 'SELECT
				'.$funcion.' AS "RESULTADO" 

				FROM tblpvipagovehiculoingreso pvi
				
								LEFT JOIN tblmonmoneda mon
								ON pvi.MonId = mon.MonId
	
							
						
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$sucursal.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarPagoVehiculoIngreso($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsPagoVehiculoIngresoDetalle = new ClsPagoVehiculoIngresoDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
					
					//MtdObtenerPagoVehiculoIngresoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPagoVehiculoIngreso=NULL,$oEstado=NULL,$oVehiculo=NULL)
					$ResPagoVehiculoIngresoDetalle = $InsPagoVehiculoIngresoDetalle->MtdObtenerPagoVehiculoIngresoDetalles(NULL,NULL,NULL,'PvdId','DESC',NULL,$elemento,NULL,NULL,NULL);
					$ArrPagoVehiculoIngresoDetalles = $ResPagoVehiculoIngresoDetalle['Datos'];

					if(!empty($ArrPagoVehiculoIngresoDetalles)){
						$pvdetalle = '';

						foreach($ArrPagoVehiculoIngresoDetalles as $DatPagoVehiculoIngresoDetalle){
							$pvdetalle .= '#'.$DatPagoVehiculoIngresoDetalle->PvdId;
						}

						if(!$InsPagoVehiculoIngresoDetalle->MtdEliminarPagoVehiculoIngresoDetalle($pvdetalle)){								
							$error = true;
						}

					}
					
					if(!$error) {		
					
						$this->PviId = $elemento;
						$this->MtdObtenerPagoVehiculoIngreso();

						$sql = 'DELETE FROM tblpvipagovehiculoingreso WHERE  (PviId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{
							
							$this->MtdAuditarPagoVehiculoIngreso(3,"Se elimino el pago de vehiculo",$aux);		
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
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoPagoVehiculoIngreso($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();
		
		$InsPagoVehiculoIngresoDetalle = new ClsPagoVehiculoIngresoDetalle();
		
		$elementos = explode("#",$oElementos);

		//$InsPagoVehiculoIngreso = new ClsPagoVehiculoIngreso();
		//$InsPagoVehiculoIngresoDetalles = new ClsPagoVehiculoIngresoDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	
					
					//MtdObtenerPagoVehiculoIngresoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPagoVehiculoIngreso=NULL,$oEstado=NULL,$oVehiculo=NULL)
					$ResPagoVehiculoIngresoDetalle = $InsPagoVehiculoIngresoDetalle->MtdObtenerPagoVehiculoIngresoDetalles(NULL,NULL,NULL,'PvdId','DESC',NULL,$elemento,NULL,NULL,NULL);
					$ArrPagoVehiculoIngresoDetalles = $ResPagoVehiculoIngresoDetalle['Datos'];

					if(!empty($ArrPagoVehiculoIngresoDetalles)){
						$pvdetalle = '';

						foreach($ArrPagoVehiculoIngresoDetalles as $DatPagoVehiculoIngresoDetalle){
							$pvdetalle .= '#'.$DatPagoVehiculoIngresoDetalle->PvdId;
						}

						if(!$InsPagoVehiculoIngresoDetalle->MtdActualizarEstadoPagoVehiculoIngresoDetalle($pvdetalle,$oEstado)){								
							$error = true;
						}

					}
					
					
					
					if(!$error) {		
					
						$sql = 'UPDATE tblpvipagovehiculoingreso SET PviEstado = '.$oEstado.' WHERE PviId = "'.$elemento.'"';
			
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarPagoVehiculoIngreso(2,"Se actualizo el Estado del pago de vehiculo",$elemento);
					
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
	
	
	
	public function MtdActualizarRevisadoPagoVehiculoIngreso($oElementos,$oRevisado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
					$sql = 'UPDATE tblcvecompravehiculo SET PviRevisado = '.$oRevisado.' WHERE PviId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
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
	
	public function MtdVerificarExistePagoVehiculoIngreso($oCampo,$oDato,$oProveedor=NULL){

		$Respuesta =   NULL;

		if($oProveedor){
			$einveedor = ' AND PerId = "'.$oProveedor.'"';
		}

			$sql = 'SELECT 
			PviId
			FROM tblpvipagovehiculoingreso
			WHERE '.$oCampo.' = "'.$oDato.'" '.$einveedor.' LIMIT 1;';

			$resultado = $this->InsMysql->MtdConsultar($sql);

			if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
				
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);
				//$this->EinId = $fila['EinId'];
				$Respuesta = $fila['PviId'];
	
			}
			
			return $Respuesta;
	
		}
	
	
	
	public function MtdRegistrarPagoVehiculoIngreso() {

			global $Resultado;

			$error = false;

			$this->MtdGenerarPagoVehiculoIngresoId();

			$PagoVehiculoIngresoId = $this->MtdVerificarExistePagoVehiculoIngreso("PviComprobanteNumero",$this->PviComprobanteNumero,$this->PerId);
	
			if(!empty($PagoVehiculoIngresoId)){
				$error = true;
				$Resultado.='#ERR_PVI_601';
			}

			
			$sql = 'INSERT INTO tblpvipagovehiculoingreso (
			PviId,	
			SucId,
			
			PrvId,
			PerId,   
			BanId,
			    
			PviFecha,
			
			
			PviNumeroBloque,
			PviComprobanteNumero,
			PviComprobanteFecha,
			MonId,
			PviTipoCambio,
			
			PviIncluyeImpuesto,
			PviPorcentajeImpuestoVenta,
					
			PviFoto,
			PviObservacion,
			
			PviSubTotal,
			PviImpuesto,				
			PviTotal,
			
			PviEstado,			
			PviTiempoCreacion,
			PviTiempoModificacion) 
			VALUES (
			"'.($this->PviId).'", 
			"'.($this->SucId).'", 			
			
			
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->BanId)?'NULL, ':'"'.$this->BanId.'",').'
			
			"'.($this->PviFecha).'", 
		
			"'.($this->PviNumeroBloque).'", 
			'.(empty($this->PviComprobanteNumero)?'NULL, ':'"'.$this->PviComprobanteNumero.'",').'
			'.(empty($this->PviComprobanteFecha)?'NULL, ':'"'.$this->PviComprobanteFecha.'",').'
			"'.($this->MonId).'",
			'.(empty($this->PviTipoCambio)?'NULL, ':''.$this->PviTipoCambio.',').'
			
			'.($this->PviIncluyeImpuesto).',
			'.($this->PviPorcentajeImpuestoVenta).',

			"'.($this->PviFoto).'",
			"'.($this->PviObservacion).'",

			'.($this->PviSubTotal).',
			'.($this->PviImpuesto).',
			'.($this->PviTotal).',
					
			'.($this->PviEstado).',
			"'.($this->PviTiempoCreacion).'", 			
			"'.($this->PviTiempoModificacion).'");';			
		
			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			
			if(!$resultado) {							
				$error = true;
			} 


//			if(round($this->PviValorTotal) <> round($this->PviSubTotal)){
//				$error = true;
//				$Resultado.='#ERR_PVI_110';
//			}


			if(!$error){			
			
				if (!empty($this->PagoVehiculoIngresoDetalle)){		
						
					$validar = 0;				
					$InsPagoVehiculoIngresoDetalle = new ClsPagoVehiculoIngresoDetalle();		
					
					foreach ($this->PagoVehiculoIngresoDetalle as $DatPagoVehiculoIngresoDetalle){
					
						$InsPagoVehiculoIngresoDetalle->PviId = $this->PviId;
						$InsPagoVehiculoIngresoDetalle->EinId = $DatPagoVehiculoIngresoDetalle->EinId;
						
						$InsPagoVehiculoIngresoDetalle->PvdCosto = $DatPagoVehiculoIngresoDetalle->PvdCosto;	
						$InsPagoVehiculoIngresoDetalle->PvdCantidad = $DatPagoVehiculoIngresoDetalle->PvdCantidad;
						$InsPagoVehiculoIngresoDetalle->PvdImporte = $DatPagoVehiculoIngresoDetalle->PvdImporte;
						
						$InsPagoVehiculoIngresoDetalle->PvdObservacion = $DatPagoVehiculoIngresoDetalle->PvdObservacion;
						
						$InsPagoVehiculoIngresoDetalle->PvdEstado = $DatPagoVehiculoIngresoDetalle->PvdEstado;									
						$InsPagoVehiculoIngresoDetalle->PvdTiempoCreacion = $DatPagoVehiculoIngresoDetalle->PvdTiempoCreacion;
						$InsPagoVehiculoIngresoDetalle->PvdTiempoModificacion = $DatPagoVehiculoIngresoDetalle->PvdTiempoModificacion;						
						$InsPagoVehiculoIngresoDetalle->PvdEliminado = $DatPagoVehiculoIngresoDetalle->PvdEliminado;
						
						if($InsPagoVehiculoIngresoDetalle->MtdRegistrarPagoVehiculoIngresoDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_PVI_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->PagoVehiculoIngresoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
					
				
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarPagoVehiculoIngreso(1,"Se registro el pago de vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarPagoVehiculoIngreso() {

		global $Resultado;
		$error = false;

			
			$sql = 'UPDATE tblpvipagovehiculoingreso SET
			
			
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->BanId)?'BanId = NULL, ':'BanId = "'.$this->BanId.'",').'
			
			
			PviFecha = "'.($this->PviFecha).'",
			
			PviNumeroBloque = "'.($this->PviNumeroBloque).'",
			'.(empty($this->PviComprobanteNumero)?'PviComprobanteNumero = NULL, ':'PviComprobanteNumero = "'.$this->PviComprobanteNumero.'",').'
			'.(empty($this->PviComprobanteFecha)?'PviComprobanteFecha = NULL, ':'PviComprobanteFecha = "'.$this->PviComprobanteFecha.'",').'
			MonId = "'.($this->MonId).'",
			PviTipoCambio = '.($this->PviTipoCambio).',
			
			PviIncluyeImpuesto = '.($this->PviIncluyeImpuesto).',
			PviPorcentajeImpuestoVenta = '.($this->PviPorcentajeImpuestoVenta).',						
			
			PviFoto = "'.($this->PviFoto).'",
			PviObservacion = "'.($this->PviObservacion).'",

			PviSubTotal = '.($this->PviSubTotal).',
			PviImpuesto = '.($this->PviImpuesto).',
			PviTotal = '.($this->PviTotal).',
			
			PviEstado = '.($this->PviEstado).'
			WHERE PviId = "'.($this->PviId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			


			//if(round($this->PviValorTotal) <> round($this->PviSubTotal)){
//				$error = true;
//				$Resultado.='#ERR_PVI_110';
//			}
			
			
			if(!$error){
			
				if (!empty($this->PagoVehiculoIngresoDetalle)){		
						
						
					$validar = 0;				
					$InsPagoVehiculoIngresoDetalle = new ClsPagoVehiculoIngresoDetalle();
							
					foreach ($this->PagoVehiculoIngresoDetalle as $DatPagoVehiculoIngresoDetalle){
										
						$InsPagoVehiculoIngresoDetalle->PvdId = $DatPagoVehiculoIngresoDetalle->PvdId;
						$InsPagoVehiculoIngresoDetalle->PviId = $this->PviId;
						$InsPagoVehiculoIngresoDetalle->EinId = $DatPagoVehiculoIngresoDetalle->EinId;
					
						$InsPagoVehiculoIngresoDetalle->PvdCosto = $DatPagoVehiculoIngresoDetalle->PvdCosto;		
						$InsPagoVehiculoIngresoDetalle->PvdCantidad = $DatPagoVehiculoIngresoDetalle->PvdCantidad;
						$InsPagoVehiculoIngresoDetalle->PvdImporte = $DatPagoVehiculoIngresoDetalle->PvdImporte;
						$InsPagoVehiculoIngresoDetalle->PvdObservacion = $DatPagoVehiculoIngresoDetalle->PvdObservacion;
						
						$InsPagoVehiculoIngresoDetalle->PvdEstado = $DatPagoVehiculoIngresoDetalle->PvdEstado;		
						$InsPagoVehiculoIngresoDetalle->PvdTiempoCreacion = $DatPagoVehiculoIngresoDetalle->PvdTiempoCreacion;
						$InsPagoVehiculoIngresoDetalle->PvdTiempoModificacion = $DatPagoVehiculoIngresoDetalle->PvdTiempoModificacion;
						$InsPagoVehiculoIngresoDetalle->PvdEliminado = $DatPagoVehiculoIngresoDetalle->PvdEliminado;
						
						if(empty($InsPagoVehiculoIngresoDetalle->PvdId)){
							if($InsPagoVehiculoIngresoDetalle->PvdEliminado<>2){
								if($InsPagoVehiculoIngresoDetalle->MtdRegistrarPagoVehiculoIngresoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PVI_201';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsPagoVehiculoIngresoDetalle->PvdEliminado==2){
								if($InsPagoVehiculoIngresoDetalle->MtdEliminarPagoVehiculoIngresoDetalle($InsPagoVehiculoIngresoDetalle->PvdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PVI_203';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsPagoVehiculoIngresoDetalle->MtdEditarPagoVehiculoIngresoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PVI_202';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->PagoVehiculoIngresoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
			
				
				
				
				
				
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarPagoVehiculoIngreso(2,"Se edito el pago de vehiculo",$this);		
				return true;
			}	
				
		}
		
		
	
		public function MtdEditarPagoVehiculoIngresoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblpvipagovehiculoingreso SET 
			'.$oCampo.' = "'.($oDato).'",
			PviTiempoModificacion = NOW()
			WHERE PviId = "'.($oId).'";';
			
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



		private function MtdAuditarPagoVehiculoIngreso($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->PviId;

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
		
}
?>