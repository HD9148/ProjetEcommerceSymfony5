<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAdressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/compte/adresses', name: 'app_account_adress')]
    public function index(): Response
    {
        return $this->render('account/adress.html.twig');
    }

    #[Route('/compte/ajouter-une-adresse/', name: 'app_add_adress')]
    public function add(Request $request, Cart $cart): Response
    {
        $adress = new Adress();
        $form = $this->createForm(AdressType::class, $adress);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $adress->setUser($this->getUser());
            // dd($adress);
            //Envoyer à la base donnnées
            $this->entityManager->persist($adress);
            $this->entityManager->flush();
            if($cart->get()){
                return $this->redirectToRoute('app_order');
            } else {

                return $this->redirectToRoute('app_adress');
            }
            
        }

        return $this->render('account/adress_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/compte/modifier-adresse/{id}', name: 'app_edit_adress')]

    public function edit(Request $request, $id): Response
    {
        $adress=  $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if(!$adress || $adress->getUser() != $this->getUser()){
            return $this->redirectToRoute('app_account_adress');
        }

        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_adress');
            
            // dd($adress);
        }

        return $this->render('account/adress_form.html.twig', [
            'controller_name' => 'AccountAdressController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/supprimer-adresse/{id}', name: 'app_delete_adress')]

    public function delete( $id): Response
    {
        $adress=  $this->entityManager->getRepository(Adress::class)->findOneById($id);
        if( $adress && $adress->getUser() == $this->getUser()){
            $this->entityManager->remove($adress);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('app_account_adress');
    }
}


