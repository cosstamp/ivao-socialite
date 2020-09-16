<?php


namespace IvaoSocialite;


use ArrayAccess;

class User implements \Laravel\Socialite\Contracts\User, ArrayAccess
{
    private $id;
    private $firstName;
    private $lastName;

    /** @var array */
    private $raw;

    public function __construct(array $raw)
    {
        $this->id = $raw["vid"];
        $this->firstName = $raw["firstname"];
        $this->lastName = $raw["lastname"];
        $this->raw = [
            "vid" => intval($raw["vid"]),
            "firstName" => $raw["firstname"],
            "lastName" => $raw["lastname"],
            "administrativeRating" => $raw["rating"],
            "atcRating" => $raw["ratingatc"],
            "ratingpilot" => $raw["ratingpilot"],
            "division" => $raw["division"],
            "country" => $raw["country"],
            "staff" => explode(":", $raw["staff"])
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNickname()
    {
        return null;
    }

    public function getName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getEmail()
    {
        return null;
    }

    public function getAvatar()
    {
        return null;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->raw);
    }

    public function offsetGet($offset)
    {
        return $this->raw[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->raw[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->raw[$offset]);
    }
}