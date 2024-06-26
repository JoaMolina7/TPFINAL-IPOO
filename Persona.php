<?php
class Persona {
	private $id;
    private $nrodoc;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $mensajeoperacion;
    public function __construct(){
		
		$this->nrodoc = 0;
		$this->pnombre = "";
		$this->papellido = "";
		$this->ptelefono = "";
		$this->id = "";
	}

	public function cargar($id,$NroD,$Nom,$Ape,$ptelefono){		
		$this->setNrodoc($NroD);
		$this->setPNombre($Nom);
		$this->setPApellido($Ape);
		$this->setPTelefono($ptelefono);
		$this->setId($id);
    }

    // Getters y setters

	public function getId() {
		return $this->id;
	}
    public function getNrodoc() { 
        return $this->nrodoc; 
    }
    public function getPNombre() { 
        return $this->pnombre; 
    }
    public function getPApellido() { 
        return $this->papellido; 
    }
    public function getPTelefono() { 
        return $this->ptelefono; 
    }
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setNrodoc($nrodoc) { 
        $this->nrodoc = $nrodoc; 
    }
    public function setPNombre($pnombre) { 
        $this->pnombre = $pnombre; 
    }
    public function setpapellido($papellido) { 
        $this->papellido = $papellido; 
    }
    public function setPTelefono($ptelefono) { 
        $this->ptelefono = $ptelefono; 
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
    /**
	 * Recupera los datos de una persona por id
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($id){
		$base=new BaseDatos();
		$consultaPersona = "SELECT * FROM persona WHERE id='$id'";
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){
				    $this->setId($id);			
				    $this->setNrodoc($row2['nrodoc']);
					$this->setPNombre($row2['pnombre']);
					$this->setPApellido($row2['papellido']);
					$this->setPTelefono($row2['ptelefono']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}
    public  function listar($condicion=""){
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from persona ";
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by papellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){				
				$arregloPersona= array();
				while($row2=$base->Registro()){

					$id=$row2['id'];
					$NroDoc=$row2['nrodoc'];
					$pnombre=$row2['pnombre'];
					$papellido=$row2['papellido'];
					$ptelefono=$row2['ptelefono'];
				
					$perso=new Persona();
					$perso->cargar($id,$NroDoc,$pnombre,$papellido,$ptelefono);
					array_push($arregloPersona,$perso);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloPersona;
	}		
	public function insertar() {
		$base = new BaseDatos();
		$resp = false;
		$consultaInsertar = "INSERT INTO persona(nrodoc, papellido, pnombre, ptelefono) 
							 VALUES ('" . $this->getNrodoc() . "','" . $this->getPApellido() . "','" . $this->getPNombre() . "','" . $this->getPTelefono() . "')";
	
		if ($base->Iniciar()) {
			if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
				$this->setId($id);
				$resp = true;
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
		
		return $resp;
	}
	
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consulta = "SELECT * FROM persona WHERE id=".$this->getId();
		$found = false;
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consulta)) {
				$row2 = $base->Registro();
				if ($row2['id'] == $this->getId()) {
					$found = true;
				}
			}
		}
		if ($found) {

		$nombre = $this->getPNombre();
		$apellido = $this->getPApellido();
		$telefono = $this->getPTelefono();
		$nrodoc = $this->getNrodoc();
		$id = $this->getId();

		$consultaModifica = "UPDATE persona SET pnombre='$nombre', papellido='$apellido', ptelefono='$telefono', nrodoc='$nrodoc' WHERE id=$id";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		}

		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		$consulta = "SELECT * FROM persona WHERE id=".$this->getId();
		$found = false; 
		if ($base->iniciar()) {
			if ($base->ejecutar($consulta)) {
				$row2 = $base->Registro();
				if ($row2['id'] == $this->getId()) {
					$found = true;
				}
			}
		}
		if ($found) {
			if($base->Iniciar()){
				$consultaBorra="DELETE FROM persona WHERE id=".$this->getId();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		}
		return $resp; 
	}
    public function __toString(){
	    return 
		"\nId: ".$this->getId().
		"\nNombre: ".$this->getPNombre(). 
		"\nApellido: ". $this->getPApellido(). 
		"\nDNI: ".$this->getNrodoc()."\n";
	}
}
