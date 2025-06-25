<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CustomerRepository;
use App\Form\CustomerForm;
use App\Entity\Customer;

class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'customer_index')]
    public function index(CustomerRepository $repo): Response
    {
        $customers = $repo->findAll();
        dump($customers); // This will dump the customer data to the Symfony profiler

        return $this->render('customer/index.html.twig',[
            'customers' => $customers,
        ]);
    }
    
    #[Route('/customer/{id}', name: 'customer_show', requirements: ['id' => '\d+'])]
    public function show(int $id, CustomerRepository $repo): Response
    {
        $customer = $repo->find($id);
        
        if (!$customer) {
            throw $this->createNotFoundException('Customer not found');
        }

        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    #[Route('/customer/create', name: 'customer_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $customer = new Customer();

        $form = $this->createForm(CustomerForm::class, $customer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
    
            $manager->persist($customer);

            $manager->flush();


            $this->addFlash('success', 'Customer created successfully!');

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/customer/edit/{id}', name: 'customer_edit',  requirements: ['id' => '\d+'])]
    public function edit(Customer $customer, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CustomerForm::class, $customer);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
    
            $manager->flush();


            $this->addFlash('success', 'Customer updated successfully!');

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/customer/delete/{id}', name: 'customer_delete',  requirements: ['id' => '\d+'])]
    public function delete(Customer $customer, Request $request, EntityManagerInterface $manager): Response
    {
        if ($request->isMethod('POST')) {
            $manager->remove($customer);
            $manager->flush();

            $this->addFlash('success', 'Customer deleted successfully!' );

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/delete.html.twig', [
            'customer' => $customer,
        ]);
    }
}
