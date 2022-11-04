<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserGroup
 *
 * @ORM\Table(name="user_group")
 * @ORM\Entity
 */
#[ApiResource]
class UserGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    #[Assert\NotNull]
    #[Assert\Length(
        min: 6,
        max: 255,
        minMessage: 'Le libellé doit contenir au moins {{limit}} caractères',
        maxMessage: 'Le libellé doit contenir moins de {{limit}} caractères'
    )]
    private string $label;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    #[Assert\NotNull]
    private DateTime $createdAt;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    #[Assert\NotNull]
    private bool $active;

    /**
     * @var Collection<Media>
     *
     * @ORM\ManyToMany(targetEntity="Media", mappedBy="userType")
     */
    private Collection $media;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->media = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserGroup
     */
    public function setId(int $id): UserGroup
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return UserGroup
     */
    public function setLabel(string $label): UserGroup
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return UserGroup
     */
    public function setCreatedAt(DateTime $createdAt): UserGroup
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return UserGroup
     */
    public function setUpdatedAt(?DateTime $updatedAt): UserGroup
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return UserGroup
     */
    public function setActive(bool $active): UserGroup
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media[] = $medium;
            $medium->addUserGroup($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            $medium->removeUserGroup($this);
        }

        return $this;
    }

}
