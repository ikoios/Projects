<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_name = null;

    #[ORM\Column(nullable: true)]
    private ?int $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $identifier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    /**
     * @var Collection<int, Address>
     */
    #[ORM\OneToMany(targetEntity: Address::class, mappedBy: 'user')]
    private Collection $address;

    /**
     * @var Collection<int, Tasks>
     */
    #[ORM\ManyToMany(targetEntity: Tasks::class, inversedBy: 'user')]
    private Collection $task;

    /**
     * @var Collection<int, Roles>
     */
    #[ORM\ManyToMany(targetEntity: Roles::class, mappedBy: 'user')]
    private Collection $role;

    #[ORM\ManyToOne(inversedBy: 'user')]
    private ?ContactList $contactList = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    private ?Groups $groups = null;

    public function __construct()
    {
        $this->address = new ArrayCollection();
        $this->task = new ArrayCollection();
        $this->role = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->address->contains($address)) {
            $this->address->add($address);
            $address->setUsers($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        if ($this->address->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUsers() === $this) {
                $address->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getTask(): Collection
    {
        return $this->task;
    }

    public function addTask(Tasks $task): static
    {
        if (!$this->task->contains($task)) {
            $this->task->add($task);
        }

        return $this;
    }

    public function removeTask(Tasks $task): static
    {
        $this->task->removeElement($task);

        return $this;
    }

    /**
     * @return Collection<int, Roles>
     */
    public function getRoles(): Collection
    {
        return $this->role;
    }

    public function addRole(Roles $role): static
    {
        if (!$this->role->contains($role)) {
            $this->role->add($role);
            $role->addUser($this);
        }

        return $this;
    }

    public function removeRole(Roles $role): static
    {
        if ($this->role->removeElement($role)) {
            $role->removeUser($this);
        }

        return $this;
    }

    public function getContactList(): ?ContactList
    {
        return $this->contactList;
    }

    public function setContactList(?ContactList $contactList): static
    {
        $this->contactList = $contactList;

        return $this;
    }

    public function getGroups(): ?Groups
    {
        return $this->groups;
    }

    public function setGroups(?Groups $groups): static
    {
        $this->groups = $groups;

        return $this;
    }
}
