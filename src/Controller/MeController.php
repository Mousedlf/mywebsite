<?php

namespace App\Controller;

use App\Entity\Me;
use App\Form\MeType;
use App\Repository\MeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('{_locale}/me')]

class MeController extends AbstractController
{
    #[Route('/', name: 'app_me')]
    public function index(Request $request, MeRepository $repository): Response
    {
        $locale = $request->getLocale();
        $me = $repository->findAll();

        return $this->render('me/index.html.twig', [
            'locale' => $locale,
            'me'=>$me
        ]);
    }

    #[Route('/new', name: 'new_me' , priority: 2)]
    #[Route('/edit/{id}', name: 'edit_me', priority: 2)]
    public function create(Request $request, EntityManagerInterface $manager, Me $me=null): Response
    {
        $edit= false;
        $title = "new";

        if($me){
            $edit = true;
            $title = "edit";
        }
        if(!$edit){$me= new Me();}

        $formMe = $this->createForm(MeType::class, $me);
        $formMe->handleRequest($request);
        if($formMe->isSubmitted() && $formMe->isValid()){

            $manager->persist($me);
            $manager->flush();

            return $this->redirectToRoute('app_me');
        }


        return $this->render('me/new.html.twig', [
            'formMe'=>$formMe,
            'edit'=>$edit,
            'title'=>$title
        ]);
    }
}
