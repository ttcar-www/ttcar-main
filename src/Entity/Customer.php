<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
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
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress_ue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress_no_ue;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdays_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country_birth;

    /**
     * @ORM\ManyToOne(targetEntity=Nationality::class, inversedBy="order")
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pice_identity;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_piece;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $delivery_piece;

    /**
     * @ORM\ManyToOne(targetEntity=Reason::class, inversedBy="order")
     */
    private $reason;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_young;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="customer", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     */
    private $date_piece;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="customer_country")
     */
    private $adress_country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress_city;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="customer_country_hue")
     */
    private $adress_country_hue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress_city_hue;

    /**
     * @ORM\Column(type="integer")
     */
    private $adress_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $adress_code_hue;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customer_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $birth_postal;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdressUe(): ?string
    {
        return $this->adress_ue;
    }

    public function setAdressUe(string $adress_ue): self
    {
        $this->adress_ue = $adress_ue;

        return $this;
    }

    public function getAdressNoUe(): ?string
    {
        return $this->adress_no_ue;
    }

    public function setAdressNoUe(string $adress_no_ue): self
    {
        $this->adress_no_ue = $adress_no_ue;

        return $this;
    }

    public function getBirthdaysDate(): ?\DateTimeInterface
    {
        return $this->birthdays_date;
    }

    public function setBirthdaysDate(\DateTimeInterface $birthdays_date): self
    {
        $this->birthdays_date = $birthdays_date;

        return $this;
    }

    public function getCountryBirth(): ?string
    {
        return $this->country_birth;
    }

    public function setCountryBirth(string $country_birth): self
    {
        $this->country_birth = $country_birth;

        return $this;
    }


    public function getPiceIdentity(): ?string
    {
        return $this->pice_identity;
    }

    public function setPiceIdentity(string $pice_identity): self
    {
        $this->pice_identity = $pice_identity;

        return $this;
    }

    public function getNumberPiece(): ?int
    {
        return $this->number_piece;
    }

    public function setNumberPiece(int $number_piece): self
    {
        $this->number_piece = $number_piece;

        return $this;
    }

    public function getDeliveryPiece(): ?string
    {
        return $this->delivery_piece;
    }

    public function setDeliveryPiece(string $delivery_piece): self
    {
        $this->delivery_piece = $delivery_piece;

        return $this;
    }

    public function getNameYoung(): ?string
    {
        return $this->name_young;
    }

    public function setNameYoung(string $name_young): self
    {
        $this->name_young = $name_young;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDatePiece()
    {
        return $this->date_piece;
    }

    /**
     * @param mixed $date_piece
     */
    public function setDatePiece($date_piece): void
    {
        $this->date_piece = $date_piece;
    }


    /**
     * @return mixed
     */
    public function getAdressCity()
    {
        return $this->adress_city;
    }

    /**
     * @param mixed $adress_city
     */
    public function setAdressCity($adress_city): void
    {
        $this->adress_city = $adress_city;
    }

    /**
     * @return mixed
     */
    public function getAdressCode()
    {
        return $this->adress_code;
    }

    /**
     * @param mixed $adress_code
     */
    public function setAdressCode($adress_code): void
    {
        $this->adress_code = $adress_code;
    }

    /**
     * @return mixed
     */
    public function getAdressCodeHue()
    {
        return $this->adress_code_hue;
    }

    /**
     * @param mixed $adress_code_hue
     */
    public function setAdressCodeHue($adress_code_hue): void
    {
        $this->adress_code_hue = $adress_code_hue;
    }


    /**
     * @return mixed
     */
    public function getAdressCityHue()
    {
        return $this->adress_city_hue;
    }

    /**
     * @param mixed $adress_city_hue
     */
    public function setAdressCityHue($adress_city_hue): void
    {
        $this->adress_city_hue = $adress_city_hue;
    }


    /**
     * @return mixed
     */
    public function getCustomerType()
    {
        return $this->customer_type;
    }

    /**
     * @param mixed $customer_type
     */
    public function setCustomerType($customer_type): void
    {
        $this->customer_type = $customer_type;
    }


    /**
     * @return mixed
     */
    public function getBirthPostal()
    {
        return $this->birth_postal;
    }

    /**
     * @param mixed $birth_postal
     */
    public function setBirthPostal($birth_postal): void
    {
        $this->birth_postal = $birth_postal;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality): void
    {
        $this->nationality = $nationality;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @return mixed
     */
    public function getAdressCountry()
    {
        return $this->adress_country;
    }

    /**
     * @param mixed $adress_country
     */
    public function setAdressCountry($adress_country): void
    {
        $this->adress_country = $adress_country;
    }

    /**
     * @return mixed
     */
    public function getAdressCountryHue()
    {
        return $this->adress_country_hue;
    }

    /**
     * @param mixed $adress_country_hue
     */
    public function setAdressCountryHue($adress_country_hue): void
    {
        $this->adress_country_hue = $adress_country_hue;
    }

}
