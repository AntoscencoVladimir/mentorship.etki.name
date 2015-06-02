<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Controller;

use DateTime;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Applicant;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Application;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Repository\ApplicationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * This controller does dull work. With applicants.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Controller
 * @author  Etki <etki@etki.name>
 */
class ApplicantController extends Controller
{
    /**
     * Toggles applicant active state.
     *
     * @param Applicant $applicant Applicant.
     *
     * @ParamConverter("applicant", class="MentorshipMasterBundle:Applicant")
     *
     * @return RedirectResponse
     * @since 0.1.0
     */
    public function toggleActiveStateAction(Applicant $applicant)
    {
        $applicant->setIsActive(!$applicant->getIsActive());
        $this->getDoctrine()->getManager()->persist($applicant);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * Starts applicant application.
     *
     * @param Applicant $applicant Applicant.
     *
     * @ParamConverter("applicant", class="MentorshipMasterBundle:Applicant")
     *
     * @return RedirectResponse
     * @since 0.1.0
     */
    public function startApplicationAction(Applicant $applicant)
    {
        $manager = $this->getDoctrine()->getManager();
        /** @type ApplicationRepository $repository */
        $repository =
            $manager->getRepository('MentorshipMasterBundle:Application');
        if ($repository->findActiveByApplicant($applicant)) {
            $message = 'Applicant has already started application';
            throw new BadRequestHttpException($message);
        }
        $application = new Application;
        // todo attach @timestampable
        $application->setStartedAt(new DateTime);
        $application->setApplicant($applicant);
        $manager->persist($application);
        $manager->flush();
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * Ends applicant application.
     *
     * @param Applicant $applicant Applicant.
     *
     * @ParamConverter("applicant", class="MentorshipMasterBundle:Applicant")
     *
     * @return RedirectResponse
     * @since 0.1.0
     */
    public function finishApplicationAction(Applicant $applicant)
    {
        $manager = $this->getDoctrine()->getManager();
        /** @type ApplicationRepository $repository */
        $repository =
            $manager->getRepository('MentorshipMasterBundle:Application');
        // just in case something went mad and there's more than one application
        if (!($applications = $repository->findActiveByApplicant($applicant))) {
            $message = 'No applications exit for provided applicant';
            throw new BadRequestHttpException($message);
        }
        foreach ($applications as $application) {
            $application->setFinishedAt(new DateTime);
            $manager->persist($application);
        }
        $applicant->setIsActive(false);
        $manager->persist($applicant);
        $manager->flush();
        return $this->redirectToRoute('admin_dashboard');
    }
}
