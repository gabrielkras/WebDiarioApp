<?php

namespace WebDiario\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use WebDiario\CoreBundle\Entity\Professors;

class Classroom extends EntityRepository
{
    public function findAllSubjectsByProfessor(Professors $professors)
    {
        $query = $this->createQueryBuilder('c')
            ->select('c','p','s','co','st')
            ->innerJoin('c.professor', 'p')
            ->innerJoin('c.subject','s')
            ->innerJoin('c.course', "co")
            ->innerJoin("c.students",'st')
            ->where('c.professor = :id')
            ->setParameter('id',$professors)
            ->getQuery();
        return $query->getArrayResult();
    }

}