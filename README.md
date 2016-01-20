Netmask
=======

The Netmask class parses and understands IPv4 CIDR blocks so they can be explored and compared. This module is highly inspired by [node-netmask](https://github.com/rs/node-netmask) module.

Translations
------------

- [Português (Brasil)](translations/README.pt-BR.md)

Installation
-----------

```shell
$ composer require grntartaglia/netmask
```

Synopsis
--------

```php
$block = new Netmask\Netmask('192.168.0.1/24');
$block->base;                       // 192.168.0.0
$block->mask;                       // 255.255.255.0
$block->bitmask;                    // 24
$block->hostmask;                   // 0.0.0.255
$block->broadcast;                  // 192.168.0.255
$block->size;                       // 256
$block->first;                      // 192.168.0.1
$block->last;                       // 192.168.0.254

$block->contains('192.168.0.7/24'); // true
$block->contains('192.168.0.126');  // true
$block->contains('192.168.1.1');    // false

// ['192.168.0.1', '192.168.0.2', '192.168.0.3', ...]
$block->getAll();

foreach ($block->getAll() as $ip) {
    // IP: 192.168.0.x
}
```

Constructing
------------

Netmask objects are created with an IP address and optionally a mask. There are many forms that are recognized:

```php
new Netmask('192.168.0.1/24');            // The preferred form.
new Netmask('192.168.0.1');               // A /32 block.
new Netmask('192.168.0.1/255.255.255.0');
```

API
---

- `->base`: The base address of the network block as a string (eg: 216.240.32.0). Base does not give an indication of the size of the network block.
- `->mask`: The netmask as a string (eg: 255.255.255.0).
- `->hostmask`: The host mask which is the opposite of the netmask (eg: 0.0.0.255).
- `->bitmask`: The netmask as a number of bits in the network portion of the address for this block (eg: 24).
- `->size`: The number of IP addresses in a block (eg: 256).
- `->broadcast`: The blocks broadcast address (eg: 192.168.1.0/24 => 192.168.1.255)
- `->first`, `->last`: First and last useable address
- `->contains($ip or $block)`: Returns a true if the IP number `$ip` is part of the network. That is, a true value is returned if `$ip` is between `$base` and `$broadcast`. If a Netmask object or a block is given, it returns true only of the given block fits inside the network.
- `->getAll()`: Returns an array with all the useable addresses, ie between `$first` and `$last`.
- `->__toString()`: The netmask in base/bitmask format (e.g., '216.240.32.0/24')

License
-------

(The MIT License)

Copyright (c) 2016 Gabriel Tartaglia <gabriel@cappu.com.br>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the 'Software'), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
