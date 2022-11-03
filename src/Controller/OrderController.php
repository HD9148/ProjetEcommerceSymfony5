<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use DateTimeImmutable;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;
    }
    
    #[Route('/commande', name: 'app_order')]
    public function index(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()->getAdresses()->getValues())
            {
                return $this->redirectToRoute('app_add_adress');
            }
        $form = $this->createForm(OrderType::class, null, [
            'user'=> $this->getUser()
        ]);
        return $this->render('order/index.html.twig',[
            'form'=>$form->createView(),
            'cart'=> $cart->getFull()
        ]);
    }

    #[Route('/commande/recap', name: 'app_order_recap', methods:"POST")]
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
        //** Récup */
            'user'=> $this->getUser()
        ]); 

        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid()){
            // Enregistrer ma commande

            $date = new DateTimeImmutable();

            $carrieres = $form->get('carrieres')->getData();
            $delivery = $form->get('adresses')->getData();

            $delivery_content = $delivery->getFirstName().''.$delivery->getLastName();
            $delivery_content = $delivery->getPhone();


            if($delivery->getCompany()){
                $delivery_content .= '<br/>'. $delivery->getCompany();
            }

            $delivery_content = $delivery->getAdress();
            $delivery_content = $delivery->getCodePostal();
            $delivery_content = $delivery->getPays();

            
            // Enregistrer mes products Order()
            // dd($delivery_content);
            $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carrieres->getName());
            $order->setCarrierPrice($carrieres->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);

            $this->entityManagerInterface->persist($order);
            // Enregistrer mes products OrderDetails()
            
            foreach ($cart->getFull() as $product){
                $orderDetails = new OrderDetails();
                
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);

            $this->entityManagerInterface->persist($orderDetails);


        }

        // dd($order);
            //Pour envoyer les données dans phpMyadmin
            $this->entityManagerInterface->flush();

            return $this->render('order/add.html.twig',[
                'form'=>$form->createView(),
                'cart'=> $cart->getFull(),
                'carriere'=> $carrieres,
                'delivery'=> $delivery_content,
                'reference'=>$order->getReference(),
            ]);
        }

        return $this->redirectToRoute('app_cart');

        

        
        // dd($order);
    }
}
