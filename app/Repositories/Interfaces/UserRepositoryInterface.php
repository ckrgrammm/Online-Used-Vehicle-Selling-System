<?php
namespace App\Repositories\Interfaces;

Interface UserRepositoryInterface{
    
    public function allUser();
    public function storeUser($data);
    public function findUser($id);
    public function findUserByEmail($email);
    public function updateUser($data, $id); 
    public function edit_password($data, $id); 
    public function password_reset($data); 
    public function destroyUser($id);
}