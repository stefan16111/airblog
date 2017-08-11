<?php

namespace AirblogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AirblogBundle\Repository\TagRepository")
 * @ORM\Table(name="blog_tags")
 */
class Tag extends AbstractTaxonomy {

    /**
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags")
     */
    protected $posts;

}
