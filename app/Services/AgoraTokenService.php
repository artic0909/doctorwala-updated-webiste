<?php

namespace App\Services;

use App\Services\Agora\RtcTokenBuilder2;
use Carbon\Carbon;
use Exception;

class AgoraTokenService
{
    protected string $appId;
    protected string $appCertificate;

    public function __construct()
    {
        $this->appId = (string) config('services.agora.app_id', env('AGORA_APP_ID', ''));
        $this->appCertificate = (string) config('services.agora.app_certificate', env('AGORA_APP_CERTIFICATE', ''));

        if (empty($this->appId) || empty($this->appCertificate)) {
            throw new Exception('Agora credentials (AGORA_APP_ID / AGORA_APP_CERTIFICATE) are not configured.');
        }
    }

    /**
     * Generate an RTC Token for an appointment video session
     *
     * @param string $channelName
     * @param int|string $uid
     * @param int $role
     * @param int $expireSeconds
     * @return array
     */
    public function generateRtcToken(
        string $channelName,
        $uid,
        int $role = RtcTokenBuilder2::ROLE_PUBLISHER,
        int $expireSeconds = 3600
    ): array {
        $token = RtcTokenBuilder2::buildTokenWithUid(
            $this->appId,
            $this->appCertificate,
            $channelName,
            $uid,
            $role,
            $expireSeconds,
            $expireSeconds
        );

        $expiresAt = Carbon::now()->addSeconds($expireSeconds);

        return [
            'app_id'     => $this->appId,
            'channel'    => $channelName,
            'uid'        => $uid,
            'token'      => $token,
            'role'       => $role === RtcTokenBuilder2::ROLE_PUBLISHER ? 'publisher' : 'subscriber',
            'expires_at' => $expiresAt->toIso8601String(),
            'expires_in' => $expireSeconds,
        ];
    }
}
