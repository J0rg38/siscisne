<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoTipoUnidadMedida
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoTipoUnidadMedida {

    public $PtuId;
	public $RtiId;
	public $UmeId;
	public $PtuTipo;	

	public $UmeNombre;
	public $UmeAbreviatura;
	
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

	public function MtdGenerarProductoTipoUnidadMedidaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PtuId,5),unsigned)) AS "MAXIMO"
		FROM tblptuproductotipounidadmedida';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->PtuId ="PTU-10000";
		}else{
			$fila['MAXIMO']++;
			$this->PtuId = "PTU-".$fila['MAXIMO'];					
		}		

	}

    public function MtdObtenerProductoTipoUnidadMedidas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PtuId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTipo=NULL,$oProductoTipo=NULL,$oUso=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
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
				
		if(!empty($oTipo)){
			$tipo = ' AND ptu.PtuTipo = '.$oTipo;
		}
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND ptu.RtiId = "'.$oProductoTipo.'"';
		}	

		if(!empty($oUso)){
			$uso = ' AND ume.UmeUso = '.$oUso;
		}



			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ptu.PtuId,
				ptu.RtiId,
				ptu.UmeId,
				ptu.PtuTipo,
				ume.UmeNombre,
				ume.UmeAbreviacion
				
				FROM tblptuproductotipounidadmedida ptu	
					LEFT JOIN tblumeunidadmedida ume
					ON ptu.UmeId = ume.UmeId
				WHERE 1 = 1 '.$filtrar.$tipo.$ptipo.$uso.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoTipoUnidadMedida = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ProductoTipoUnidadMedida = new $InsProductoTipoUnidadMedida();				
                    $ProductoTipoUnidadMedida->PtuId = $fila['PtuId'];
                    $ProductoTipoUnidadMedida->RtiId= $fila['RtiId'];
					$ProductoTipoUnidadMedida->UmeId= $fila['UmeId'];
					$ProductoTipoUnidadMedida->PtuTipo = $fila['PtuTipo'];
					
					$ProductoTipoUnidadMedida->UmeNombre = $fila['UmeNombre'];
					$ProductoTipoUnidadMedida->UmeAbreviacion = $fila['UmeAbreviacion'];

                    $ProductoTipoUnidadMedida->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ProductoTipoUnidadMedida;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	
	
	
	public function MtdRegistrarProductoTipoUnidadMedida() {
	
		$this->MtdGenerarProductoTipoUnidadMedidaId();
			
			$sql = 'INSERT INTO tblptuproductotipounidadmedida (
				PtuId,
				RtiId,
				UmeId,
				PtuTipo
				) 
				VALUES (
				"'.($this->PtuId).'", 
				"'.($this->RtiId).'", 
				"'.($this->UmeId).'", 
				'.($this->PtuTipo).');';	
				
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
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