<?php

namespace App\Services\Agora;

class AccessToken2
{
    public const SERVICE_TYPE_RTC = 1;
    public const PRIVILEGE_JOIN_CHANNEL = 1;
    public const PRIVILEGE_PUBLISH_AUDIO_STREAM = 2;
    public const PRIVILEGE_PUBLISH_VIDEO_STREAM = 3;
    public const PRIVILEGE_PUBLISH_DATA_STREAM = 4;

    public string $appId;
    public string $appCertificate;
    public int $issueTs;
    public int $salt;
    public int $expire;
    public array $services = [];

    public function __construct(string $appId, string $appCertificate, int $issueTs = 0, int $expire = 3600)
    {
        $this->appId = $appId;
        $this->appCertificate = $appCertificate;
        $this->issueTs = $issueTs > 0 ? $issueTs : time();
        $this->salt = rand(1, 99999999);
        $this->expire = $expire;
    }

    public function addService(Service $service): void
    {
        $this->services[$service->getServiceType()] = $service;
    }

    public function build(): string
    {
        $signing = $this->getSign();
        $data = pack('v', $this->issueTs)
            . pack('V', $this->salt)
            . pack('v', count($this->services));

        foreach ($this->services as $service) {
            $data .= $service->pack();
        }

        $signature = hash_hmac('sha256', $signing . $data, $this->appCertificate, true);
        $content = pack('v', strlen($signature)) . $signature . $data;

        // Compression using zlib
        $compressed = @gzcompress($content, 9);
        $body = $compressed !== false ? $compressed : $content;

        return '007' . base64_encode(hex2bin($this->appId) . $body);
    }

    protected function getSign(): string
    {
        $hmac = hash_hmac('sha256', pack('V', $this->issueTs), $this->appCertificate, true);
        return hash_hmac('sha256', pack('V', $this->salt), $hmac, true);
    }
}

abstract class Service
{
    protected int $serviceType;
    protected array $privileges = [];

    public function __construct(int $serviceType)
    {
        $this->serviceType = $serviceType;
    }

    public function getServiceType(): int
    {
        return $this->serviceType;
    }

    public function addPrivilege(int $privilege, int $expire): void
    {
        $this->privileges[$privilege] = $expire;
    }

    public function pack(): string
    {
        $val = pack('v', $this->serviceType) . $this->packService();
        $val .= pack('v', count($this->privileges));
        foreach ($this->privileges as $k => $v) {
            $val .= pack('v', $k) . pack('V', $v);
        }
        return $val;
    }

    abstract protected function packService(): string;
}

class ServiceRtc extends Service
{
    protected string $channelName;
    protected string $uid;

    public function __construct(string $channelName = '', string $uid = '')
    {
        parent::__construct(AccessToken2::SERVICE_TYPE_RTC);
        $this->channelName = $channelName;
        $this->uid = $uid;
    }

    protected function packService(): string
    {
        return pack('v', strlen($this->channelName)) . $this->channelName
            . pack('v', strlen($this->uid)) . $this->uid;
    }
}
