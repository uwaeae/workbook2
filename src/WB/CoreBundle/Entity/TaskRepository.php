<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Florian Engler 
 * Mail: florian.engler@gmx.de
 * Date: 23.05.13
 * Time: 11:15
 */

namespace WB\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


class TaskRepository extends EntityRepository {

    public function getScheduledTasksForJob($id){
        $qb = $this->createQueryBuilder('t');
        $qb->innerJoin('t.job','j','WITH',' j.id ='.$id)
            ->where($qb->expr()->eq('t.scheduled','TRUE'))
            ->orderby('t.start');;

        return $qb->getQuery()->getResult();

    }

}