<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Order1;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/commande/merci/{stripeSessionId}', name: 'app_order_validate')]
    public function index(Cart $cart, $stripeSessionId): Response

    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() !== $this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        if(!$order->getIsPaid()){
            // Vider la session cart 
            $cart->remove();

            // Modifier le statut isPaid
            $order->setIsPaid(1);
            $this->entityManager->flush();

            // Envoyer un email au client pour confirmer la commande
        }
        // Afficher les quelques informations de commande de l'utilisateur  
        return $this->render('order_validate/index.html.twig', [
            'order'=> $order
        ]);
    }
}
