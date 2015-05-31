<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Service;

use InvalidArgumentException;
use Symfony\Component\Form\FormInterface;

/**
 *
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Service
 * @author  Etki <etki@etki.name>
 */
class FormEntityDataExtractor
{
    /**
     * Extracts entity data for specified form.
     *
     * @param FormInterface $form   Form to extract data structure from.
     * @param object        $entity Entity to populate form with.
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     *
     * @return array Extracted data.
     * @since 0.1.0
     */
    public function extractEntityData(FormInterface $form, $entity)
    {
        $data = [];
        $class = $form->getConfig()->getDataClass();
        if (!($entity instanceof $class)) {
            $message = sprintf(
                'Invalid entity class: got `%s` instead of `%s`',
                get_class($entity),
                $class
            );
            throw new InvalidArgumentException($message);
        }
        foreach ($form as $key => $value) {
            if (isset($entity->$key)) {
                $data[$key] = $entity->$key;
                continue;
            }
            $variants = [
                $key,
                'is' . ucfirst($key),
                'get' . ucfirst($key),
            ];
            foreach ($variants as $method) {
                if (method_exists($entity, $method)) {
                    $data[$key] = call_user_func([$entity, $method,]);
                    continue;
                }
            }
        }
        return $data;
    }
}
