<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTipoCambio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTipoCambio {

    public $TcaId;
	public $MonId;
    public $TcaFecha;
	public $TcaMontoCompra;
	public $TcaMontoVenta;
	public $TcaMontoComercial;
	public $TcaTiempoCreacion;
	public $TcaTiempoModificacion;
	
    public $TcaEliminado;
	
	public $MonNombre;
	public $MonSimbolo;
	
    	public $InsMysql;
	
	// Propiedades adicionales para evitar warnings
	public $TcaUsuarioRegistro;
	public $TcaEstado;
	public $TcaEstadoDescripcion;
	public $TcaEstadoIcono;
	public $TcaFechaFormateada;
	public $TcaMontoCompraFormateado;
	public $TcaMontoVentaFormateado;
	public $TcaMontoComercialFormateado;
	public $TcaTiempoCreacionFormateado;
	public $TcaTiempoModificacionFormateado;

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

	public function MtdGenerarTipoCambioId() {


			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TcaId,5),unsigned)) AS "MAXIMO"
			FROM tbltcatipocambio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TcaId = "TCA-10000";

			}else{
				$fila['MAXIMO']++;
				$this->TcaId = "TCA-".$fila['MAXIMO'];					
			}	
			
			
					
		}
		
    public function MtdObtenerTipoCambio(){

        $sql = 'SELECT 
        TcaId,
		MonId,        
		DATE_FORMAT(TcaFecha, "%d/%m/%Y") AS "NTcaFecha",
		TcaMontoCompra,
		TcaMontoVenta,
		TcaMontoComercial,	
		TcaTiempoCreacion,
		TcaTiempoModificacion,
		
		TcaUsuarioRegistro
		
        FROM tbltcatipocambio
        WHERE TcaId = "'.$this->TcaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TcaId = $fila['TcaId'];
			$this->MonId = $fila['MonId'];	
            $this->TcaFecha = $fila['NTcaFecha'];			
			$this->TcaMontoCompra = $fila['TcaMontoCompra'];	
			$this->TcaMontoVenta = $fila['TcaMontoVenta'];	
			$this->TcaMontoComercial = $fila['TcaMontoComercial'];	
			$this->TcaTiempoCreacion = $fila['TcaTiempoCreacion'];
			$this->TcaTiempoModificacion = $fila['TcaTiempoModificacion'];
			$this->TcaUsuarioRegistro = $fila['TcaUsuarioRegistro'];
			
			
			
			
		}	
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		        
		return $Respuesta;
    }


	public function ObtenerTipoCambioInternet(){
		 
		 $Respuesta = false;
		 
		 switch ($this->MonId){
			 
			 case 'MON-10001':
			 
			 	$url = file_get_contents("http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias","r");
				
				if($url){
					
					$texto = '';
					
					$texto = $url;
						
					//while(!feof($url)){
//						$texto.=fgets($url,512);
//					}
				
					//deb($texto);
				
					$ntexto = preg_replace('/([a-zA-Z-]+=(\'|\")?[0-9a-zA-Z%-\/;_.#]*(\'|\")?)/',"",$texto);
					//Borramos espacios en blanco y saltos de linea	del HTML	
					$ntexto = preg_replace('/\t\t+/', '', $ntexto);
					$ntexto = preg_replace('/\s+/', '', $ntexto);
					$ntexto = preg_replace('/\n\n+/', '', $ntexto);
					
					//deb($ntexto);
					
					//Capturamos el dia actual	 
					if(!empty($this->TcaFecha)){
						list($ano,$mes,$dia) = explode("-",$this->TcaFecha);
						$dia = $dia +1 -1;
					}else{
						$dia = date("j");	
					}
					
					//Ubicamos el dia el HTML 
					$udia =  strpos($ntexto,"<strong>".$dia."</strong>");	
					//cortamos apartir de la cadena buscada anteriormente
					
					echo "<h1>";
					echo "a: ".$dia." - ".$udia;
					echo "</h1>";
					
					$ntexto = substr($ntexto,$udia);
					
					$ntexto = preg_replace(array('/<(\/|)?strong>(<\/td>|)?/','/<\/td>/'),"",$ntexto);
					$ntexto = preg_replace("/<td>/",":::",$ntexto);
					
					$Tcambio = preg_split('/:::/',$ntexto);
					
					for($f=3;$f<count($Tcambio);$f++){
						$Tcambio[$f]=NULL;
					}
					
					$Tcambio = array_filter($Tcambio);
						$Tcambio[2] = strip_tags($Tcambio[2]);
					}
					
					if(!empty($Tcambio[1]) and !empty($Tcambio[2])){
						
						
						echo "Tipo de cambio VENTA: ".$Tcambio[1];
						echo "<br>";
						echo "Tipo de cambio COMPRA: ".$Tcambio[2];
						echo "<br>";
						
						$InsTipoCambio1 = new ClsTipoCambio();
						$InsTipoCambio1->MonId = $this->MonId;
						$InsTipoCambio1->TcaFecha = ($this->TcaFecha);
						$InsTipoCambio1->MtdObtenerTipoCambioFecha();
						
						if(empty($InsTipoCambio1->TcaId)){
							
							$this->TcaMontoCompra = $Tcambio[1];
							$this->TcaMontoVenta = $Tcambio[2];
							//$this->TcaMontoComercial = 3.6;// round($Tcambio[2],1);
							$this->TcaMontoComercial = $Tcambio[2];
			
							$this->TcaTiempoCreacion = date("Y-m-d H:i:s");
							$this->TcaTiempoModificacion = date("Y-m-d H:i:s");		
							
							if($this->MtdRegistrarTipoCambio()){
								
								
								
								echo "Se registro correctamente el TC";
									echo "<br>";
									
								$Respuesta = true;	
							}else{
									echo "No se pudo registar el TC";
									echo "<br>";
							}
							
						}else{
							
							
							$this->TcaId = $InsTipoCambio1->TcaId;
							
							$this->TcaMontoCompra = $Tcambio[1];
							$this->TcaMontoVenta = $Tcambio[2];
							$this->TcaMontoComercial = $Tcambio[2];
			
							$this->TcaTiempoCreacion = date("Y-m-d H:i:s");
							$this->TcaTiempoModificacion = date("Y-m-d H:i:s");		
							
							if($this->MtdEditarTipoCambio()){
								
								
								
								$this->MtdEditarTipoCambioComercial();
								
								echo "Se edito correctamente el TC";
								echo "<br>";
								$Respuesta = true;	
							}else{
								echo "No se pudo editar el TC";
								echo "<br>";
							}
							
						}
						
					}else{
						echo "No se pudo obtener TC";
						echo "<br>";
					}
					
				
				
				//$Respuesta = false;	
				
			 break;
			 
		 }

		return $Respuesta;
		
	}
	public function MtdObtenerTipoCambioUltimo(){

        $sql = 'SELECT 
        tca.TcaId,
		tca.MonId,        
		DATE_FORMAT(tca.TcaFecha, "%d/%m/%Y") AS "NTcaFecha",
		tca.TcaMontoCompra,
		tca.TcaMontoVenta,
		tca.TcaMontoComercial,
		tca.TcaUsuarioRegistro,
		
		mon.MonNombre,
		mon.MonSimbolo
        FROM tbltcatipocambio tca
		
			LEFT JOIN tblmonmoneda mon
			ON tca.MonId = mon.MonId
		
        WHERE tca.MonId = "'.$this->MonId.'"
		ORDER BY tca.TcaTiempoCreacion DESC LIMIT 1;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TcaId = $fila['TcaId'];
			$this->MonId = $fila['MonId'];	
            $this->TcaFecha = $fila['NTcaFecha'];			
			$this->TcaMontoCompra = $fila['TcaMontoCompra'];	
			$this->TcaMontoVenta = $fila['TcaMontoVenta'];
			$this->TcaMontoComercial = $fila['TcaMontoComercial'];
			$this->TcaUsuarioRegistro = $fila['TcaUsuarioRegistro'];
			
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
				
			
		}	
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		        
		return $Respuesta;
    }
	
	
	public function MtdObtenerTipoCambioActual(){

        $sql = 'SELECT 
        tca.TcaId,
		tca.MonId,        
		DATE_FORMAT(tca.TcaFecha, "%d/%m/%Y") AS "NTcaFecha",
		tca.TcaMontoCompra,
		tca.TcaMontoVenta,
		tca.TcaMontoComercial,
		tca.TcaUsuarioRegistro,
		
		mon.MonNombre,
		mon.MonSimbolo
        FROM tbltcatipocambio tca
			LEFT JOIN tblmonmoneda mon
			ON tca.MonId = mon.MonId
		
        WHERE tca.MonId = "'.$this->MonId.'"
		AND tca.TcaFecha = DATE(NOW())';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TcaId = $fila['TcaId'];
			$this->MonId = $fila['MonId'];	
            $this->TcaFecha = $fila['NTcaFecha'];			
			$this->TcaMontoCompra = $fila['TcaMontoCompra'];	
			$this->TcaMontoVenta = $fila['TcaMontoVenta'];
			$this->TcaMontoComercial = $fila['TcaMontoComercial'];
			$this->TcaUsuarioRegistro = $fila['TcaUsuarioRegistro'];
			
			
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
				
			
		}	
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		        
		return $Respuesta;
    }
	
	
		public function MtdObtenerTipoCambioFecha(){

        $sql = 'SELECT 
        tca.TcaId,
		tca.MonId,        
		DATE_FORMAT(tca.TcaFecha, "%d/%m/%Y") AS "NTcaFecha",
		tca.TcaMontoCompra,
		tca.TcaMontoVenta,
		tca.TcaMontoComercial,
		tca.TcaUsuarioRegistro,
		
		mon.MonNombre,
		mon.MonSimbolo
        FROM tbltcatipocambio tca
		
		LEFT JOIN tblmonmoneda mon
		ON tca.MonId = mon.MonId
		
        WHERE tca.MonId = "'.$this->MonId.'"
		 AND tca.TcaFecha = "'.$this->TcaFecha.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TcaId = $fila['TcaId'];
			$this->MonId = $fila['MonId'];	
            $this->TcaFecha = $fila['NTcaFecha'];			
			$this->TcaMontoCompra = $fila['TcaMontoCompra'];	
			$this->TcaMontoVenta = $fila['TcaMontoVenta'];
			$this->TcaMontoComercial = $fila['TcaMontoComercial'];
			$this->TcaUsuarioRegistro = $fila['TcaUsuarioRegistro'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
				
			
		}	
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		        
		return $Respuesta;
    }
	
	
    public function MtdObtenerTipoCambios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TcaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oMoneda = NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$moneda = '';
		$fecha = '';

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
		
		if(!empty($oMoneda)){
			$moneda = ' AND tca.MonId = "'.$oMoneda.'"';
		}

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tca.TcaFecha)>="'.$oFechaInicio.'" AND DATE(tca.TcaFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(tca.TcaFecha)>="'.$oFechaInicio.'"';
			}

		}else{
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tca.TcaFecha)<="'.$oFechaFin.'"';		
			}	
					
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				tca.TcaId,
				tca.MonId,
				DATE_FORMAT(tca.TcaFecha, "%d/%m/%Y") AS "NTcaFecha",
				tca.TcaMontoCompra,
				tca.TcaMontoVenta,
				tca.TcaMontoComercial,
				DATE_FORMAT(tca.TcaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTcaTiempoCreacion",
        		DATE_FORMAT(tca.TcaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTcaTiempoModificacion",
				tca.TcaUsuarioRegistro,
				
				mon.MonNombre,
				mon.MonSimbolo
				FROM tbltcatipocambio tca
				LEFT JOIN tblmonmoneda mon
				ON tca.MonId = mon.MonId 
				WHERE 1 = 1 '.$filtrar.$moneda.$fecha.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTipoCambio = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$TipoCambio = new $InsTipoCambio();
                    $TipoCambio->TcaId = $fila['TcaId'];
					$TipoCambio->MonId= $fila['MonId'];			
                    $TipoCambio->TcaFecha= $fila['NTcaFecha'];
					$TipoCambio->TcaMontoCompra= $fila['TcaMontoCompra'];			
					$TipoCambio->TcaMontoVenta= $fila['TcaMontoVenta'];		
					$TipoCambio->TcaMontoComercial= $fila['TcaMontoComercial'];		
					
					
					$TipoCambio->TcaTiempoCreacion= $fila['NTcaTiempoCreacion'];	
					$TipoCambio->TcaTiempoModificacion= $fila['NTcaTiempoModificacion'];	
					
					$TipoCambio->TcaUsuarioRegistro= $fila['TcaUsuarioRegistro'];	
					
					
					$TipoCambio->MonNombre= $fila['MonNombre'];		
					$TipoCambio->MonSimbolo= $fila['MonSimbolo'];		
						
                    $TipoCambio->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TipoCambio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	
	public function MtdEliminarTipoCambio($oElementos) {
		
		// Inicializar variable para evitar warnings
		$eliminar = '';
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' TcaId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (TcaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (TcaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
		
			$sql = 'DELETE FROM tbltcatipocambio WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarTipoCambio() {
	
	
			$this->MtdGenerarTipoCambioId();
		
			$sql = 'INSERT INTO tbltcatipocambio (
			TcaId,
			MonId,
			TcaFecha,
			TcaMontoCompra,
			TcaMontoVenta,
			TcaUsuarioRegistro,
			
			
			TcaMontoComercial,
			TcaTiempoCreacion,
			TcaTiempoModificacion
			) 
			VALUES (
			"'.($this->TcaId).'", 
			"'.($this->MonId).'",
			"'.($this->TcaFecha).'",
			'.($this->TcaMontoCompra).',	
			'.($this->TcaMontoVenta).',	
			"'.($this->TcaUsuarioRegistro).'",
			
			

			'.(empty($this->TcaMontoComercial)?'NULL, ':''.$this->TcaMontoComercial.',').'

			"'.($this->TcaTiempoCreacion).'",									
			"'.($this->TcaTiempoModificacion).'");';					

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
	
	public function MtdEditarTipoCambio() {
		
			$sql = 'UPDATE tbltcatipocambio SET 
			
			 TcaFecha = "'.($this->TcaFecha).'",
			 TcaMontoCompra = '.($this->TcaMontoCompra).',
			 TcaMontoVenta = '.($this->TcaMontoVenta).',	
			 '.(empty($this->TcaMontoComercial)?'TcaMontoComercial = NULL, ':'TcaMontoComercial = '.$this->TcaMontoComercial.',').'
			 
		
			 TcaTiempoModificacion = "'.($this->TcaTiempoModificacion).'"	 	 
			 WHERE TcaId = "'.($this->TcaId).'";';
			
		
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
		
	
		public function MtdEditarTipoCambioComercial() {
		
			$sql = 'UPDATE tbltcatipocambio SET 
			
			 '.(empty($this->TcaMontoComercial)?'TcaMontoComercial = NULL, ':'TcaMontoComercial = '.$this->TcaMontoComercial.',').'
			 
			 TcaTiempoModificacion = "'.($this->TcaTiempoModificacion).'"	 	 
			 WHERE TcaId = "'.($this->TcaId).'";';
			
		
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
		
	
	
	  public function MtdObtenerTipoCambioPromedioMensual($oAno,$oMes,$oMoneda){
		
		$Respuesta = 1;
		
        $sql = 'SELECT 
       
		AVG(TcaMontoVenta) AS TcaPromedioTipoCambio
		
        FROM tbltcatipocambio
        WHERE YEAR(TcaFecha) = "'.$oAno.'" 
		AND MONTH(TcaFecha) = "'.$oMes.'" 
		AND MonId = "'.$oMoneda.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			$Respuesta = $fila['TcaPromedioTipoCambio'];
	
		}
		        
		return $Respuesta;
    }
	
	
}
?>