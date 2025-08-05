<?php
class ClsPoo  {

	public $Ruta;
	
	private $PaqAlmacen;
	private $PaqContabilidad;
	private $PaqRRHH;
	private $PaqAcceso;
	private $PaqReporte;
	private $PaqEmpresa;
	private $PaqConfiguracion;
	private $PaqActividad;
	private $PaqLogistica;
	private $PaqVentas;
	private $PaqTaller;

	function __construct(){
		
		$this->PaqAlmacen  = 'paquetes/PaqAlmacen/Clases/';		
		$this->PaqContabilidad  = 'paquetes/PaqContabilidad/Clases/';	
		$this->PaqRRHH  = 'paquetes/PaqRRHH/Clases/';	
		$this->PaqAcceso  = 'paquetes/PaqAcceso/Clases/';		
		$this->PaqReporte = 'paquetes/PaqReporte/Clases/';
		$this->PaqEmpresa = 'paquetes/PaqEmpresa/Clases/';
		$this->PaqConfiguracion = 'paquetes/PaqConfiguracion/Clases/';
		$this->PaqActividad = 'paquetes/PaqActividad/Clases/';
		$this->PaqActividadConf = 'paquetes/PaqActividad/Configuraciones/';
		$this->PaqLogistica = 'paquetes/PaqLogistica/Clases/';
		$this->PaqExterno = 'paquetes/PaqExterno/Clases/';
		
		$this->PaqVentas = 'paquetes/PaqVentas/Clases/';
		$this->PaqTaller = 'paquetes/PaqTaller/Clases/';
		$this->PaqAdministracion = 'paquetes/PaqAdministracion/Clases/';
		
		
	}
	
	public function MtdBorrarRuta(){
		$this->Ruta = '';
	}
	
	public function MtdPaqAlmacen(){
		
		//echo $this->Ruta.$this->PaqAlmacen;
		//echo "<br>";
		
		return $this->Ruta.$this->PaqAlmacen;
	}
	
	public function MtdPaqContabilidad(){
		return $this->Ruta.$this->PaqContabilidad;
	}
	
	public function MtdPaqRRHH(){
		return $this->Ruta.$this->PaqRRHH;
	}
		
	public function MtdPaqAcceso(){	
		return $this->Ruta.$this->PaqAcceso;
	}

	public function MtdPaqReporte(){	
		return $this->Ruta.$this->PaqReporte;
	}
	
	public function MtdPaqEmpresa(){	
		return $this->Ruta.$this->PaqEmpresa;
	}
	
	public function MtdPaqConfiguracion(){	
		return $this->Ruta.$this->PaqConfiguracion;
	}
	
	public function MtdPaqActividad(){	
		return $this->Ruta.$this->PaqActividad;
	}
	
	public function MtdPaqActividadConf(){	
		return $this->Ruta.$this->PaqActividadConf;
	}
	
	public function MtdPaqLogistica(){	
		return $this->Ruta.$this->PaqLogistica;
	}
	
	public function MtdPaqExterno(){	
		return $this->Ruta.$this->PaqExterno;
	}
	
	public function MtdPaqVentas(){	
		return $this->Ruta.$this->PaqVentas;
	}
	
	
	public function MtdPaqTaller(){	
		return $this->Ruta.$this->PaqTaller;
	}
	
	public function MtdPaqAdministracion(){	
		return $this->Ruta.$this->PaqAdministracion;
	}

}
$InsPoo = new ClsPoo();
?>