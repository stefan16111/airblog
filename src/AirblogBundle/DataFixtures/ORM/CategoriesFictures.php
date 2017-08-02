<?php

namespace AirblogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AirblogBundle\Entity\Category;

class CategoryFixtures extends AbstractFixture {

    public function load(ObjectManager $manager) {
        $Category = new Category();
        $Category->setName('nowa kategoria')
                ->setSlug('nowa-kategoria');
        
        $manager->persist($Category);
        
        $Cat2 = new Category();
        
        $Cat2->setName('Kategoria druga')
                ->setSlug('druga_kategoria');
        
        $manager->persist($Cat2);
        
        $manager->flush();
    }

}
