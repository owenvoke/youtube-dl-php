<?php

namespace pxgamer\YDP;

/**
 * Class Format
 */
class Format
{
    /**
     * @var int
     */
    private $tag;
    /**
     * @var string
     */
    private $quality;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $url;
    /**
     * @var \DateTime
     */
    private $expires;
    /**
     * @var int
     */
    private $ipBits;
    /**
     * @var string
     */
    private $ip;

    /**
     * Format constructor.
     *
     * @param string $tag
     * @param string $quality
     * @param string $type
     * @param string $url
     * @param string $expires
     * @param string $ipBits
     * @param string $ip
     *
     * @throws \Exception
     */
    public function __construct(
        string $tag,
        string $quality,
        string $type,
        string $url,
        string $expires,
        string $ipBits,
        string $ip
    ) {
        if (!is_numeric($tag)) {
            throw new \Exception('Format iTag is non-numeric.');
        }
        if (!is_numeric($ipBits)) {
            throw new \Exception('IP Bits is non-numeric.');
        }

        $this->quality = $quality;
        $this->type = $type;
        $this->url = $url;
        $this->ip = $ip;

        $expiryTime = strtotime($expires);
        $this->expires = new \DateTime($expiryTime);

        $this->tag = (int)$tag;
        $this->ipBits = (int)$ipBits;
    }

    /**
     * @return int
     */
    public function getTag(): int
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getQuality(): string
    {
        return $this->quality;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return \DateTime
     */
    public function getExpires(): \DateTime
    {
        return $this->expires;
    }

    /**
     * @return int
     */
    public function getIpBits(): int
    {
        return $this->ipBits;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }
}
