<?php

namespace App\Service;

use App\Entity\Education;
use Doctrine\Common\Collections\Collection;

class VerifyEntity
{
    public function isInCollection(Education $education, Collection $haystack): bool
    {
        $result = false;
        foreach ($haystack as $needle) {
            if ($needle === $education) {
                $result = true;
            }
        }

        return $result;
    }
}
