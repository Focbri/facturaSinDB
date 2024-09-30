<?php
require_once 'Cliente.php';
require_once 'Producto.php';
require_once 'Factura.php';
require_once 'SistemaFacturacion.php';

session_start();

if (!isset($_SESSION['sistema'])) {
    $_SESSION['sistema'] = new SistemaFacturacion();
}
$sistema = $_SESSION['sistema'];

// Agregar  cliente
if (isset($_POST['agregar_cliente'])) {
    $nombre = $_POST['nombre_cliente'];
    $dni = $_POST['dni_cliente'];
    $telefono = $_POST['telefono_cliente'];
    $nuevoCliente = new Cliente($nombre, $dni, $telefono);
    $sistema->agregarCliente($nuevoCliente);
}

// Agregar  producto
if (isset($_POST['agregar_producto'])) {
    $nombreProducto = $_POST['nombre_producto'];
    $cantidadProducto = $_POST['cantidad_producto'];
    $precioProducto = $_POST['precio_producto'];
    $nuevoProducto = new Producto($nombreProducto, $cantidadProducto, $precioProducto);
    $sistema->agregarProducto($nuevoProducto);
}

// Generar factura
if (isset($_POST['generar_factura'])) {
    $dniCliente = $_POST['dni_cliente_factura'];
    $productosSeleccionados = [];

    if (!empty($_POST['productos'])) {
        foreach ($_POST['productos'] as $producto) {
            $productosSeleccionados[] = [
                'nombre' => $producto,
                'cantidad' => $_POST['cantidad_' . $producto]
            ];
        }
    }

    $factura = $sistema->generarFactura($dniCliente, $productosSeleccionados);
    if ($factura) {
        $factura->mostrarFactura();
    } else {
        echo "Cliente no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Facturación</title>
</head>
<body>

    <h1>Sistema de Facturación</h1>

    <!-- Formulario --------->
    <h2>Agregar Cliente</h2>
    <form method="POST">
        Nombre: <input type="text" name="nombre_cliente" required><br>
        DNI: <input type="text" name="dni_cliente" required><br>
        Teléfono: <input type="text" name="telefono_cliente" required><br>
        <input type="submit" name="agregar_cliente" value="Agregar Cliente">
    </form>

    <!-- Formulario productos ---------->
    <h2>Agregar Producto</h2>
    <form method="POST">
        Nombre del Producto: <input type="text" name="nombre_producto" required><br>
        Cantidad: <input type="number" name="cantidad_producto" required><br>
        Precio: <input type="number" name="precio_producto" step="0.01" required><br>
        <input type="submit" name="agregar_producto" value="Agregar Producto">
    </form>

    <!-- Formulario factura -->
    <h2>Generar Factura</h2>
    <form method="POST">
        DNI del Cliente: <input type="text" name="dni_cliente_factura" required><br>
        
        <h3>Seleccionar productos:</h3>
        <?php
        $productos = $sistema->listarProductos();
        foreach ($productos as $producto) {
            echo '<input type="checkbox" name="productos[]" value="'.$producto->getNombre().'">'.$producto->getNombre().' ($'.$producto->getPrecio().')<br>';
            echo 'Cantidad: <input type="number" name="cantidad_'.$producto->getNombre().'" value="1" min="1"><br>';
        }
        ?>
        <input type="submit" name="generar_factura" value="Generar Factura">
    </form>

    <!-- Listado clientes -->
    <h2>Lista de Clientes</h2>
    <ul>
        <?php
        $clientes = $sistema->listarClientes();
        foreach ($clientes as $cliente) {
            echo "<li>".$cliente->getNombre()." (DNI: ".$cliente->getDni().", Teléfono: ".$cliente->getTelefono().")</li>";
        }
        ?>
    </ul>

    <!-- Listado productos -->
    <h2>Lista de Productos</h2>
    <ul>
        <?php
        foreach ($sistema->listarProductos() as $producto) {
            echo "<li>".$producto->getNombre()." (Precio: $".$producto->getPrecio().", Cantidad disponible: ".$producto->getCantidad().")</li>";
        }
        ?>
    </ul>

</body>
</html>
