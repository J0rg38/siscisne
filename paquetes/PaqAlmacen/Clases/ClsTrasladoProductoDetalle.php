<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoProductoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoProductoDetalle {

    public $TpdId;
	public $TptId;
	public $ProId;
	public $UmeId;

	public $TpdCosto;
    public $TpdCantidad;	
	public $TpdCantidadReal;
	public $TpdImporte;	
	public $TpdEstado;	
	public $TpdTiempoCreacion;
	public $TpdTiempoModificacion;
    public $TpdEliminado;
	

	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProNombre;
	public $RtiId;
	public $UmeIdOrigen;
	
	public $UmeNombre;
	public $UmeAbreviacion;

				
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

	private function MtdGenerarTrasladoProductoDetalleId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TpdId,5),unsigned)) AS "MAXIMO"
			FROM tbltpdtrasladoproductodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TpdId = "TPD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TpdId = "TPD-".$fila['MAXIMO'];					
			}
				
		}
		
		
   public function MtdObtenerTrasladoProductoDetalle(){

		$sql = 'SELECT
			 
			tpd.TpdId,			
			tpd.TptId,
			tpd.ProId,
			tpd.UmeId,

			tpd.TpdCosto,
			tpd.TpdCantidad,
			tpd.TpdCantidadReal,
			tpd.TpdImporte,
			DATE_FORMAT(tpd.TpdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTpdTiempoCreacion",
	        DATE_FORMAT(tpd.TpdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTpdTiempoModificacion",
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(tpt.TptFecha, "%d/%m/%Y") AS "NTptFecha",
			
		
			
			FROM tbltpdtrasladoproductodetalle tpd
				LEFT JOIN tblproproducto pro
				ON tpd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON tpd.UmeId = ume.UmeId				
						LEFT JOIN tbltpttrasladoproducto tpt
						ON tpd.TptId = tpt.TptId
						

		WHERE tpd.TpdId = "'.$this->TpdId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->TpdId = $fila['TpdId'];
			$this->TptId = $fila['TptId'];
			$this->UmeId = $fila['UmeId'];
			
			$this->TpdCosto = $fila['TpdCosto'];  
			$this->TpdCantidad = $fila['TpdCantidad'];  
			$this->TpdCantidadReal = $fila['TpdCantidadReal'];  
			$this->TpdImporte = $fila['TpdImporte'];
			
			$this->TpdTiempoCreacion = $fila['NTpdTiempoCreacion'];  
			$this->TpdTiempoModificacion = $fila['NTpdTiempoModificacion']; 
								
			$this->ProId = $fila['ProId'];
			$this->ProCodigoOriginal = $fila['ProCodigoOriginal'];
			$this->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
			$this->ProNombre = (($fila['ProNombre']));
			$this->RtiId = (($fila['RtiId']));
			$this->UmeIdOrigen = (($fila['UmeIdOrigen']));
			
			$this->UmeNombre = (($fila['UmeNombre']));
			$this->UmeAbreviacion = (($fila['UmeAbreviacion']));
			
			$this->TptFecha = (($fila['NTptFecha']));
			
		
					
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	

    public function MtdObtenerTrasladoProductoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TpdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoProducto=NULL,$oEstado=NULL,$oProducto=NULL,$oTrasladoProductoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
		
		if(!empty($oTrasladoProducto)){
			$tptvimiento = ' AND tpd.TptId = "'.$oTrasladoProducto.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND tpd.TpdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (tpd.ProId = "'.$oProducto.'") ';
		}
		
		
		if(!empty($oTrasladoProductoEstado)){
			$amestado = ' AND (tpt.TptEstado = '.$oTrasladoProductoEstado.') ';
		}



		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			
			AND 
			
			(
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		

		if(!empty($oProductoTipo)){
			$ptipo = ' AND (pro.RtiId = "'.$oProductoTipo.'") ';
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
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			tpd.TpdId,			
			tpd.TptId,
			tpd.ProId,
			tpd.UmeId,

			tpd.TpdCosto,
			tpd.TpdCantidad,
			tpd.TpdCantidadReal,
			tpd.TpdImporte,
			
			tpd.TpdEstado,
			DATE_FORMAT(tpd.TpdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTpdTiempoCreacion",
	        DATE_FORMAT(tpd.TpdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTpdTiempoModificacion",
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume2.UmeNombre  AS "UmeNombreOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(tpt.TptFecha, "%d/%m/%Y") AS "NTptFecha",
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			cli.CliNumeroDocumento,
			
			top.TopNombre
			
			FROM tbltpdtrasladoproductodetalle tpd
			
				LEFT JOIN tblproproducto pro
				ON tpd.ProId = pro.ProId
	
					LEFT JOIN tblumeunidadmedida ume
					ON tpd.UmeId = ume.UmeId		

						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId

							LEFT JOIN tbltpttrasladoproducto tpt
							ON tpd.TptId = tpt.TptId
						
								LEFT JOIN tblclicliente cli
								ON tpt.CliId = cli.CliId
								
									LEFT JOIN tbltoptipooperacion top
									ON tpt.TopId = top.TopId
		
								
			WHERE 1 = 1
		
			'.$tptvimiento.$fecha.$estado.$producto.$filtrar.$amestado.$vmarca.$almacen.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoProductoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoProductoDetalle = new $InsTrasladoProductoDetalle();
                    $TrasladoProductoDetalle->TpdId = $fila['TpdId'];
                    $TrasladoProductoDetalle->TptId = $fila['TptId'];
					$TrasladoProductoDetalle->UmeId = $fila['UmeId'];
					
					$TrasladoProductoDetalle->TpdCosto = $fila['TpdCosto'];  
			        $TrasladoProductoDetalle->TpdCantidad = $fila['TpdCantidad'];  
					$TrasladoProductoDetalle->TpdCantidadReal = $fila['TpdCantidadReal'];  
					
					$TrasladoProductoDetalle->TpdCosto = $fila['TpdCosto'];  
					$TrasladoProductoDetalle->TpdImporte = $fila['TpdImporte'];
				
					$TrasladoProductoDetalle->TpdEstado = $fila['TpdEstado'];
					$TrasladoProductoDetalle->TpdTiempoCreacion = $fila['NTpdTiempoCreacion'];  
					$TrasladoProductoDetalle->TpdTiempoModificacion = $fila['NTpdTiempoModificacion']; 	
									
					$TrasladoProductoDetalle->ProId = $fila['ProId'];
					$TrasladoProductoDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$TrasladoProductoDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $TrasladoProductoDetalle->ProNombre = (($fila['ProNombre']));
					$TrasladoProductoDetalle->RtiId = (($fila['RtiId']));
					$TrasladoProductoDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$TrasladoProductoDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					
					$TrasladoProductoDetalle->UmeNombre = (($fila['UmeNombre']));
					$TrasladoProductoDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$TrasladoProductoDetalle->TptFecha = (($fila['NTptFecha']));
					
					$TrasladoProductoDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$TrasladoProductoDetalle->CliNombre = (($fila['CliNombre']));
					$TrasladoProductoDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$TrasladoProductoDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					$TrasladoProductoDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$TrasladoProductoDetalle->TopNombre = (($fila['TopNombre']));
					
                    $TrasladoProductoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoProductoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		




    public function MtdObtenerTrasladoProductoDetallesValor($oFuncion="SUM",$oParametro="TptTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TpdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoProducto=NULL,$oEstado=NULL,$oProducto=NULL,$oTrasladoProductoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oModalidadIngreso=NULL,$oPersonal=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oTrasladoProducto)){
			$tptvimiento = ' AND tpd.TptId = "'.$oTrasladoProducto.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND tpd.TpdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (tpd.ProId = "'.$oProducto.'") ';
		}

		if(!empty($oTrasladoProductoEstado)){
			$amestado = ' AND (tpt.TptEstado = '.$oTrasladoProductoEstado.') ';
		}

		

		
		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			
			AND 
			
			(
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND (pro.RtiId = "'.$oProductoTipo.'") ';
		}		
		
		
		if(!empty($oPersonal)){
			$personal = ' AND (tpt.PerId = "'.$oPersonal.'") ';
		}		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (tpt.SucId = "'.$oSucursal.'") ';
		}		
		
		
		//,$=NULL,$=NULL,$=NULL
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(tpt.TptFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(tpt.TptFecha) ="'.($oAno).'"';
		}
		
		
		$sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			FROM tbltpdtrasladoproductodetalle tpd
				LEFT JOIN tblproproducto pro
				ON tpd.ProId = pro.ProId
		
					LEFT JOIN tblumeunidadmedida ume
					ON tpd.UmeId = ume.UmeId		

						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId

							LEFT JOIN tbltpttrasladoproducto tpt
							ON tpd.TptId = tpt.TptId
							
											LEFT JOIN tblclicliente cli
											ON tpt.CliId = cli.CliId
								
								LEFT JOIN tbltoptipooperacion top
								ON tpt.TopId = top.TopId
	
							
			WHERE   1 = 1 '.$ano.$mes.$tptvimiento.$mingreso.$personal.$sucursal.$estado.$producto.$filtrar.$amestado.$vmarca.$ptipo.$orden.$paginacion;	
			
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}
				
		
	//Accion eliminar	 
	
	public function MtdEliminarTrasladoProductoDetalle($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (TpdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (TpdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tbltpdtrasladoproductodetalle 
				WHERE '.$eliminar;
							
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
	public function MtdActualizarEstadoTrasladoProductoDetalle($oElementos,$oEstado) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$actualizar .= '  (TpdId = "'.($elemento).'")';	
					}else{
						$actualizar .= '  (TpdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'UPDATE tbltpdtrasladoproductodetalle SET 
				TpdEstado = '.$oEstado.'
				WHERE '.$actualizar;
							
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
	
	public function MtdRegistrarTrasladoProductoDetalle() {
	
			$this->MtdGenerarTrasladoProductoDetalleId();
			
			$sql = 'INSERT INTO tbltpdtrasladoproductodetalle (
			TpdId,
			TptId,	
			ProId,
			UmeId,
		
			TpdCosto,
			TpdCantidad,
			TpdCantidadReal,
			TpdImporte,
			
			TpdEstado,
			TpdTiempoCreacion,
			TpdTiempoModificacion
			) 
			VALUES (
			"'.($this->TpdId).'", 
			"'.($this->TptId).'", 
			"'.($this->ProId).'", 
			"'.trim($this->UmeId).'", 
			
			'.($this->TpdCosto).',
			'.($this->TpdCantidad).',
			'.($this->TpdCantidadReal).',
			'.($this->TpdImporte).', 
			
			'.($this->TpdEstado).',
			"'.($this->TpdTiempoCreacion).'",
			"'.($this->TpdTiempoModificacion).'");';
		
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
	
	public function MtdEditarTrasladoProductoDetalle() {

			$sql = 'UPDATE tbltpdtrasladoproductodetalle SET 	
			ProId = "'.($this->ProId).'",
			UmeId = "'.trim($this->UmeId).'",
			
			TpdCosto = '.($this->TpdCosto).',
			TpdCantidad = '.($this->TpdCantidad).',
			TpdCantidadReal = '.($this->TpdCantidadReal).',
			TpdImporte = '.($this->TpdImporte).',
			
			TpdEstado = '.($this->TpdEstado).'
			
			WHERE TpdId = "'.($this->TpdId).'";';
					
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
	
	
	
		public function MtdEditarTrasladoProductoDetalleDato($oCampo,$oDato,$oTrasladoProductoDetalleId) {

			$sql = 'UPDATE tbltpdtrasladoproductodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE TpdId = "'.($oTrasladoProductoDetalleId).'";';
					
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
		
		
}
?>