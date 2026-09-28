<?php

namespace App\Services\Agora;

class RtcTokenBuilder2
{
    public const ROLE_PUBLISHER = 1;
    public const ROLE_SUBSCRIBER = 2;

    /**
     * Build token with user account (string or int uid)
     *
     * @param string $appId
     * @param string $appCertificate
     * @param string $channelName
     * @param string|int $uid
     * @param int $role
     * @param int $tokenExpire
     * @param int $privilegeExpire
     * @return string
     */
    public static function buildTokenWithUid(
        string $appId,
        string $appCertificate,
        string $channelName,
        $uid,
        int $role = self::ROLE_PUBLISHER,
        int $tokenExpire = 3600,
        int $privilegeExpire = 3600
    ): string {
        $token = new AccessToken2($appId, $appCertificate, time(), $tokenExpire);
        $rtcService = new ServiceRtc($channelName, (string)$uid);

        $rtcService->addPrivilege(AccessToken2::PRIVILEGE_JOIN_CHANNEL, $tokenExpire);
        if ($role === self::ROLE_PUBLISHER) {
            $rtcService->addPrivilege(AccessToken2::PRIVILEGE_PUBLISH_AUDIO_STREAM, $privilegeExpire);
            $rtcService->addPrivilege(AccessToken2::PRIVILEGE_PUBLISH_VIDEO_STREAM, $privilegeExpire);
            $rtcService->addPrivilege(AccessToken2::PRIVILEGE_PUBLISH_DATA_STREAM, $privilegeExpire);
        }

        $token->addService($rtcService);
        return $token->build();
    }
}
