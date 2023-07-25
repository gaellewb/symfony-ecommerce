<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class UsersSettings
{
    #[Assert\Timezone]
    protected string $timezone;
}