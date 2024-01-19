<?php

//Incluir el modelo de pedidos
namespace Controllers;

use Repositories\PedidoRepository;
use Repositories\ProductoRepository;
use Services\ProductoService;
use Utils\Utils;
use Lib\Pages;
use Services\PedidoService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// definir clase controladora
class PedidoController {
    private Pages $pages;
    private PedidoService $pedidoService;
    private ProductoService $productoService; 

    public function __construct() {
        $this->pages = new Pages();
        $this->pedidoService = new PedidoService(new PedidoRepository());
        $this->productoService = new ProductoService(new ProductoRepository());
    }

    //Método para mostrar todos los pedidos
    public function mostrarPedido(){
        if(!isset($_SESSION['login'])){
            $this->pages->render('usuario/login' , ['errores' => 'No hay productos en el carrito']);
        }
        elseif(isset($_SESSION['login']) && count($_SESSION['carrito']) >= 1){
            $this->pages->render('pedido/crear');
        } elseif (isset($_SESSION['login']) && count($_SESSION['carrito']) == 0) {
            $this->pages->render('carrito/ver' , ['errores' => 'No hay productos en el carrito']);
        }
    }

    public function todosLosPedidos(){
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'usuario/login');
        }
        else {
            $usuario = $_SESSION['login'];
            if ($usuario->rol == 'admin') {
                $pedidos = $this->pedidoService->getAll();
                $this->pages->render('pedido/gestionarPedidos', ['pedidos' => $pedidos]);
            }
            else {
                header('Location: ' . BASE_URL . 'usuario/login');
            }
        }
    }

    public function misPedidos(){
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'usuario/login');
        }
        else {
            $usuario = $_SESSION['login'];
            $pedidos = $this->pedidoService->getByUsuario($usuario->id);
            $this->pages->render('pedido/misPedidos', ['pedidos' => $pedidos]);
        }
    }

    public function validarPedido($provincia, $localidad, $direccion) {
        $errores = [];
        if (empty($provincia) || strlen($provincia) < 2) {
            $errores['provincia'] = 'La provincia no puede estar vacía y debe tener al menos 2 caracteres';
        }
        if (empty($localidad) || strlen($localidad) < 2) {
            $errores['localidad'] = 'La localidad no puede estar vacía y debe tener al menos 2 caracteres';
        }
        if (empty($direccion) || strlen($direccion) < 5) {
            $errores['direccion'] = 'La dirección no puede estar vacía y debe tener al menos 5 caracteres';
        }
        return $errores;
    }

    public function crear () {

        if (!isset($_SESSION['login']) || $_SESSION['carrito'] == "") {
            header('Location: ' . BASE_URL . 'usuario/login');
        }

        else {
            //Obtener los datos del formulario
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
            $coste = isset($_POST['coste']) ? $_POST['coste'] : false;
            $estado = 'pendiente';
            $fecha = Utils::getFecha();
            $hora = Utils::getHora();

            //Validar los datos
            $errores = $this->validarPedido($provincia, $localidad, $direccion);

            if (!empty($errores)) {
                $this->pages->render('pedido/crear', ['errores' => $errores]);
            } else {
            
            //Obtener el usuario logueado
            $usuario = $_SESSION['login'];
            //Obtener el carrito del usuario
            $carrito = $_SESSION['carrito'];
            //Obtener el total del carrito
            $total = $this->pedidoService->getTotalCarrito($carrito);
            //Crear el pedido
            $pedido = $this->pedidoService->save($usuario->id, $provincia, $localidad, $direccion, $total, $estado, $fecha, $hora, $carrito);
            //Vaciar el carrito
            unset($_SESSION['carrito']);
            //Redirigir a la página de mis pedidos
            header('Location: ' . BASE_URL . 'pedido/misPedidos');
            
            }
        }
    }

    public function eliminar($id){
        $usuario = $_SESSION['login'];

        if ($usuario->rol == 'admin') {
            $this->pedidoService->delete($id);
            header('Location: ' . BASE_URL . 'pedido/todosLosPedidos');
        }
    }

    public function editar($id){
        $pedidos = $this->pedidoService->getAll();
        $this->pages->render('pedido/gestionarPedidos', ['pedidos' => $pedidos, 'id' => $id]);
    }

    public function validarPedidoActualizado($data) {
        $errores = [];
        // Validar coste
        if (empty($data['coste']) || !is_numeric($data['coste'])) {
            $errores['coste'] = 'El coste es requerido y debe ser un número';
        }

        // Validar estado
        $estadosPermitidos = ['pendiente', 'confirmado'];
        if (empty($data['estado']) || !in_array($data['estado'], $estadosPermitidos)) {
            $errores['estado'] = 'El estado es requerido y debe ser "pendiente" o "confirmado"';
        }

        // Validar fecha
        if (empty($data['fecha']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['fecha'])) {
            $errores['fecha'] = 'La fecha es requerida y debe estar en el formato YYYY-MM-DD';
        }

        // Validar hora
        if (empty($data['hora']) || !preg_match('/^\d{2}:\d{2}:\d{2}$/', $data['hora'])) {
            $errores['hora'] = 'La hora es requerida y debe estar en el formato HH:MM:SS';
        }

        return $errores;
    }

    public function actualizar(){
        $usuario = $_SESSION['login'];
        $pedido = $_POST['data'];
        $id = $pedido['id'];
        $coste = $pedido['coste'];
        $fecha = $pedido['fecha'];
        $hora = $pedido['hora'];
        $estado = $pedido['estado'];
        $usuario_id = $pedido['usuario_id'];
        
        if ($usuario->rol == 'admin') {
            $data = $_POST['data'];
            $errores = $this->validarPedidoActualizado($data);
    
            if (!empty($errores)) {
                // Hay errores, redirigir al formulario con los errores
                $pedidos = $this->pedidoService->getAll();
                $this->pages->render('pedido/gestionarPedidos', ['pedidos' => $pedidos ,'errores' => $errores]);
            } else {
                // No hay errores, actualizar el pedido en la base de datos
                $this->pedidoService->editar($id, $coste, $fecha, $hora, $estado, $usuario_id);
                $this->pages->render('pedido/gestionarPedidos');
            }
        }
    }

    public function confirmarPedido($id) {
        //Obtener el usuario logueado
        $usuario = $_SESSION['login'];

        //Si el usuario es admin, actualizar el estado del pedido
        if ($usuario->rol == 'admin') {
            $this->pedidoService->confirmarPedido($id);
            $this->enviarEmail($id);
        }

    }


        /**
     * Envia un correo electrónico al cliente.
     * @return void
     */
    public function enviarEmail($id) {
        /**
         * This example shows settings to use when sending via Google's Gmail servers.
         * This uses traditional id & password authentication - look at the gmail_xoauth.phps
         * example to see how to use XOAUTH2.
         * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
         */
    
        //Import PHPMailer classes into the global namespace
        //require '../vendor/autoload.php';
    
        //Create a new PHPMailer instance
        $mail = new PHPMailer();
    
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
    
        //Enable SMTP debugging
        //SMTP::DEBUG_OFF = off (for production use)
        //SMTP::DEBUG_CLIENT = client messages
        //SMTP::DEBUG_SERVER = client and server messages
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
        //if your network does not support SMTP over IPv6,
        //though this may cause issues with TLS
    
        //Set the SMTP port number:
        // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
        // - 587 for SMTP+STARTTLS
        $mail->Port = 465;
    
        //Set the encryption mechanism to use:
        // - SMTPS (implicit TLS on port 465) or
        // - STARTTLS (explicit TLS on port 587)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
    
        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = 'farmaciaphppablo@gmail.com';
    
        //Password to use for SMTP authentication
        $mail->Password = 'esgu meyv ppfa wutj';
    
        //Set who the message is to be sent from
        //Note that with gmail you can only use your account address (same as `Username`)
        //or predefined aliases that you have configured within your account.
        //Do not use user-submitted addresses in here
        $mail->setFrom('farmaciaphppablo@gmail.com', 'Tienda de Pablo López Lozano');
    
        //Set an alternative reply-to address
        //This is a good place to put user-submitted addresses
        $mail->addReplyTo('replyto@example.com', 'First Last');
    
        //Set who the message is to be sent to
        $mail->addAddress($_SESSION['login']->email, $_SESSION['login']->nombre);
        // $mail->addAddress('plopezlozano12@gmail.com', 'YOU');
    
        //Set the subject line
        $mail->Subject = 'Ya ha llegado su pedido';
    
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        // $mail->msgHTML(file_get_contents('Views/pedido/correo.php'), __DIR__);
        ob_start();
    
        // Define the variables
        $nombre = $_SESSION['login']->nombre;
        $idPedido = $id;
        // $productos = $this->pedidoService->getProductosPedido($id);
        $productos = $this->pedidoService->getProductosPedido($id);
        $fecha = Utils::getFecha();
        $hora = Utils::getHora();
        // Include the file and store the output in a variable
        include __DIR__ . '/../Views/pedido/correo.php';
        $html = ob_get_contents();
    
        // End output buffering
        ob_end_clean();
    
        // Use the output as the HTML body of the email
        $mail->msgHTML($html, __DIR__);
    
        //Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';
    
        //Attach an image file
        $mail->addAttachment('images/phpmailer_mini.png');
    
        //send the message, check for errors
        if (!$mail->send()) {
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            // header('Location: ' . BASE_URL . 'pedido/misPedidos');
            echo '<h1><a href="/Tienda-PHP">Volver</a></h1>';
            echo 'Message sent!';
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }
    
        //Section 2: IMAP
        //IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
        //Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
        //You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
        //be useful if you are trying to get this working on a non-Gmail IMAP server.
        function save_mail($mail)
        {
            //You can change 'Sent Mail' to any other folder or tag
            $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
    
            //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
            $imapStream = imap_open($path, $mail->Username, $mail->Password);
    
            $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
            imap_close($imapStream);
    
            return $result;
        }
        
        }


}
