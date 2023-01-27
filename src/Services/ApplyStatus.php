<?php

namespace App\Services;

use App\Entity\Recruiter;

class ApplyStatus
{
    public function sumApplicationStatus(Recruiter $recruiter, ?string $status): int
    {
        $sumApplicationStatus = 0;

        foreach ($recruiter->getOffers() as $offer) {
            foreach ($offer->getApplications() as $application) {
                if ($application->getApplicationStatus() === $status) {
                    $sumApplicationStatus++;
                }
            }
        }

        return $sumApplicationStatus;
    }

    public function sumApplicationNoStatus(Recruiter $recruiter): int
    {
        $sumApplyNoStatus = 0;

        foreach ($recruiter->getOffers() as $offer) {
            if ($offer->getApplications()->isEmpty()) {
                $sumApplyNoStatus++;
            }
        }

        return $sumApplyNoStatus;
    }
}
