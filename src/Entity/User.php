<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="login_UNIQUE", columns={"login"})},
 *     indexes={@ORM\Index(name="fk_user_user_group1_idx", columns={"user_group_id"})})
 * @ORM\Entity
 */
#[ApiResource]
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=30, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 6,
        max: 30,
        minMessage: 'Votre identifiant doit contenir au moins {{limit}} caractères',
        maxMessage: 'Votre identifiant doit contenir moins de {{limit}} caractères'
    )]
    private string $login;

    /**
     * @var array<string>
     *
     * @ORM\Column(name="roles", type="json", nullable=false)
     */
    #[Assert\NotNull]
    #[Assert\Type('array')]
    private array $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Length(
        min: 12,
        max: 30,
        minMessage: 'Votre mot de passe doit contenir au moins {{limit}} caractères',
        maxMessage: 'Votre mot de passe doit contenir moins de {{limit}} caractères'
    )]
    private string $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    /**
     * @var string
     *
     * @ORM\Column(name="civility", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Choice(['Mr', 'Mme', 'Mlle'])]
    private string $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Votre nom doit contenir au moins {{limit}} caractères',
        maxMessage: 'Votre nom doit contenir moins de {{limit}} caractères'
    )]
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 255,
        minMessage: 'Votre prénom doit contenir au moins {{limit}} caractères',
        maxMessage: 'Votre prénom doit contenir moins de {{limit}} caractères'
    )]
    private string $firstname;

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
     * @var UserGroup
     *
     * @ORM\OneToOne(targetEntity="UserGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_group_id", referencedColumnName="id")
     * })
     */
    private UserGroup $userGroup;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<string> $roles
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getCivility(): string
    {
        return $this->civility;
    }

    /**
     * @param string $civility
     * @return User
     */
    public function setCivility(string $civility): User
    {
        $this->civility = $civility;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
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
     * @return User
     */
    public function setCreatedAt(DateTime $createdAt): User
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
     * @return User
     */
    public function setUpdatedAt(?DateTime $updatedAt): User
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
     * @return User
     */
    public function setActive(bool $active): User
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return UserGroup
     */
    public function getUserGroup(): UserGroup
    {
        return $this->userGroup;
    }

    /**
     * @param UserGroup $userGroup
     * @return User
     */
    public function setUserGroup(UserGroup $userGroup): User
    {
        $this->userGroup = $userGroup;
        return $this;
    }

}
