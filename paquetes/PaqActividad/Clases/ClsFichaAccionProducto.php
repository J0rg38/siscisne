<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccionProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccionProducto {

    public $FapId;
	public $FccId;
	public $ProId;
	public $UmeId;
	
	public $FaaId;
	
	public $FapCantidad;
	public $FapCantidadReal;
	
	public $FapAccion;
	
	public $FapVerificar1;
	public $FapVerificar2;
	public $FapEstado;
	public $FapTiempoCreacion;
	public $FapTiempoModificacion;
    public $FapEliminado;
	
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProCosto;
	public $ProPrecio;
	
	public $RtiId;
	public $UmeIdOrigen;
	public $UmeNombre;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaAccionProductoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FapId,5),unsigned)) AS "MAXIMO"
		FROM tblfapfichaaccionproducto';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FapId = "FIP-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FapId = "FAP-".$fila['MAXIMO'];					
		}

	}
	

    public function MtdObtenerFichaAccionProducto(){

        $sql = 'SELECT 

			fap.FapId,			
			fap.FccId,
			fap.ProId,
			fap.UmeId,
			
			fap.FaaId,
			
			fap.FapCantidad,
			fap.FapCantidadReal,
			
			fap.FapAccion,
			
			fap.FapVerificar1,
			fap.FapVerificar2,
			fap.FapEstado,
			DATE_FORMAT(fap.FapTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFapTiempoCreacion",
	        DATE_FORMAT(fap.FapTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFapTiempoModificacion",
			
			pro.ProNombre,
		
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProCosto,
			pro.ProPrecio,
			
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre		
			
			FROM tblfapfichaaccionproducto fap
				LEFT JOIN tblproproducto pro
				ON fap.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON fap.UmeId = ume.UmeId		
					
			WHERE FapId = "'.$this->FapId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->FapId = $fila['FapId'];
			$this->FccId = $fila['FccId'];					
			$this->ProId = $fila['ProId'];	
			$this->UmeId = $fila['UmeId'];
			
			$this->FaaId = $fila['FaaId'];
			
			$this->FapCantidad = $fila['FapCantidad'];	
			$this->FapCantidadReal = $fila['FapCantidadReal'];	
			
			$this->FapAccion = $fila['FapAccion'];	
			
			$this->FapVerificar1 = $fila['FapVerificar1'];	
			$this->FapVerificar2 = $fila['FapVerificar2'];						
			$this->FapEstado = $fila['FapEstado'];
			$this->FapTiempoCreacion = $fila['NFapTiempoCreacion'];  
			$this->FapTiempoModificacion = $fila['NFapTiempoModificacion'];
			
			$this->ProNombre = $fila['ProNombre']; 
			$this->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
			$this->ProCodigoAlternativo = $fila['ProCodigoAlternativo']; 
			$this->ProCosto = $fila['ProCosto']; 
			$this->ProPrecio = $fila['ProPrecio']; 
			
			$this->RtiId = $fila['RtiId']; 
			$this->UmeIdOrigen = $fila['UmeIdOrigen']; 
			$this->UmeNombre = $fila['UmeNombre']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


	public function MtdVerificarExisteFichaAccionProductos($oCampo,$oDato,$oFichaAccion){
		 
		 $FichaAccionProductoId = "";
		 
		 $ResFichaAccionProducto = $this->MtdObtenerFichaAccionProductos($oCampo,$oDato,'FapId','ASC','1',$oFichaAccion,NULL,NULL,1,NULL,NULL);
		 $ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
		 
		 if(!empty($ArrFichaAccionProductos)){
			 foreach($ArrFichaAccionProductos as $DatFichaAccionProducto){
				 
				 $FichaAccionProductoId = $DatFichaAccionProducto->FapId;
				 
			 }
		 }
		
		 return $FichaAccionProductoId;
	 }
	 
	 
	public function MtdObtenerFichaAccionProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FapId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oFichaAccionMantenimiento=NULL,$oEstricto=1,$oAccion=NULL,$oVehiculoMarca=NULL) {


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
		
		if(!empty($oFichaAccion)){
			$faccion = ' AND fap.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fap.FapEstado = '.$oEstado.'';
		}		

		if(!empty($oFichaAccionMantenimiento)){
			$famantenimiento = ' AND fap.FaaId = "'.$oFichaAccionMantenimiento.'"';
		}	

		//if($oEstricto){
//			
//			$estricto = " AND fap.FaaId IS NULL ";
//			
//		}
		
		switch($oEstricto){
			
			case 1:
				$estricto = " AND fap.FaaId IS NULL ";
			break;
			
			case 2:
				$estricto = " AND fap.FaaId IS NOT NULL ";
			break;
			
			case 0:
			
			break;
			
		}
		
		if(!empty($oAccion)){
			$accion = ' AND fap.FapAccion = "'.$oAccion.'"';
		}	
		
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'"';
		}	
		
	 	 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fap.FapId,			
			fap.FccId,
			fap.ProId,
			fap.UmeId,
			
			fap.FaaId,
			
			fap.FapCantidad,
			fap.FapCantidadReal,
			
			fap.FapAccion,
			
			fap.FapVerificar1,
			fap.FapVerificar2,
			fap.FapEstado,
			DATE_FORMAT(fap.FapTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFapTiempoCreacion",
	        DATE_FORMAT(fap.FapTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFapTiempoModificacion",
			
			pro.ProNombre,
		
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProCosto,
			pro.ProPrecio,
			
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre		
			
			FROM tblfapfichaaccionproducto fap
			
				LEFT JOIN tblproproducto pro
				ON fap.ProId = pro.ProId
				
					LEFT JOIN tblumeunidadmedida ume
					ON fap.UmeId = ume.UmeId				
					
			WHERE  1 = 1 '.$estricto.$faccion.$estado.$famantenimiento.$accion.$vmarca.$filtrar.$orden.$paginacion;	
		
		
//			WHERE  1 = 1 '.$faccion.$estado.$filtrar.$orden.$paginacion;	
		
////	$InsAlmacenMovimientoSalidaDetalle1->ProNombre = $DatFichaAccionProducto->ProNombre;
//	$InsAlmacenMovimientoSalidaDetalle1->RtiId= $DatFichaAccionProducto->RtiId;
//	$InsAlmacenMovimientoSalidaDetalle1->UmeNombre= $DatFichaAccionProducto->UmeNombre;
//	$InsAlmacenMovimientoSalidaDetalle1->UmeIdOrigen= $DatFichaAccionProducto->UmeIdOrigen;
							
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaAccionProducto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccionProducto = new $InsFichaAccionProducto();
                    $FichaAccionProducto->FapId = $fila['FapId'];
                    $FichaAccionProducto->FccId = $fila['FccId'];					
					$FichaAccionProducto->ProId = $fila['ProId'];	
					$FichaAccionProducto->UmeId = $fila['UmeId'];
					
					$FichaAccionProducto->FaaId = $fila['FaaId'];
					
					$FichaAccionProducto->FapCantidad = $fila['FapCantidad'];	
					$FichaAccionProducto->FapCantidadReal = $fila['FapCantidadReal'];	

					$FichaAccionProducto->FapAccion = $fila['FapAccion'];	
					
					$FichaAccionProducto->FapVerificar1 = $fila['FapVerificar1'];	
					$FichaAccionProducto->FapVerificar2 = $fila['FapVerificar2'];						
					$FichaAccionProducto->FapEstado = $fila['FapEstado'];
					$FichaAccionProducto->FapTiempoCreacion = $fila['NFapTiempoCreacion'];  
					$FichaAccionProducto->FapTiempoModificacion = $fila['NFapTiempoModificacion'];
					
					$FichaAccionProducto->ProNombre = $fila['ProNombre']; 
					$FichaAccionProducto->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
					$FichaAccionProducto->ProCodigoAlternativo = $fila['ProCodigoAlternativo']; 
					$FichaAccionProducto->ProCosto = $fila['ProCosto']; 
					$FichaAccionProducto->ProPrecio = $fila['ProPrecio']; 
					
					$FichaAccionProducto->RtiId = $fila['RtiId']; 
					$FichaAccionProducto->UmeIdOrigen = $fila['UmeIdOrigen']; 
					$FichaAccionProducto->UmeNombre = $fila['UmeNombre']; 
			
                    $FichaAccionProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaAccionProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		public function MtdObtenerFichaAccionProductosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'FapId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oFichaAccionMantenimiento=NULL,$oEstricto=1,$oAccion=NULL,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL) {


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
		
		if(!empty($oFichaAccion)){
			$faccion = ' AND fap.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fap.FapEstado = '.$oEstado.'';
		}		

		if(!empty($oFichaAccionMantenimiento)){
			$famantenimiento = ' AND fap.FaaId = "'.$oFichaAccionMantenimiento.'"';
		}	

		//if($oEstricto){
//			
//			$estricto = " AND fap.FaaId IS NULL ";
//			
//		}
		
		switch($oEstricto){
			
			case 1:
				$estricto = " AND fap.FaaId IS NULL ";
			break;
			
			case 2:
				$estricto = " AND fap.FaaId IS NOT NULL ";
			break;
			
			case 0:
			
			break;
			
		}
		
		if(!empty($oAccion)){
			$accion = ' AND fap.FapAccion = "'.$oAccion.'"';
		}	
		


		if(!empty($oFichaIngresoModalidadIngreso)){

			$elementos = explode(",",$oFichaIngresoModalidadIngreso);

			$i=1;
			$mingreso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$mingreso .= '  (fim.MinId = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$mingreso .= ' OR ';	
				}
			$i++;		
			}

			$mingreso .= ' ) 
			)
			';

		}
		
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'"';
		}		
		
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND pro.RtiId = "'.$oProductoTipo.'"';
		}		
		
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(fin.FinFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(fin.FinFecha) ="'.($oAno).'"';
		}
		
	 	 $sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			
			FROM tblfapfichaaccionproducto fap
			
				LEFT JOIN tblamdalmacenmovimientodetalle amd
				ON amd.FapId = fap.FapId
				
					LEFT JOIN tblfccfichaaccion fcc
					ON fap.FccId = fcc.FccId
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblfinfichaingreso fin
							ON fim.FinId = fin.FinId
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId
							
					LEFT JOIN tblproproducto pro
					ON fap.ProId = pro.ProId
						LEFT JOIN tblumeunidadmedida ume
						ON fap.UmeId = ume.UmeId				
					
			WHERE  1 = 1 '.$ano.$mes.$estricto.$faccion.$estado.$famantenimiento.$accion.$mingreso.$vmarca.$ptipo.$filtrar.$orden.$paginacion;	
		
	$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];			
		}
				
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaAccionProducto($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FapId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FapId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfapfichaaccionproducto 
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
	
	
	public function MtdRegistrarFichaAccionProducto() {
	
			$this->MtdGenerarFichaAccionProductoId();
			
			$sql = 'INSERT INTO tblfapfichaaccionproducto (
			FapId,
			FccId,	
			ProId,
			UmeId,
			
			FaaId,
			
			FapCantidad,
			FapCantidadReal,
			
			FapAccion,
			
			FapVerificar1,
			FapVerificar2,
			FapEstado,
			FapTiempoCreacion,
			FapTiempoModificacion) 
			VALUES (
			"'.($this->FapId).'", 
			"'.($this->FccId).'", 
			"'.($this->ProId).'", 
			'.(empty($this->UmeId)?'NULL, ':'"'.$this->UmeId.'",').'		
			
			'.(empty($this->FaaId)?'NULL, ':'"'.$this->FaaId.'",').'			
			
			'.($this->FapCantidad).',
			'.($this->FapCantidadReal).',
			
			"'.($this->FapAccion).'",
			
			'.($this->FapVerificar1).',
			1,
			'.($this->FapEstado).',
			"'.($this->FapTiempoCreacion).'",
			"'.($this->FapTiempoModificacion).'");';
		//'.($this->FapVerificar2).',
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
	
	//'.(empty($this->FaaId)?'FaaId = NULL, ':'FaaId = "'.$this->FaaId.'",').'	
	
	public function MtdEditarFichaAccionProducto() {

		$sql = 'UPDATE tblfapfichaaccionproducto SET 	
		ProId = "'.($this->ProId).'",
		'.(empty($this->UmeId)?'UmeId = NULL, ':'UmeId = "'.$this->UmeId.'",').'			

		FapCantidad = '.($this->FapCantidad).',
		FapCantidadReal = '.($this->FapCantidadReal).',
		
		FapAccion = "'.($this->FapAccion).'",
		
		FapVerificar1 = '.($this->FapVerificar1).'
		
		WHERE FapId = "'.($this->FapId).'";';
				//FapVerificar2 = '.($this->FapVerificar2).'
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
	
	
	
	
	
	/*
	EXCLUSIVO PARA TALLER
	*/
	
	public function MtdEditarFichaAccionProductoTaller() {

		$sql = 'UPDATE tblfapfichaaccionproducto SET 	
		ProId = "'.($this->ProId).'",
		'.(empty($this->UmeId)?'UmeId = NULL, ':'UmeId = "'.$this->UmeId.'",').'			
		FapCantidad = '.($this->FapCantidad).',
		FapCantidadReal = '.($this->FapCantidadReal).'
		WHERE FapId = "'.($this->FapId).'";';
				
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
	
	
	
	
	/*
	* EXCLUSIVO PARA CAMBIOS DE ESTADO
	*/
	public function MtdEditarFichaAccionProductoVerificar2() {

		$sql = 'UPDATE tblfapfichaaccionproducto SET 	
		FapVerificar2 = '.($this->FapVerificar2).'
		WHERE FapId = "'.($this->FapId).'";';
				
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
	
	public function MtdEditarFichaAccionProductoVerificar1() {

		$sql = 'UPDATE tblfapfichaaccionproducto SET 	
		FapVerificar1 = '.($this->FapVerificar1).'
		WHERE FapId = "'.($this->FapId).'";';
				
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