<?php
namespace Services;
use Repositories\PedidoRepository;

class PedidoService {
    private $pedidoRepository;

    public function __construct(PedidoRepository $pedidoRepository) {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function getAll() {
        return $this->pedidoRepository->getAll();
    }

    public function getById($id) {
        return $this->pedidoRepository->getById($id);
    }

    public function getByUsuario($usuarioId) {
        return $this->pedidoRepository->getByUsuario($usuarioId);
    }

    public function save($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito) {
        return $this->pedidoRepository->save($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito);
    }

    public function getLineasPedido($pedidoId) {
        return $this->pedidoRepository->getLineasPedido($pedidoId);
    }

    // public function saveLinea($pedidoId, $productoId, $unidades) {
    //     return $this->pedidoRepository->saveLinea($pedidoId, $productoId, $unidades);
    // }

    public function getTotalCarrito($carrito) {
        return $this->pedidoRepository->calcularTotal($carrito);
    }

    public function confirmarPedido($id) {
        return $this->pedidoRepository->confirmarPedido($id);
    }

}
