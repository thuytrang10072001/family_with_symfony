<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CustomerForm;
use App\Service\CustomerService;
use App\Entity\Customer;

class CustomerController extends AbstractController
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    #[Route('/customer', name: 'customer_index')]
    public function index(): Response
    {
        $customers = $this->customerService->getAllCustomers();
    
        return $this->render('customer/index.html.twig',[
            'customers' => $customers,
        ]);
    }
    
    #[Route('/customer/{id}', name: 'customer_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $customer = $this->customerService->getCustomerById($id);
        
        if (!$customer) {
            throw $this->createNotFoundException('Customer not found');
        }

        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    #[Route('/customer/create', name: 'customer_create')]
    public function create(Request $request): Response
    {
        $customer = new Customer();

        $form = $this->createForm(CustomerForm::class, $customer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
    
            $this->customerService->save($customer, true);

            $this->addFlash('success', 'Customer created successfully!');

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/customer/edit/{id}', name: 'customer_edit',  requirements: ['id' => '\d+'])]
    public function edit(Customer $customer, Request $request): Response
    {
        $form = $this->createForm(CustomerForm::class, $customer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
    
            $this->customerService->save($customer, true);

            $this->addFlash('success', 'Customer updated successfully!');

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/customer/delete/{id}', name: 'customer_delete',  requirements: ['id' => '\d+'])]
    public function delete(Customer $customer, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $this->customerService->delete($customer, true);

            $this->addFlash('success', 'Customer deleted successfully!' );

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/delete.html.twig', [
            'customer' => $customer,
        ]);
    }
}
