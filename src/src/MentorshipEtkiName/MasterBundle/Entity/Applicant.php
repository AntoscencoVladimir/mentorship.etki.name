<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Entity;

use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Applicant entity.
 *
 * @ORM\Entity(repositoryClass="Etki\Projects\MentorshipEtkiName\MasterBundle\Repository\ApplicantRepository")
 * @ORM\Table(name="applicant")
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
class Applicant implements Serializable
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
     * @Assert\NotBlank(message="applicant.title.not_blank")
     * @Assert\Length(max="64", maxMessage="applicant.title.too_long")
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
    private $isPrivate = true;
    /**
     * Tells if applicant is still active.
     *
     * @ORM\Column(name="is_active", type="boolean")
     *
     * @type bool
     * @since 0.1.0
     */
    private $isActive = true;
    /**
     * Applicant's email.
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Email(message="applicant.email.not_email")
     * @Assert\NotBlank(message="applicant.email.not_blank")
     * @Assert\Length(max="64", maxMessage="applicant.email.too_long")
     *
     * @type string
     * @since 0.1.0
     */
    private $email;
    /**
     * Applicant's story.
     *
     * @ORM\Column(type="string")
     *
     * @type string
     * @since 0.1.0
     */
    private $story;

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
    public function getIsPrivate()
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
    public function setIsPrivate($isPrivate)
    {
        $this->isPrivate = $isPrivate;
        return $this;
    }

    /**
     * Returns isActive.
     *
     * @return boolean
     * @since 0.1.0
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Sets isActive.
     *
     * @param boolean $isActive IsActive.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * Returns email.
     *
     * @return string
     * @since 0.1.0
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets email.
     *
     * @param string $email Email.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Returns story.
     *
     * @return string
     * @since 0.1.0
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Sets story.
     *
     * @param string $story Story.
     *
     * @return $this Current instance.
     * @since 0.1.0
     */
    public function setStory($story)
    {
        $this->story = $story;
        return $this;
    }

    /**
     * Serializes object.
     *
     * @return string
     * @since 0.1.0
     */
    public function serialize()
    {
        return serialize(get_object_vars($this));
    }

    /**
     * Performs deserialization.
     *
     * @param string $serializedData Data as a string.
     *
     * @return void
     * @since 0.1.0
     */
    public function unserialize($serializedData)
    {
        $data = unserialize($serializedData);
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
}
