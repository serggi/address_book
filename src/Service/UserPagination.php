<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface as SlidingPaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class UserPagination implements UserPaginationInterface
{
    private $paginator;
    private $entityManager;

    public function __construct(PaginatorInterface $paginator, EntityManagerInterface $entityManager)
    {
        $this->paginator     = $paginator;
        $this->entityManager = $entityManager;
    }

    public function get(): SlidingPaginationInterface
    {
        $request = Request::createFromGlobals();
        $qb = $this->entityManager->getRepository(User::class)->createQueryBuilder('u');

        if ($request->query->getAlpha('alpha') !== '') {
            $alpha = $request->query->getAlpha('alpha', 'a').'%';
            $qb->where($qb->expr()->like('u.lastName', $qb->expr()->literal($alpha)));
        }

        return $this->paginator->paginate(
            $qb->getQuery(),
            $request->query->getInt('page', self::DEFAULT_PAGE),
            $request->query->getInt('limit', self::DEFAULT_LIMIT),
            [
                'defaultSortFieldName' => ['u.lastName', 'u.firstName'],
                'defaultSortDirection' => 'asc',
            ]
        );
    }
}
