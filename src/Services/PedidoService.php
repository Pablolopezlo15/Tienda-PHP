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

    public function delete($id) {
        return $this->pedidoRepository->delete($id);
    }

    public function editar($id, $fecha, $hora, $coste, $estado, $usuario_id) {
        return $this->pedidoRepository->editar($id, $fecha, $hora ,$coste, $estado, $usuario_id);
    }

    public function save($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito) {
        return $this->pedidoRepository->save($usuarioId, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito);
    }

    public function getProductosPedido($pedidoId) {
        return $this->pedidoRepository->getProductosPedido($pedidoId);
    }

    public function getTotalCarrito($carrito) {
        return $this->pedidoRepository->calcularTotal($carrito);
    }

    public function getCantidadProducto($pedidoId, $productoId) {
        return $this->pedidoRepository->getCantidadProducto($pedidoId, $productoId);
    }

    public function confirmarPedido($pedidoId) {
        $pedidoRepository = new PedidoRepository();
        return $pedidoRepository->confirmarPedido($pedidoId);
    }

}
