<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Repository;

/**
 * A fake repository that erm imitates normal repository findAll() output.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Repository
 * @author  Etki <etki@etki.name>
 */
class LinkRepository
{
    /**
     * Returns all the links
     *
     * @return array
     * @since 0.1.0
     */
    public function findAll()
    {
        $links = [
            [
                'title' => 'PHP Mentoring',
                'icon' => 'php-mentoring.png',
                'url' => 'http://phpmentoring.org/'
            ],
            [
                'title' => 'StackOverflow',
                'icon' => 'stackoverflow.png',
                'url' => 'http://stackoverflow.com/',
            ],
            [
                'title' => 'StackOverflow.Ru / ex-hashcode.ru',
                'icon' => 'stackoverflow.png',
                'url' => 'http://ru.stackoverflow.com/',
            ],
            [
                'title' => 'AskDev.ru',
                'icon' => 'askdev.png',
                'url' => 'http://askdev.ru/',
            ],
            [
                'title' => 'Govnokod',
                'icon' => 'govnokod.png',
                'url' => 'http://govnokod.ru/'
            ],
        ];
        foreach ($links as &$link) {
            $link['icon']
                = 'bundles/mentorshipmaster/images/logo/' . $link['icon'];
        }
        return $links;
    }
}
