<?php

namespace App\Services;

use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;

class RecaptchaEnterpriseService
{
    public function verify(string $token, string $action, float $minScore = 0.5): bool
    {
        // Absolute path to your JSON file
        $credentialsPath = base_path('storage/app/google/abiding-ripple-485604-u0-0ceac760a2d1.json');

        // Pass credentials directly
        $client = new RecaptchaEnterpriseServiceClient([
            'credentials' => $credentialsPath,
        ]);

        $event = (new Event)
            ->setSiteKey(config('services.recaptcha.site_key'))
            ->setToken($token);

        $assessment = (new Assessment)
            ->setEvent($event);

        $response = $client->createAssessment(
            $client->projectName(config('services.recaptcha.project_id')),
            $assessment
        );

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
