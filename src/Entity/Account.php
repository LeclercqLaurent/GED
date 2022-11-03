<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Account
 *
 * @ORM\Table(name="account", uniqueConstraints={@ORM\UniqueConstraint(name="login_UNIQUE", columns={"login"})})
 * @ORM\Entity
 */
#[ApiResource]
class Account
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
     * @ORM\Column(name="login", type="string", length=30, nullable=false)
     */
    #[Assert\NotNull]
    #[Assert\Length(
        min: 6,
        max: 30,
        minMessage: 'Votre identifiant doit contenir au moins {{limit}} caractères',
        maxMessage: 'Votre identifiant doit contenir moins de {{limit}} caractères'
    )]
    private string $login;

    /**
     * @var array
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
    #[Assert\NotNull]
    #[Assert\Email]
    private string $email;

    /**
     * @var string
     *
     * @ORM\Column(name="civility", type="string", length=255, nullable=false)
     */
    #[Assert\NotNull]
    #[Assert\Choice(['Mr', 'Mme', 'Mlle'])]
    private string $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    #[Assert\NotNull]
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
    #[Assert\NotNull]
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Account
     */
    public function setId(int $id): Account
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
     * @return Account
     */
    public function setLogin(string $login): Account
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return Account
     */
    public function setRoles(array $roles): Account
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
     * @return Account
     */
    public function setPassword(string $password): Account
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
     * @return Account
     */
    public function setEmail(string $email): Account
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
     * @return Account
     */
    public function setCivility(string $civility): Account
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
     * @return Account
     */
    public function setName(string $name): Account
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
     * @return Account
     */
    public function setFirstname(string $firstname): Account
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
     * @return Account
     */
    public function setCreatedAt(DateTime $createdAt): Account
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
     * @return Account
     */
    public function setUpdatedAt(?DateTime $updatedAt): Account
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
     * @return Account
     */
    public function setActive(bool $active): Account
    {
        $this->active = $active;
        return $this;
    }

}
