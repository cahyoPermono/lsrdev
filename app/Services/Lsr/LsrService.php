<?php

namespace App\Services\Lsr;

use Illuminate\Support\Facades\Storage;

class LsrService
{
    /**
     * Get all companies from JSON file
     */
    public function getCompanies()
    {
        $jsonContent = Storage::get('dummy-data/lsr/companies.json');
        $companies = json_decode($jsonContent, true);

        // Ensure we return an array even if JSON is empty or invalid
        return is_array($companies) ? $companies : [];
    }

    /**
     * Get all blocks from JSON file
     */
    public function getBlocks()
    {
        $jsonContent = Storage::get('dummy-data/lsr/blocks.json');
        $blocks = json_decode($jsonContent, true);

        // Ensure we return an array even if JSON is empty or invalid
        return is_array($blocks) ? $blocks : [];
    }

    /**
     * Get all areas from JSON file
     */
    public function getAreas()
    {
        $jsonContent = Storage::get('dummy-data/lsr/areas.json');
        return json_decode($jsonContent, true);
    }

    /**
     * Get all locations from JSON file
     */
    public function getLocations()
    {
        $jsonContent = Storage::get('dummy-data/lsr/locations.json');
        return json_decode($jsonContent, true);
    }

    /**
     * Get all functions from JSON file
     */
    public function getFunctions()
    {
        $jsonContent = Storage::get('dummy-data/lsr/functions.json');
        return json_decode($jsonContent, true);
    }

    /**
     * Get all categories from JSON file
     */
    public function getCategories()
    {
        $jsonContent = Storage::get('dummy-data/lsr/categories.json');
        return json_decode($jsonContent, true);
    }

    /**
     * Get all work verifiers from JSON file
     */
    public function getWorkVerifiers()
    {
        $jsonContent = Storage::get('dummy-data/lsr/work-verifiers.json');
        return json_decode($jsonContent, true);
    }

    /**
     * Get all questionnaires from JSON file
     */
    public function getQuestionnaires()
    {
        $jsonContent = Storage::get('dummy-data/lsr/questionnaires.json');
        return json_decode($jsonContent, true);
    }

    /**
     * Get submissions with optional filtering
     */
    public function getSubmissions($filters = [])
    {
        $jsonContent = Storage::get('dummy-data/lsr/submissions.json');
        $submissions = json_decode($jsonContent, true);

        // Ensure we return an array even if JSON is empty or invalid
        if (!is_array($submissions)) {
            $submissions = [];
        }

        // Apply filters if provided
        if (!empty($filters)) {
            $submissions = $this->applySubmissionFilters($submissions, $filters);
        }

        return $submissions;
    }

    /**
     * Create new submission
     */
    public function createSubmission($data)
    {
        // Get existing submissions
        $jsonContent = Storage::get('dummy-data/lsr/submissions.json');
        $submissions = json_decode($jsonContent, true);

        // Ensure we return an array even if JSON is empty or invalid
        if (!is_array($submissions)) {
            $submissions = [];
        }

        // Generate new ID
        $newId = count($submissions) > 0 ? max(array_column($submissions, 'id')) + 1 : 1;

        // Create new submission
        $newSubmission = [
            'id' => $newId,
            'user_id' => $data['user_id'] ?? 1, // Default to user ID 1 if not provided
            'company_id' => $data['company_id'],
            'block_id' => $data['block_id'],
            'area_id' => $data['area_field'], // Note: using area_field as per your request
            'location_id' => $data['location'],
            'function_id' => $data['function'],
            'ptw_number' => $data['ptw_number'],
            'activity_description' => $data['activity_description'],
            'categories' => $data['categorys'], // Note: using categorys as per your request
            'start_work_verifier_id' => $data['start_work_verifier_id'],
            'questionnaires' => isset($data['questionnaires']) ? $data['questionnaires'] : [],
            'status' => 'need_stage_2',
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString()
        ];

        // Add to submissions array
        $submissions[] = $newSubmission;

        // Save back to file
        Storage::put('dummy-data/lsr/submissions.json', json_encode($submissions, JSON_PRETTY_PRINT));

        return $newSubmission;
    }

    /**
     * Update submission with new questionnaires and status
     */
    public function updateSubmission($submissionId, $newQuestionnaires)
    {
        // Get existing submissions
        $jsonContent = Storage::get('dummy-data/lsr/submissions.json');
        $submissions = json_decode($jsonContent, true);

        // Ensure we return an array even if JSON is empty or invalid
        if (!is_array($submissions)) {
            $submissions = [];
        }

        // Find the submission by ID
        $submissionIndex = null;
        foreach ($submissions as $index => $submission) {
            if ($submission['id'] == $submissionId) {
                $submissionIndex = $index;
                break;
            }
        }

        // If submission not found, return null
        if ($submissionIndex === null) {
            return null;
        }

        // Update the submission
        $submissions[$submissionIndex]['questionnaires'] = $newQuestionnaires;
        $submissions[$submissionIndex]['status'] = 'verified_stage_2';
        $submissions[$submissionIndex]['updated_at'] = now()->toISOString();

        // Save back to file
        Storage::put('dummy-data/lsr/submissions.json', json_encode($submissions, JSON_PRETTY_PRINT));

        return $submissions[$submissionIndex];
    }

    /**
     * Update submission status to not_comply_stage_2
     */
    public function updateSubmissionStatus($submissionId, $reason = null)
    {
        // Get existing submissions
        $jsonContent = Storage::get('dummy-data/lsr/submissions.json');
        $submissions = json_decode($jsonContent, true);

        // Ensure we return an array even if JSON is empty or invalid
        if (!is_array($submissions)) {
            $submissions = [];
        }

        // Find the submission by ID
        $submissionIndex = null;
        foreach ($submissions as $index => $submission) {
            if ($submission['id'] == $submissionId) {
                $submissionIndex = $index;
                break;
            }
        }

        // If submission not found, return null
        if ($submissionIndex === null) {
            return null;
        }

        // Update the submission status
        $submissions[$submissionIndex]['status'] = 'not_comply_stage_2';
        $submissions[$submissionIndex]['not_comply_reason'] = $reason;
        $submissions[$submissionIndex]['updated_at'] = now()->toISOString();

        // Save back to file
        Storage::put('dummy-data/lsr/submissions.json', json_encode($submissions, JSON_PRETTY_PRINT));

        return $submissions[$submissionIndex];
    }

    /**
     * Apply filters to submissions
     */
    private function applySubmissionFilters($submissions, $filters)
    {
        return array_filter($submissions, function($submission) use ($filters) {
            // Filter by status
            if (!empty($filters['status']) && $submission['status'] !== $filters['status']) {
                return false;
            }

            // Filter by work verifier
            if (!empty($filters['work_verifier_id']) &&
                $submission['start_work_verifier_id'] != $filters['work_verifier_id']) {
                return false;
            }

            return true;
        });
    }

    // Future production methods (for easy migration)

    /**
     * Production: Get companies from external API
     */
    public function getCompaniesFromApi()
    {
        // return Http::get(config('api.lsr.companies_url'))->json();
        return $this->getCompanies(); // Currently using dummy data
    }

    /**
     * Production: Create submission via external API
     */
    public function createSubmissionViaApi($data)
    {
        // return Http::post(config('api.lsr.submissions_url'), $data)->json();
        return $this->createSubmission($data); // Currently using dummy data
    }
}
