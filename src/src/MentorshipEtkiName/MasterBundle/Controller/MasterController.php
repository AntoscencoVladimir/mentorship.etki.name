<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Controller;

use Doctrine\ORM\EntityManager;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Repository\ApplicantRepository;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * The heart of whole app, main controller.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Controller
 * @author  Etki <etki@etki.name>
 */
class MasterController extends Controller
{
    /**
     * This action serves the default homepage.
     *
     * @param string $language
     *
     * @return Response
     * @since 0.1.0
     */
    public function indexAction($language = 'ru')
    {
        if (!in_array($language, ['ru',/* 'en',*/], true)) {
            throw $this->createNotFoundException();
        }
        $templateName = sprintf(
            'MentorshipMasterBundle:Master:index-%s.html.twig',
            $language
        );
        /** @type EntityManager $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        /** @type ApplicantRepository $applicantRepository */
        $applicantRepository
            = $entityManager->getRepository('MentorshipMasterBundle:Applicant');
        // temporary data
        $context = [
            'links' => (new LinkRepository())->findAll(),
            'active_applicants' => $applicantRepository->getActiveApplicants(),
            'counter' => $applicantRepository->getApplicantCount(),
        ];
        return $this->render($templateName, $context);
    }
}
