<?php


namespace App\Gateway;


class PaymentGateway
{
    private $description;
    private $price;
    private $currency;
    private $quantity;
    private $email;
    private $surname;
    private $lastname;

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
}
