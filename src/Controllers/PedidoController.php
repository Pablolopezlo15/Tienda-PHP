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
        if(isset($_SESSION['login']) && count($_SESSION['carrito']) >= 1){
            $this->pages->render('pedido/crear');
        } else {
            var_dump('No estás logueado o no tienes productos en el carrito');
        }
    }

    public function misPedidos(){
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'usuario/login');
        }
        else {
            //Obtener el usuario logueado
            $usuario = $_SESSION['login'];
            //Obtener los pedidos del usuario
            $pedidos = $this->pedidoService->getByUsuario($usuario->id);
            //Mostrar la vista de mis pedidos
            $this->pages->render('pedido/misPedidos', ['pedidos' => $pedidos]);
        }
    }

    //Método para agregar un pedido a la base de datos
    public function crear () {
        //Si el usuario no está logueado, redirigir a la página de login
        if (!isset($_SESSION['login']) || $_SESSION['carrito'] == "") {
            header('Location: ' . BASE_URL . 'usuario/login');
        }
        //Si el usuario está logueado, crear el pedido
        else {
            //Obtener los datos del formulario
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
            $coste = isset($_POST['coste']) ? $_POST['coste'] : false;
            $estado = 'pendiente';
            $fecha = Utils::getFecha();
            $hora = Utils::getHora();

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

    public function confirmarPedido($id) {
        //Obtener el usuario logueado
        $usuario = $_SESSION['login'];

        //Si el usuario es admin, actualizar el estado del pedido
        if ($usuario->rol == 'admin') {
            $this->pedidoService->confirmarPedido($id);
            $this->enviarEmail($id);
        }
        //Redirigir a la página de mis pedidos
        header('Location: ' . BASE_URL . 'pedido/misPedidos');
        
    }

    public function getProductos($idPedido) {
        $lineasPedido = $this->pedidoService->getLineasPedido($idPedido);
        $productos = [];
    
        foreach ($lineasPedido as $linea) {
            $productoId = $linea['producto_id']; 
            $producto = $this->productoService->getById($productoId);
            $productos[] = $producto;
        }
    
        return $productos;
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
        $mail->setFrom('farmaciaphppablo@gmail.com', 'Farmacia de Pablo López Lozano');
    
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
        $productos = $this->getProductos($idPedido);
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
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $this->pages->render('pedido/misPedidos');
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
    
        header('Location: ' . BASE_URL . 'pedido/misPedidos');
    
        }


}
