<?php
class Producto {
    private $nombre;
    private $cantidad;
    private $precio;

    public function __construct($nombre, $cantidad, $precio) {
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function calcularSubtotal() {
        return $this->cantidad * $this->precio;
    }
}
?>
