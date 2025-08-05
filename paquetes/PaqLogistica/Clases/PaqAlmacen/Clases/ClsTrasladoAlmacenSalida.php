<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoAlmacenSalida
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoAlmacenSalida {

    public $TasId;
	public $TasTipo;
	public $FccId;
	
	public $AlmId;
	public $TasFecha;
	public $TopId;

	public $VdiId;
	public $CprId;
	public $LtiId;
	
	public $TasComprobanteNumero;
	public $TasResponsable;
	
    public $TasObservacion;
	public $TasDescuento;
	public $TasTotal;
	
	public $TasFactura;
	public $TasGuiaRemision;
	
	public $TasEmpresaTransporte;
	public $TasEmpresaTransporteDocumento;
	public $TasEmpresaTransporteFecha;
	public $TasEmpresaTransporteTipoEnvio;
	public $TasEmpresaTransporteClave;
	public $TasEmpresaTransporteDestino;

	public $TasEstado;
	public $TasTiempoCreacion;
	public $TasTiempoModificacion;
    public $TasEliminado;

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
	
	public $TasTotalItems;
	
	public $FimObsequio;
	
	public $TrasladoAlmacenSalidaDetalle;
		
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarTrasladoAlmacenSalidaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(amo.AmoId,5),unsigned)) AS "MAXIMO"
			FROM tblamoalmacenmovimiento amo
				WHERE amo.AmoTipo = 2';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TasId = "TAS-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TasId = "TAS-".$fila['MAXIMO'];					
			}
				
	}
		
    public function MtdObtenerTrasladoAlmacenSalida(){

		$sql = 'SELECT 
        amo.AmoId AS TasId,  
		amo.CliId,
		
		amo.AlmId,
		amo.AlmIdDestino,
		amo.PerId,
		
		DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "TasFecha",
		amo.TopId,
		
		amo.LtiId,

		amo.AmoComprobanteNumero AS TasComprobanteNumero,
		amo.AmoResponsable AS TasResponsable,
	
		amo.AmoObservacion AS TasObservacion, 
	
		CASE
			WHEN EXISTS (
				SELECT 
				gam.GamId
				FROM tblgamguiaremisionalmacenmovimiento gam
				WHERE gam.AmoId = amo.AmoId
				 LIMIT 1
			) THEN "Si"
			ELSE "No"
			END AS TasGuiaRemision,
		
		amo.AmoEmpresaTransporte AS TasEmpresaTransporte,
		amo.AmoEmpresaTransporteDocumento AS TasEmpresaTransporteDocumento,
		amo.AmoEmpresaTransporteClave AS TasEmpresaTransporteClave,
		amo.AmoEmpresaTransporteTipoEnvio AS TasEmpresaTransporteTipoEnvio,
		DATE_FORMAT(amo.AmoEmpresaTransporteFecha, "%d/%m/%Y") AS "TasEmpresaTransporteFecha",
		amo.AmoEmpresaTransporteDestino AS "TasEmpresaTransporteDestino",
							
		amo.AmoEstado AS TasEstado,
		DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "TasTiempoCreacion",
        DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "TasTiempoModificacion",
		
	
		alm.AlmNombre,
		alm.AlmDireccion,
		alm.AlmDistrito,
		alm.AlmProvincia,
		alm.AlmDepartamento,
		
		alm2.AlmNombre AS AlmNombreDestino,
		alm2.AlmDireccion AS AlmDireccionDestino,
		alm2.AlmDistrito AS AlmDistritoDestino,
		alm2.AlmProvincia AS AlmProvinciaDestino,
		alm2.AlmDepartamento AS AlmDepartamentoDestino,
		
		
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		cli.CliNumeroDocumento,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.TdoId,
		
		(
		SELECT gre.GreId FROM tblgamguiaremisionalmacenmovimiento gam
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
						LEFT JOIN tblgrtguiaremisiontalonario grt
						ON gre.GrtId = grt.GrtId
				WHERE gam.AmoId = amo.AmoId	
				AND gre.GreEstado <>  6
				ORDER BY gre.GreFechaInicioTraslado DESC	
				LIMIT 1
		) AS GreId,
		
		(
		SELECT grt.GrtNumero FROM tblgamguiaremisionalmacenmovimiento gam
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
						LEFT JOIN tblgrtguiaremisiontalonario grt
						ON gre.GrtId = grt.GrtId
				WHERE gam.AmoId = amo.AmoId	
				AND gre.GreEstado <>  6
				ORDER BY gre.GreFechaInicioTraslado DESC	
				LIMIT 1
		) AS GrtNumero,
		
		(
		SELECT grt.GrtId FROM tblgamguiaremisionalmacenmovimiento gam
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
						LEFT JOIN tblgrtguiaremisiontalonario grt
						ON gre.GrtId = grt.GrtId
				WHERE gam.AmoId = amo.AmoId	
				AND gre.GreEstado <>  6
				ORDER BY gre.GreFechaInicioTraslado DESC	
				LIMIT 1
		) AS GrtId,
		
		(
		SELECT 		
		DATE_FORMAT(gre.GreFechaInicioTraslado , "%d/%m/%Y") 		
		FROM tblgamguiaremisionalmacenmovimiento gam
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
						LEFT JOIN tblgrtguiaremisiontalonario grt
						ON gre.GrtId = grt.GrtId
				WHERE gam.AmoId = amo.AmoId	
				AND gre.GreEstado <>  6
				ORDER BY gre.GreFechaInicioTraslado DESC	
				LIMIT 1
		) AS GreFechaInicioTraslado		
		
		FROM tblamoalmacenmovimiento amo
			LEFT JOIN tblalmalmacen alm
			ON amo.AlmId = alm.AlmId
			
				LEFT JOIN tblalmalmacen alm2
				ON amo.AlmIdDestino = alm2.AlmId
				
					LEFT JOIN tblperpersonal per
					ON amo.PerId = per.PerId
						LEFT JOIN tblclicliente cli
						ON amo.CliId = cli.CliId
				
		WHERE amo.AmoId = "'.$this->TasId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->TasId = $fila['TasId'];
			$this->CliId = $fila['CliId'];
			
			$this->AlmId = $fila['AlmId'];
			$this->AlmIdDestino = $fila['AlmIdDestino'];
			$this->PerId = $fila['PerId'];
			
			$this->TasFecha = $fila['TasFecha'];
			$this->TopId = $fila['TopId'];

			$this->LtiId = $fila['LtiId'];

			$this->TasComprobanteNumero = $fila['TasComprobanteNumero'];
			$this->TasResponsable = $fila['TasResponsable'];

			$this->TasObservacion = $fila['TasObservacion'];
		
			$this->TasGuiaRemision = $fila['TasGuiaRemision'];
			
			$this->TasEmpresaTransporte = $fila['TasEmpresaTransporte'];
			$this->TasEmpresaTransporteDocumento = $fila['TasEmpresaTransporteDocumento'];
			$this->TasEmpresaTransporteClave = $fila['TasEmpresaTransporteClave'];
			$this->TasEmpresaTransporteTipoEnvio = $fila['TasEmpresaTransporteTipoEnvio'];
			$this->TasEmpresaTransporteFecha = $fila['TasEmpresaTransporteFecha'];
			$this->TasEmpresaTransporteDestino = $fila['TasEmpresaTransporteDestino'];
			
			$this->TasEstado = $fila['TasEstado'];
			$this->TasTiempoCreacion = $fila['TasTiempoCreacion']; 
			$this->TasTiempoModificacion = $fila['TasTiempoModificacion']; 	

		
			$this->AlmNombre = $fila['AlmNombre']; 
			$this->AlmDireccion = $fila['AlmDireccion'];
			$this->AlmDistrito = $fila['AlmDistrito'];
			$this->AlmProvincia = $fila['AlmProvincia'];
			$this->AlmDepartamento = $fila['AlmDepartamento'];
			
			$this->AlmNombreDestino = $fila['AlmNombreDestino'];
			$this->AlmDireccionDestino = $fila['AlmDireccionDestino'];
			$this->AlmDistritoDestino = $fila['AlmDistritoDestino'];
			$this->AlmProvinciaDestino = $fila['AlmProvinciaDestino'];
			$this->AlmDepartamentoDestino = $fila['AlmDepartamentoDestino'];
		
			
			$this->PerNombre = $fila['PerNombre']; 	
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno']; 	
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno']; 	
			
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento']; 	
			$this->CliNombre = $fila['CliNombre']; 	
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno']; 	
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno']; 	
			$this->TdoId = $fila['TdoId']; 
			
			$this->GreId = $fila['GreId']; 
			$this->TdoId = $fila['TdoId']; 
			$this->TdoId = $fila['TdoId']; 	
			
			$this->GreId = $fila['GreId']; 	
			$this->GrtNumero = $fila['GrtNumero']; 	
			$this->GrtId = $fila['GrtId'];
			$this->GreFechaInicioTraslado = $fila['GreFechaInicioTraslado'];

			switch($this->TasEstado){
			
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
				
			$this->TasEstadoDescripcion = $Estado;
			
			
			switch($this->TasEstado){
			
				case 1:
					$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
				break;
			
				case 3:
					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
				break;	
				
				default:
					$Estado = "";
				break;
			
			}
				
			$this->TasEstadoIcono = $Estado;

			$InsTrasladoAlmacenSalidaDetalle = new ClsTrasladoAlmacenSalidaDetalle();
			$ResTrasladoAlmacenSalidaDetalle =  $InsTrasladoAlmacenSalidaDetalle->MtdObtenerTrasladoAlmacenSalidaDetalles(NULL,NULL,NULL,"amd.AmdId","ASC",NULL,$this->TasId);
			$this->TrasladoAlmacenSalidaDetalle = 	$ResTrasladoAlmacenSalidaDetalle['Datos'];	

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;

    }

    public function MtdObtenerTrasladoAlmacenSalidas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oTieneGenerarEntrada=false,$oSubTipo=NULL) {

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
					amd.AmdId
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE 
						amd.AmoId = amo.AmoId AND 
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
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (amo.AmoEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) ';

		}
		
		
		
		
		if($oTieneGenerarEntrada == true){


			$gentrada = ' AND 
			
			(
			
					IFNULL((
					
						SELECT 
	
							(
								IFNULL(amd.AmdCantidad,0) 
								
								- IFNULL(
	
									(
										SELECT 
										SUM(amd2.AmdCantidad)
										FROM tblamdalmacenmovimientodetalle amd2
												
										WHERE amd2.AmdIdOrigen = amd.AmdId
											AND amd2.AmdEstado = 3
										LIMIT 1
									)
	
								,0)
								
								
							)  AS TsdCantidadPendiente
	
						FROM tblamdalmacenmovimientodetalle amd
								LEFT JOIN tblproproducto pro
								ON amd.ProId = pro.ProId
	
						WHERE amd.AmoId = amo.AmoId
							AND amd.AmdEstado = 3
							HAVING TsdCantidadPendiente > 0
						
						LIMIT 1
					),0)
					
				 > 0 
			
			
			)
			
			';
			
		}

			if(!empty($oSubTipo)){
				$stipo = ' AND (amo.AmoSubTipo) = '.$oSubTipo.' ';		
			}	
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amo.AmoId AS TasId,	
				amo.FccId,	
				
				amo.AmoTipo,
				
				amo.AlmId,
				amo.AlmIdDestino,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
				amo.TopId,
					
					
				amo.LtiId,
				
				amo.MonId,
				amo.AmoTipoCambio AS TasTipoCambios,
				
				amo.AmoComprobanteNumero AS TasComprobanteNumero,
				amo.AmoResponsable AS TasResponsable,

				amo.AmoObservacion AS TasObservacion,
			
				CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
					WHERE gam.AmoId = amo.AmoId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS TasGuiaRemision,
								
				amo.AmoEmpresaTransporte AS TasEmpresaTransporte,
				amo.AmoEmpresaTransporteDocumento AS TasEmpresaTransporteDocumento,
				amo.AmoEmpresaTransporteClave AS TasEmpresaTransporteClave,
				amo.AmoEmpresaTransporteTipoEnvio AS TasEmpresaTransporteTipoEnvio,
				DATE_FORMAT(amo.AmoEmpresaTransporteFecha, "%d/%m/%Y") AS "TasEmpresaTransporteFecha",
				amo.AmoEmpresaTransporteDestino AS "TasEmpresaTransporteDestino",
				
				amo.AmoCierre AS TasCierre,		
				amo.AmoEstado AS TasEstado,
				DATE_FORMAT(amo.AmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "TasTiempoCreacion",
	        	DATE_FORMAT(amo.AmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "TasTiempoModificacion",

				(SELECT COUNT(amd.AmdId) FROM tblamdalmacenmovimientodetalle amd WHERE amd.AmoId = amo.AmoId ) AS "TasTotalItems",
				
				top.TopNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				alm.AlmNombre,
				alm2.AlmNombre AS AlmNombreDestino,
				
				(
		SELECT gre.GreId FROM tblgamguiaremisionalmacenmovimiento gam
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
						LEFT JOIN tblgrtguiaremisiontalonario grt
						ON gre.GrtId = grt.GrtId
				WHERE gam.AmoId = amo.AmoId	
				AND gre.GreEstado <>  6
				ORDER BY gre.GreFechaInicioTraslado DESC	
				LIMIT 1
		) AS GreId,
		
		(
		SELECT grt.GrtNumero FROM tblgamguiaremisionalmacenmovimiento gam
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
						LEFT JOIN tblgrtguiaremisiontalonario grt
						ON gre.GrtId = grt.GrtId
				WHERE gam.AmoId = amo.AmoId	
				AND gre.GreEstado <>  6
				ORDER BY gre.GreFechaInicioTraslado DESC	
				LIMIT 1
		) AS GrtNumero,
		
		(
		SELECT grt.GrtId FROM tblgamguiaremisionalmacenmovimiento gam
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
						LEFT JOIN tblgrtguiaremisiontalonario grt
						ON gre.GrtId = grt.GrtId
				WHERE gam.AmoId = amo.AmoId	
				AND gre.GreEstado <>  6
				ORDER BY gre.GreFechaInicioTraslado DESC	
				LIMIT 1
		) AS GrtId,
		
		(
		SELECT 		
		DATE_FORMAT(gre.GreFechaInicioTraslado , "%d/%m/%Y") 		
		FROM tblgamguiaremisionalmacenmovimiento gam
					LEFT JOIN tblgreguiaremision gre
					ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
						LEFT JOIN tblgrtguiaremisiontalonario grt
						ON gre.GrtId = grt.GrtId
				WHERE gam.AmoId = amo.AmoId	
				AND gre.GreEstado <>  6
				ORDER BY gre.GreFechaInicioTraslado DESC	
				LIMIT 1
		) AS GreFechaInicioTraslado	,
		
		
		
		
		
		
				
		CASE
				WHEN EXISTS (
					SELECT 

						(
							IFNULL(amd.AmdCantidad,0) 
							
							
							- IFNULL(

								(
									SELECT 
									SUM(amd2.AmdCantidad)
									FROM tblamdalmacenmovimientodetalle amd2
											
									WHERE amd2.AmdIdOrigen = amd.AmdId
										AND amd2.AmdEstado = 3
									LIMIT 1
								)

							,0)
							
							
						)  AS TsdCantidadPendiente

					FROM tblamdalmacenmovimientodetalle amd
							LEFT JOIN tblproproducto pro
							ON amd.ProId = pro.ProId

					WHERE amd.AmoId = amo.AmoId
						AND amd.AmdEstado = 3
						HAVING TsdCantidadPendiente > 0
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VdiGenerarEntrada
				
				
				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tbltoptipooperacion top
					ON amo.TopId = top.TopId
						
						LEFT JOIN tblmonmoneda mon
						ON amo.MonId = mon.MonId
						
							LEFT JOIN tblalmalmacen alm
							ON amo.AlmId = alm.AlmId
							
								LEFT JOIN tblalmalmacen alm2
								ON amo.AlmIdDestino = alm2.AlmId
								
				WHERE amo.AmoTipo = 2 
			
			
				'.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$pfacturar.$modalidad.$amsubtipo.$gentrada.$orden.$paginacion;
//	AND amo.AmoSubTipo = 6

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoAlmacenSalida = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoAlmacenSalida = new $InsTrasladoAlmacenSalida();
                    $TrasladoAlmacenSalida->TasId = $fila['TasId'];
					
					$TrasladoAlmacenSalida->AlmId = $fila['AlmId'];
					$TrasladoAlmacenSalida->AlmIdDestino = $fila['AlmIdDestino'];
					$TrasladoAlmacenSalida->TasFecha = $fila['NAmoFecha'];
					$TrasladoAlmacenSalida->TopId = $fila['TopId'];
					
					$TrasladoAlmacenSalida->LtiId = $fila['NLtiId'];
					
					$TrasladoAlmacenSalida->MonId = $fila['MonId'];
					$TrasladoAlmacenSalida->TasTipoCambio = $fila['TasTipoCambio'];
			
					$TrasladoAlmacenSalida->TasComprobanteNumero = $fila['TasComprobanteNumero'];
					$TrasladoAlmacenSalida->TasResponsable = $fila['TasResponsable'];
			
					$TrasladoAlmacenSalida->TasObservacion = $fila['TasObservacion'];
					
					$TrasladoAlmacenSalida->TasGuiaRemision = $fila['TasGuiaRemision'];					
					
					$TrasladoAlmacenSalida->TasEmpresaTransporte = $fila['TasEmpresaTransporte'];
					$TrasladoAlmacenSalida->TasEmpresaTransporteDocumento = $fila['TasEmpresaTransporteDocumento'];
					$TrasladoAlmacenSalida->TasEmpresaTransporteClave = $fila['TasEmpresaTransporteClave'];
					$TrasladoAlmacenSalida->TasEmpresaTransporteTipoEnvio = $fila['TasEmpresaTransporteTipoEnvio'];
					$TrasladoAlmacenSalida->TasEmpresaTransporteFecha = $fila['TasEmpresaTransporteFecha'];
					$TrasladoAlmacenSalida->TasEmpresaTransporteDestino = $fila['TasEmpresaTransporteDestino'];
					
					$TrasladoAlmacenSalida->TasCierre = $fila['TasCierre'];
					$TrasladoAlmacenSalida->TasEstado = $fila['TasEstado'];
					$TrasladoAlmacenSalida->TasTiempoCreacion = $fila['TasTiempoCreacion'];  
					$TrasladoAlmacenSalida->TasTiempoModificacion = $fila['TasTiempoModificacion']; 

					$TrasladoAlmacenSalida->TasTotalItems = $fila['TasTotalItems']; 
					$TrasladoAlmacenSalida->TasSinPrecio = $fila['TasSinPrecio']; 

					$TrasladoAlmacenSalida->TopNombre = $fila['TopNombre']; 

					$TrasladoAlmacenSalida->TdoId = $fila['TdoId']; 

					$TrasladoAlmacenSalida->CliNombreCompleto = $fila['CliNombreCompleto'];
					$TrasladoAlmacenSalida->CliNombre = $fila['CliNombre'];
					$TrasladoAlmacenSalida->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$TrasladoAlmacenSalida->CliApellidoMaterno = $fila['CliApellidoMaterno'];

					$TrasladoAlmacenSalida->LtiUtilidad = $fila['LtiUtilidad']; 
					$TrasladoAlmacenSalida->LtiNombre = $fila['LtiNombre']; 
					
					$TrasladoAlmacenSalida->CliId = $fila['CliId'];
					$TrasladoAlmacenSalida->TdoId = $fila['TdoId'];
					$TrasladoAlmacenSalida->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$TrasladoAlmacenSalida->CliDireccion = $fila['CliDireccion'];

					$TrasladoAlmacenSalida->MonNombre = $fila['MonNombre'];
					$TrasladoAlmacenSalida->MonSimbolo = $fila['MonSimbolo'];

					$TrasladoAlmacenSalida->AlmNombre = $fila['AlmNombre'];
					$TrasladoAlmacenSalida->AlmNombreDestino = $fila['AlmNombreDestino'];
					
					$TrasladoAlmacenSalida->GreId = $fila['GreId'];
					$TrasladoAlmacenSalida->GrtNumero = $fila['GrtNumero'];
					$TrasladoAlmacenSalida->GrtId = $fila['GrtId'];
					$TrasladoAlmacenSalida->GreFechaInicioTraslado = $fila['GreFechaInicioTraslado'];
					
					$TrasladoAlmacenSalida->VdiGenerarEntrada = $fila['VdiGenerarEntrada'];
					
					switch($TrasladoAlmacenSalida->TasEstado){

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
				
			$TrasladoAlmacenSalida->TasEstadoDescripcion = $Estado;
			
			
			switch($TrasladoAlmacenSalida->TasEstado){
			
				case 1:
					$Estado = '<img width="15" height="15" alt="[No Realizado]" title="No Realizado" src="imagenes/estado/no_realizado.png" />';
				break;
			
				case 3:
					$Estado = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';						
				break;	
				
				default:
					$Estado = "";
				break;
			
			}
				
			$TrasladoAlmacenSalida->TasEstadoIcono = $Estado;



                    $TrasladoAlmacenSalida->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoAlmacenSalida;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
			
		}
		
   public function MtdObtenerTrasladoAlmacenSalidasValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oSubTipo=NULL) {

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
					amd.AmdId
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE 
						amd.AmoId = amo.AmoId AND 
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
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (amo.AmoEstado = '.($elemento).')';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) ';

		}
		

		
		//deb($oSubTipo);
		if(!empty($oSubTipo)){

			$elementos = explode(",",$oSubTipo);

			$i=1;
			$amsubtipo .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$amsubtipo .= '  (amo.AmoSubTipo = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$amsubtipo .= ' OR ';	
				}
			$i++;		
			}

			$amsubtipo .= ' ) ';

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
		
		
			$sql = 'SELECT
			
				'.$funcion.' AS "RESULTADO"
				
				
				FROM tblamoalmacenmovimiento amo
					LEFT JOIN tbltoptipooperacion top
					ON amo.TopId = top.TopId
						LEFT JOIN tblfccfichaaccion fcc
						ON amo.FccId = fcc.FccId
							LEFT JOIN tblfimfichaingresomodalidad fim
							ON fcc.FimId = fim.FimId
								LEFT JOIN tblminmodalidadingreso min
								ON fim.MinId = min.MinId
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
									
						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
							
										LEFT JOIN tbleinvehiculoingreso ein
										ON fin.EinId = ein.EinId
									
											LEFT JOIN tblvvevehiculoversion vve
											ON ein.VveId = vve.VveId
												LEFT JOIN tblvmovehiculomodelo vmo
												ON ein.VmoId = vmo.VmoId
													LEFT JOIN tblvmavehiculomarca vma
													ON vmo.Vmaid = vma.VmaId	
													
										LEFT JOIN tblcprcotizacionproducto cpr
										ON amo.CprId = cpr.CprId
				WHERE amo.AmoTipo = 2 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$faccion.$fingreso.$confactura.$conficha.$fiestado.$conboleta.$concrepuesto.$crestado.$pfacturar.$modalidad.$amsubtipo.$orden.$paginacion;
			
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
			
		}
		
		
	
	//Accion eliminar	 
	public function MtdEliminarTrasladoAlmacenSalida($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsTrasladoAlmacenSalidaDetalle = new ClsTrasladoAlmacenSalidaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){
				
				
				$this->TasId = $elemento;
				
				$ResTrasladoAlmacenSalidaDetalle = $InsTrasladoAlmacenSalidaDetalle->MtdObtenerTrasladoAlmacenSalidaDetalles(NULL,NULL,NULL,'amd.AmdId','Desc',NULL,$this->TasId);
				$ArrTrasladoAlmacenSalidaDetalles = $ResTrasladoAlmacenSalidaDetalle['Datos'];

				if(!empty($ArrTrasladoAlmacenSalidaDetalles)){
					$amdetalle = '';

					foreach($ArrTrasladoAlmacenSalidaDetalles as $DatTrasladoAlmacenSalidaDetalle){
						$amdetalle .= '#'.$DatTrasladoAlmacenSalidaDetalle->TsdId;
					}

					if(!$InsTrasladoAlmacenSalidaDetalle->MtdEliminarTrasladoAlmacenSalidaDetalle($amdetalle)){								
						$error = true;
					}
						
				}
				
				
				if(!$error) {		
				
					$sql = 'DELETE FROM tblamoalmacenmovimiento WHERE  (AmoId = "'.($this->TasId).'" ) ';
												
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{
						
						
						$this->MtdAuditarTrasladoAlmacenSalida(3,"Se elimino el Movimiento de Almacen",$aux);		
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
	public function MtdActualizarEstadoTrasladoAlmacenSalida($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsTrasladoAlmacenSalida = new ClsTrasladoAlmacenSalida();
		$InsTrasladoAlmacenSalidaDetalle = new ClsTrasladoAlmacenSalidaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
		

					$ResTrasladoAlmacenSalidaDetalle = $InsTrasladoAlmacenSalidaDetalle->MtdObtenerTrasladoAlmacenSalidaDetalles(NULL,NULL,NULL,'amd.AmdId','Desc',NULL,$elemento);
					$ArrTrasladoAlmacenSalidaDetalles = $ResTrasladoAlmacenSalidaDetalle['Datos'];
	
					if(!empty($ArrTrasladoAlmacenSalidaDetalles)){
						$amdetalle = '';
	
						foreach($ArrTrasladoAlmacenSalidaDetalles as $DatTrasladoAlmacenSalidaDetalle){
							$amdetalle .= '#'.$DatTrasladoAlmacenSalidaDetalle->TsdId;
						}
	
						if(!$InsTrasladoAlmacenSalidaDetalle->MtdActualizarEstadoTrasladoAlmacenSalidaDetalle($amdetalle,$oEstado)){								
							$error = true;
						}
							
					}
				
				
					if(!$error){

						$sql = 'UPDATE tblamoalmacenmovimiento SET AmoEstado = '.$oEstado.' WHERE AmoId = "'.$elemento.'"';
			
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarTrasladoAlmacenSalida(2,"Se actualizo el Estado del Movimiento de Almacen",$elemento);
					
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
	
	
	public function MtdRegistrarTrasladoAlmacenSalida() {

		global $Resultado;

		$error = false;

			$this->MtdGenerarTrasladoAlmacenSalidaId();
//LtiId,
			$sql = 'INSERT INTO tblamoalmacenmovimiento (
			AmoId,				
			
			FccId,
			TopId,
			PerId,
			
			CprId,
			VdiId,
			
			NpaId,
			AmoCantidadDia,
			
			CliId,	
			LtiId,
			
			AmoTipo,
			AmoSubTipo,
			
			TalId,
			PprId,
			
			AlmId,
			AlmIdDestino,
			
			AmoIdOrigen,
			
			AmoFecha,
			MonId,
			AmoTipoCambio,
			AmoGuiaRemisionNumero,
			AmoGuiaRemisionFecha,
			
			AmoComprobanteNumero,
			AmoResponsable,
			
			AmoObservacion,
			AmoDescuento,
			AmoSubTotal,
			AmoImpuesto,
			AmoTotal,
			
			AmoCancelado,
			AmoRevisado,
			AmoFacturable,
			
			
			AmoEmpresaTransporte,
			AmoEmpresaTransporteDocumento,
			AmoEmpresaTransporteClave,
			AmoEmpresaTransporteTipoEnvio,
			AmoEmpresaTransporteFecha,
			AmoEmpresaTransporteDestino,
			
			
			AmoCierre,
			AmoEstado,			
			AmoTiempoCreacion,
			AmoTiempoModificacion) 
			VALUES (
			"'.($this->TasId).'", 
			
			NULL,
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			
			NULL,
			NULL,
			
			NULL,
			0,
			
			"'.($this->CliId).'", 
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			
			2,
			8,
			
			NULL,
			NULL,
			
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			'.(empty($this->AlmIdDestino)?'NULL, ':'"'.$this->AlmIdDestino.'",').'
			
			
			NULL,
			
			"'.($this->TasFecha).'", 
			'.(empty($this->MonId)?'NULL, ':'"'.$this->MonId.'",').'
			0, 			
			NULL, 
			NULL,
			
			"'.($this->TasComprobanteNumero).'",
			"'.($this->TasResponsable).'",
			
			"'.($this->TasObservacion).'",
			0,
			
			0,
			0,
			0,
			
			2,
			0,
			1,
			
			
			"'.($this->TasEmpresaTransporte).'",
			"'.($this->TasEmpresaTransporteDocumento).'",
			"'.($this->TasEmpresaTransporteClave).'",
			"'.($this->TasEmpresaTransporteTipoEnvio).'",
			'.(empty($this->TasEmpresaTransporteFecha)?'NULL, ':'"'.$this->TasEmpresaTransporteFecha.'",').'
			"'.($this->TasEmpresaTransporteDestino).'",
		
			2,
			'.($this->TasEstado).',
			"'.($this->TasTiempoCreacion).'", 				
			"'.($this->TasTiempoModificacion).'");';			

			$this->InsMysql->MtdTransaccionIniciar();

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
					
			if(!$error){			

				if (!empty($this->TrasladoAlmacenSalidaDetalle)){		
						
					$validar = 0;				
					$InsTrasladoAlmacenSalidaDetalle = new ClsTrasladoAlmacenSalidaDetalle();		
					
					foreach ($this->TrasladoAlmacenSalidaDetalle as $DatTrasladoAlmacenSalidaDetalle){
					
						$InsTrasladoAlmacenSalidaDetalle->TasId = $this->TasId;
						$InsTrasladoAlmacenSalidaDetalle->ProId = $DatTrasladoAlmacenSalidaDetalle->ProId;
						$InsTrasladoAlmacenSalidaDetalle->UmeId = $DatTrasladoAlmacenSalidaDetalle->UmeId;

						$InsTrasladoAlmacenSalidaDetalle->TsdCantidad = $DatTrasladoAlmacenSalidaDetalle->TsdCantidad;
						$InsTrasladoAlmacenSalidaDetalle->TsdCantidadReal = $DatTrasladoAlmacenSalidaDetalle->TsdCantidadReal;
						$InsTrasladoAlmacenSalidaDetalle->TsdCantidadRealAnterior = $DatTrasladoAlmacenSalidaDetalle->TsdCantidadRealAnterior;
					
						$InsTrasladoAlmacenSalidaDetalle->TsdEstado = $DatTrasladoAlmacenSalidaDetalle->TsdEstado;									
						$InsTrasladoAlmacenSalidaDetalle->TsdTiempoCreacion = $DatTrasladoAlmacenSalidaDetalle->TsdTiempoCreacion;
						$InsTrasladoAlmacenSalidaDetalle->TsdTiempoModificacion = $DatTrasladoAlmacenSalidaDetalle->TsdTiempoModificacion;						
						$InsTrasladoAlmacenSalidaDetalle->TsdEliminado = $DatTrasladoAlmacenSalidaDetalle->TsdEliminado;
						
						$InsTrasladoAlmacenSalidaDetalle->AlmId = $this->AlmId;
						$InsTrasladoAlmacenSalidaDetalle->TsdFecha = $this->TasFecha;
						
						$StockReal = 0;
						$Fecha = explode("/",$this->TasFecha);
						$Ano = $Fecha[2];
						
						$InsAlmacenProducto = new ClsAlmacenProducto();
						//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
						$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTrasladoAlmacenSalidaDetalle->ProId,$this->AlmId,$Ano);
						
						if( ($StockReal + $InsTrasladoAlmacenSalidaDetalle->TsdCantidadRealAnterior) < $InsTrasladoAlmacenSalidaDetalle->TsdCantidadReal and $InsTrasladoAlmacenSalidaDetalle->TsdEliminado == 1 and $InsTrasladoAlmacenSalidaDetalle->TsdEstado == 3){
//							
							$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
							$Resultado.='#ERR_TAS_208';												 
							
						}else{
							
							$StockReal = 0;
							$Fecha = explode("/",$this->TasFecha);
							$Ano = $Fecha[2];
							
							$InsAlmacenProducto = new ClsAlmacenProducto();
							
							$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTrasladoAlmacenSalidaDetalle->ProId,$this->AlmId,$Ano);
							
							if( ($StockReal + $InsTrasladoAlmacenSalidaDetalle->TsdCantidadRealAnterior) < $InsTrasladoAlmacenSalidaDetalle->TsdCantidadReal and $InsTrasladoAlmacenSalidaDetalle->TsdEliminado == 1 and $InsTrasladoAlmacenSalidaDetalle->TsdEstado == 3){
//							
								$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
								$Resultado.='#ERR_TPE_208';												 
								
							}else{
								
								if($InsTrasladoAlmacenSalidaDetalle->MtdRegistrarTrasladoAlmacenSalidaDetalle()){
									$validar++;	
								}else{
									 $Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TAS_201';
								}
								
							}
							
							
						}
																
					
					}					
					
					if(count($this->TrasladoAlmacenSalidaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
	
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarTrasladoAlmacenSalida(1,"Se registro el Movimiento de Almacen",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarTrasladoAlmacenSalida() {

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblamoalmacenmovimiento SET
		
		'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
		'.(empty($this->AlmIdDestino)?'AlmIdDestino = NULL, ':'AlmIdDestino = "'.$this->AlmIdDestino.'",').'
		'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
		
		AmoFecha = "'.($this->TasFecha).'",
		'.(empty($this->MonId)?'MonId = NULL, ':'MonId = "'.$this->MonId.'",').'
		
		AmoEmpresaTransporte = "'.($this->TasEmpresaTransporte).'",
		AmoEmpresaTransporteDocumento = "'.($this->TasEmpresaTransporteDocumento).'",
		AmoEmpresaTransporteClave = "'.($this->TasEmpresaTransporteClave).'",
		AmoEmpresaTransporteTipoEnvio = "'.($this->TasEmpresaTransporteTipoEnvio).'",
		'.(empty($this->TasEmpresaTransporteFecha)?'AmoEmpresaTransporteFecha = NULL, ':'AmoEmpresaTransporteFecha = "'.$this->TasEmpresaTransporteFecha.'",').'
		AmoEmpresaTransporteDestino = "'.($this->TasEmpresaTransporteDestino).'",

		AmoComprobanteNumero = "'.($this->TasComprobanteNumero).'",
		AmoResponsable = "'.($this->TasResponsable).'",
		
		AmoObservacion = "'.($this->TasObservacion).'",
		
		AmoTiempoModificacion = "'.($this->TasTiempoModificacion).'",
		AmoEstado = '.($this->TasEstado).'
		WHERE AmoId = "'.($this->TasId).'";';			

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 			

		if(!$error){
			
				if (!empty($this->TrasladoAlmacenSalidaDetalle)){		

					$validar = 0;	
					$item = 1;			
					$InsTrasladoAlmacenSalidaDetalle = new ClsTrasladoAlmacenSalidaDetalle();
							
					foreach ($this->TrasladoAlmacenSalidaDetalle as $DatTrasladoAlmacenSalidaDetalle){
										
						$InsProducto = new ClsProducto();
						$InsProducto->ProId = $DatTrasladoAlmacenSalidaDetalle->ProId;
						$InsProducto->MtdObtenerProducto(false);
						
						
						$InsTrasladoAlmacenSalidaDetalle->TsdId = $DatTrasladoAlmacenSalidaDetalle->TsdId;
						$InsTrasladoAlmacenSalidaDetalle->TasId = $this->TasId;
						$InsTrasladoAlmacenSalidaDetalle->ProId = $DatTrasladoAlmacenSalidaDetalle->ProId;
						$InsTrasladoAlmacenSalidaDetalle->UmeId = $DatTrasladoAlmacenSalidaDetalle->UmeId;

						$InsTrasladoAlmacenSalidaDetalle->TsdCantidad = $DatTrasladoAlmacenSalidaDetalle->TsdCantidad;
						$InsTrasladoAlmacenSalidaDetalle->TsdCantidadReal = $DatTrasladoAlmacenSalidaDetalle->TsdCantidadReal;
						$InsTrasladoAlmacenSalidaDetalle->TsdCantidadRealAnterior = $DatTrasladoAlmacenSalidaDetalle->TsdCantidadRealAnterior;
						
						$InsTrasladoAlmacenSalidaDetalle->TsdEstado = $DatTrasladoAlmacenSalidaDetalle->TsdEstado;		
						$InsTrasladoAlmacenSalidaDetalle->TsdTiempoCreacion = $DatTrasladoAlmacenSalidaDetalle->TsdTiempoCreacion;
						$InsTrasladoAlmacenSalidaDetalle->TsdTiempoModificacion = $DatTrasladoAlmacenSalidaDetalle->TsdTiempoModificacion;
						$InsTrasladoAlmacenSalidaDetalle->TsdEliminado = $DatTrasladoAlmacenSalidaDetalle->TsdEliminado;
						
						$InsTrasladoAlmacenSalidaDetalle->AlmId = $this->AlmId;
						$InsTrasladoAlmacenSalidaDetalle->TsdFecha = $this->TasFecha;
						
						if(empty($InsTrasladoAlmacenSalidaDetalle->TsdId)){
							if($InsTrasladoAlmacenSalidaDetalle->TsdEliminado<>2){
								

											if(!empty($InsTrasladoAlmacenSalidaDetalle->ProId)){
												if(!empty($InsTrasladoAlmacenSalidaDetalle->UmeId)){
													if(!empty($InsTrasladoAlmacenSalidaDetalle->TsdCantidad)){
														if(!empty($InsTrasladoAlmacenSalidaDetalle->TsdCantidadReal)){
														
															//if($InsTrasladoAlmacenSalidaDetalle->TsdEstado == 3){
																
																$StockReal = 0;
																$Fecha = explode("/",$this->TasFecha);
																$Ano = $Fecha[2];
																
																$InsAlmacenProducto = new ClsAlmacenProducto();
																//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
																$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTrasladoAlmacenSalidaDetalle->ProId,$this->AlmId,$Ano);
																
																if( ($StockReal + $InsTrasladoAlmacenSalidaDetalle->TsdCantidadRealAnterior) < $InsTrasladoAlmacenSalidaDetalle->TsdCantidadReal and $InsTrasladoAlmacenSalidaDetalle->TsdEliminado == 1 and $InsTrasladoAlmacenSalidaDetalle->TsdEstado == 3){
				//							
																	$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																	$Resultado.='#ERR_TAS_208';												 
																	
																}else{
																	
																	if($InsTrasladoAlmacenSalidaDetalle->MtdRegistrarTrasladoAlmacenSalidaDetalle()){
																		$validar++;	
																	}else{
																		$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																		$Resultado.='#ERR_TAS_201';
																	}
																	
																}
																
															//}
												
															/*if($InsTrasladoAlmacenSalidaDetalle->MtdRegistrarTrasladoAlmacenSalidaDetalle()){
																$validar++;	
															}else{
																$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																$Resultado.='#ERR_TAS_201';
																//$Resultado.='#\n';
															}*/
											
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TAS_205';
															//$Resultado.='#\n';
														}
													}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TAS_207';
															//$Resultado.='#\n';
													}
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_TAS_207';
													//$Resultado.='#\n';
												}
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TAS_206';
												//$Resultado.='#\n';
											}
											
							}else{
								$validar++;
							}
						}else{						
							if($InsTrasladoAlmacenSalidaDetalle->TsdEliminado==2){
								if($InsTrasladoAlmacenSalidaDetalle->MtdEliminarTrasladoAlmacenSalidaDetalle($InsTrasladoAlmacenSalidaDetalle->TsdId)){
									$validar++;					
								}else{
									$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
									$Resultado.='#ERR_TAS_203';
									//$Resultado.='#\n';
								}
							}else{
								
											if(!empty($InsTrasladoAlmacenSalidaDetalle->ProId)){
												if(!empty($InsTrasladoAlmacenSalidaDetalle->UmeId)){
													if(!empty($InsTrasladoAlmacenSalidaDetalle->TsdCantidad)){
														if(!empty($InsTrasladoAlmacenSalidaDetalle->TsdCantidadReal)){
							
															/*if($InsTrasladoAlmacenSalidaDetalle->MtdEditarTrasladoAlmacenSalidaDetalle()){
																$validar++;	
															}else{
																$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																$Resultado.='#ERR_TAS_202';
																//$Resultado.='#\n';	
															}*/
															
															//if($InsTrasladoAlmacenSalidaDetalle->TsdEstado == 3){
																
																$StockReal = 0;
																$Fecha = explode("/",$this->TasFecha);
																$Ano = $Fecha[2];
																
																$InsAlmacenProducto = new ClsAlmacenProducto();
																//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
																$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($InsTrasladoAlmacenSalidaDetalle->ProId,$this->AlmId,$Ano);
																
																
																if( ($StockReal + $InsTrasladoAlmacenSalidaDetalle->TsdCantidadRealAnterior) < $InsTrasladoAlmacenSalidaDetalle->TsdCantidadReal and $InsTrasladoAlmacenSalidaDetalle->TsdEliminado == 1 and $InsTrasladoAlmacenSalidaDetalle->TsdEstado == 3){
				//							
																	$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																	$Resultado.='#ERR_TAS_208';												 
																	
																}else{
																	
																	if($InsTrasladoAlmacenSalidaDetalle->MtdEditarTrasladoAlmacenSalidaDetalle()){
																		$validar++;	
																	}else{
																		$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
																		$Resultado.='#ERR_TAS_202';
																		//$Resultado.='#\n';	
																	}
																	
																}
															
															//}
											
														}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TAS_205';
															//$Resultado.='#\n';
														}
													}else{
															$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
															$Resultado.='#ERR_TAS_207';
															//$Resultado.='#\n';
													}
												}else{
													$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
													$Resultado.='#ERR_TAS_207';
													//$Resultado.='#\n';
												}
											}else{
												$Resultado='#- '.($InsProducto->ProCodigoOriginal).' '.($InsProducto->ProNombre);
												$Resultado.='#ERR_TAS_206';
												//$Resultado.='#\n';
											}

							}
						}	
						
						$item++;								
					}
					
					if(count($this->TrasladoAlmacenSalidaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
		
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarTrasladoAlmacenSalida(2,"Se edito el Movimiento de Almacen",$this);		
				return true;
			}	
				
		}	
		
	
	
		private function MtdAuditarTrasladoAlmacenSalida($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->TasId;

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