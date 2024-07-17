<?php

/*
 * This file is part of the nulxrd/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\Crypto\Key;

use XmlDSig\Crypto\Encoding\PEM;
use XmlDSig\Exception\RuntimeException;

class AsymmetricKey implements KeyInterface
{
    public function __construct(
        protected PEM $key
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getPEM(): PEM {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function getMaterial(): string {
        return $this->key->string();
    }

    public static function fromString(string $pem, string $passphrase = ''): self {
        if (($key = \openssl_pkey_get_private($pem, $passphrase)) === false) {
            throw new RuntimeException('Cannot read the key: ' . (string) \openssl_error_string());
        }

        if (\openssl_pkey_export($key, $decrypted) === false) {
            throw new RuntimeException('Cannot decrypt the key: ' . (string) \openssl_error_string());
        }

        return new self(
            PEM::fromString($decrypted)
        );
    }

    public static function fromFile(string $path, string $passphrase = ''): self {
        if (!\file_exists($path)) {
            throw new RuntimeException('The file does not exist: ' . $path);
        }

        return self::fromString((string) \file_get_contents($path), $passphrase);
    }
}
