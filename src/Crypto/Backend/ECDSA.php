<?php

/*
 * This file is part of the sxbrsky/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\Crypto\Backend;

use XmlDSig\Constants as C;
use XmlDSig\Crypto\Key\KeyInterface;

final class ECDSA implements SignatureBackendInterface
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
        return (string) \EllipticCurve\Ecdsa::sign(
            $plaintext,
            \EllipticCurve\PrivateKey::fromPem(
                $key->getMaterial()
            )
        )->_toString();
    }
}
