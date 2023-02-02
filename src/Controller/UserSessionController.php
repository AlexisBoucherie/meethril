<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\UserSession;
use App\Form\UserSessionType;
use App\Repository\UserSessionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/user/session')]
class UserSessionController extends AbstractController
{
    private TokenStorageInterface $tokenStorage;
    private EntityManagerInterface $entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_user_session_index', methods: ['GET'])]
    public function index(UserSessionRepository $userSessionRepository): Response
    {
        return $this->render('user_session/index.html.twig', [
            'user_sessions' => $userSessionRepository->findAll(),
        ]);
    }

    /**
     * A user can join a session
     *
     * @param Request $request
     * @param UserSessionRepository $userSessionRepository
     * @return Response
     */
    #[Route('/join/{session}', name: 'app_user_session_join', methods: ['GET', 'POST'])]
    public function join(
        Request $request,
        UserSessionRepository $userSessionRepository,
        Session $session,
    ): Response
    {
        $userSession = new UserSession();
        $form = $this->createForm(UserSessionType::class, $userSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get current app.user
            $user = $this->tokenStorage->getToken()->getUser();
            // set all needed info form session creation
            $userSession->setSessionId($session);
            $userSession->setUserId($user);
            $userSession->setUserIsOwner(false);
            $userSession->setCreatedAt(new DateTime());
            // save user_session info provided by the user
            $userSessionRepository->save($userSession, true);
            // change session max_players
            $session->setCurrentPlayerNb($session->getCurrentPlayerNb()+1);
            // save the session
            $this->entityManager->persist($session);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_session_show', ['id' => $session->getId()], Response::HTTP_SEE_OTHER);
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
        if ($this->isCsrfTokenValid('delete' . $userSession->getId(), $request->request->get('_token'))) {
            $userSessionRepository->remove($userSession, true);
        }

        return $this->redirectToRoute('app_user_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
