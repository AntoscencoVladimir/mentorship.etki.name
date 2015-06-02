<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Controller;

use Etki\Projects\MentorshipEtkiName\MasterBundle\Repository\ApplicantRepository;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Service\SimpleDoctrineCacheCleaner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin controller.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Controller
 * @author  Etki <etki@etki.name>
 */
class AdminController extends Controller
{
    /**
     * Main listing.
     *
     * @return Response
     * @since 0.1.0
     */
    public function indexAction()
    {
        /** @type ApplicantRepository $applicantRepository */
        $applicantRepository = $this
            ->getDoctrine()
            ->getRepository('MentorshipMasterBundle:Applicant');
        $context = [
            'active_applicants' => $applicantRepository->getCurrentApplicants(),
            'waiting_applicants'
                => $applicantRepository->getWaitingApplicants(),
            'inactive_applicants'
                => $applicantRepository->getInactiveApplicants(),
            'active_applicant_limit'
                => $this->getParameter('application.active_applicant_limit'),
        ];
        $template = 'MentorshipMasterBundle:Admin:index.html.twig';
        return $this->render($template, $context);
    }

    /**
     * Drops all cache known to the system.
     *
     * @return RedirectResponse
     * @since 0.1.0
     */
    public function dropCacheAction()
    {
        /** @type SimpleDoctrineCacheCleaner $cleaner */
        $cleaner = $this
            ->get('name.etki.mentorship.master.doctrine_result_cache_cleaner');
        $cleaner->purgeCache();
        return $this->redirectToRoute('admin_dashboard');
    }
}
