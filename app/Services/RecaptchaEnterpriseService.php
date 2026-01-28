<?php

namespace App\Services;

use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;

class RecaptchaEnterpriseService
{
    public function verify(string $token, string $action, float $minScore = 0.5): bool
    {
        $client = new RecaptchaEnterpriseServiceClient();

        $event = (new Event())
            ->setSiteKey(config('services.recaptcha.site_key'))
            ->setToken($token);

        $assessment = (new Assessment())
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
