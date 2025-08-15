<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaCreditoVenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaCreditoVenta {

    public $NcvId;
	
    public $PerId;	
	public $CliId;	
	public $AmoIdOrigen;

	
	public $NcvComprobanteNumero;
	public $NcvComprobanteNumeroSerie;
	public $NcvComprobanteNumeroNumero;
	
	public $MonId;
	public $NcvTipoCambio;
	
	public $NcvEstado;
	public $NcvFechaEmision;
	public $NcvPorcentajeImpuestoVenta;
	
	public $NcvSubTotal;
	public $NcvImpuesto;
	public $NcvTotal;	
	public $NcvTotalReal;	
	
	public $NcvObservacion;
	public $NcvObservacionImpresa;

	
    public $NcvTiempoCreacion;
    public $NcvTiempoModificacion;
    public $NcvEliminado;
	
	public $NcvTotalItems;
	public $NotaCreditoVentaDetalle;

	public $CliNombre;
	public $TdoId;
	public $CliNumeroDocumento;
	public $CliTelefono;
	public $CliEmail;
	public $CliCelular;
	public $CliFax;

	public $CliDepartamento;
	public $CliProvincia;
	public $CliDistrito;
	
	public $MonNombre;
	public $MonSimbolo;
	
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

	public function MtdGenerarNotaCreditoVentaId() {
			
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(AmoId,5),unsigned)) AS "MAXIMO"
		FROM tblamoalmacenmovimiento';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->NcvId = "NCV-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->NcvId = "NCV-".$fila['MAXIMO'];					
		}	
			
	}
		
    public function MtdObtenerNotaCreditoVenta($oCompleto=true){


		$sql = 'SELECT 
				amo.AmoId AS NcvId,
				amo.PerId,
				amo.CliId,
				
				amo.AlmId,
				
				amo.AmoIdOrigen,
				
				amo.AmoComprobanteNumero AS NcvComprobanteNumero,				
				DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NcvComprobanteFecha",

				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFechaEmision",
				amo.AmoPorcentajeImpuestoVenta,

				amo.AmoObservacion AS "NcvObservacion",
				
				amo.MonId,
				amo.AmoTipoCambio AS "NcvTipoCambio",
				
				amo.AmoFoto AS "NcvFoto",
				amo.AmoEstado AS "NcvEstado",
								
				amo.AmoIncluyeImpuesto AS "NcvIncluyeImpuesto",
				
				amo.AmoSubTotal AS "NcvSubTotal",	
				amo.AmoImpuesto AS "NcvImpuesto",
				amo.AmoTotal AS "NcvTotal",	
				
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcvTiempoCreacion",
                DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNcvTiempoModificacion",

				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,

				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,

				cli.TdoId,
				cli.CliNumeroDocumento,

				mon.MonNombre,
				mon.MonSimbolo

				FROM tblamoalmacenmovimiento amo
						
					LEFT JOIN tblclicliente cli
					ON amo.CliId = cli.CliId
					
						LEFT JOIN tblmonmoneda mon
							ON amo.MonId = mon.MonId
							
				WHERE amo.AmoId = "'.$this->NcvId.'" ;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			$this->NcvId = $fila['NcvId'];

            $this->PerId = $fila['PerId'];		
			$this->CliId = $fila['CliId'];
			$this->AlmId = $fila['AlmId'];
			
			$this->AmoIdOrigen = $fila['AmoIdOrigen'];
			
			$this->NcvComprobanteNumero = $fila['NcvComprobanteNumero'];
			list($this->NcvComprobanteNumeroSerie,$this->NcvComprobanteNumeroNumero) = explode("-",$this->NcvComprobanteNumero);
			$this->NcvComprobanteFecha = $fila['NcvComprobanteFecha'];
			
			$this->NcvFechaEmision = $fila['NNcvFechaEmision'];
			$this->NcvPorcentajeImpuestoVenta = $fila['NcvPorcentajeImpuestoVenta'];

			list($this->NcvObservacion,$this->NcvObservacionImpresa) = explode("###",$fila['NcvObservacion']);	
			
			$this->MonId = $fila['MonId'];
			$this->NcvTipoCambio = $fila['NcvTipoCambio'];	

			$this->NcvFoto = $fila['NcvFoto'];
			$this->NcvEstado = $fila['NcvEstado'];
			

			$this->NcvIncluyeImpuesto = $fila['NcvIncluyeImpuesto'];
			
			$this->NcvSubTotal = $fila['NcvSubTotal'];
			$this->NcvImpuesto = $fila['NcvImpuesto'];
			$this->NcvTotal = $fila['NcvTotal'];

			$this->NcvTiempoCreacion = $fila['NNcvTiempoCreacion'];
			$this->NcvTiempoModificacion = $fila['NNcvTiempoModificacion']; 		

			$this->CliNombreCompleto = $fila['CliNombreCompleto']; 
			$this->CliNombre = $fila['CliNombre']; 
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
			
			$this->TdoId = $fila['TdoId']; 
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento']; 

			$this->MonNombre = $fila['MonNombre']; 
			$this->MonSimbolo = $fila['MonSimbolo']; 
			
			if($oCompleto){
				
				$InsNotaCreditoVentaDetalle = new ClsNotaCreditoVentaDetalle();
				$ResNotaCreditoVentaDetalle =  $InsNotaCreditoVentaDetalle->MtdObtenerNotaCreditoVentaDetalles(NULL,NULL,NULL,NULL,NULL,$this->NcvId);
				$this->NotaCreditoVentaDetalle = $ResNotaCreditoVentaDetalle['Datos'];

			}

			switch($this->NcvEstado){

				case 1:
					$this->NcvEstadoDescripcion = "Pendiente";
				break;
									
				case 3:
					$this->NcvEstadoDescripcion = "Recibido";
				break;
				
				case 6:
					$this->NcvEstadoDescripcion = "Anulado";
			
				break;
				
			}
				
				
				switch($this->NcvEstado){
					case 1:
						$this->NcvEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$this->NcvEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Recibido]" title="Recibido" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->NcvEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					
				}
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerNotaCreditoVentas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oAlmacenMovimientoOrigen=NULL,$oProveedor=NULL) {
	
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
						nod.NcvId = amo.NcvId AND
							
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
			$cliente = ' AND amo.CliId = "'.$oProveedor.'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId AS NcvId,
				
				amo.PerId,
				amo.CliId,
				amo.AmoIdOrigen,
		
				amo.AmoComprobanteNumero AS "NcvComprobanteNumero",
				DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NcvComprobanteFecha",
				
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NNcvFechaEmision",
				amo.AmoPorcentajeImpuestoVenta AS "NcvPorcentajeImpuestoVenta",
			
				amo.AmoIncluyeImpuesto AS "NcvIncluyeImpuesto",
			
				amo.AmoSubTotal AS "NcvSubTotal",	
				amo.AmoImpuesto AS "NcvImpuesto",
				amo.AmoTotal AS "NcvTotal",
		
				amo.AmoObservacion AS "NcvObservacion",

				amo.MonId,
				amo.AmoTipoCambio AS "NcvTipoCambio",
					
				amo.AmoFoto AS "NcvFoto",
				amo.AmoEstado AS "NcvEstado",	
				
				
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NcvTiempoCreacion",
                DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NcvTiempoModificacion",
				
				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId) AS "NcvTotalItems",
				
				cli.TdoId,
				cli.CliNumeroDocumento,
				
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,				

				mon.MonNombre,
				mon.MonSimbolo,
				
				amo2.AmoComprobanteNumero AS AmoComprobanteNumeroOrigen,
				DATE_FORMAT(amo2.AmoComprobanteFecha, "%d/%m/%Y %H:%i:%s") AS "AmoComprobanteFechaOrigen"

				FROM tblamoalmacenmovimiento amo
					
					LEFT JOIN tblclicliente cli
					ON amo.CliId = cli.CliId
					
						LEFT JOIN tblmonmoneda mon
						ON amo.MonId = mon.MonId
						
						LEFT JOIN tblamoalmacenmovimiento amo2
						ON amo.AmoId = amo2.AmoId
						
				WHERE  amo.AmoTipo = 2 AND amo.AmoSubTipo = 5 '.$filtrar.$sucursal.$estado.$fecha.$talonario.$credito.$regimen.$npago.$moneda.$amovimientoorigen.$cliente.$ovvehiculo.$vdirecta.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaCreditoVenta = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$NotaCreditoVenta = new $InsNotaCreditoVenta();
                    $NotaCreditoVenta->NcvId = $fila['NcvId'];
					
                    $NotaCreditoVenta->PerId= $fila['PerId'];
					$NotaCreditoVenta->CliId= $fila['CliId'];
					$NotaCreditoVenta->AmoIdOrigen= $fila['AmoIdOrigen'];

					$NotaCreditoVenta->NcvComprobanteNumero = $fila['NcvComprobanteNumero'];
					$NotaCreditoVenta->NcvComprobanteFecha = $fila['NcvComprobanteFecha'];
		
					$NotaCreditoVenta->NcvFechaEmision = $fila['NNcvFechaEmision'];
					$NotaCreditoVenta->NcvPorcentajeImpuestoVenta = $fila['NcvPorcentajeImpuestoVenta'];
					
					$NotaCreditoVenta->NcvSubTotal = $fila['NcvSubTotal']; 
					$NotaCreditoVenta->NcvImpuesto = $fila['NcvImpuesto']; 					
					$NotaCreditoVenta->NcvTotal = $fila['NcvTotal']; 
					
					list($NotaCreditoVenta->NcvObservacion,$NotaCreditoVenta->NcvObservacionImpresa) = explode("###",$fila['NcvObservacion']);	

					$NotaCreditoVenta->MonId = $fila['MonId'];
					$NotaCreditoVenta->NcvTipoCambio = $fila['NcvTipoCambio'];
					
					$NotaCreditoVenta->NcvFoto = $fila['NcvFoto'];
					$NotaCreditoVenta->NcvEstado = $fila['NcvEstado'];
					
					
					$NotaCreditoVenta->NcvIncluyeImpuesto = $fila['NcvIncluyeImpuesto'];	
					
					$NotaCreditoVenta->NcvSubTotal = $fila['NcvSubTotal'];	
					$NotaCreditoVenta->NcvImpuesto = $fila['NcvImpuesto'];	
					$NotaCreditoVenta->NcvTotal = $fila['NcvTotal'];	
					
                    $NotaCreditoVenta->NcvTiempoCreacion = $fila['NcvTiempoCreacion'];
                    $NotaCreditoVenta->NcvTiempoModificacion = $fila['NcvTiempoModificacion'];

                    $NotaCreditoVenta->NcvTotalItems = $fila['NcvTotalItems'];					

					$NotaCreditoVenta->CliNombreCompleto = $fila['CliNombreCompleto'];
					$NotaCreditoVenta->CliNombre = $fila['CliNombre'];
					$NotaCreditoVenta->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$NotaCreditoVenta->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$NotaCreditoVenta->TdoId = $fila['TdoId'];
					$NotaCreditoVenta->CliNumeroDocumento = $fila['CliNumeroDocumento'];

					$NotaCreditoVenta->MonNombre = $fila['MonNombre'];
					$NotaCreditoVenta->MonSimbolo = $fila['MonSimbolo'];
					
					$NotaCreditoVenta->AmoComprobanteNumeroOrigen = $fila['AmoComprobanteNumeroOrigen'];
					$NotaCreditoVenta->AmoComprobanteFechaOrigen = $fila['AmoComprobanteFechaOrigen'];


					switch($NotaCreditoVenta->NcvEstado){
						
						case 1:
							$NotaCreditoVenta->NcvEstadoDescripcion = "Pendiente";
						break;
											
						case 3:
							$NotaCreditoVenta->NcvEstadoDescripcion = "Recibido";
						break;
						
						case 6:
							$NotaCreditoVenta->NcvEstadoDescripcion = "Anulado";
					
						break;
						
					}
				
				
					switch($NotaCreditoVenta->NcvEstado){
					case 1:
						$NotaCreditoVenta->NcvEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 3:
						$NotaCreditoVenta->NcvEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Recibido]" title="Recibido" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$NotaCreditoVenta->NcvEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
				}
				
				
					$NotaCreditoVenta->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $NotaCreditoVenta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

