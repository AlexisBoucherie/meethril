<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\User;
use App\Entity\UserSession;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\UserSessionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/session')]
class SessionController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private TokenStorageInterface $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }
    #[Route('/new', name: 'app_session_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        SessionRepository $sessionRepository,
    ): Response {
        $session = new Session();
        // manage the form creation
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // set other parameters for session
            $session->setCurrentPlayerNb(0);
            $session->setCreatedAt(new DateTime());
            // set all the info given through the Session form, by the user
            $sessionRepository->save($session, true);
            // get current app.user
            $user = $this->tokenStorage->getToken()->getUser();
            // add new session in the join table User-Session
            $userSession = new UserSession();
            $userSession->setUserId($user);
            $userSession->setSessionId($session);
            $userSession->setUserIsOwner(true);
            $userSession->setCreatedAt(new DateTime());
            // save the User_Session
            $this->entityManager->persist($userSession);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session/new.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, SessionRepository $sessionRepository): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionRepository->save($session, true);

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session/edit.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, SessionRepository $sessionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $sessionRepository->remove($session, true);
        }

        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
