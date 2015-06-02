<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Applicant;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Application;

/**
 * Repository for application entity.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Repository
 * @author  Etki <etki@etki.name>
 */
class ApplicationRepository extends EntityRepository
{
    /**
     * Finds active applications by applicant.
     *
     * @param Applicant $applicant Applicant.
     *
     * @return Application[]
     * @since 0.1.0
     */
    public function findActiveByApplicant(Applicant $applicant)
    {
        return $this->findBy(['applicant' => $applicant, 'finishedAt' => null]);
    }
}
