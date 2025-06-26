<?php

namespace Modules\UserModule\Services;

use Modules\UserModule\Repository\UserRepository;
use Spatie\Permission\Models\Permission;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($data)
    {
        $user_data = [
            'name' => $data->name,
            'branch_id' => $data->branch_id,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ];
        $user = $this->userRepository->create($user_data);

        $data['permissions'] = isset($data['permissions']) ? $data['permissions'] : [];
        $user->permissions()->sync($data['permissions']);
        return $user;
    }

    public function findAll()
    {
        return $this->userRepository->get();
    }

    public function findOne($id)
    {
        return $this->userRepository->find($id);
    }

    public function update($data)
    {
        $user_data = [
            'name' => $data['name'],
            'branch_id' => $data['branch_id'],
            'email' => $data['email'],
        ];
        if ($data['password'] != null)
            $user_data['password'] = bcrypt($data['password']);

        $user =  $this->userRepository->update($user_data, $data['id']);

        $data['permissions'] = isset($data['permissions']) ? $data['permissions'] : [];
        $user->permissions()->sync($data['permissions']);


        return $user;
    }

    public function deleteOne($id)
    {
        return $this->userRepository->delete($id);
    }
 
    public function updatePassword($data)
    {
        $new_password = bcrypt($data->password);
         return $this->userRepository->update(['password' => $new_password], $data->id);  
    }
}
