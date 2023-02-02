<?php

namespace App\Controller;

use App\Entity\UserSession;
use App\Form\UserSessionType;
use App\Repository\UserSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/session')]
class UserSessionController extends AbstractController
{
    #[Route('/', name: 'app_user_session_index', methods: ['GET'])]
    public function index(UserSessionRepository $userSessionRepository): Response
    {
        return $this->render('user_session/index.html.twig', [
            'user_sessions' => $userSessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserSessionRepository $userSessionRepository): Response
    {
        $userSession = new UserSession();
        $form = $this->createForm(UserSessionType::class, $userSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userSessionRepository->save($userSession, true);

            return $this->redirectToRoute('app_user_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_session/new.html.twig', [
            'user_session' => $userSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_session_show', methods: ['GET'])]
    public function show(UserSession $userSession): Response
    {
        return $this->render('user_session/show.html.twig', [
            'user_session' => $userSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserSession $userSession, UserSessionRepository $userSessionRepository): Response
    {
        $form = $this->createForm(UserSessionType::class, $userSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userSessionRepository->save($userSession, true);

            return $this->redirectToRoute('app_user_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_session/edit.html.twig', [
            'user_session' => $userSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_session_delete', methods: ['POST'])]
    public function delete(Request $request, UserSession $userSession, UserSessionRepository $userSessionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userSession->getId(), $request->request->get('_token'))) {
            $userSessionRepository->remove($userSession, true);
        }

        return $this->redirectToRoute('app_user_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
