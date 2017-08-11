<?php

namespace AirblogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository {
    
    public function getTagsListOcc() {
        
        $qb = $this->createQueryBuilder('t')
                ->select('t.slug, t.name, COUNT(p) as occ')
                ->leftJoin('t.posts', 'p')
                ->groupBy('t.name');
        
        return $qb->getQuery()->getArrayResult();
        
    }


}
