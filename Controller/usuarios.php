<?php
require_once(__DIR__.'/../Framework/Controller.php');
require_once(__DIR__.'/../Framework/Auth.php');
require_once(__DIR__.'/../Framework/Constant.php');
require_once(__DIR__.'/../Entity/User.php');
require_once(__DIR__.'/../Entity/Anuncio.php');
require_once(__DIR__.'/../Entity/MLAccount.php');
require_once(__DIR__.'/../settings.php');
require_once(__DIR__.'/../Libs/MercadoLivre/meli.php');

class Usuarios extends Controller{
    function __construct(){
        parent::__construct();
        $a = new Anuncio();
        $this->Context['anuncios_pendentes_count'] = count($a->AnunciosPendentesByOwner($_SESSION[SESSION_USER]->id));
    }
    
    function Adicionar($id = null){
        $this->ViewFile = 'usuarios__manage';
        if (isset($_POST['submit'])){
            $errors = array();
            if (strlen($_POST['name']) == 0 || strlen($_POST['login']) == 0 || strlen($_POST['email']) == 0 || strlen($_POST['plainPassword']) == 0){
                $errors[] = 'Todos os campos são necessários';
            }
            $u = new User();
            if (isset($_POST['id'])){
                $u->id = $_POST['id'];
            }
            $u->login = $_POST['login'];
            $u->name = $_POST['name'];
            $u->email = $_POST['email'];
            $u->plainPassword = $_POST['plainPassword'];
            
            $result = 1;
            if (!isset($_POST['id'])){
                $result = $u->Register();
            }else{
                $result = $u->Save();    
            }
            $this->Context['user'] = $u;
            if (!is_array($result)){
                unset($u);
                $u = new User();
                $u->id = $result;
                $u->Load($result );
                
                $this->redirectTo('usuarios', 'adicionar', array($u->id));
            }else{
                $this->Context['errors'] = $result;
            }
            
            
            
        }
        
        if (isset($id)){
            $u = new User();
            $u->Load($id);
            $this->Context['user'] = $u;
        }
        $this->render();
    }
    
    function Editar($id){
        $this->ViewFile = 'usuarios__manage';
        $this->render();
    }
    
    function Remover(){
        $this->ViewFile = 'usuarios__remover';
        $this->render();
    }
    
    function Listar(){
        $this->ViewFile = 'usuarios__listar';
        $this->Context['users'] = User::All();
        $this->render();
    }
}