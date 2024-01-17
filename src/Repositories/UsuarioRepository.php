<?php
namespace Repositories;
use Lib\BaseDatos;
use PDO;


class UsuarioRepository {
    private BaseDatos $db;

    public function __construct() {
        $this->db = new BaseDatos();
            
    }

    public function create($usuario): bool{
        $id = $usuario->getId();
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $rol = 'user';

        // $id = NULL;
        // $nombre=$this->getNombre();
        // $apellidos=$this->getApellidos();
        // $email = $this->getEmail();
        // $password = $this->getPassword();
        // $rol = 'user';

        try {
            $ins = $this->db->prepara("INSERT INTO usuarios (id, nombre, apellidos, email, password, rol) values (:id, :nombre, :apellidos, :email, :password, :rol)");

            $ins->bindValue(':id', $id);
            $ins->bindValue(':nombre', $nombre);
            $ins->bindValue(':apellidos', $apellidos);
            $ins->bindValue(':email', $email);
            $ins->bindValue(':password', $password);
            $ins->bindValue(':rol', $rol);

            $ins->execute();

            $result = true;
        } catch (PDOException $error){
            $result = false;
        }

        $ins->closeCursor();
        $ins=null;

        return $result;
    }

    public function login($usuario){
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();

        try {
            $datosUsuario = $this->buscaMail($email);

            if ($datosUsuario !== false){
                $verify = password_verify($password, $datosUsuario->password);

                if ($verify){
                    $result = $datosUsuario;
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }
        } catch (PDOException $error){
            $result = false;
        }

        return $result;
    }

    public function buscaMail($email){
        $select = $this->db->prepara("SELECT * FROM usuarios WHERE email=:email");
        $select->bindValue(':email', $email, PDO::PARAM_STR);

        try {
            $select->execute();
            if ($select && $select->rowCount() == 1){
                $result = $select->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $err){
            $result = false;
        }
        return $result;
    }

}