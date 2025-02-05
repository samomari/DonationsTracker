<?php

namespace App\Service;

use App\Repository\DonationRepository;
use App\Model\Donation;

class DonationService {
    private $donationRepository;
    private $charityService;

    public function __construct(DonationRepository $donationRepository,CharityService $charityService) {
        $this->donationRepository = $donationRepository;
        $this->charityService = $charityService;
    }

    public function addDonation($donorName, $amount, $charityId) {
        // Check if the charity is active
        if (!$this->charityService->isCharityActive($charityId)) {
            return "Cannot add donation to an inactive charity.";
        }

        // Validate the donation amount
        if (!is_numeric($amount) || $amount <= 0) {
            return "Invalid donation amount.";
        }

        $donation = new Donation($donorName, $amount, $charityId, date('Y-m-d H:i:s'));
        $this->donationRepository->addDonation($donation);

        return null; // No error
    }

    public function getAllDonations() {
        return $this->donationRepository->getAllDonations();
    }

    public function viewDonationsByCharity($charityId) {
        return $this->donationRepository->getDonationsByCharityId($charityId);
    }
}