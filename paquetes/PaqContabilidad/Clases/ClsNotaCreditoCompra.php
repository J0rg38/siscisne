<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaCreditoCompra
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaCreditoCompra {

    public $NccId;
	
    public $PerId;	
	public $PrvId;	
	public $AmoIdOrigen;

	
	public $NccComprobanteNumero;
	public $NccComprobanteNumeroSerie;
	public $NccComprobanteNumeroNumero;
	
	public $MonId;
	public $NccTipoCambio;
	
	public $NccEstado;
	public $NccFechaEmision;
	public $NccPorcentajeImpuestoVenta;
	
	public $NccSubTotal;
	public $NccImpuesto;
	public $NccTotal;	
	public $NccTotalReal;	
	
	public $NccObservacion;
	public $NccObservacionImpresa;

	
    public $NccTiempoCreacion;
    public $NccTiempoModificacion;
    public $NccEliminado;
	
	public $NccTotalItems;
	public $NotaCreditoCompraDetalle;

	public $PrvNombre;
	public $TdoId;
	public $PrvNumeroDocumento;
	public $PrvTelefono;
	public $PrvEmail;
	public $PrvCelular;
	public $PrvFax;

	public $PrvDepartamento;
	public $PrvProvincia;
	public $PrvDistrito;
	
	public $MonNombre;
	public $MonSimbolo;
	
    public $InsMysql;
	

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarNotaCreditoCompraId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AmoId,5),unsigned)) AS "MAXIMO"
			FROM tblamoalmacenmovimiento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->NccId = "NCC-10000";

			}else{
				$fila['MAXIMO']++;
				$this->NccId = "NCC-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerNotaCreditoCompra($oCompleto=true){


		$sql = 'SELECT 
				amo.AmoId AS NccId,
				amo.PerId,
				amo.PrvId,
				
				amo.AlmId,
				
				amo.AmoIdOrigen,
				
				amo.AmoComprobanteNumero AS NccComprobanteNumero,				
				DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NccComprobanteFecha",

				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFechaEmision",
				amo.AmoPorcentajeImpuestoVenta,

				amo.AmoObservacion AS "NccObservacion",
				
				amo.MonId,
				amo.AmoTipoCambio AS "NccTipoCambio",
				
				amo.AmoFoto AS "NccFoto",
				amo.AmoEstado AS "NccEstado",
								
				amo.AmoIncluyeImpuesto AS "NccIncluyeImpuesto",
				
				amo.AmoSubTotal AS "NccSubTotal",	
				amo.AmoImpuesto AS "NccImpuesto",
				amo.AmoTotal AS "NccTotal",	
				
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNccTiempoCreacion",
                DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNccTiempoModificacion",

				CONCAT(IFNULL(prv.PrvNombre,"")," ",IFNULL(prv.PrvApellidoPaterno,"")," ",IFNULL(prv.PrvApellidoMaterno,"")) AS PrvNombreCompleto,

				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,

				prv.TdoId,
				prv.PrvNumeroDocumento,

				mon.MonNombre,
				mon.MonSimbolo

				FROM tblamoalmacenmovimiento amo
						
					LEFT JOIN tblprvproveedor prv
					ON amo.PrvId = prv.PrvId
					
						LEFT JOIN tblmonmoneda mon
							ON amo.MonId = mon.MonId
							
				WHERE amo.AmoId = "'.$this->NccId.'" ;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			$this->NccId = $fila['NccId'];

            $this->PerId = $fila['PerId'];		
			$this->PrvId = $fila['PrvId'];
			$this->AlmId = $fila['AlmId'];
			
			$this->AmoIdOrigen = $fila['AmoIdOrigen'];
			
			$this->NccComprobanteNumero = $fila['NccComprobanteNumero'];
			list($this->NccComprobanteNumeroSerie,$this->NccComprobanteNumeroNumero) = explode("-",$this->NccComprobanteNumero);
			$this->NccComprobanteFecha = $fila['NccComprobanteFecha'];
			
			$this->NccFechaEmision = $fila['NNccFechaEmision'];
			$this->NccPorcentajeImpuestoVenta = $fila['NccPorcentajeImpuestoVenta'];

			list($this->NccObservacion,$this->NccObservacionImpresa) = explode("###",$fila['NccObservacion']);	
			
			$this->MonId = $fila['MonId'];
			$this->NccTipoCambio = $fila['NccTipoCambio'];	

			$this->NccFoto = $fila['NccFoto'];
			$this->NccEstado = $fila['NccEstado'];
			

			$this->NccIncluyeImpuesto = $fila['NccIncluyeImpuesto'];
			
			$this->NccSubTotal = $fila['NccSubTotal'];
			$this->NccImpuesto = $fila['NccImpuesto'];
			$this->NccTotal = $fila['NccTotal'];

			$this->NccTiempoCreacion = $fila['NNccTiempoCreacion'];
			$this->NccTiempoModificacion = $fila['NNccTiempoModificacion']; 		

			$this->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
			$this->PrvNombre = $fila['PrvNombre']; 
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
			
			$this->TdoId = $fila['TdoId']; 
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 

			$this->MonNombre = $fila['MonNombre']; 
			$this->MonSimbolo = $fila['MonSimbolo']; 
			
			if($oCompleto){
				
				$InsNotaCreditoCompraDetalle = new ClsNotaCreditoCompraDetalle();
				$ResNotaCreditoCompraDetalle =  $InsNotaCreditoCompraDetalle->MtdObtenerNotaCreditoCompraDetalles(NULL,NULL,NULL,NULL,NULL,$this->NccId);
				$this->NotaCreditoCompraDetalle = $ResNotaCreditoCompraDetalle['Datos'];

			}

			switch($this->NccEstado){

				case 1:
					$this->NccEstadoDescripcion = "Pendiente";
				break;
									
				case 3:
					$this->NccEstadoDescripcion = "Recibido";
				break;
				
				case 6:
					$this->NccEstadoDescripcion = "Anulado";
			
				break;
				
			}
				
				
				switch($this->NccEstado){
					case 1:
						$this->NccEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$this->NccEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Recibido]" title="Recibido" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->NccEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					
				}
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerNotaCreditoCompras($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oAlmacenMovimientoOrigen=NULL,$oProveedor=NULL) {
	
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
					nod.NodId
					FROM tblnodnotacreditocompradetalle nod
						LEFT JOIN tblproproducto pro
						ON nod.ProId = pro.ProId
					WHERE 
						nod.NccId = amo.NccId AND
							
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%"  OR
						pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%" 
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
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (amo.AmoEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

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
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'"';
		}

		if(!empty($oAlmacenMovimientoOrigen)){
			$amovimientoorigen = ' AND amo.AmoIdOrigen = "'.$oAlmacenMovimientoOrigen.'"';
		}
		
		if(!empty($oProveedor)){
			$cliente = ' AND amo.PrvId = "'.$oProveedor.'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId AS NccId,
				
				amo.PerId,
				amo.PrvId,
				amo.AmoIdOrigen,
		
				amo.AmoComprobanteNumero AS "NccComprobanteNumero",
				DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NccComprobanteFecha",
				
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NNccFechaEmision",
				amo.AmoPorcentajeImpuestoVenta AS "NccPorcentajeImpuestoVenta",
			
				amo.AmoIncluyeImpuesto AS "NccIncluyeImpuesto",
			
				amo.AmoSubTotal AS "NccSubTotal",	
				amo.AmoImpuesto AS "NccImpuesto",
				amo.AmoTotal AS "NccTotal",
		
				amo.AmoObservacion AS "NccObservacion",

				amo.MonId,
				amo.AmoTipoCambio AS "NccTipoCambio",
					
				amo.AmoFoto AS "NccFoto",
				amo.AmoEstado AS "NccEstado",	
				
				
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NccTiempoCreacion",
                DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NccTiempoModificacion",
				
				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId) AS "NccTotalItems",
				
				prv.TdoId,
				prv.PrvNumeroDocumento,
				
				CONCAT(IFNULL(prv.PrvNombre,"")," ",IFNULL(prv.PrvApellidoPaterno,"")," ",IFNULL(prv.PrvApellidoMaterno,"")) AS PrvNombreCompleto,
				
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,				

				mon.MonNombre,
				mon.MonSimbolo,
				
				amo2.AmoComprobanteNumero AS AmoComprobanteNumeroOrigen,
				DATE_FORMAT(amo2.AmoComprobanteFecha, "%d/%m/%Y %H:%i:%s") AS "AmoComprobanteFechaOrigen"

				FROM tblamoalmacenmovimiento amo
					
					LEFT JOIN tblprvproveedor prv
					ON amo.PrvId = prv.PrvId
					
						LEFT JOIN tblmonmoneda mon
						ON amo.MonId = mon.MonId
						
						LEFT JOIN tblamoalmacenmovimiento amo2
						ON amo.AmoId = amo2.AmoId
						
				WHERE  amo.AmoTipo = 2 AND amo.AmoSubTipo = 5 '.$filtrar.$sucursal.$estado.$fecha.$talonario.$credito.$regimen.$npago.$moneda.$amovimientoorigen.$cliente.$ovvehiculo.$vdirecta.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaCreditoCompra = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$NotaCreditoCompra = new $InsNotaCreditoCompra();
                    $NotaCreditoCompra->NccId = $fila['NccId'];
					
                    $NotaCreditoCompra->PerId= $fila['PerId'];
					$NotaCreditoCompra->PrvId= $fila['PrvId'];
					$NotaCreditoCompra->AmoIdOrigen= $fila['AmoIdOrigen'];

					$NotaCreditoCompra->NccComprobanteNumero = $fila['NccComprobanteNumero'];
					$NotaCreditoCompra->NccComprobanteFecha = $fila['NccComprobanteFecha'];
		
					$NotaCreditoCompra->NccFechaEmision = $fila['NNccFechaEmision'];
					$NotaCreditoCompra->NccPorcentajeImpuestoVenta = $fila['NccPorcentajeImpuestoVenta'];
					
					$NotaCreditoCompra->NccSubTotal = $fila['NccSubTotal']; 
					$NotaCreditoCompra->NccImpuesto = $fila['NccImpuesto']; 					
					$NotaCreditoCompra->NccTotal = $fila['NccTotal']; 
					
					list($NotaCreditoCompra->NccObservacion,$NotaCreditoCompra->NccObservacionImpresa) = explode("###",$fila['NccObservacion']);	

					$NotaCreditoCompra->MonId = $fila['MonId'];
					$NotaCreditoCompra->NccTipoCambio = $fila['NccTipoCambio'];
					
					$NotaCreditoCompra->NccFoto = $fila['NccFoto'];
					$NotaCreditoCompra->NccEstado = $fila['NccEstado'];
					
					
					$NotaCreditoCompra->NccIncluyeImpuesto = $fila['NccIncluyeImpuesto'];	
					
					$NotaCreditoCompra->NccSubTotal = $fila['NccSubTotal'];	
					$NotaCreditoCompra->NccImpuesto = $fila['NccImpuesto'];	
					$NotaCreditoCompra->NccTotal = $fila['NccTotal'];	
					
                    $NotaCreditoCompra->NccTiempoCreacion = $fila['NccTiempoCreacion'];
                    $NotaCreditoCompra->NccTiempoModificacion = $fila['NccTiempoModificacion'];

                    $NotaCreditoCompra->NccTotalItems = $fila['NccTotalItems'];					

					$NotaCreditoCompra->PrvNombreCompleto = $fila['PrvNombreCompleto'];
					$NotaCreditoCompra->PrvNombre = $fila['PrvNombre'];
					$NotaCreditoCompra->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$NotaCreditoCompra->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					
					$NotaCreditoCompra->TdoId = $fila['TdoId'];
					$NotaCreditoCompra->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];

					$NotaCreditoCompra->MonNombre = $fila['MonNombre'];
					$NotaCreditoCompra->MonSimbolo = $fila['MonSimbolo'];
					
					$NotaCreditoCompra->AmoComprobanteNumeroOrigen = $fila['AmoComprobanteNumeroOrigen'];
					$NotaCreditoCompra->AmoComprobanteFechaOrigen = $fila['AmoComprobanteFechaOrigen'];


					switch($NotaCreditoCompra->NccEstado){
						
						case 1:
							$NotaCreditoCompra->NccEstadoDescripcion = "Pendiente";
						break;
											
						case 3:
							$NotaCreditoCompra->NccEstadoDescripcion = "Recibido";
						break;
						
						case 6:
							$NotaCreditoCompra->NccEstadoDescripcion = "Anulado";
					
						break;
						
					}
				
				
					switch($NotaCreditoCompra->NccEstado){
					case 1:
						$NotaCreditoCompra->NccEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$NotaCreditoCompra->NccEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Recibido]" title="Recibido" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$NotaCreditoCompra->NccEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
				}
				
				
					$NotaCreditoCompra->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $NotaCreditoCompra;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

