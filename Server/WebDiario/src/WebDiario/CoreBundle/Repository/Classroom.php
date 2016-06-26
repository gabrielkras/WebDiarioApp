<?php

namespace WebDiario\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use WebDiario\CoreBundle\Entity\Professors;
use WebDiario\CoreBundle\Entity\Students;

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

    public function findAllSubjectsByStudent(Students $student)
    {
        $query = $this->createQueryBuilder('c')
            ->select('c','p','s','co','st')
            ->innerJoin('c.professor', 'p')
            ->innerJoin('c.subject','s')
            ->innerJoin('c.course', "co")
            ->leftJoin("c.students","st")
            ->where("st.id  = :id")
            ->setParameter('id',$student)
            ->groupBy("c.id")
            ->getQuery();
        return $query->getArrayResult();
    }

}