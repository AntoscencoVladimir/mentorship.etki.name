<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Entity;

use DateTime;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\ORM\Mapping as ORM;

/**
 * Single application entity (not the application that is run, but applicant's
 * application for mentorship).
 *
 * @ORM\Entity(repositoryClass="Etki\Projects\MentorshipEtkiName\MasterBundle\Repository\ApplicationRepository")
 * @ORM\Table(name="application")
 *
 * @IgnoreAnnotation("type")
 *
 * @SuppressWarnings(PHPMD.ShortVariableName)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Entity
 * @author  Etki <etki@etki.name>
 */
class Application
{
    /**
     * Identifier.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @type int
     * @since 0.1.0
     */
    private $id;
    /**
     * Day the mentorship has started.
     *
     * @ORM\Column(name="started_at", type="date")
     *
     * @type DateTime
     * @since 0.1.0
     */
    private $startedAt;
    /**
     * Day the mentorship has ended.
     *
     * @ORM\Column(name="finished_at", type="date")
     *
     * @type DateTime
     * @since 0.1.0
     */
    private $finishedAt;
    /**
     * Referenced applicant.
     *
     * @ORM\ManyToOne(targetEntity="Applicant")
     * @ORM\JoinColumn(name="applicant_id", referencedColumnName="id")
     *
     * @type Applicant
     * @since 0.1.0
     */
    private $applicant;

    /**
     * Returns id.
     *
     * @return int
     * @since 0.1.0
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param int $id Id.
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns startedAt.
     *
     * @return DateTime
     * @since 0.1.0
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Sets startedAt.
     *
     * @param DateTime $startedAt StartedAt.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    /**
     * Returns finishedAt.
     *
     * @return DateTime
     * @since 0.1.0
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * Sets finishedAt.
     *
     * @param DateTime $finishedAt FinishedAt.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finishedAt = $finishedAt;
        return $this;
    }

    /**
     * Returns applicant.
     *
     * @return Applicant
     * @since 0.1.0
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

    /**
     * Sets applicant.
     *
     * @param Applicant $applicant Applicant.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setApplicant($applicant)
    {
        $this->applicant = $applicant;
        return $this;
    }
}
