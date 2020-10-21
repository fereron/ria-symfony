<?php
declare(strict_types=1);

namespace Ria\Bundle\PostBundle\Repository;

use Doctrine\ORM\EntityRepository;
//use Ria\Core\Query\EntitySpecificationRepositoryTrait;
//use Ria\News\Core\Query\Hydrator\StoryHydrator;
//use Ria\News\Core\Query\ViewModel\StoryViewModel;

class StoryRepository extends EntityRepository
{
//    use EntitySpecificationRepositoryTrait;

    /**
     * @return string
     */
    function getSpecsNamespace(): string
    {
        return "Ria\\News\\Core\\Query\\Specifications\\Story";
    }

    /**
     * @param string $language
     * @param int $limit
     * @return array
     */
    public function list(string $language, int $limit): array
    {
        return $this->createQueryBuilder('s')
            ->select(['s.id', 't.title', 't.slug'])
            ->innerJoin('s.translations', 't', 'with', 't.language = :language')
            ->where('s.status = :status')
            ->orderBy('s.created_at', 'desc')
            ->setParameters([':status' => true, ':language' => $language])
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();

    }

    /**
     * @param string $slug
     * @param string $language
     * @return StoryViewModel|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findBySlug(string $slug, string $language): ?StoryViewModel
    {
        return $this->createQueryBuilder('s')
            ->select(['s.id', 't.title', 't.slug', 't.description', 's.cover'])
            ->innerJoin('s.translations', 't', 'with', 't.language = :language')
            ->where('t.slug = :slug')
            ->setParameters([
                'slug'     => $slug,
                'language' => $language
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult(StoryHydrator::HYDRATION_MODE);
    }

}