//MtdObtenerNotaCreditoVentas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcvId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL)


//MtdObtenerNotaCreditoVentas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimientoOrigen=NULL)


public function MtdObtenerNotaCreditoVentasValor($oFuncion="SUM",$oParametro="NcvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMoneda=NULL,$oAlmacenMovimientoOrigen=NULL,$oProveedor=NULL) {

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
						$estado .= '  (amo.NcvEstado = "'.($elemento).'")';	
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
			$cliente = ' AND amo.CliId = "'.$oProveedor.'"';
		}	
			$sql = 'SELECT

				'.$funcion.' AS "RESULTADO"
				
				FROM tblamoalmacenmovimiento amo
				
				LEFT JOIN tblclicliente cli
				ON amo.CliId = cli.CliId
				
				WHERE amo.AmoTipo = 2 AND amo.AmoSubTipo = 5
				'.$$filtrar.$sucursal.$estado.$fecha.$credito.$regimen.$npago.$moneda.$mes.$ano.$amovimientoorigen.$cliente.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}




	public function MtdActualizarEstadoNotaCreditoVenta($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$aux = explode("%",$elemento);
					$this->NcvId = $aux[0];
					
					
					$sql = 'UPDATE tblamoalmacenmovimiento SET AmoEstado = '.$oEstado.' WHERE   (AmoId = "'.($aux[0]).'" )';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{

						$this->MtdAuditarNotaCreditoVenta(2,"Se actualizo el Estado de la NotaCreditoVenta",$aux);	
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
	
	public function MtdEliminarNotaCreditoVenta($oElementos) {
		
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$InsNotaCreditoVentaDetalle = new ClsNotaCreditoVentaDetalle();
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$this->NcvId = $elemento;
					$this->MtdObtenerNotaCreditoVenta();

					if(!$error){
						

//MtdObtenerNotaCreditoVentaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oNotaCreditoVenta=NULL,$oAlmacenMovimientoDetalleId=NULL,$oNotaCreditoVentaEstado=NULL)
						$ResNotaCreditoVentaDetalle = $InsNotaCreditoVentaDetalle->MtdObtenerNotaCreditoVentaDetalles(NULL,NULL,'NodId','DESC',NULL,$elemento,NULL,NULL);
						$ArrNotaCreditoVentaDetalles = $ResNotaCreditoVentaDetalle['Datos'];
	
						if(!empty($ArrNotaCreditoVentaDetalles)){
							$amdetalle = '';
	
							foreach($ArrNotaCreditoVentaDetalles as $DatNotaCreditoVentaDetalle){
								$amdetalle .= '#'.$DatNotaCreditoVentaDetalle->NodId;
							}
	
							if(!$InsNotaCreditoVentaDetalle->MtdEliminarNotaCreditoVentaDetalle($amdetalle)){								
								$error = true;
							}
	
						}
					
						
						if(!$error) {
							
							$sql = 'DELETE FROM tblamoalmacenmovimiento WHERE (AmoId = "'.($elemento).'" )';
							$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
							
							if(!$resultado) {						
								$error = true;
							}else{
								$this->MtdAuditarNotaCreditoVenta(3,"Se elimino la Nota de Credito de Compra",$aux);		
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
	
	
	public function MtdRegistrarNotaCreditoVenta() {

			global $Resultado;
			$error = false;
			
			$this->NcvId = trim($this->NcvId);
			
			$this->InsMysql->MtdTransaccionIniciar();

			$this->MtdGenerarNotaCreditoVentaId();
			
				$sql = 'INSERT INTO tblamoalmacenmovimiento (
				AmoId,
				
				PerId, 
				CliId,
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
				"'.($this->NcvId).'", 
				
				'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
				"'.($this->CliId).'",
				"'.($this->AlmId).'",
				
				"'.($this->TopId).'",
				"'.($this->CtiId).'",
				
				'.(empty($this->AmoIdOrigen)?'NULL, ':'"'.$this->AmoIdOrigen.'",').'
			
				"'.($this->NcvComprobanteNumero).'",
				'.(empty($this->NcvComprobanteFecha)?'NULL, ':'"'.$this->NcvComprobanteFecha.'",').'
				
				"'.($this->NcvFechaEmision).'",
				'.($this->NcvPorcentajeImpuestoVenta).',
				
				'.($this->NcvIncluyeImpuesto).',
				
				'.($this->NcvSubTotal).',
				'.($this->NcvImpuesto).',
				'.($this->NcvTotal).',			
				
				"'.($this->NcvObservacion).'", 
				
				"'.($this->MonId).'",
				'.(empty($this->NcvTipoCambio)?'NULL, ':''.$this->NcvTipoCambio.',').'
				
				"'.($this->NcvFoto).'",
				'.($this->NcvEstado).',

				2,
				5,

				"'.($this->NcvTiempoCreacion).'", 
				"'.($this->NcvTiempoModificacion).'");';
		
				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;
						
						switch($this->InsMysql->MtdObtenerErrorCodigo()){
							case 1062:					
								$Resultado.="#ERR_NCV_402";
							break;
						}
					} 
				}
				
				if(!$error){			
				
					if (!empty($this->NotaCreditoVentaDetalle)){		
							
						$validar = 0;				
						$InsNotaCreditoVentaDetalle = new ClsNotaCreditoVentaDetalle();		
								
						foreach ($this->NotaCreditoVentaDetalle as $DatNotaCreditoVentaDetalle){
							
							$InsNotaCreditoVentaDetalle->NcvId = $this->NcvId;
							
							$InsNotaCreditoVentaDetalle->ProId = $DatNotaCreditoVentaDetalle->ProId;
							$InsNotaCreditoVentaDetalle->UmeId = $DatNotaCreditoVentaDetalle->UmeId;

							$InsNotaCreditoVentaDetalle->AmdIdOrigen = $DatNotaCreditoVentaDetalle->AmdIdOrigen;

							$InsNotaCreditoVentaDetalle->NodPrecio = $DatNotaCreditoVentaDetalle->NodPrecio;
							$InsNotaCreditoVentaDetalle->NodCantidad = $DatNotaCreditoVentaDetalle->NodCantidad;
							$InsNotaCreditoVentaDetalle->NodCantidadReal = $DatNotaCreditoVentaDetalle->NodCantidadReal;
							$InsNotaCreditoVentaDetalle->NodImporte = $DatNotaCreditoVentaDetalle->NodImporte;
							
							$InsNotaCreditoVentaDetalle->NodEstado = $DatNotaCreditoVentaDetalle->NodEstado;
							$InsNotaCreditoVentaDetalle->NodTiempoCreacion = $DatNotaCreditoVentaDetalle->NodTiempoCreacion;
							$InsNotaCreditoVentaDetalle->NodTiempoModificacion = $DatNotaCreditoVentaDetalle->NodTiempoModificacion;						
							$InsNotaCreditoVentaDetalle->NodEliminado = $DatNotaCreditoVentaDetalle->NodEliminado;
							
							if($InsNotaCreditoVentaDetalle->MtdRegistrarNotaCreditoVentaDetalle()){
								$validar++;					
							}else{
								$Resultado.='#ERR_NCV_201';
								$Resultado.='#Item Numero: '.($validar+1);
							}
						}					
						
						if(count($this->NotaCreditoVentaDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
				
				
		

			if($error) {	

				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarNotaCreditoVenta(1,"Se registro la NotaCreditoVenta",$this);			
				return true;
			}			
			
	}
	
	public function MtdEditarNotaCreditoVenta() {
		
			global $Resultado;
			$error = false;


			$this->InsMysql->MtdTransaccionIniciar();
			
				$sql = 'UPDATE tblamoalmacenmovimiento SET 
				
				'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
				
				AmoComprobanteNumero = "'.($this->NcvComprobanteNumero).'",	
				'.(empty($this->NcvComprobanteFecha)?'AmoComprobanteFecha = NULL, ':'AmoComprobanteFecha = "'.$this->NcvComprobanteFecha.'",').'
			
				AmoFecha = "'.($this->NcvFechaEmision).'",	
				AmoPorcentajeImpuestoVenta = '.($this->NcvPorcentajeImpuestoVenta).',
				
				MonId = "'.($this->MonId).'",
				'.(empty($this->NcvTipoCambio)?'AmoTipoCambio = NULL, ':'AmoTipoCambio = "'.$this->NcvTipoCambio.'",').'
				
				AmoIncluyeImpuesto = '.($this->NcvIncluyeImpuesto).',
				
				AmoFoto = "'.($this->NcvFoto).'",
				AmoSubTotal = '.($this->NcvSubTotal).',
				AmoImpuesto = '.($this->NcvImpuesto).',
				AmoTotal = '.($this->NcvTotal).',
				AmoObservacion = "'.($this->NcvObservacion).'",
				
				AmoEstado = '.($this->NcvEstado).',
				
				AmoTiempoModificacion = "'.($this->NcvTiempoModificacion).'"			
				WHERE AmoId = "'.($this->NcvId).'";';
				
				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;
					} 
				}
	
				if(!$error){
				
					if (!empty($this->NotaCreditoVentaDetalle)){		
							
							
						$validar = 0;				
						$InsNotaCreditoVentaDetalle = new ClsNotaCreditoVentaDetalle();		
								
						foreach ($this->NotaCreditoVentaDetalle as $DatNotaCreditoVentaDetalle){
											
							$InsNotaCreditoVentaDetalle->NodId = $DatNotaCreditoVentaDetalle->NodId;
							$InsNotaCreditoVentaDetalle->NcvId = $this->NcvId;
							
							$InsNotaCreditoVentaDetalle->AmdIdOrigen = $DatNotaCreditoVentaDetalle->AmdIdOrigen;
							
							$InsNotaCreditoVentaDetalle->ProId = $DatNotaCreditoVentaDetalle->ProId;
							$InsNotaCreditoVentaDetalle->UmeId = $DatNotaCreditoVentaDetalle->UmeId;
							
							$InsNotaCreditoVentaDetalle->NodPrecio = $DatNotaCreditoVentaDetalle->NodPrecio;
							$InsNotaCreditoVentaDetalle->NodCantidad = $DatNotaCreditoVentaDetalle->NodCantidad;
							$InsNotaCreditoVentaDetalle->NodCantidadReal = $DatNotaCreditoVentaDetalle->NodCantidadReal;
							$InsNotaCreditoVentaDetalle->NodImporte = $DatNotaCreditoVentaDetalle->NodImporte;
							
							$InsNotaCreditoVentaDetalle->NodEstado = $DatNotaCreditoVentaDetalle->NodEstado;
							$InsNotaCreditoVentaDetalle->NodTiempoCreacion = $DatNotaCreditoVentaDetalle->NodTiempoCreacion;
							$InsNotaCreditoVentaDetalle->NodTiempoModificacion = $DatNotaCreditoVentaDetalle->NodTiempoModificacion;
							$InsNotaCreditoVentaDetalle->NodEliminado = $DatNotaCreditoVentaDetalle->NodEliminado;
							
							if(empty($InsNotaCreditoVentaDetalle->NodId)){
								if($InsNotaCreditoVentaDetalle->NodEliminado<>2){
									if($InsNotaCreditoVentaDetalle->MtdRegistrarNotaCreditoVentaDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_NCV_201';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}else{
									$validar++;	
								}
							}else{						
								if($InsNotaCreditoVentaDetalle->NodEliminado==2){
									if($InsNotaCreditoVentaDetalle->MtdEliminarNotaCreditoVentaDetalle($InsNotaCreditoVentaDetalle->NodId)){
										$validar++;					
									}else{
										$Resultado.='#ERR_NCV_203';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}else{
									if($InsNotaCreditoVentaDetalle->MtdEditarNotaCreditoVentaDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_NCV_202';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}
							}									
						}
						
						
						if(count($this->NotaCreditoVentaDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
						
						
				
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				$this->MtdAuditarNotaCreditoVenta(2,"Se edito la NotaCreditoVenta",$this);		
				return true;
			}	
		
		
		}	
		

	public function MtdVerificarExisteAlmacenMovimientoSalidaId($oAlmacenMovimientoSalidaId){
		
		$NotaCreditoVenta = array();
		
        $sql = 'SELECT 
		amo.AmoId AS "NcvId"
        FROM tblamoalmacenmovimiento amo
        WHERE  amo.AmoId = "'.$oAlmacenMovimientoSalidaId.'" 
		AND amo.AmoEstado <> 1
		LIMIT 1;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				$NotaCreditoVenta[]  = $fila['NcvId'];
				
			}
		}
		return $NotaCreditoVenta ;

	}
			
	public function MtdVerificarExisteNotaCreditoVenta($oCampo,$oDato){
			
		$Respuesta =   NULL;

		$sql = 'SELECT 
		amo.AmoId AS "NcvId"
		FROM tblamoalmacenmovimiento amo
		WHERE '.$oCampo.' = "'.$oDato.'" LIMIT 1;';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			$Respuesta = $fila['NcvId'];
		}
		
		return $Respuesta;
	
	}
		
	private function MtdAuditarNotaCreditoVenta($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
		
		$InsAuditoria = new ClsAuditoria($this->InsMysql);
		$InsAuditoria->AudCodigo = $this->NcvId;
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