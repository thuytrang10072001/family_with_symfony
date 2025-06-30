<?php

namespace App\Service;

use App\Repository\CustomerRepository;

class CustomerService
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers()
    {
        return $this->customerRepository->findAll();
    }

    public function getCustomerById(int $id)
    {
        return $this->customerRepository->find($id);
    }

    public function save($customer, $flush)
    {
        $this->customerRepository->save($customer, $flush);
    }

    public function delete($customer, $flush)
    {
        $this->customerRepository->remove($customer, $flush);
    }
}