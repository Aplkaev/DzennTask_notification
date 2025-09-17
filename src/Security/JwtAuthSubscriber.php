<?php

namespace App\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JwtAuthSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly string $jwtSecret
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => ['onKernelRequest', 10],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $authHeader = $request->headers->get('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            throw new UnauthorizedHttpException('Bearer', 'Missing Authorization Header');
        }

        $jwt = $matches[1];
        $payload = $this->validateJwt($jwt);

        if ($payload === null) {
            throw new UnauthorizedHttpException('Bearer', 'Invalid or expired token');
        }

        // Можно положить payload в атрибуты Request для дальнейшего использования
        $request->attributes->set('jwt_payload', $payload);
    }

    private function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    private function validateJwt(string $jwt): ?array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return null;
        }

        [$header, $payload, $signature] = $parts;
        $expected = rtrim(strtr(base64_encode(
            hash_hmac('sha256', "$header.$payload", $this->jwtSecret, true)
        ), '+/', '-_'), '=');

        if (!hash_equals($expected, $signature)) {
            return null;
        }

        $data = json_decode($this->base64UrlDecode($payload), true);

        if (isset($data['exp']) && time() >= $data['exp']) {
            return null;
        }

        return $data;
    }
}
