<?php
class SistemaFacturacion {
    private $clientes = [];
    private $productos = [];

    // Agregar un cliente
    public function agregarCliente(Cliente $cliente) {
        $this->clientes[] = $cliente;
    }

    // Listar todos los clientes
    public function listarClientes() {
        return $this->clientes;
    }

    // Agregar un producto
    public function agregarProducto(Producto $producto) {
        $this->productos[] = $producto;
    }

    // Listar todos los productos
    public function listarProductos() {
        return $this->productos;
    }

    // Generar una factura
    public function generarFactura($dniCliente, $productosSeleccionados) {
        foreach ($this->clientes as $cliente) {
            if ($cliente->getDni() == $dniCliente) {
                $factura = new Factura($cliente);
                foreach ($productosSeleccionados as $productoSeleccionado) {
                    foreach ($this->productos as $producto) {
                        if ($producto->getNombre() == $productoSeleccionado['nombre']) {
                            $factura->agregarProducto(new Producto($producto->getNombre(), $productoSeleccionado['cantidad'], $producto->getPrecio()));
                        }
                    }
                }
                return $factura;
            }
        }
        return null;
    }
}
?>
