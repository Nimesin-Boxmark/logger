<?php
namespace Logger\Infrastructure\Domain\Model\Log;

use Logger\Domain\Model\Log\LogRepositoryInterface;
use Logger\Domain\Model\Log\Log;
use Doctrine\ORM\EntityRepository;

class DoctrineLogRepository extends EntityRepository implements LogRepositoryInterface
{
    private $setIdTable;
    /**
     *
     * {@inheritDoc}
     * @see \Logger\Domain\Model\Log\LogRepositoryInterface::add()
     */
    public function add(Log $log)
    {
        $this->getEntityManager()->persist($log);
        try{
            $this->getEntityManager()->flush($log);
            $this->getEntityManager()->commit();
        }catch (\Throwable $e) {
            $this->getEntityManager()->close();
            $this->getEntityManager()->rollBack();
        }
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \Logger\Domain\Model\Log\LogRepositoryInterface::remove()
     */
    public function remove(Log $log)
    {
        $this->getEntityManager()->remove($log);
    }
    
    public function setIdTable($idTable)
    {
        $this->idTable = $idTable;
    }
}

