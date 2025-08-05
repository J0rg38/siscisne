<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoProducto {

    public $TptId;
	public $TptTipo;
	public $PerId;
	
	public $CtiId;
	public $TptFecha;
	public $TopId;

	public $CliId;
	public $PrvId;

	
	public $TptReferencia;
	public $TptResponsable;
	
    public $TptObservacion;
	public $TptFoto;
	public $TptTotal;
	
	public $TptFactura;
	public $TptGuiaRemision;
	
	

	public $TptEstado;
	public $TptTiempoCreacion;
	public $TptTiempoModificacion;
    public $TptEliminado;

	public $TopNombre;
	public $FinId;
	public $FinFecha;

	public $MinId;
	public $MinSigla;
	public $MinNombre;

	public $FccManoObra;
	
	public $FinVehiculoKilometraje;
	public $EinPlaca;
	public $EinVIN;
	public $EinAnoFabricacion;

	
	
	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;

	public $CliNombre;
//	public $CliApellidoPaterno;
//	public $CliApellidoMaterno;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	
	public $TptTotalItems;
	
	public $FimObsequio;
	
	public $TrasladoProductoDetalle;
		
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarTrasladoProductoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(tpt.TptId,5),unsigned)) AS "MAXIMO"
			FROM tbltpttrasladoproducto tpt
				';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TptId = "TPT-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TptId = "TPT-".$fila['MAXIMO'];					
			}
				
	}
		
    public function MtdObtenerTrasladoProducto(){

		$sql = 'SELECT 
        tpt.TptId,  
		tpt.SucId,
		tpt.SucIdDestino,
		
		tpt.PerId,
		
		tpt.CtiId,
		DATE_FORMAT(tpt.TptFecha, "%d/%m/%Y") AS "NTptFecha",
		DATE_FORMAT(tpt.TptFechaLlegada, "%d/%m/%Y") AS "NTptFechaLlegada",
		tpt.TopId,
		
		tpt.CliId,
		tpt.PrvId,
		
		tpt.TopId,

		tpt.MonId,
		tpt.TptTipoCambio,
				
	
		tpt.TptReferencia,
		DATE_FORMAT(tpt.TptReferenciaFecha, "%d/%m/%Y") AS "NTptReferenciaFecha",
		
		tpt.TptResponsable,
	
		tpt.TptObservacion,
		tpt.TptObservacionImpresa,		
		tpt.TptFoto,
		
		tpt.TptIncluyeImpuesto,
		tpt.TptPorcentajeImpuestoVenta,
	
		tpt.TptCierre,
		tpt.TptEstado,
		DATE_FORMAT(tpt.TptTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTptTiempoCreacion",
        DATE_FORMAT(tpt.TptTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTptTiempoModificacion",
		
		suc.SucNombre,
		suc.SucDireccion,
		suc.SucDepartamento,
		suc.SucProvincia,
		suc.SucDistrito,
		suc.SucCodigoUbigeo,
		
	suc2.SucNombre AS SucNombreDestino,
		suc2.SucDireccion AS SucDireccionDestino,
		suc2.SucDepartamento AS SucDepartamentoDestino,
		suc2.SucProvincia AS SucProvinciaDestino,
		suc2.SucDistrito AS SucDistritoDestino,
		
		suc2.SucCodigoUbigeo AS SucCodigoUbigeoDestino
		
		FROM tbltpttrasladoproducto tpt
			LEFT JOIN tblsucsucursal suc
			ON tpt.SucId = suc.SucId
				LEFT JOIN tblsucsucursal suc2
				ON tpt.SucIdDestino = suc2.SucId
			
		WHERE tpt.TptId = "'.$this->TptId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->TptId = $fila['TptId'];
			$this->SucId = $fila['SucId'];
			$this->SucIdDestino = $fila['SucIdDestino'];
			$this->PerId = $fila['PerId'];
			
			$this->CtiId = $fila['CtiId'];
			$this->TptFecha = $fila['NTptFecha'];
			$this->TptFechaLlegada = $fila['NTptFechaLlegada'];
			$this->TopId = $fila['TopId'];

			$this->CliId = $fila['CliId'];
			$this->PrvId = $fila['PrvId'];
			$this->TopId = $fila['TopId'];

			$this->MonId = $fila['MonId'];
			$this->TptTipoCambio = $fila['TptTipoCambio'];
			
			
			
			$this->TptReferencia = $fila['TptReferencia'];
			list($this->TptReferenciaSerie,$this->TptReferenciaNumero) = explode("-",$this->TptReferencia);
			
			
			$this->TptReferenciaFecha = $fila['NTptReferenciaFecha'];
			$this->TptResponsable = $fila['TptResponsable'];

			$this->TptObservacion = $fila['TptObservacion'];
			$this->TptObservacionImpresa = $fila['TptObservacionImpresa'];
			$this->TptFoto = $fila['TptFoto'];

			$this->TptIncluyeImpuesto = $fila['TptIncluyeImpuesto'];
			$this->TptPorcentajeImpuestoVenta = $fila['TptPorcentajeImpuestoVenta'];
		
			$this->TptCierre = $fila['TptCierre'];
			$this->TptEstado = $fila['TptEstado'];
			$this->TptTiempoCreacion = $fila['NTptTiempoCreacion']; 
			$this->TptTiempoModificacion = $fila['NTptTiempoModificacion']; 	
			
			
			
			
			$this->SucNombre = $fila['SucNombre']; 
			$this->SucDireccion = $fila['SucDireccion']; 	

			$this->SucDepartamento = $fila['SucDepartamento']; 	
			$this->SucProvincia = $fila['SucProvincia']; 
			$this->SucDistrito = $fila['SucDistrito']; 	
			$this->SucCodigoUbigeo = $fila['SucCodigoUbigeo']; 	
			
			
			
			$this->SucDireccionDestino = $fila['SucDireccionDestino']; 
			$this->SucDepartamentoDestino = $fila['SucDepartamentoDestino']; 	
			$this->SucProvinciaDestino = $fila['SucProvinciaDestino']; 
			$this->SucDistritoDestino = $fila['SucDistritoDestino']; 
			$this->SucCodigoUbigeoDestino = $fila['SucCodigoUbigeoDestino']; 	
			
			
			
			switch($this->TptEstado){
			
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
				
			$this->TptEstadoDescripcion = $Estado;
			
			//
//			switch($this->TptEstado){
//			
//				case 1:
//					$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
//				break;
//			
//				case 3:
//					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
//				break;	
//				
//				default:
//					$Estado = "";
//				break;
//			
//			}
//				
//			$this->TptEstadoIcono = $Estado;




			$InsTrasladoProductoDetalle = new ClsTrasladoProductoDetalle();
			//MtdObtenerTrasladoProductoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TpdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoProducto=NULL,$oEstado=NULL,$oProducto=NULL,$oTrasladoProductoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
			$ResTrasladoProductoDetalle =  $InsTrasladoProductoDetalle->MtdObtenerTrasladoProductoDetalles(NULL,NULL,NULL,"TpdId","ASC",NULL,$this->TptId);
			$this->TrasladoProductoDetalle = 	$ResTrasladoProductoDetalle['Datos'];	

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTrasladoProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'TptId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oSucursal=NULL,$oSucursalDestino=NULL,$oFecha="TptFecha") {

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
					tpd.TpdId
					FROM tbltpdtrasladoproductodetalle tpd
						LEFT JOIN tblproproducto pro
						ON tpd.ProId = pro.ProId
						
					WHERE 
						tpd.TptId = tpt.TptId AND 
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(tpt.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(tpt.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(tpt.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tpt.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (tpt.TptEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) ';

		}
		
		
		
		
			if(!empty($oSucursal)){
			$sucursal = ' AND tpt.SucId = "'.$oSucursal.'"';
		}
		
		
			if(!empty($oSucursalDestino)){
			$sdestino = ' AND tpt.SucIdDestino = "'.$oSucursalDestino.'"';
		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				tpt.TptId,
				tpt.SucId,
				tpt.SucIdDestino,
					
				tpt.PerId,	
				
				tpt.CtiId,
				DATE_FORMAT(tpt.TptFecha, "%d/%m/%Y") AS "NTptFecha",
				DATE_FORMAT(tpt.TptFechaLlegada, "%d/%m/%Y") AS "NTptFechaLlegada",
				
				tpt.CliId,
				tpt.PrvId,
				tpt.TopId,
			
				tpt.MonId,
				tpt.TptTipoCambio,
				
				tpt.TptReferencia,
				DATE_FORMAT(tpt.TptReferenciaFecha, "%d/%m/%Y") AS "NTptReferenciaFecha",
				tpt.TptResponsable,

				tpt.TptObservacion,
				tpt.TptObservacionImpresa,
				tpt.TptFoto,
				
				tpt.TptCierre,					
				tpt.TptEstado,
				DATE_FORMAT(tpt.TptTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTptTiempoCreacion",
	        	DATE_FORMAT(tpt.TptTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTptTiempoModificacion",

				(SELECT COUNT(tpd.TpdId) FROM tbltpdtrasladoproductodetalle tpd WHERE tpd.TptId = tpt.TptId ) AS "TptTotalItems",
			
				top.TopNombre,
				cti.CtiNombre,
			
				suc.SucNombre,
				suc2.SucNombre AS SucNombreDestino,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno
				
				FROM tbltpttrasladoproducto tpt
					LEFT JOIN tbltoptipooperacion top
					ON tpt.TopId = top.TopId
						LEFT JOIN tblcticomprobantetipo cti
						ON tpt.CtiId = cti.CtiId
					
										LEFT JOIN tblmonmoneda mon
										ON tpt.MonId = mon.MonId
											LEFT JOIN tblsucsucursal suc
											ON tpt.SucId = suc.SucId
												LEFT JOIN tblsucsucursal suc2
												ON tpt.SucIdDestino = suc2.SucId
												
												LEFT JOIN tblperpersonal per
												ON tpt.PerId = per.PerId
												
				WHERE 1 = 1
			
				'.$filtrar.$fecha.$tipo.$sdestino.$sucursal.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$pfacturar.$modalidad.$amsubtipo.$orden.$paginacion;


			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoProducto = new $InsTrasladoProducto();
                    $TrasladoProducto->TptId = $fila['TptId'];
					$TrasladoProducto->SucId = $fila['SucId'];
					$TrasladoProducto->SucIdDestino = $fila['SucIdDestino'];
				
					$TrasladoProducto->CtiId = $fila['CtiId'];
					$TrasladoProducto->TptFecha = $fila['NTptFecha'];
					
					$TrasladoProducto->CliId = $fila['CliId'];
					$TrasladoProducto->PrvId = $fila['PrvId'];
					$TrasladoProducto->TopId = $fila['NTopId'];
					
					$TrasladoProducto->MonId = $fila['MonId'];
					$TrasladoProducto->TptTipoCambio = $fila['TptTipoCambio'];
			
					$TrasladoProducto->TptReferencia = $fila['TptReferencia'];
					$TrasladoProducto->TptReferenciaFecha = $fila['NTptReferenciaFecha'];
					$TrasladoProducto->TptResponsable = $fila['TptResponsable'];
			
					$TrasladoProducto->TptObservacion = $fila['TptObservacion'];
					$TrasladoProducto->TptObservacionImpresa = $fila['TptObservacionImpresa'];
					
					$TrasladoProducto->TptFoto = $fila['TptFoto'];
					
					$TrasladoProducto->TptCierre = $fila['TptCierre'];
					$TrasladoProducto->TptEstado = $fila['TptEstado'];
					$TrasladoProducto->TptTiempoCreacion = $fila['NTptTiempoCreacion'];  
					$TrasladoProducto->TptTiempoModificacion = $fila['NTptTiempoModificacion']; 

					$TrasladoProducto->TptTotalItems = $fila['TptTotalItems']; 
					
					$TrasladoProducto->TopNombre = $fila['TopNombre']; 
					$TrasladoProducto->CtiNombre = $fila['CtiNombre']; 
				
	
				
					$TrasladoProducto->TdoId = $fila['TdoId']; 
					
					$TrasladoProducto->CliNombreCompleto = $fila['CliNombreCompleto'];
					$TrasladoProducto->CliNombre = $fila['CliNombre'];
					$TrasladoProducto->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$TrasladoProducto->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$TrasladoProducto->CliNumeroDocumento = $fila['CliNumeroDocumento'];

					$TrasladoProducto->LtiUtilidad = $fila['LtiUtilidad']; 
					$TrasladoProducto->LtiNombre = $fila['LtiNombre']; 
					
					$TrasladoProducto->CliId = $fila['CliId'];
					$TrasladoProducto->TdoId = $fila['TdoId'];
					$TrasladoProducto->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$TrasladoProducto->CliDireccion = $fila['CliDireccion'];
		
					$TrasladoProducto->MonNombre = $fila['MonNombre'];
					$TrasladoProducto->MonSimbolo = $fila['MonSimbolo'];

				$TrasladoProducto->SucNombre = $fila['SucNombre'];
				$TrasladoProducto->SucNombreDestino = $fila['SucNombreDestino'];
				
				$TrasladoProducto->PerNombre = $fila['PerNombre'];
				$TrasladoProducto->PerApellidoPaterno = $fila['PerApellidoPaterno'];
				$TrasladoProducto->PerApellidoMaterno = $fila['PerApellidoMaterno'];
				
				
			switch($TrasladoProducto->TptEstado){
			
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
				
			$TrasladoProducto->TptEstadoDescripcion = $Estado;
			
			
		//	switch($TrasladoProducto->TptEstado){
//			
//				case 1:
//					$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
//				break;
//			
//				case 3:
//					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
//				break;	
//				
//				default:
//					$Estado = "";
//				break;
//			
//			}
//				
//			$TrasladoProducto->TptEstadoIcono = $Estado;
//


                    $TrasladoProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
			
			

	
		}
		




   public function MtdObtenerTrasladoProductosValor($oFuncion="SUM",$oParametro="TptTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'TptId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPersonal=NULL) {

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
					tpd.TpdId
					FROM tbltpdtrasladoproductodetalle tpd
						LEFT JOIN tblproproducto pro
						ON tpd.ProId = pro.ProId
						
					WHERE 
						tpd.TptId = tpt.TptId AND 
						(
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(tpt.TptFecha)>="'.$oFechaInicio.'" AND DATE(tpt.TptFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(tpt.TptFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tpt.TptFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (tpt.TptEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) ';

		}
		

		if(!empty($oPersonal)){
			$personal = ' AND tpt.PerId = "'.$oPersonal.'"';
		}
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(tpt.TptFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(tpt.TptFecha) ="'.($oAno).'"';
		}
		
		
			$sql = 'SELECT
			
				'.$funcion.' AS "RESULTADO"
				
				
				FROM tbltpttrasladoproducto tpt
					LEFT JOIN tbltoptipooperacion top
					ON tpt.TopId = top.TopId
						
									
						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.TopId = lti.TopId
							
									
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$pfacturar.$modalidad.$amsubtipo.$orden.$paginacion;
			
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
			
		}
		
		
	
	//Accion eliminar	 
	public function MtdEliminarTrasladoProducto($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsTrasladoProductoDetalle = new ClsTrasladoProductoDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){
				
				
				$this->TptId = $elemento;
				
				$ResTrasladoProductoDetalle = $InsTrasladoProductoDetalle->MtdObtenerTrasladoProductoDetalles(NULL,NULL,NULL,'TpdId','Desc',NULL,$this->TptId);
				$ArrTrasladoProductoDetalles = $ResTrasladoProductoDetalle['Datos'];

				if(!empty($ArrTrasladoProductoDetalles)){
					$amdetalle = '';

					foreach($ArrTrasladoProductoDetalles as $DatTrasladoProductoDetalle){
						$amdetalle .= '#'.$DatTrasladoProductoDetalle->TpdId;
					}

					if(!$InsTrasladoProductoDetalle->MtdEliminarTrasladoProductoDetalle($amdetalle)){								
						$error = true;
					}
						
				}
				
				$this->MtdObtenerTrasladoProducto();

				if(!empty($this->FinId)){
					$InsFichaIngreso = new ClsFichaIngreso();
					$InsFichaIngreso->FinId = $this->FinId;
					
					if(!$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($InsFichaIngreso->FinId,3,false)){
						$error = false;
					}
				}
						
				
				if(!$error) {		
				
					$sql = 'DELETE FROM tbltpttrasladoproducto WHERE  (TptId = "'.($this->TptId).'" ) ';
												
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{
						
						
						$this->MtdAuditarTrasladoProducto(3,"Se elimino el Movimiento de Almacen",$aux);		
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
	public function MtdActualizarEstadoTrasladoProducto($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsTrasladoProducto = new ClsTrasladoProducto();
		$InsTrasladoProductoDetalle = new ClsTrasladoProductoDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
		

					$ResTrasladoProductoDetalle = $InsTrasladoProductoDetalle->MtdObtenerTrasladoProductoDetalles(NULL,NULL,NULL,'TpdId','Desc',NULL,$elemento);
					$ArrTrasladoProductoDetalles = $ResTrasladoProductoDetalle['Datos'];
	
					if(!empty($ArrTrasladoProductoDetalles)){
						$amdetalle = '';
	
						foreach($ArrTrasladoProductoDetalles as $DatTrasladoProductoDetalle){
							$amdetalle .= '#'.$DatTrasladoProductoDetalle->TpdId;
						}
	
						if(!$InsTrasladoProductoDetalle->MtdActualizarEstadoTrasladoProductoDetalle($amdetalle,$oEstado)){								
							$error = true;
						}
							
					}
				
				
					if(!$error){

						$sql = 'UPDATE tbltpttrasladoproducto SET TptEstado = '.$oEstado.' WHERE TptId = "'.$elemento.'"';
			
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarTrasladoProducto(2,"Se actualizo el Estado del Movimiento de Almacen",$elemento);
					
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
	
	
	public function MtdRegistrarTrasladoProducto() {

		global $Resultado;

		$error = false;

$InsAlmacenStock = new ClsAlmacenStock();
		
		
		
			$this->MtdGenerarTrasladoProductoId();
//TopId,
			$sql = 'INSERT INTO tbltpttrasladoproducto (
			TptId,
			SucId,
			SucIdDestino,
							
			PerId,
			TopId,
			CtiId,
			
			PrvId,
			CliId,
			
			TptFecha,
			TptFechaLlegada,
			
			MonId,
			TptTipoCambio,
		
			TptReferencia,
			TptReferenciaFecha,
			TptResponsable,
			
			TptObservacion,
			TptObservacionImpresa,
			
			TptFoto,
			
			TptCierre,
			TptEstado,			
			TptTiempoCreacion,
			TptTiempoModificacion) 
			VALUES (
			"'.($this->TptId).'", 
			"'.($this->SucId).'", 
			"'.($this->SucIdDestino).'", 
			
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			'.(empty($this->CtiId)?'NULL, ':'"'.$this->CtiId.'",').'
			
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			
			"'.($this->TptFecha).'", 
			'.(empty($this->TptFechaLlegada)?'NULL, ':'"'.$this->TptFechaLlegada.'",').' 
			
			'.(empty($this->MonId)?'NULL, ':'"'.$this->MonId.'",').'
			'.(empty($this->TptTipoCambio)?'NULL, ':'"'.$this->TptTipoCambio.'",').' 
			
			"'.($this->TptReferencia).'",
			'.(empty($this->TptReferenciaFecha)?'NULL, ':'"'.$this->TptReferenciaFecha.'",').' 			
			"'.($this->TptResponsable).'",
			
			"'.($this->TptObservacion).'",
			"'.($this->TptObservacionImpresa).'",
			
			"'.($this->TptFoto).'", 
		
			"'.($this->TptCierre).'",
			'.($this->TptEstado).',
			"'.($this->TptTiempoCreacion).'", 				
			"'.($this->TptTiempoModificacion).'");';			
//'.($this->TptSubTipo).',
			$this->InsMysql->MtdTransaccionIniciar();
//NULL,

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
					
			if(!$error){			

				if (!empty($this->TrasladoProductoDetalle)){		
						
					$validar = 0;				
					$InsTrasladoProductoDetalle = new ClsTrasladoProductoDetalle();		
					
					foreach ($this->TrasladoProductoDetalle as $DatTrasladoProductoDetalle){
					
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatTrasladoProductoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						$InsTrasladoProductoDetalle->TptId = $this->TptId;
						$InsTrasladoProductoDetalle->ProId = $DatTrasladoProductoDetalle->ProId;
						$InsTrasladoProductoDetalle->UmeId = $DatTrasladoProductoDetalle->UmeId;

						$InsTrasladoProductoDetalle->TpdCosto = $DatTrasladoProductoDetalle->TpdCosto;
						$InsTrasladoProductoDetalle->TpdCantidad = $DatTrasladoProductoDetalle->TpdCantidad;
						$InsTrasladoProductoDetalle->TpdCantidadReal = $DatTrasladoProductoDetalle->TpdCantidadReal;						
						$InsTrasladoProductoDetalle->TpdImporte = $DatTrasladoProductoDetalle->TpdImporte;
						$InsTrasladoProductoDetalle->TpdEstado = $DatTrasladoProductoDetalle->TpdEstado;							
						$InsTrasladoProductoDetalle->TpdTiempoCreacion = $DatTrasladoProductoDetalle->TpdTiempoCreacion;
						$InsTrasladoProductoDetalle->TpdTiempoModificacion = $DatTrasladoProductoDetalle->TpdTiempoModificacion;						
						$InsTrasladoProductoDetalle->TpdEliminado = $DatTrasladoProductoDetalle->TpdEliminado;
						
						$StockReal = 0;
						$Fecha = explode("/",$this->TptFecha);
						$Ano = $Fecha[2];
						
						//$InsAlmacenProducto = new ClsAlmacenProducto();
						//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
						//$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->CtiId,$Ano,$this->SucId);
						$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,NULL,$Ano,$InsTrasladoProductoDetalle->ProId);
$StockReal = 10000;

					//if( ($StockReal + $InsTrasladoProductoDetalle->TpdCantidadRealAnterior) < $InsTrasladoProductoDetalle->TpdCantidadReal and $InsTrasladoProductoDetalle->TpdEliminado == 1 and $InsTrasladoProductoDetalle->TpdEstado == 3){
						if( ($StockReal ) < $InsTrasladoProductoDetalle->TpdCantidadReal and $InsTrasladoProductoDetalle->TpdEliminado == 1 and $InsTrasladoProductoDetalle->TpdEstado == 3){
////							
							$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
							$Resultado.='#ERR_TPT_208';												 
//							
						}else{
							
							if($InsTrasladoProductoDetalle->MtdRegistrarTrasladoProductoDetalle()){
								$validar++;	
							}else{
								$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
								$Resultado.='#ERR_TPT_201';
								//$Resultado.='#Item Numero: '.($validar+1);
							}
							
						}
																
																
						//if($InsTrasladoProductoDetalle->MtdRegistrarTrasladoProductoDetalle()){
//							$validar++;	
//						}else{
//							$Resultado.='#ERR_TPT_201';
//							$Resultado.='#Item Numero: '.($validar+1);
//						}
					}					
					
					if(count($this->TrasladoProductoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
						
			//if(!$error){			
//			
//				if (!empty($this->TrasladoProductoDetalle)){		
//						
//					$validar = 0;				
//					$InsTrasladoProductoDetalle = new ClsTrasladoProductoDetalle();		
//					
//					foreach ($this->TrasladoProductoDetalle as $DatTrasladoProductoDetalle){
//					
//						$InsTrasladoProductoDetalle->TptId = $this->TptId;
//						$InsTrasladoProductoDetalle->ProId = $DatTrasladoProductoDetalle->ProId;
//						$InsTrasladoProductoDetalle->UmeId = $DatTrasladoProductoDetalle->UmeId;
//						$InsTrasladoProductoDetalle->TpdCosto = $DatTrasladoProductoDetalle->TpdCosto;
//						$InsTrasladoProductoDetalle->TpdCantidad = $DatTrasladoProductoDetalle->TpdCantidad;
//						$InsTrasladoProductoDetalle->TpdCantidadReal = $DatTrasladoProductoDetalle->TpdCantidadReal;
//						$InsTrasladoProductoDetalle->TpdImporte = $DatTrasladoProductoDetalle->TpdImporte;
//						$InsTrasladoProductoDetalle->TpdEstado = $this->TptEstado;									
//						$InsTrasladoProductoDetalle->TpdTiempoCreacion = $DatTrasladoProductoDetalle->TpdTiempoCreacion;
//						$InsTrasladoProductoDetalle->TpdTiempoModificacion = $DatTrasladoProductoDetalle->TpdTiempoModificacion;						
//						$InsTrasladoProductoDetalle->TpdEliminado = $DatTrasladoProductoDetalle->TpdEliminado;
//						
//						if($InsTrasladoProductoDetalle->MtdRegistrarTrasladoProductoDetalle()){
//							$validar++;	
//						}else{
//							$Resultado.='#ERR_TPT_201';
//							$Resultado.='#Item Numero: '.($validar+1);
//						}
//					}					
//					
//					if(count($this->TrasladoProductoDetalle) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarTrasladoProducto(1,"Se registro el Movimiento de Almacen",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarTrasladoProducto() {

		global $Resultado;
		$error = false;
		
		$InsAlmacenStock = new ClsAlmacenStock();
		
		$sql = 'UPDATE tbltpttrasladoproducto SET
		SucId = "'.($this->SucId).'",
		SucIdDestino = "'.($this->SucIdDestino).'",
		
		'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
		'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
		'.(empty($this->CtiId)?'CtiId = NULL, ':'CtiId = "'.$this->CtiId.'",').'
		
		TptFecha = "'.($this->TptFecha).'",
		'.(empty($this->TptFechaLlegada)?'TptFechaLlegada = NULL, ':'TopId = "'.$this->TopId.'",').'
		
		'.(empty($this->MonId)?'MonId = NULL, ':'MonId = "'.$this->MonId.'",').'
		'.(empty($this->CtiId)?'TptTipoCambio = NULL, ':'TptTipoCambio = "'.$this->TptTipoCambio.'",').'
		
		TptReferencia = "'.($this->TptReferencia).'",
		'.(empty($this->TptReferenciaFecha)?'TptReferenciaFecha = NULL, ':'TptReferenciaFecha = "'.$this->TptReferenciaFecha.'",').'
		TptResponsable = "'.($this->TptResponsable).'",
		
		TptObservacion = "'.($this->TptObservacion).'",
		TptObservacionImpresa = "'.($this->TptObservacionImpresa).'",
		
		TptFoto = "'.($this->TptFoto).'",
		
		TptCierre = "'.($this->TptCierre).'",
		TptTiempoModificacion = "'.($this->TptTiempoModificacion).'",
		TptEstado = '.($this->TptEstado).'
		WHERE TptId = "'.($this->TptId).'";';			

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 			

		if(!$error){
			
				if (!empty($this->TrasladoProductoDetalle)){		

					$validar = 0;	
					$item = 1;			
					$InsTrasladoProductoDetalle = new ClsTrasladoProductoDetalle();
							
					foreach ($this->TrasladoProductoDetalle as $DatTrasladoProductoDetalle){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatTrasladoProductoDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						$InsTrasladoProductoDetalle->TpdId = $DatTrasladoProductoDetalle->TpdId;
						$InsTrasladoProductoDetalle->TptId = $this->TptId;
						$InsTrasladoProductoDetalle->ProId = $DatTrasladoProductoDetalle->ProId;
						$InsTrasladoProductoDetalle->UmeId = $DatTrasladoProductoDetalle->UmeId;

						$InsTrasladoProductoDetalle->TpdCosto = $DatTrasladoProductoDetalle->TpdCosto;
						$InsTrasladoProductoDetalle->TpdCantidad = $DatTrasladoProductoDetalle->TpdCantidad;
						$InsTrasladoProductoDetalle->TpdCantidadReal = $DatTrasladoProductoDetalle->TpdCantidadReal;
						$InsTrasladoProductoDetalle->TpdImporte = $DatTrasladoProductoDetalle->TpdImporte;
						$InsTrasladoProductoDetalle->TpdEstado = $DatTrasladoProductoDetalle->TpdEstado;
						$InsTrasladoProductoDetalle->TpdTiempoCreacion = $DatTrasladoProductoDetalle->TpdTiempoCreacion;
						$InsTrasladoProductoDetalle->TpdTiempoModificacion = $DatTrasladoProductoDetalle->TpdTiempoModificacion;
						$InsTrasladoProductoDetalle->TpdEliminado = $DatTrasladoProductoDetalle->TpdEliminado;
						
						$InsTrasladoProductoDetalle->CtiId = $DatTrasladoProductoDetalle->CtiId;
						$InsTrasladoProductoDetalle->TpdFecha = $DatTrasladoProductoDetalle->TpdFecha;
						
						if(empty($InsTrasladoProductoDetalle->TpdId)){
							if($InsTrasladoProductoDetalle->TpdEliminado<>2){
								

											if(!empty($InsTrasladoProductoDetalle->ProId)){
												if(!empty($InsTrasladoProductoDetalle->UmeId)){
													if(!empty($InsTrasladoProductoDetalle->TpdCantidad)){
														if(!empty($InsTrasladoProductoDetalle->TpdCantidadReal)){
														
															//if($InsTrasladoProductoDetalle->TpdEstado == 3){
																
																$StockReal = 0;
																$Fecha = explode("/",$this->TptFecha);
																$Ano = $Fecha[2];
																
															//	$InsAlmacenProducto = new ClsAlmacenProducto();
//																//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
//																$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->CtiId,$Ano,$this->SucId);
//																
																$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,NULL,$Ano,$InsTrasladoProductoDetalle->ProId);
										
															$StockReal = 10000;
															//if( ($StockReal + $InsTrasladoProductoDetalle->TpdCantidadRealAnterior) < $InsTrasladoProductoDetalle->TpdCantidadReal and $InsTrasladoProductoDetalle->TpdEliminado == 1 and $InsTrasladoProductoDetalle->TpdEstado == 3){
																if( ($StockReal ) < $InsTrasladoProductoDetalle->TpdCantidadReal and $InsTrasladoProductoDetalle->TpdEliminado == 1 and $InsTrasladoProductoDetalle->TpdEstado == 3){
										////							
																	$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																	$Resultado.='#ERR_TPT_208';												 
										//							
																}else{
																	
																	if($InsTrasladoProductoDetalle->MtdRegistrarTrasladoProductoDetalle()){
																		$validar++;	
																	}else{
																		$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																		$Resultado.='#ERR_TPT_201';
																		//$Resultado.='#Item Numero: '.($validar+1);
																	}
																	
																}
																
																
																
																
																
																
																
																
															//}
												
															/*if($InsTrasladoProductoDetalle->MtdRegistrarTrasladoProductoDetalle()){
																$validar++;	
															}else{
																$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																$Resultado.='#ERR_TPT_201';
																//$Resultado.='#\n';
															}*/
											
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TPT_205';
															//$Resultado.='#\n';
														}
													}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TPT_207';
															//$Resultado.='#\n';
													}
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_TPT_207';
													//$Resultado.='#\n';
												}
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TPT_206';
												//$Resultado.='#\n';
											}
											
							}else{
								$validar++;
							}
						}else{						
							if($InsTrasladoProductoDetalle->TpdEliminado==2){
								if($InsTrasladoProductoDetalle->MtdEliminarTrasladoProductoDetalle($InsTrasladoProductoDetalle->TpdId)){
									$validar++;					
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TPT_203';
									//$Resultado.='#\n';
								}
							}else{
								
											if(!empty($InsTrasladoProductoDetalle->ProId)){
												if(!empty($InsTrasladoProductoDetalle->UmeId)){
													if(!empty($InsTrasladoProductoDetalle->TpdCantidad)){
														if(!empty($InsTrasladoProductoDetalle->TpdCantidadReal)){
							
															/*if($InsTrasladoProductoDetalle->MtdEditarTrasladoProductoDetalle()){
																$validar++;	
															}else{
																$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																$Resultado.='#ERR_TPT_202';
																//$Resultado.='#\n';	
															}*/
															
															//if($InsTrasladoProductoDetalle->TpdEstado == 3){
																
																$StockReal = 0;
																$Fecha = explode("/",$this->TptFecha);
																$Ano = $Fecha[2];
																
																//$InsAlmacenProducto = new ClsAlmacenProducto();
																//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
																//$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTallerPedidoDetalle->ProId,$this->CtiId,$Ano,$this->SucId);
																$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($this->SucId,NULL,$Ano,$InsTrasladoProductoDetalle->ProId);
																
																
																$StockReal = 10000;
																
																
																if( ($StockReal + $InsTrasladoProductoDetalle->TpdCantidadRealAnterior) < $InsTrasladoProductoDetalle->TpdCantidadReal and $InsTrasladoProductoDetalle->TpdEliminado == 1 and $InsTrasladoProductoDetalle->TpdEstado == 3){
//				//							
																	$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																	$Resultado.='#ERR_TPT_208';												 
//																	
																}else{
																	
																	if($InsTrasladoProductoDetalle->MtdEditarTrasladoProductoDetalle()){
																		$validar++;	
																	}else{
																		$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																		$Resultado.='#ERR_TPT_202';
																		//$Resultado.='#\n';	
																	}
																	
																}
															
														
											
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TPT_205';
															//$Resultado.='#\n';
														}
													}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TPT_207';
															//$Resultado.='#\n';
													}
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_TPT_207';
													//$Resultado.='#\n';
												}
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TPT_206';
												//$Resultado.='#\n';
											}

							}
						}	
						
						$item++;								
					}
					
					if(count($this->TrasladoProductoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
		
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarTrasladoProducto(2,"Se edito el Movimiento de Almacen",$this);		
				return true;
			}	
				
		}	
		
	
	
		private function MtdAuditarTrasladoProducto($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->TptId;

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