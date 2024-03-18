<?php

/*
 * This file is part of the nuldark/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Nuldark\XmlDSig\Crypto;

use Nuldark\XmlDSig\Constants as C;
use Nuldark\XmlDSig\Crypto\Backend\OpenSSL;
use Nuldark\XmlDSig\Crypto\Backend\SignatureBackendInterface;
use Nuldark\XmlDSig\Crypto\Key\KeyInterface;

class CryptoSigner implements CryptoSignerInterface
{
    protected SignatureBackendInterface $backend;

    public function __construct(
        protected KeyInterface $key,
        protected string $algId,
        protected string $digest,
    ) {
        $this->setBackend();
        $this->backend->setDigestAlg($digest);
    }

    /**
     * @inheritDoc
     */
    public function getAlgorithm(): string {
        return $this->algId;
    }

    /**
     * @inheritDoc
     */
    public function getDigest(): string {
        return $this->digest;
    }

    /**
     * @inheritDoc
     */
    public function setBackend(SignatureBackendInterface $backend = null): void {
        if ($backend === null) {
            $backend = new OpenSSL();
        }

        $this->backend = $backend;
        $this->backend->setDigestAlg($this->digest);
    }

    /**
     * @inheritDoc
     */
    public function sign(string $data): string {
        return $this->backend->sign($this->key, $data);
    }

    /**
     * Compute digest value.
     *
     * @param string $data
     *  Data to be hashed.
     * @param bool $encode
     *  Transform hash to base64 encoding.
     *
     * @return string
     */
    public function hash(string $data, bool $encode = true): string {
        $hash = \hash(
            C::getDigestAlgorithm($this->digest),
            $data,
            true
        );

        return $encode ? \base64_encode($hash) : $hash;
    }
}
