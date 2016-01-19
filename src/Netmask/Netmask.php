<?php
namespace Netmask;

class Netmask
{
    public $base;
    public $mask;
    public $bitmask;
    public $hostmask;
    public $broadcast;
    public $size;
    public $first;
    public $last;

    protected $netLong;
    protected $maskLong;

    public function __construct($net)
    {
        list($net, $mask) = explode('/', $net);

        if (!$mask) {
            switch (count(explode('.', $net))) {
                case 1:
                    $mask = 8;
                    break;
                case 2:
                    $mask = 16;
                    break;
                case 3:
                    $mask = 24;
                    break;
                case 4:
                    $mask = 32;
            }
        }

        if (is_string($mask) && strpos($mask, '.') !== false) {
            $this->maskLong = \ip2long($mask);

            if (!$this->maskLong) {
                throw new \InvalidArgumentException("Invalid mask: $mask");
            }

            for ($i = 32; $i > 0; $i--) {
                if ($this->maskLong === 0xffffffff << (32 - $i)) {
                    $this->bitmask = $i;
                    break;
                }
            }
        } elseif ($mask) {
            $this->bitmask = intval($mask, 10);
            $this->maskLong = (0xffffffff << (32 - $this->bitmask));
        } else {
            throw new \InvalidArgumentException("Invalid mask: empty");
        }

        $this->netLong = ip2long($net) & $this->maskLong;

        if (!$this->netLong) {
            throw new \InvalidArgumentException("Invalid net address: $net");
        }

        if ($this->bitmask > 32) {
            throw new \InvalidArgumentException("Invalid mask for ip4: $mask");
        }

        $this->size     = pow(2, 32 - $this->bitmask);
        $this->base     = long2ip($this->netLong);
        $this->mask     = long2ip($this->maskLong);
        $this->hostmask = long2ip(~$this->maskLong);

        $this->first = $this->bitmask <= 30
                       ? long2ip($this->netLong + 1)
                       : $this->base;

        $this->last = $this->bitmask <= 30
                      ? long2ip($this->netLong + $this->size - 2)
                      : long2ip($this->netLong + $this->size - 1);

        if ($this->bitmask <= 30) {
            $this->broadcast = long2ip($this->netLong + $this->size - 1);
        }
    }

    public function __toString()
    {
        return $this->base . '/' . $this->bitmask;
    }

    public function contains($ip)
    {
        if (is_string($ip) &&
           (strpos($ip, '/') !== false || count(explode('.', $ip)) !== 4)) {
            $ip = new Netmask($ip);
        }

        if ($ip instanceof Netmask) {
            return $this->contains($ip->base)
                && $this->contains(($ip->broadcast ?: $ip->last));
        } else {
            return (ip2long($ip) & $this->maskLong) === ($this->netLong & $this->maskLong);
        }
    }

    public function getAll()
    {
        $res = array();
        foreach (range(ip2long($this->first), ip2long($this->last)) as $long) {
            $res[] = long2ip($long);
        }
        return $res;
    }
}
