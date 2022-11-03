<?php

namespace App\Controller;

use App\Entity\Carrier;
use App\Form\CarrierType;
use App\Repository\CarrierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/carrier')]
class AdminCarrierController extends AbstractController
{
    #[Route('/', name: 'app_admin_carrier_index', methods: ['GET'])]
    public function index(CarrierRepository $carrierRepository): Response
    {
        return $this->render('admin_carrier/index.html.twig', [
            'carriers' => $carrierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_carrier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarrierRepository $carrierRepository): Response
    {
        $carrier = new Carrier();
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrierRepository->save($carrier, true);

            return $this->redirectToRoute('app_admin_carrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_carrier/new.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_carrier_show', methods: ['GET'])]
    public function show(Carrier $carrier): Response
    {
        return $this->render('admin_carrier/show.html.twig', [
            'carrier' => $carrier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_carrier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carrier $carrier, CarrierRepository $carrierRepository): Response
    {
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrierRepository->save($carrier, true);

            return $this->redirectToRoute('app_admin_carrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_carrier/edit.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_carrier_delete', methods: ['POST'])]
    public function delete(Request $request, Carrier $carrier, CarrierRepository $carrierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carrier->getId(), $request->request->get('_token'))) {
            $carrierRepository->remove($carrier, true);
        }

        return $this->redirectToRoute('app_admin_carrier_index', [], Response::HTTP_SEE_OTHER);
    }
}
