<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFacturaExportacionAlmacenMovimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFacturaExportacionAlmacenMovimiento {

    public $FeaId;
	public $FexId;
	public $FetId;

	public $AmoId;
	
	public $FeaEliminado;
	
	public $FetNumero;
	
	public $AmoFecha;
	public $AmoTotal;	

	public $FexTotal;
	public $FexTotalReal;
	public $FexAmortizado;
	public $FexSaldo;

	
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

	private function MtdGenerarFacturaExportacionAlmacenMovimientoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FeaId,5),unsigned)) AS "MAXIMO"
			FROM tblfeafacturaexportacionalmacenmovimiento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FeaId = "FEA-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FeaId = "FEA-".$fila['MAXIMO'];					
			}	
		}
		
    public function MtdObtenerFacturaExportacionAlmacenMovimiento(){

        $sql = 'SELECT 
        FeaId,
		FexId,
		FetId,
		AmoId
        FROM tblfeafacturaexportacionalmacenmovimiento
        WHERE FeaId = "'.$this->FeaId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->FeaId = $fila['FeaId'];
			$this->FexId = $fila['FexId'];
			$this->FetId = $fila['FetId'];
			$this->AmoId = $fila['AmoId'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerFacturaExportacionAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FeaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFacturaExportacion=NULL,$oFacturaExportacionTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL) {
		
		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}	
		
		if(!empty($oFacturaExportacion) and !empty($oFacturaExportacionTalonario)){
			$boleta = ' AND  fea.FexId = "'.$oFacturaExportacion.'" AND fea.FetId = "'.$oFacturaExportacionTalonario.'" ';
		}
		
		if(!empty($oAlmacenMovimiento)){
			$amovimiento = ' AND fea.AmoId = "'.$oAlmacenMovimiento.'" ';
		}

		if(!empty($oTipo)){
			switch($oTipo){
				case 1:
					$tipo = ' AND fea.AmoId IS NOT NULL';
					
					if($oAnulado){
						$anulado = ' AND amo.AmoEstado <> 1';
					}
				break;
				
				case 3:
					$tipo = ' AND fea.FexId IS NOT NULL AND fea.FetId IS NOT NULL';

					if($oAnulado){
						$anulado = ' AND fex.FexEstado <> 6';
					}
					
				break;
			}
		}
		
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fea.FeaId,
				
				fea.FexId,
				fea.FetId,
				fet.FetNumero,
				fex.FexTotal,

				fex.FexTotal AS "FexTotalReal",
				
				fea.AmoId,
				DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha"
				
				FROM tblfeafacturaexportacionalmacenmovimiento fea	
					LEFT JOIN tblfexfacturaexportacion fex
					ON (fea.FexId = fex.FexId AND fea.FetId = fex.FetId)
						LEFT JOIN tblfetfacturaexportaciontalonario fet
						ON fea.FetId = fet.FetId
							
								LEFT JOIN tblamoalmacenmovimiento amo
								ON (fea.AmoId = amo.AmoId)

				WHERE 1 = 1 '.$filtrar.$boleta.$amovimiento.$anulado.$tipo.$orden.$paginacion;
					
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFacturaExportacionAlmacenMovimiento = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$FacturaExportacionAlmacenMovimiento = new $InsFacturaExportacionAlmacenMovimiento();
				
					
                    $FacturaExportacionAlmacenMovimiento->FeaId = $fila['FeaId'];
					$FacturaExportacionAlmacenMovimiento->FexId = $fila['FexId'];
					$FacturaExportacionAlmacenMovimiento->FetId = $fila['FetId'];
					$FacturaExportacionAlmacenMovimiento->FetNumero = $fila['FetNumero'];
					$FacturaExportacionAlmacenMovimiento->FexTotal = $fila['FexTotal'];
					$FacturaExportacionAlmacenMovimiento->FexTotalReal = $fila['FexTotalReal'];
					$FacturaExportacionAlmacenMovimiento->AmoId = $fila['AmoId'];
					$FacturaExportacionAlmacenMovimiento->AmoFecha = $fila['NAmoFecha'];
										
                    $FacturaExportacionAlmacenMovimiento->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FacturaExportacionAlmacenMovimiento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	public function MtdEliminarFacturaExportacionAlmacenMovimiento($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (FeaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FeaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM  tblfeafacturaexportacionalmacenmovimiento WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarFacturaExportacionAlmacenMovimiento() {
	
			$this->MtdGenerarFacturaExportacionAlmacenMovimientoId();
		
			$sql = 'INSERT INTO tblfeafacturaexportacionalmacenmovimiento (
			FeaId,			
			AmoId,
			FexId,
			FetId
			) 
			VALUES (
			"'.($this->FeaId).'", 
			'.(empty($this->AmoId)?'NULL, ':'"'.$this->AmoId.'",').'
			"'.($this->FexId).'", 
			"'.($this->FetId).'");';

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