//MtdObtenerNotaCreditoCompras($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NccId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL)


//MtdObtenerNotaCreditoCompras($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimientoOrigen=NULL)


public function MtdObtenerNotaCreditoComprasValor($oFuncion="SUM",$oParametro="NccId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oAlmacenMovimientoOrigen=NULL,$oProveedor=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace("*","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
		}
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}

		
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (amo.NccEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

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

				
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND amo.MonId = "'.$oMoneda.'"';
		}
		
				
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
	
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) ="'.($oAno).'"';
		}
			
		if(!empty($oAlmacenMovimientoOrigen)){
			$amovimientoorigen = ' AND amo.AmoId = "'.$oAlmacenMovimientoOrigen.'"';
		}	
		
		if(!empty($oProveedor)){
			$cliente = ' AND amo.PrvId = "'.$oProveedor.'"';
		}	
			$sql = 'SELECT

				'.$funcion.' AS "RESULTADO"
				
				FROM tblamoalmacenmovimiento amo
				
				LEFT JOIN tblprvproveedor prv
				ON amo.PrvId = prv.PrvId
				
				WHERE amo.AmoTipo = 2 AND amo.AmoSubTipo = 5
				'.$$filtrar.$sucursal.$estado.$fecha.$credito.$regimen.$npago.$moneda.$mes.$ano.$amovimientoorigen.$cliente.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}




	public function MtdActualizarEstadoNotaCreditoCompra($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$aux = explode("%",$elemento);
					$this->NccId = $aux[0];
					
					
					$sql = 'UPDATE tblamoalmacenmovimiento SET AmoEstado = '.$oEstado.' WHERE   (AmoId = "'.($aux[0]).'" )';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{

						$this->MtdAuditarNotaCreditoCompra(2,"Se actualizo el Estado de la NotaCreditoCompra",$aux);	
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
	
	public function MtdEliminarNotaCreditoCompra($oElementos) {
		
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$InsNotaCreditoCompraDetalle = new ClsNotaCreditoCompraDetalle();
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$this->NccId = $elemento;
					$this->MtdObtenerNotaCreditoCompra();

					if(!$error){
						

//MtdObtenerNotaCreditoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oNotaCreditoCompra=NULL,$oAlmacenMovimientoDetalleId=NULL,$oNotaCreditoCompraEstado=NULL)
						$ResNotaCreditoCompraDetalle = $InsNotaCreditoCompraDetalle->MtdObtenerNotaCreditoCompraDetalles(NULL,NULL,'NodId','DESC',NULL,$elemento,NULL,NULL);
						$ArrNotaCreditoCompraDetalles = $ResNotaCreditoCompraDetalle['Datos'];
	
						if(!empty($ArrNotaCreditoCompraDetalles)){
							$amdetalle = '';
	
							foreach($ArrNotaCreditoCompraDetalles as $DatNotaCreditoCompraDetalle){
								$amdetalle .= '#'.$DatNotaCreditoCompraDetalle->NodId;
							}
	
							if(!$InsNotaCreditoCompraDetalle->MtdEliminarNotaCreditoCompraDetalle($amdetalle)){								
								$error = true;
							}
	
						}
					
						
						if(!$error) {
							
							$sql = 'DELETE FROM tblamoalmacenmovimiento WHERE (AmoId = "'.($elemento).'" )';
							$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
							
							if(!$resultado) {						
								$error = true;
							}else{
								$this->MtdAuditarNotaCreditoCompra(3,"Se elimino la Nota de Credito de Compra",$aux);		
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
	
	
	public function MtdRegistrarNotaCreditoCompra() {

			global $Resultado;
			$error = false;
			
			$this->NccId = trim($this->NccId);
			
			$this->InsMysql->MtdTransaccionIniciar();

			$this->MtdGenerarNotaCreditoCompraId();
			
				$sql = 'INSERT INTO tblamoalmacenmovimiento (
				AmoId,
				SucId,
				
				PerId, 
				PrvId,
				AlmId,
				
				TopId,
				CtiId,
				
				AmoIdOrigen,
				
				AmoComprobanteNumero,
				AmoComprobanteFecha,
				
				AmoFecha,
				AmoPorcentajeImpuestoVenta,
				
				AmoIncluyeImpuesto,

				AmoSubTotal,
				AmoImpuesto,
				AmoTotal,		

				AmoObservacion,
				
				MonId,
				AmoTipoCambio,	
				
				AmoFoto,
				AmoEstado,
				
				AmoTipo,
				AmoSubTipo,
				
				AmoTiempoCreacion,
				AmoTiempoModificacion
				
				) 
				VALUES (
				"'.($this->NccId).'", 
				"'.($this->SucId).'", 
				'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
				"'.($this->PrvId).'",
				"'.($this->AlmId).'",
				
				"'.($this->TopId).'",
				"'.($this->CtiId).'",
				
				'.(empty($this->AmoIdOrigen)?'NULL, ':'"'.$this->AmoIdOrigen.'",').'
			
				"'.($this->NccComprobanteNumero).'",
				'.(empty($this->NccComprobanteFecha)?'NULL, ':'"'.$this->NccComprobanteFecha.'",').'
				
				"'.($this->NccFechaEmision).'",
				'.($this->NccPorcentajeImpuestoVenta).',
				
				'.($this->NccIncluyeImpuesto).',
				
				'.($this->NccSubTotal).',
				'.($this->NccImpuesto).',
				'.($this->NccTotal).',			
				
				"'.($this->NccObservacion).'", 
				
				"'.($this->MonId).'",
				'.(empty($this->NccTipoCambio)?'NULL, ':''.$this->NccTipoCambio.',').'
				
				"'.($this->NccFoto).'",
				'.($this->NccEstado).',

				2,
				5,

				"'.($this->NccTiempoCreacion).'", 
				"'.($this->NccTiempoModificacion).'");';
		
				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;
						
						switch($this->InsMysql->MtdObtenerErrorCodigo()){
							case 1062:					
								$Resultado.="#ERR_NCC_402";
							break;
						}
					} 
				}
				
				if(!$error){			
				
					if (!empty($this->NotaCreditoCompraDetalle)){		
							
						$validar = 0;				
						$InsNotaCreditoCompraDetalle = new ClsNotaCreditoCompraDetalle();		
								
						foreach ($this->NotaCreditoCompraDetalle as $DatNotaCreditoCompraDetalle){
							
							$InsNotaCreditoCompraDetalle->NccId = $this->NccId;
							
							$InsNotaCreditoCompraDetalle->ProId = $DatNotaCreditoCompraDetalle->ProId;
							$InsNotaCreditoCompraDetalle->UmeId = $DatNotaCreditoCompraDetalle->UmeId;

							$InsNotaCreditoCompraDetalle->AmdIdOrigen = $DatNotaCreditoCompraDetalle->AmdIdOrigen;

							$InsNotaCreditoCompraDetalle->NodPrecio = $DatNotaCreditoCompraDetalle->NodPrecio;
							$InsNotaCreditoCompraDetalle->NodCantidad = $DatNotaCreditoCompraDetalle->NodCantidad;
							$InsNotaCreditoCompraDetalle->NodCantidadReal = $DatNotaCreditoCompraDetalle->NodCantidadReal;
							$InsNotaCreditoCompraDetalle->NodImporte = $DatNotaCreditoCompraDetalle->NodImporte;
							
							$InsNotaCreditoCompraDetalle->AlmId = $this->AlmId;
							$InsNotaCreditoCompraDetalle->NodFecha = $this->NccFechaEmision;
							
							$InsNotaCreditoCompraDetalle->NodEstado = $DatNotaCreditoCompraDetalle->NodEstado;
							$InsNotaCreditoCompraDetalle->NodTiempoCreacion = $DatNotaCreditoCompraDetalle->NodTiempoCreacion;
							$InsNotaCreditoCompraDetalle->NodTiempoModificacion = $DatNotaCreditoCompraDetalle->NodTiempoModificacion;						
							$InsNotaCreditoCompraDetalle->NodEliminado = $DatNotaCreditoCompraDetalle->NodEliminado;
							
							if($InsNotaCreditoCompraDetalle->MtdRegistrarNotaCreditoCompraDetalle()){
								$validar++;					
							}else{
								$Resultado.='#ERR_NCC_201';
								$Resultado.='#Item Numero: '.($validar+1);
							}
						}					
						
						if(count($this->NotaCreditoCompraDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
				
				
		

			if($error) {	

				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarNotaCreditoCompra(1,"Se registro la NotaCreditoCompra",$this);			
				return true;
			}			
			
	}
	
	public function MtdEditarNotaCreditoCompra() {
		
			global $Resultado;
			$error = false;


			$this->InsMysql->MtdTransaccionIniciar();
			
				$sql = 'UPDATE tblamoalmacenmovimiento SET 
				
				'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
				
				AmoComprobanteNumero = "'.($this->NccComprobanteNumero).'",	
				'.(empty($this->NccComprobanteFecha)?'AmoComprobanteFecha = NULL, ':'AmoComprobanteFecha = "'.$this->NccComprobanteFecha.'",').'
			
				AmoFecha = "'.($this->NccFechaEmision).'",	
				AmoPorcentajeImpuestoVenta = '.($this->NccPorcentajeImpuestoVenta).',
				
				MonId = "'.($this->MonId).'",
				'.(empty($this->NccTipoCambio)?'AmoTipoCambio = NULL, ':'AmoTipoCambio = "'.$this->NccTipoCambio.'",').'
				
				AmoIncluyeImpuesto = '.($this->NccIncluyeImpuesto).',
				
				AmoFoto = "'.($this->NccFoto).'",
				AmoSubTotal = '.($this->NccSubTotal).',
				AmoImpuesto = '.($this->NccImpuesto).',
				AmoTotal = '.($this->NccTotal).',
				AmoObservacion = "'.($this->NccObservacion).'",
				
				AmoEstado = '.($this->NccEstado).',
				
				AmoTiempoModificacion = "'.($this->NccTiempoModificacion).'"			
				WHERE AmoId = "'.($this->NccId).'";';
				
				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;
					} 
				}
	
				if(!$error){
				
					if (!empty($this->NotaCreditoCompraDetalle)){		
							
							
						$validar = 0;				
						$InsNotaCreditoCompraDetalle = new ClsNotaCreditoCompraDetalle();		
								
						foreach ($this->NotaCreditoCompraDetalle as $DatNotaCreditoCompraDetalle){
											
							$InsNotaCreditoCompraDetalle->NodId = $DatNotaCreditoCompraDetalle->NodId;
							$InsNotaCreditoCompraDetalle->NccId = $this->NccId;
							
							$InsNotaCreditoCompraDetalle->AmdIdOrigen = $DatNotaCreditoCompraDetalle->AmdIdOrigen;
							
							$InsNotaCreditoCompraDetalle->ProId = $DatNotaCreditoCompraDetalle->ProId;
							$InsNotaCreditoCompraDetalle->UmeId = $DatNotaCreditoCompraDetalle->UmeId;
							
							$InsNotaCreditoCompraDetalle->NodPrecio = $DatNotaCreditoCompraDetalle->NodPrecio;
							$InsNotaCreditoCompraDetalle->NodCantidad = $DatNotaCreditoCompraDetalle->NodCantidad;
							$InsNotaCreditoCompraDetalle->NodCantidadReal = $DatNotaCreditoCompraDetalle->NodCantidadReal;
							$InsNotaCreditoCompraDetalle->NodImporte = $DatNotaCreditoCompraDetalle->NodImporte;
							
							$InsNotaCreditoCompraDetalle->NodEstado = $DatNotaCreditoCompraDetalle->NodEstado;
							$InsNotaCreditoCompraDetalle->NodTiempoCreacion = $DatNotaCreditoCompraDetalle->NodTiempoCreacion;
							$InsNotaCreditoCompraDetalle->NodTiempoModificacion = $DatNotaCreditoCompraDetalle->NodTiempoModificacion;
							$InsNotaCreditoCompraDetalle->NodEliminado = $DatNotaCreditoCompraDetalle->NodEliminado;
							
							if(empty($InsNotaCreditoCompraDetalle->NodId)){
								if($InsNotaCreditoCompraDetalle->NodEliminado<>2){
									if($InsNotaCreditoCompraDetalle->MtdRegistrarNotaCreditoCompraDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_NCC_201';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}else{
									$validar++;	
								}
							}else{						
								if($InsNotaCreditoCompraDetalle->NodEliminado==2){
									if($InsNotaCreditoCompraDetalle->MtdEliminarNotaCreditoCompraDetalle($InsNotaCreditoCompraDetalle->NodId)){
										$validar++;					
									}else{
										$Resultado.='#ERR_NCC_203';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}else{
									if($InsNotaCreditoCompraDetalle->MtdEditarNotaCreditoCompraDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_NCC_202';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}
							}									
						}
						
						
						if(count($this->NotaCreditoCompraDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
						
						
				
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				$this->MtdAuditarNotaCreditoCompra(2,"Se edito la NotaCreditoCompra",$this);		
				return true;
			}	
		
		
		}	
		

	public function MtdVerificarExisteAlmacenMovimientoSalidaId($oAlmacenMovimientoSalidaId){
		
		$NotaCreditoCompra = array();
		
        $sql = 'SELECT 
		amo.AmoId AS "NccId"
        FROM tblamoalmacenmovimiento amo
        WHERE  amo.AmoId = "'.$oAlmacenMovimientoSalidaId.'" 
		AND amo.AmoEstado <> 1
		LIMIT 1;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				$NotaCreditoCompra[]  = $fila['NccId'];
				
			}
		}
		return $NotaCreditoCompra ;

	}
			
	public function MtdVerificarExisteNotaCreditoCompra($oCampo,$oDato){
			
		$Respuesta =   NULL;

		$sql = 'SELECT 
		amo.AmoId AS "NccId"
		FROM tblamoalmacenmovimiento amo
		WHERE '.$oCampo.' = "'.$oDato.'" LIMIT 1;';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			$Respuesta = $fila['NccId'];
		}
		
		return $Respuesta;
	
	}
		
	private function MtdAuditarNotaCreditoCompra($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
		
		$InsAuditoria = new ClsAuditoria();
		$InsAuditoria->AudCodigo = $this->NccId;
		$InsAuditoria->AudCodigoExtra = $this->BtaId;
		$InsAuditoria->PerId = $this->PerId;
		$InsAuditoria->SucId = $this->SucId;
		$InsAuditoria->AudAccion = $oAccion;
		$InsAuditoria->AudDescripcion = $oDescripcion;
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