<?php

/*
 * This file is part of the nulxrd/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\Crypto\Backend;

use XmlDSig\Crypto\Key\KeyInterface;

interface SignatureBackendInterface
{
    /**
     * Sets digest algorithm.
     *
     * @param string $digest
     *  The digest identifier.
     *
     * @return void
     */
    public function setDigestAlg(string $digest): void;

    /**
     * Sings given plaintext.
     *
     * @param XmlDSig\Crypto\Key\KeyInterface $key
     *  The key used to sign.
     * @param string $plaintext
     *  Text to be signed.
     *
     * @return string
     *
     * @throws XmlDSig\Exception\SigningException
     */
    public function sign(KeyInterface $key, string $plaintext): string;
}
