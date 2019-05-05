<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *
     * Regexp list allows:
     *      - Unicode characters range а-я
     *      - Unicode character ё
     *      - Space
     *      - Any kind of punctuation character
     *      - Letters range a-z
     *      - Numbers range 0-9
     * Modifiers:
     *      - i - insensitive
     *      - u - unicode
     * @Assert\Regex(pattern="/^[\x{0430}-\x{044F}\x{0451} \p{P}a-z0-9]+$/iu")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Image(minWidth = 130, maxWidth = 130, minHeight = 100, maxHeight = 100)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Image(minWidth = 800, maxWidth = 800)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(protocols = {"http", "https"}, relativeProtocol = false)
     */
    private $url;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
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
