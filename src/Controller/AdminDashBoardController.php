<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashBoardController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_dash_board')]
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]

    public function index(): Response
    {
        return $this->render('admin_dash_board/index.html.twig');
    }
}
