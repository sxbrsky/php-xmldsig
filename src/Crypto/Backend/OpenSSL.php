<?php

/*
 * This file is part of the nuldark/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Nuldark\XmlDSig\Crypto\Backend;

use Nuldark\XmlDSig\Constants as C;
use Nuldark\XmlDSig\Crypto\Key\KeyInterface;
use Nuldark\XmlDSig\Exception\SigningException;

final class OpenSSL implements SignatureBackendInterface
{
    protected string $digest;

    public function __construct() {
        $this->setDigestAlg(C::DIGEST_SHA256);
    }

    /**
     * @inheritDoc
     */
    public function setDigestAlg(string $digest): void {
        $this->digest = C::getDigestAlgorithm($digest);
    }

    /**
     * @inheritDoc
     */
    public function sign(KeyInterface $key, string $plaintext): string {
        if (!\openssl_sign($plaintext, $signature, $key->getMaterial(), $this->digest)) {
            throw new SigningException('Cannot sign the data: ' . (string) \openssl_error_string());
        }

        return $signature;
    }
}
