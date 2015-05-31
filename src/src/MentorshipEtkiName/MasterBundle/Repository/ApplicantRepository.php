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
    const CACHE_ID_ACTIVE_APPLICANTS_COUNTER = 'ActiveApplicantsCounter';
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
     * Returns list of active applicants.
     *
     * @return Applicant[]
     * @since 0.1.0
     */
    public function getActiveApplicants()
    {
        $query = $this
            ->createQueryBuilder('a')
            ->distinct()
            ->join('MentorshipMasterBundle:Application', 'apl')
            ->where('apl.finishedAt IS NULL')
            ->andWhere('apl.startedAt < CURRENT_TIMESTAMP()')
            ->getQuery();
        $cacheId = self::getCacheId(self::CACHE_ID_ACTIVE_APPLICANTS_COUNTER);
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
