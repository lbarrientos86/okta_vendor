<?php

namespace Modules\PhpGsm;

require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;

class SecretManager
{
    private SecretManagerServiceClient $client;
    private string $projectId;

    public function __construct(string $projectId, string $credentialsPath)
    {
        $this->projectId = $projectId;

        $this->client = new SecretManagerServiceClient([
            'credentials' => $credentialsPath
        ]);
    }

    public function getSecret(string $secretId, string $version = 'latest'): string
    {
        $name = sprintf(
            'projects/%s/secrets/%s/versions/%s',
            $this->projectId,
            $secretId,
            $version
        );

        $response = $this->client->accessSecretVersion($name);

        return $response->getPayload()->getData();
    }
}
