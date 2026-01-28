<?php

namespace App\Services;

use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\CreateAssessmentRequest;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;

class RecaptchaEnterpriseService
{
    public function verify(string $token, string $action, float $minScore = 0.5): bool
    {
        $credentialsPath = base_path('storage/app/google/abiding-ripple-485604-u0-0ceac760a2d1.json');

        $client = new RecaptchaEnterpriseServiceClient([
            'credentials' => $credentialsPath,
        ]);

        // Event
        $event = (new Event)
            ->setSiteKey(config('services.recaptcha.site_key'))
            ->setToken($token);

        // Assessment
        $assessment = (new Assessment)
            ->setEvent($event);

        // Build request object
        $request = (new CreateAssessmentRequest)
            ->setParent($client->projectName(config('services.recaptcha.project_id')))
            ->setAssessment($assessment);

        // Make request
        $response = $client->createAssessment($request);

        // Token invalid
        if (! $response->getTokenProperties()->getValid()) {
            return false;
        }

        // Action mismatch
        if ($response->getTokenProperties()->getAction() !== $action) {
            return false;
        }

        // Score check
        return $response->getRiskAnalysis()->getScore() >= $minScore;
    }
}
