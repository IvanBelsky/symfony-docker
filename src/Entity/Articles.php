<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $text_art;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $foto;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="articles")
     */
    private $id_comment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->id_comment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTextArt(): ?string
    {
        return $this->text_art;
    }

    public function setTextArt(string $text_art): self
    {
        $this->text_art = $text_art;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getIdComment(): Collection
    {
        return $this->id_comment;
    }

    public function addIdComment(Comment $idComment): self
    {
        if (!$this->id_comment->contains($idComment)) {
            $this->id_comment[] = $idComment;
            $idComment->setArticles($this);
        }

        return $this;
    }

    public function removeIdComment(Comment $idComment): self
    {
        if ($this->id_comment->removeElement($idComment)) {
            // set the owning side to null (unless already changed)
            if ($idComment->getArticles() === $this) {
                $idComment->setArticles(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
