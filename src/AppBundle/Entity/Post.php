<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\PostController;
#use Symfony\Component\Validator\Constraints as Assert;
#use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $text;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=200)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $parent;

     /**
     * @ORM\Column(type="string", length=20)
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $updated;

    /**
     * @ORM\Column(type="integer", length=100)
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $deleted;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $contains_img;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $countSubPosts;

    private $createdTime;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getContainsImg()
    {
        return $this->contains_img;
    }

    /**
     * @param mixed $contains_img
     */
    public function setContainsImg($contains_img)
    {
        $this->contains_img = $contains_img;
    }

    /**
     * @return mixed
     */
    public function getCreatedTime()
    {
        $PostController = new PostController();
        return $PostController->time_elapsed_string($this->created);
    }

    /**
     * @return mixed
     */
    public function getCountSubPosts()
    {
        return $this->countSubPosts;
    }

    /**
     * @param mixed $countSubPosts
     */
    public function setCountSubPosts($countSubPosts)
    {
        $this->countSubPosts = $countSubPosts;
    }


}