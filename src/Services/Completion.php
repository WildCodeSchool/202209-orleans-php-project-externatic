<?php

namespace App\Services;

use App\Entity\Candidate;

class Completion
{
    public const NUMBER_OF_ITEMS = 3;
    public function completionProfil(Candidate $candidate): float
    {
        $completionProfil = 0;

        if (!$candidate->getExperiences()->isEmpty()) {
            $completionProfil++;
        }
        if (!$candidate->getSkills()->isEmpty()) {
            $completionProfil++;
        }
        if (!$candidate->getEducation()->isEmpty()) {
            $completionProfil++;
        }
        $completionProfil = ($completionProfil / self::NUMBER_OF_ITEMS) * 100;

        return ceil($completionProfil);
    }
}
