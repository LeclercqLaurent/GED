<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity
 */
#[ApiResource]
class Media
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
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    #[Assert\Length(
        min: 5,
        max: 65535,
        minMessage: 'Votre libellé doit contenir au moins {{limit}} caractères',
        maxMessage: 'Votre libellé doit contenir moins de {{limit}} caractères'
    )]
    private ?string $description;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Le chemin vers le fichier doit contenir au moins {{limit}} caractères',
        maxMessage: 'Le chemin vers le fichier doit contenir moins de {{limit}} caractères'
    )]
    private string $path;

    /**
     * @var string
     *
     * @ORM\Column(name="mime_type", type="string", length=255, nullable=false)
     */
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Le type doit contenir au moins {{limit}} caractères',
        maxMessage: 'Le type doit contenir moins de {{limit}} caractères'
    )]
    private string $mimeType;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer", nullable=false, options={"unsigned"=true})
     */
    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    private int $size;

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
     * @var Collection<UserGroup>
     *
     * @ORM\ManyToMany(targetEntity="UserGroup", inversedBy="media")
     * @ORM\JoinTable(name="media_has_user_group",
     *   joinColumns={
     *     @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_group_id", referencedColumnName="id")
     *   }
     * )
     */
    private Collection $userGroup;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userGroup = new ArrayCollection();
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
     * @return Media
     */
    public function setId(int $id): Media
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
     * @return Media
     */
    public function setLabel(string $label): Media
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Media
     */
    public function setDescription(?string $description): Media
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Media
     */
    public function setPath(string $path): Media
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     * @return Media
     */
    public function setMimeType(string $mimeType): Media
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return Media
     */
    public function setSize(int $size): Media
    {
        $this->size = $size;
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
     * @return Media
     */
    public function setCreatedAt(DateTime $createdAt): Media
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
     * @return Media
     */
    public function setUpdatedAt(?DateTime $updatedAt): Media
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
     * @return Media
     */
    public function setActive(bool $active): Media
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return Collection|UserGroup[]
     */
    public function getUserGroup(): Collection|UserGroup
    {
        return $this->userGroup;
    }

    public function addUserGroup(UserGroup $userGroup): self
    {
        if (!$this->userGroup->contains($userGroup)) {
            $this->userGroup[] = $userGroup;
        }

        return $this;
    }

    public function removeUserGroup(UserGroup $userGroup): self
    {
        $this->userGroup->removeElement($userGroup);

        return $this;
    }

}
