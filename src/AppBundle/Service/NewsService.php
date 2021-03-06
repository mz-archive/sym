<?php

namespace AppBundle\Service;

use AppBundle\Entity\News;
use Doctrine\ORM\EntityManager;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Класс для работы с данными
 *
 * @param $callback
 */
class NewsService
{
    protected $em;

    /**
     * DbService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Получение количества всех новостей
     *
     * @return mixed
     */
    public function getLastNewsId()
    {
        $em = $this->em;

        $qb = $em->createQueryBuilder();
        $qb->select('n.id');
        $qb->from('AppBundle:News','n');
        $qb->orderBy('n.id','DESC');
        $qb->setMaxResults(1);


        $resQuery = $qb->getQuery()->getSingleScalarResult();

        return $resQuery;
    }

    /**
     * Получение количества активных новостей
     *
     * @return mixed
     */
    public function getCountActiveNews()
    {
        $em = $this->em;

        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(n.id)');
        $qb->from('AppBundle:News','n');
        $qb->where('n.active=1');

        $resQuery = $qb->getQuery()->getSingleScalarResult();

        return $resQuery;
    }

    /**
     * Получение всех новостей
     *
     * @return array
     */
    public function getNews()
    {
        $em = $this->em;
        $repo = $em->getRepository('AppBundle:News');
        $resQuery = $repo->findAll();

        return $resQuery;
    }

    /**
     * Получение выборки новостей из $count записей
     *
     *
     * @param $start
     * @param $count
     * @return array
     */
    public function getLimitNews($start, $count)
    {
        $em = $this->em;
        $qb = $em->createQueryBuilder();
        $qb ->add('select', 'u')
            ->add('from', 'AppBundle:News u')
            ->add('where', 'u.active=1')
            ->setFirstResult( $start )
            ->setMaxResults( $count );

        $query = $qb->getQuery();
        $resQuery = $query->getResult();

        return $resQuery;
    }


    /**
     * Получение конкретной новости
     *
     * @param $slug
     * @return array
     */
    public function getNewsBySlug($slug)
    {
        $em = $this->em;
        $repo = $em->getRepository('AppBundle:News');

        $resQuery = $repo->findOneBy(
            ['slug' => $slug]
        );

        return $resQuery;
    }
}