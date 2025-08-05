<?php
/*
Demo Websocket: Server Code
---------------------------
    @Author: ANHVNSE02067
    @Website: www.nhatanh.net
    @Email: anhvnse@gmail.com
 */
require "PHP-Websockets/websockets.php";

class Server extends WebSocketServer
{
    private $_connecting = 'Connecting to server..';
    private $_welcome = 'Hello, welcome to echo server!';

    protected function connected($user)
    {
        // Send welcome message to user
        $this->send($user, $this->_welcome);
    }    

    protected function process($user, $message)
    {
		//
//		$link = mysql_connect("localhost:3306", "admsistema", "fabrica");
//		mysql_select_db("test", $link);
//		
//		$query = "INSERT INTO prueba(mensaje) VALUES ('".$message."');";
//		mysql_query($query,$link);
		
        // Upper case user message and send back to user
        $response = 'Upper case -> ' . strtoupper($message);
		
        $this->send($user, $response);
		
		
		
    }

    protected function closed($user)
    {
        // Alert on server
        echo "User $user->id  closed connection".PHP_EOL;
    }

    public function __destruct()
    {
        echo "Server destroyed!".PHP_EOL;
    }
}


//$addr = '192.168.10.2';
$addr = '192.168.1.11';
$port = '9001';

$server = new Server($addr, $port);
$server->run();
