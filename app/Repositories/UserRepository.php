<?php

namespace App\Repositories;

class UserRepository extends Repository
{
    public  function getUsersByRoleAndName(?string $name ,string $role , array $relatedObjects=[])
    {
        return $this->getModel->with($relatedObjects)
            ->where('role',$role)
            ->where('name', 'like', $name.'%');
    }

}
