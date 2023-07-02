<?php declare(strict_types=1);

namespace Sas\CustomForm\Struct\Request;

use Shopware\Core\Framework\Struct\Struct;
use Symfony\Component\HttpFoundation\FileBag;

class SacCustomFormStruct extends Struct
{

    protected ?string $mediaId;

    protected string $firstName;

    protected string $lastName;

    protected ?string $phoneNumber;

    protected string $company;

    protected string $email;

    protected ?string $street;

    protected ?string $streetNumber;

    protected ?string $postalCode;

    protected ?string $country;

    protected ?string $city;

    protected ?string $description;

    protected ?FileBag $files;

    public function __construct(array $data,FileBag $file)
    {
        $this->firstName = $data['firstName'] ?? "" ?: null;
        $this->lastName = $data['lastName'] ?? "" ?: null;
        $this->phoneNumber = $data['phoneNumber'] ?? "" ?: null;
        $this->company = $data['company'] ?? "" ?: null;
        $this->email = $data['email'] ?? "" ?: null;
        $this->street = $data['street'] ?? "" ?: null;
        $this->streetNumber = $data['streetNumber'] ?? "" ?: null;
        $this->postalCode = $data['postalCode'] ?? "" ?: null;
        $this->country = $data['postalCode'] ?? "" ?: null;
        $this->city = $data['city'] ?? "" ?: null;
        $this->description = $data['description'] ?? "" ?: null;
        $this->files = $file->get('files') ? $file : null;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     */
    public function setCompany(?string $company)
    {
        $this->company = $company;
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
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     */
    public function setStreet(?string $street)
    {
        $this->street = $street;
    }

    /**
     * @return string|null
     */
    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    /**
     * @param string|null $streetNumber
     */
    public function setStreetNumber(?string $streetNumber)
    {
        $this->streetNumber = $streetNumber;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     */
    public function setPostalCode(?string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city)
    {
        $this->city = $city;
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
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    /**
     * @return FileBag|null
     */
    public function getFiles(): ?FileBag
    {
        return $this->files;
    }

    /**
     * @param FileBag|null $files
     */
    public function setFiles(?FileBag $files)
    {
        $this->files = $files;
    }


    /**
     * @return string|null
     */
    public function getMediaId(): ?string
    {
        return $this->mediaId;
    }

    /**
     * @param string|null $mediaId
     */
    public function setMediaId(?string $mediaId)
    {
        $this->mediaId = $mediaId;
    }
}
