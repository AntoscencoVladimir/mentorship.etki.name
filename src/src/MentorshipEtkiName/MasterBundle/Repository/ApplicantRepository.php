<?php

namespace Etki\Projects\MentorshipEtkiName\MasterBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Etki\Projects\MentorshipEtkiName\MasterBundle\Entity\Applicant;

/**
 * Repository for applicant entity.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Projects\MentorshipEtkiName\MasterBundle\Repository
 * @author  Etki <etki@etki.name>
 */
class ApplicantRepository extends EntityRepository
{
    /**
     * Prefix for all cache identifiers.
     *
     * @since 0.1.0
     */
    const CACHE_ID_PREFIX = 'MentorshipBundle:Applicant:';
    /**
     * Total applicants counter cache ID suffix.
     *
     * @since 0.1.0
     */
    const CACHE_ID_TOTAL_APPLICANTS_COUNTER = 'TotalApplicantsCounter';
    /**
     * Active applicants counter cache ID suffix.
     *
     * @since 0.1.0
     */
    const CACHE_ID_ACTIVE_APPLICANTS_SET = 'ActiveApplicantsCounter';
    /**
     * Active applicants counter cache ID suffix.
     *
     * @since 0.1.0
     */
    const CACHE_ID_INACTIVE_APPLICANTS_SET = 'ActiveApplicantsSet';
    /**
     * Waiting applicants cache ID suffix.
     *
     * @since 0.1.0
     */
    const CACHE_ID_WAITING_APPLICANTS_SET = 'WaitingApplicantsSET';
    /**
     * Returns amount of applicants.
     *
     * @return int
     * @since 0.1.0
     */
    public function getApplicantCount()
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery();
        $cacheId = self::getCacheId(self::CACHE_ID_TOTAL_APPLICANTS_COUNTER);
        $query->useResultCache(true, 3600, $cacheId);
        return $query->getSingleScalarResult();
    }

    /**
     * Returns list of current applicants.
     *
     * @return Applicant[]
     * @since 0.1.0
     */
    public function getCurrentApplicants()
    {
        $builder = $this->createQueryBuilder('a');
        $subQueryBuilder = $this->_em->createQueryBuilder();
        $subQuery = $subQueryBuilder
            ->select('apl')
            ->from('MentorshipMasterBundle:Application', 'apl')
            ->where('apl.applicant = a')
            ->andWhere('apl.finishedAt IS NULL')
            ->getQuery();
        $query = $builder
            ->where($builder->expr()->exists($subQuery->getDQL()))
            ->getQuery();
        $cacheId = self::getCacheId(self::CACHE_ID_ACTIVE_APPLICANTS_SET);
        $query->useResultCache(true, 3600, $cacheId);
        return $query->getResult();
    }

    /**
     * Returns list of inactive applicants.
     *
     * @return Applicant[]
     * @since 0.1.0
     */
    public function getInactiveApplicants()
    {
        $builder = $this->createQueryBuilder('a');
        $subQueryBuilder = $this->_em->createQueryBuilder();
        $subQuery = $subQueryBuilder
            ->select('1')
            ->from('MentorshipMasterBundle:Application', 'apl')
            ->where($subQueryBuilder->expr()->isNull('apl.finishedAt'))
            ->andWhere(
                $subQueryBuilder->expr()->eq('apl.applicant', 'a')
            )->getDQL();
        $query = $this
            ->createQueryBuilder('a')
            ->distinct()
            ->where('a.isActive = FALSE')
            ->andWhere(
                $builder->expr()->not(
                    $builder->expr()->exists($subQuery)
                )
            )
            ->getQuery();
        $cacheId = self::getCacheId(self::CACHE_ID_INACTIVE_APPLICANTS_SET);
        $query->useResultCache(true, 3600, $cacheId);
        return $query->getResult();
    }

    /**
     * Retrieves list of applicants that are waiting for their turn.
     *
     * @return Applicant[]
     * @since 0.1.0
     */
    public function getWaitingApplicants()
    {
        $builder = $this->createQueryBuilder('a');
        $subQueryBuilder = $this->_em->createQueryBuilder();
        $subQuery = $subQueryBuilder
            ->select('1')
            ->from('MentorshipMasterBundle:Application', 'apl')
            ->where($subQueryBuilder->expr()->isNull('apl.finishedAt'))
            ->andWhere(
                $subQueryBuilder->expr()->eq('apl.applicant', 'a')
            )->getDQL();
        $query = $this
            ->createQueryBuilder('a')
            ->distinct()
            ->where('a.isActive = TRUE')
            ->andWhere(
                $builder->expr()->not(
                    $builder->expr()->exists($subQuery)
                )
            )
            ->getQuery();
        $cacheId = self::getCacheId(self::CACHE_ID_WAITING_APPLICANTS_SET);
        $query->useResultCache(true, 3600, $cacheId);
        return $query->getResult();
    }

    /**
     * Returns full-blown cache ID.
     *
     * @param string $suffix ID suffix.
     *
     * @return string Cache ID.
     * @since 0.1.0
     */
    public static function getCacheId($suffix)
    {
        return self::CACHE_ID_PREFIX . $suffix;
    }
}
