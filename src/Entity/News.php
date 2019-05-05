<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class News {
    use SoftDeleteableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    public function getId():?int {
        return $this->id;
    }

    public function getCreated():?\DateTimeInterface {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created):self {
        $this->created = $created;

        return $this;
    }

    public function getTitle():?string {
        return $this->title;
    }

    public function setTitle(string $title):self {
        $this->title = $title;

        return $this;
    }

    public function getThumbnail():?string {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail):self {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getImage():?string {
        return $this->image;
    }

    public function setImage(string $image):self {
        $this->image = $image;

        return $this;
    }

    public function getUrl():?string {
        return $this->url;
    }

    public function setUrl(string $url):self {
        $this->url = $url;

        return $this;
    }

    public function getText():?string {
        return $this->text;
    }

    public function setText(string $text):self {
        $this->text = $text;

        return $this;
    }
}
