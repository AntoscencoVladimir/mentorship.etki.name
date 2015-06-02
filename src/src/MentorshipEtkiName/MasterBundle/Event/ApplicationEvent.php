<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Event;

use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Applicant;
use Symfony\Component\EventDispatcher\Event;

/**
 * Designed to be raised whenever applicant is registered.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Event
 * @author  Etki <etki@etki.name>
 */
class ApplicationEvent extends Event
{
    private $applicant;

    /**
     * Initializer.
     *
     * @param Applicant $applicant Fresh meat.
     *
     * @since 0.1.0
     */
    public function __construct(Applicant $applicant)
    {
        $this->applicant = $applicant;
    }

    /**
     * Returns applicant entity.
     *
     * @return Applicant
     * @since 0.1.0
     */
    public function getApplicant()
    {
        return $this->applicant;
    }
}
