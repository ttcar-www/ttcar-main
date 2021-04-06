<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use App\Validator as AcmeAssert;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $create_date;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $place_plane;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $car_libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customer_type;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(
     *      min =2,
     *      max = 35,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $customer_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min =2,
     *      max = 35,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $customer_old_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min =2,
     *      max = 35,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $customer_username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *      max = 5,
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $postal_code;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="order")
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=Nationality::class, inversedBy="order")
     */
    private $nationality;

    /**
     * @ORM\Column(type="date")
     */
    private $birth_date;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *      max = 5,
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $birth_postal;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(
     *      min =2,
     *      max = 30,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $birth_city;

    /**
     * @Assert\Length(
     *      min =2,
     *      max = 30,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $birth_country;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *      min =8,
     *      max = 10,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $passport_number;

    /**
     * @ORM\Column(type="date")
     */
    private $passport_date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min =2,
     *      max = 30,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $passport_place;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $depart_place;

    /**
     * @ORM\Column(type="integer")
     */
    private $depart_price;

    /**
     * @ORM\Column(type="date")
     */
    private $depart_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $return_place;

    /**
     * @ORM\Column(type="integer")
     */
    private $return_price;

    /**
     * @ORM\Column(type="date")
     */
    private $return_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $basic_price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $promotions;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lang;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min =2,
     *      max = 30,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $adress_more;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min =2,
     *      max = 30,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $adress_more_noUe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min =8,
     *      max = 27,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $adress_no_ue;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="orderNoUe")
     */
    private $adress_country_hue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min =2,
     *      max = 30,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $adress_city_hue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Assert\Length(
     *      min =5,
     *      max = 8,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $adress_code_hue;

    /**
     * @ORM\ManyToOne(targetEntity=Reason::class, inversedBy="order")
     */
    private $reason;

    /**
     * @ORM\Column(type="array")
     */
    protected $items;

    /**
     * @ORM\Column(type="string")
     */
    private $planeDate2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $number_plane;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      min =2,
     *      max = 255,
     *      minMessage = "Vous devez entrer minimum {{ limit }} charactères",
     *      maxMessage = "Vous ne pouvez pas entrer plus de {{ limit }} charactères"
     * )
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profession;

    /**
     * @return mixed
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @param mixed $profession
     */
    public function setProfession($profession): void
    {
        $this->profession = $profession;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mark;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $promo_libelle;

    /**
     * @return mixed
     */
    public function getPromoLibelle()
    {
        return $this->promo_libelle;
    }

    /**
     * @param mixed $promo_libelle
     */
    public function setPromoLibelle($promo_libelle): void
    {
        $this->promo_libelle = $promo_libelle;
    }

    /**
     * @return mixed
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param mixed $mark
     */
    public function setMark($mark): void
    {
        $this->mark = $mark;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $count_days;

    /**
     * @return mixed
     */
    public function getCountDays()
    {
        return $this->count_days;
    }

    /**
     * @param mixed $count_days
     */
    public function setCountDays($count_days): void
    {
        $this->count_days = $count_days;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getNumberPlane()
    {
        return $this->number_plane;
    }

    /**
     * @param mixed $number_plane
     */
    public function setNumberPlane($number_plane): void
    {
        $this->number_plane = $number_plane;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(\DateTimeInterface $create_date): self
    {
        $this->create_date = $create_date;

        return $this;
    }


    public function getPlacePlane(): ?string
    {
        return $this->place_plane;
    }

    public function setPlacePlane(string $place_plane): self
    {
        $this->place_plane = $place_plane;

        return $this;
    }

    public function getCustomerType(): ?string
    {
        return $this->customer_type;
    }

    public function setCustomerType(string $customer_type): self
    {
        $this->customer_type = $customer_type;

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function setCustomerName(string $customer_name): self
    {
        $this->customer_name = $customer_name;

        return $this;
    }

    public function getCustomerOldName(): ?string
    {
        return $this->customer_old_name;
    }

    public function setCustomerOldName(?string $customer_old_name): self
    {
        $this->customer_old_name = $customer_old_name;

        return $this;
    }

    public function getCustomerUsername(): ?string
    {
        return $this->customer_username;
    }

    public function setCustomerUsername(string $customer_username): self
    {
        $this->customer_username = $customer_username;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(int $postal_code): self
    {
        $this->postal_code = $postal_code;

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

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getBirthPostal(): ?int
    {
        return $this->birth_postal;
    }

    public function setBirthPostal(int $birth_postal): self
    {
        $this->birth_postal = $birth_postal;

        return $this;
    }

    public function getBirthCity(): ?string
    {
        return $this->birth_city;
    }

    public function setBirthCity(string $birth_city): self
    {
        $this->birth_city = $birth_city;

        return $this;
    }

    public function getBirthCountry(): ?string
    {
        return $this->birth_country;
    }

    public function setBirthCountry(string $birth_country): self
    {
        $this->birth_country = $birth_country;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    public function getPassportNumber(): ?int
    {
        return $this->passport_number;
    }

    public function setPassportNumber(int $passport_number): self
    {
        $this->passport_number = $passport_number;

        return $this;
    }

    public function getPassportDate(): ?\DateTimeInterface
    {
        return $this->passport_date;
    }

    public function setPassportDate(\DateTimeInterface $passport_date): self
    {
        $this->passport_date = $passport_date;

        return $this;
    }

    public function getPassportPlace(): ?string
    {
        return $this->passport_place;
    }

    public function setPassportPlace(string $passport_place): self
    {
        $this->passport_place = $passport_place;

        return $this;
    }

    public function getDepartPlace(): ?string
    {
        return $this->depart_place;
    }

    public function setDepartPlace(string $depart_place): self
    {
        $this->depart_place = $depart_place;

        return $this;
    }

    public function getDepartPrice(): ?int
    {
        return $this->depart_price;
    }

    public function setDepartPrice(int $depart_price): self
    {
        $this->depart_price = $depart_price;

        return $this;
    }

    public function getDepartDate(): ?\DateTimeInterface
    {
        return $this->depart_date;
    }

    public function setDepartDate(\DateTimeInterface $depart_date): self
    {
        $this->depart_date = $depart_date;

        return $this;
    }

    public function getReturnPlace(): ?string
    {
        return $this->return_place;
    }

    public function setReturnPlace(string $return_place): self
    {
        $this->return_place = $return_place;

        return $this;
    }

    public function getReturnPrice(): ?int
    {
        return $this->return_price;
    }

    public function setReturnPrice(int $return_price): self
    {
        $this->return_price = $return_price;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->return_date;
    }

    public function setReturnDate(\DateTimeInterface $return_date): self
    {
        $this->return_date = $return_date;

        return $this;
    }

    public function getBasicPrice(): ?int
    {
        return $this->basic_price;
    }

    public function setBasicPrice(int $basic_price): self
    {
        $this->basic_price = $basic_price;

        return $this;
    }

    public function getPromotions(): ?int
    {
        return $this->promotions;
    }

    public function setPromotions(?int $promotions): self
    {
        $this->promotions = $promotions;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


    /**
     * @return mixed
     */
    public function getAdressNoUe()
    {
        return $this->adress_no_ue;
    }

    /**
     * @param mixed $adress_no_ue
     */
    public function setAdressNoUe($adress_no_ue): void
    {
        $this->adress_no_ue = $adress_no_ue;
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
    public function getCarLibelle()
    {
        return $this->car_libelle;
    }

    /**
     * @param mixed $car_libelle
     */
    public function setCarLibelle($car_libelle): void
    {
        $this->car_libelle = $car_libelle;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getPlaneDate2()
    {
        return $this->planeDate2;
    }

    /**
     * @param mixed $planeDate2
     */
    public function setPlaneDate2($planeDate2): void
    {
        $this->planeDate2 = $planeDate2;
    }

    /**
     * @return mixed
     */
    public function getAdressMore()
    {
        return $this->adress_more;
    }

    /**
     * @param mixed $adress_more
     */
    public function setAdressMore($adress_more): void
    {
        $this->adress_more = $adress_more;
    }

    /**
     * @return mixed
     */
    public function getAdressMoreNoUe()
    {
        return $this->adress_more_noUe;
    }

    /**
     * @param mixed $adress_more_noUe
     */
    public function setAdressMoreNoUe($adress_more_noUe): void
    {
        $this->adress_more_noUe = $adress_more_noUe;
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
}
