<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Special applicant form type.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Form\Type
 * @author  Etki <etki@etki.name>
 */
class ApplicantType extends AbstractType
{
    /**
     * Returns type name.
     *
     * @return string
     * @since 0.1.0
     */
    public function getName()
    {
        return 'applicant';
    }

    /**
     * Builds corresponding form.
     *
     * @param FormBuilderInterface $builder Form builder.
     * @param array                $options Additional options.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return void
     * @since 0.1.0
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                'text',
                ['label' => 'label.type.applicant.title', 'required' => true,]
            )->add(
                'email',
                'email',
                ['label' => 'label.type.applicant.email', 'required' => true,]
            )->add(
                'story',
                'textarea',
                ['label' => 'label.type.applicant.story', 'required' => false,]
            )->add(
                'is_private',
                'checkbox',
                [
                    'label' => 'label.type.applicant.is_private',
                    'required' => false,
                ]
            )->add(
                'save',
                'submit',
                ['label' => 'label.form.application.submit',]
            );
    }
}
