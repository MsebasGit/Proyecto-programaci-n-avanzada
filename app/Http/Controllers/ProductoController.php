<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = [
            ['nombre' => 'Orange Pi 5 Pro', 'precio' => 4000.00, 'categoria' => 'Tecnología'],
            ['nombre' => 'Raspberry Pi 5 8GB RAM', 'precio' => 3100.00, 'categoria' => 'Tecnología'],
            ['nombre' => 'Milk-V Jupiter', 'precio' => 950.00, 'categoria' => 'Accesorios'],
            ['nombre' => 'NanoPi R3s', 'precio' => 690.00, 'categoria' => 'Accesorios'],
            ['nombre' => 'Modulo 4G LTE MiniPCIe', 'precio' => 260.00, 'categoria' => 'Tecnología'],
        ];

        $precios = array_column($productos, 'precio');
        $precioPromedio = round(array_sum($precios) / count($productos), 2);

        return view('productos', compact('productos', 'precioPromedio'));
    }
}
