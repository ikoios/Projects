<?php

namespace App\Entity;

use App\Repository\ContactListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactListRepository::class)]
class ContactList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Users>
     */
    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'contactList')]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Users $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setContactList($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getContactList() === $this) {
                $user->setContactList(null);
            }
        }

        return $this;
    }
}
