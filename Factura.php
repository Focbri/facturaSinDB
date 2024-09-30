<?php
class Factura {
    private $cliente;
    private $productos = [];

    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    public function agregarProducto(Producto $producto) {
        $this->productos[] = $producto;
    }

    public function calcularTotal() {
        $total = 0;
        foreach ($this->productos as $producto) {
            $total += $producto->calcularSubtotal();
        }
        return $total;
    }

    public function mostrarFactura() {
        echo "Factura para el cliente: " . $this->cliente->getNombre() . "<br>";
        echo "DNI: " . $this->cliente->getDni() . "<br>";
        echo "Teléfono: " . $this->cliente->getTelefono() . "<br>";
        echo "Productos comprados:<br>";
        foreach ($this->productos as $producto) {
            echo "- " . $producto->getNombre() . ": " . $producto->getCantidad() . " unidades x $" . $producto->getPrecio() . " = $" . $producto->calcularSubtotal() . "<br>";
        }
        echo "Total a pagar: $" . $this->calcularTotal() . "<br>";
    }
}
?>
