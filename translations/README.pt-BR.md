Netmask
=======

A classe Netmask analisa blocos IPv4 CIDR para que eles possam ser explorados e comparados. Este módulo é altamente inspirado pelo módulo [node-netmask](https://github.com/rs/node-netmask).

Instalação
-----------

```shell
$ composer require grntartaglia/netmask
```

Sinopse
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

Construindo
------------

Objetos Netmask são construídos com um endereço IP e opcionalmente uma máscara. São aceitas as seguintes formas:

```php
new Netmask('192.168.0.1/24');            // A forma recomendada.
new Netmask('192.168.0.1');               // Um bloco /32.
new Netmask('192.168.0.1/255.255.255.0');
```

API
---

- `->base`: O endereço base do bloco de rede como string (ex.: 216.240.32.0). A base não dá uma indicação do tamanho do bloco.
- `->mask`: A máscara de rede como string (ex.: 255.255.255.0).
- `->hostmask`: A máscara do host, que é o oposto da máscara de rede (ex.: 0.0.0.255).
- `->bitmask`: A máscara de rede como um número de bits (ex.: 24).
- `->size`: O número de endereços IP do bloco (eg: 256).
- `->broadcast`: O endereço broadcast do bloco (eg: 192.168.1.0/24 => 192.168.1.255).
- `->first`, `->last`: Primeiro e último endereço IP.
- `->contains($ip or $block)`: Retorna `true` se o número IP `$ip` for parte da rede. Isto é, um valor verdadeiro é retornado se `$ip` estiver entre `$base` e `$broadcast`. Se um objeto Netmask ou um bloco for passado, o valor retornado é verdadeiro somente se o bloco dado se encaixar dentro da rede.
- `->getAll()`: Retorna uma array com todos os endereços IP, isto é, entre `$first` e `$last`.
- `->__toString()`: A máscara de rede no formato base/bitmask (ex.: '216.240.32.0/24')

License
-------

(The MIT License)

Copyright (c) 2016 Gabriel Tartaglia <gabriel@cappu.com.br>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the 'Software'), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
