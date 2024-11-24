<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['task_read','task_users'])]
    private ?string $identifier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    /**
     * @var Collection<int, Tasks>
     */
    #[ORM\ManyToMany(targetEntity: Tasks::class, mappedBy: 'users')]
    private Collection $tasks;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Address $address = null;

    /**
     * @var Collection<int, Roles>
     */
    #[ORM\ManyToMany(targetEntity: Roles::class, mappedBy: 'user')]
    private Collection $roles;

    /**
     * @var Collection<int, ContactList>
     */
    #[ORM\OneToMany(targetEntity: ContactList::class, mappedBy: 'user')]
    private Collection $contactLists;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'users')]
    private Collection $team;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->contactLists = new ArrayCollection();
        $this->team = new ArrayCollection();
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
     * @return Collection<int, Tasks>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Tasks $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->addUser($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): static
    {
        if ($this->tasks->removeElement($task)) {
            $task->removeUser($this);
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Roles>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Roles $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->addUser($this);
        }

        return $this;
    }

    public function removeRole(Roles $role): static
    {
        if ($this->roles->removeElement($role)) {
            $role->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ContactList>
     */
    public function getContactLists(): Collection
    {
        return $this->contactLists;
    }

    public function addContactList(ContactList $contactList): static
    {
        if (!$this->contactLists->contains($contactList)) {
            $this->contactLists->add($contactList);
            $contactList->setUser($this);
        }

        return $this;
    }

    public function removeContactList(ContactList $contactList): static
    {
        if ($this->contactLists->removeElement($contactList)) {
            // set the owning side to null (unless already changed)
            if ($contactList->getUser() === $this) {
                $contactList->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeam(): Collection
    {
        return $this->team;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->team->contains($team)) {
            $this->team->add($team);
            $team->addUser($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->team->removeElement($team)) {
            $team->removeUser($this);
        }

        return $this;
    }
}
