<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Florian Engler
 * Mail: florian.engler@gmx.de
 * Date: 18.12.12
 * Time: 16:41
 */
namespace WB\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


class JobRepository extends EntityRepository
{

    public  function getSimilarOpenJobs($postcode,$range,$id = 0,$store)
    {
        $qb = $this->createQueryBuilder('j');
        $qb->innerJoin('j.Address','a','WITH',$qb->expr()->andX(
            $qb->expr()->between('a.postcode', ($postcode - $range), ($postcode + $range)),
            $qb->expr()->neq('a.id', $store)
            ))->where('j.job_state_id = 1')
            ->andWhere('j.id <> '.$id)
            ->orderby('j.end');
        return $qb->getQuery()->getResult();

    }
    public  function getStoreOpenJobs($id,$store)
    {
        $qb = $this->createQueryBuilder('j');
        $qb->innerJoin('j.Address','a','WITH','j.Store s WITH s.id ='.$store)
            ->where('j.job_state_id = 1')
            ->andWhere('j.id <>'.$id)
            ->orderBy('j.end')
            ->getResult();

        return $qb->getQuery()->getResult();

    }
    public  function getStoreOldJobs($id,$store)
    {
        $qb = $this->createQueryBuilder('j');
        $qb->innerJoin('j.Address','a','WITH','j.Store s WITH s.id ='.$store)
            ->where('j.job_state_id = 2')
            ->andWhere('j.id <>'.$id)
            ->orderby('j.end')
            ->get();
        return $qb->getQuery()->getResult();
    }

    public function getOwnJobs($id){

        $qb = $this->createQueryBuilder('j');
        $qb->leftJoin('j.Tasks','t')
            ->innerJoin('t.user','u','WITH',' u.id ='.$id)
            ->where('j.jobState < 2')
            ->orderby('j.end');

        return $qb->getQuery()->getResult();

    }
    public function getCountOwnJobs($id){
        return $this->getOwnJobs($id)->count();

    }


    public function getOpenJobs(){
        $qb = $this->createQueryBuilder('j');
        $qb->leftJoin('j.Tasks','t')
            ->where('t.scheduled IS null ')
            ->andWhere('j.jobState < 2')
            ->orderby('j.end');
        return $qb->getQuery()->getResult();

    }

    public function getCountOpenJobs(){
        return $this->getOpenJobs()->Count();
    }
  // TODO zugeordnete Jobs noch in die Übersihct
    public function getAssignedJobs(){
        $qb = $this->createQueryBuilder('j');
        $qb->leftJoin('j.Tasks','t')
            ->where('t.scheduled IS TRUE')
            ->andWhere('j.job_state_id = 1')
            ->orderby('j.end');
        return $qb->getQuery()->getResult();

    }





    public function getSheduledJobs(){
        $qb = $this->createQueryBuilder('j');
        $qb->leftJoin('j.Tasks','t')
            ->leftJoin('j.JobUser','ju')
            ->where('t.scheduled IS TRUE OR j.id = ju.job_id')
            ->andWhere('j.job_state_id = 1')
            ->orderby('j.end');
        return $qb->getQuery()->getResult();

    }
    public function getCountSheduledJobs(){
        return $this->getSheduledJobs()->count();
    }

    public function getSheduledJobsByUser($UserID){
        $qb = $this->createQueryBuilder('j');
        $qb->leftJoin('j.Tasks','t' )
            ->innerJoin('t.user','u','WITH',' u.id ='.$UserID)
            ->where($qb->expr()->isNull('t.scheduled'))
            ->andWhere('j.jobState = 1')
            ->orderby('j.end');
        return $qb->getQuery()->getResult();

    }

    public function getCountSheduledJobsByUser($UserID){
        return 	$this->getSheduledJobsByUser($UserID)->count();
    }

    public function getWorkedJobs(){
        $qb = $this->createQueryBuilder('j');
        $qb->leftJoin('j.Tasks','t')
            ->leftJoin('j.Invoices','i','WITH','i.id is null')
            ->where('t.scheduled IS NOT TRUE')
            ->andWhere('j.job_state_id = 1')
            ->orderby('j.end');
        return $qb->getQuery()->getResult();
    }


    public function getCountWorkedJobs(){
        return $this->getWorkedJobs()->count();
    }

    public function getWorkedJobsByUser($UserID){
        $qb = $this->createQueryBuilder('j');
        $qb->leftJoin('j.Tasks','t')
            ->innerJoin('t.TaskUser','u','ON',' t.id = u.task_id AND u.user_id ='.$UserID )
            ->leftJoin('j.Invoices','i','ON','i.id is null   ')
            ->where('t.scheduled IS NOT TRUE')
            ->andWhere('j.job_state_id = 1')
            ->orderby('j.end');
        return $qb->getQuery()->getResult();
    }

    public function getCountWorkedJobsByUser($UserID){
        return  $this->getWorkedJobsByUser($UserID)->count();
    }

    public function getFinishedJobs(){
        $qb = $this->createQueryBuilder('j');
        $qb->leftJoin('j.Invoices','i')
            ->andWhere('i.id is null ')
            ->orderby('j.id');
        return $qb->getQuery()->getResult();

    }
    public function getCountFinishedJobs(){
        return
            $this->getFinishedJobs()->count();
    }
    public function getCompletedJobs(){
        $qb = $this->createQueryBuilder('j');
        $qb->where('j.job_state_id = 2')
            ->leftJoin('j.Invoices','i','ON','i.id is not null   ')
            ->orderby('j.end');
        return $qb->getQuery()->getResult();

    }

    public function getCountCompletedJobs(){
        return  $this->getCountCompletedJobs()->count();
    }

}
