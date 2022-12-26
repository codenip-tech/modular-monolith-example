<?php

declare(strict_types=1);

namespace Customer\Adapter\Database\ORM\Doctrine\Repository;

use Customer\Adapter\Framework\Http\API\Filter\CustomerFilter;
use Customer\Adapter\Framework\Http\API\Response\PaginatedResponse;
use Customer\Domain\Exception\ResourceNotFoundException;
use Customer\Domain\Model\Customer;
use Customer\Domain\Repository\CustomerRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class DoctrineCustomerRepository implements CustomerRepository
{
    private readonly ServiceEntityRepository $repository;
    private readonly ObjectManager|EntityManagerInterface $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = new ServiceEntityRepository($managerRegistry, Customer::class);
        $this->manager = $managerRegistry->getManager('customer_em');
    }

    public function findOneByIdOrFail(string $id): Customer
    {
        if (null === $customer = $this->repository->find($id)) {
            throw ResourceNotFoundException::createFromClassAndId(Customer::class, $id);
        }

        return $customer;
    }

    public function findOneByEmail(string $email): ?Customer
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function search(CustomerFilter $filter): PaginatedResponse
    {
        $page = $filter->page;
        $limit = $filter->limit;
        $employeeId = $filter->employeeId;
        $sort = $filter->sort;
        $order = $filter->order;
        $name = $filter->name;

        $qb = $this->repository->createQueryBuilder('c');
        $qb->orderBy(\sprintf('c.%s', $sort), $order);
        $qb
            ->andWhere('c.employeeId = :employeeId')
            ->setParameter(':employeeId', $employeeId);

        if (null !== $name) {
            $qb
                ->andWhere('c.name LIKE :name')
                ->setParameter(':name', $name.'%');
        }

        $paginator = new Paginator($qb->getQuery());
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return PaginatedResponse::create($paginator->getIterator()->getArrayCopy(), $paginator->count(), $page, $limit);
    }

    public function save(Customer $customer): void
    {
        $this->manager->persist($customer);
        $this->manager->flush();
    }

    public function remove(Customer $customer): void
    {
        $this->manager->remove($customer);
        $this->manager->flush();
    }
}
