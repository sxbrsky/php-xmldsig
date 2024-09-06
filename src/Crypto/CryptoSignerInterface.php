<?php

/*
 * This file is part of the sxbrsky/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\Crypto;

use XmlDSig\Crypto\Backend\SignatureBackendInterface;

interface CryptoSignerInterface
{
    /**
     * Gets the signature algorithm.
     *
     * @return string
     */
    public function getAlgorithm(): string;

    /**
     * Gets the digest algorithm.
     *
     * @return string
     */
    public function getDigest(): string;

    /**
     * Sets the signature algorithm backend.
     *
     * @param \XmlDSig\Crypto\Backend\SignatureBackendInterface|null $backend
     *  The backend.
     *
     * @return void
     */
    public function setBackend(?SignatureBackendInterface $backend = null): void;

    /**
     * Signs given string.
     *
     * @param string $data
     *  String to be signed.
     *
     * @return string
     */
    public function sign(string $data): string;
}
