<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser($user, $flush, $plainPassword)
    {
        $this->userRepository->add($user, $flush, $plainPassword);
    }
}