<?php
class Cliente {
    private $nombre;
    private $dni;
    private $telefono;

    public function __construct($nombre, $dni, $telefono) {
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->telefono = $telefono;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getTelefono() {
        return $this->telefono;
    }
}
?>
