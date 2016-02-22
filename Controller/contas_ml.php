<?php
require_once(__DIR__.'/../Framework/Controller.php');
require_once(__DIR__.'/../Framework/Auth.php');
require_once(__DIR__.'/../Framework/Constant.php');
require_once(__DIR__.'/../Entity/User.php');
require_once(__DIR__.'/../Entity/Anuncio.php');
require_once(__DIR__.'/../Entity/MLAccount.php');
require_once(__DIR__.'/../settings.php');
require_once(__DIR__.'/../Libs/MercadoLivre/meli.php');

class Contas_ML extends Controller{
    
    function __construct(){
        parent::__construct();
        $this->ViewFile = 'contas_ml__add_ml';
        $this->meli = new Meli(ML_APP_ID, ML_APP_SECRET_KEY);
        $this->Context['url_meli'] = $this->meli->getAuthUrl(MELI_REDIRECT);
        $this->Context['curr_page'] = 'contas_ml';
        $this->refreshAccounts();
        $a = new Anuncio();
        $this->Context['anuncios_pendentes_count'] = count($a->AnunciosPendentesByOwner($_SESSION[SESSION_USER]->id));
    }
    
    private function refreshAccounts(){
        $this->Context['accounts'] = MLAccount::AccountsByOwner($_SESSION[SESSION_USER]->id);
    }
    
    function Add(){
        
        $this->render();
    }
    
    function Remove($id){
        $acc = new MLAccount();
        $acc->id = $id;
        $acc->owner = $_SESSION[SESSION_USER]->id;
        if (is_array($acc->RemoveAccount($id))){
            $this->Context['alerts'] = ['danger' => 'Erro ao processar'];
        }else{
            $this->Context['alerts'] = ['success' => 'Conta removida.'];
        }
        $this->refreshAccounts();
        $this->render();
        
    }
    
    function Callback(){
        $user = $this->meli->authorize($_GET['code'], MELI_REDIRECT);
        if ($user['httpCode'] == 200){
            $acc = $user['body'];
            $accML = new MLAccount();
            $accML->userid = $acc->user_id;
            $accML->access_token = $acc->access_token;
            $accML->expires = $acc->expires_in;
            $accML->refresh_token = $acc->refresh_token;
            $accML->owner = $_SESSION[SESSION_USER]->id;
            
            $result = $accML->AddAccount();
            if (!is_array($result)){
                $accML->GetNickname();
                $this->Context['alerts'] = ['success' => 'Conta adicionada'];
                $this->refreshAccounts();
                $this->render();    
            }else{
                foreach($result as $v){
                    $this->Context['alerts'] = ['danger' => $v];
                    $this->render();    
                }
            }
            
        }else{ //ERRO AO CADASTRAR
            
        }
    }
    
    
}