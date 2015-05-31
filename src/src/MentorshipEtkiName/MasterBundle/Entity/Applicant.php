<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Applicant entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="applicant")
 *
 * @SuppressWarnings(PHPMD.ShortVariableName)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Entity
 * @author  Etki <etki@etki.name>
 */
class Applicant
{
    /**
     * Identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @type int
     * @since 0.1.0
     */
    private $id;
    /**
     * Applicant name, as he/she thought would be best to introduce.
     *
     * @ORM\Column(type="string", length=64)
     *
     * @type string
     * @since 0.1.0
     */
    private $title;
    /**
     * Tells if applicant's profile is private.
     *
     * @ORM\Column(name="is_private", type="boolean")
     *
     * @type bool
     * @since 0.1.0
     */
    private $isPrivate;

    /**
     * Returns identifier.
     *
     * @return int
     * @since 0.1.0
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets identifier.
     *
     * @param int $id Identifier.
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
     * Returns title.
     *
     * @return string
     * @since 0.1.0
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets title.
     *
     * @param string $title Title.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns if profile is private.
     *
     * @return boolean
     * @since 0.1.0
     */
    public function isPrivateProfile()
    {
        return $this->isPrivate;
    }

    /**
     * Sets profile privacy.
     *
     * @param boolean $isPrivate True for making profile private, false
     *                           otherwise.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setProfilePrivacy($isPrivate)
    {
        $this->isPrivate = $isPrivate;
        return $this;
    }
}
