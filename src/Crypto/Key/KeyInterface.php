<?php

/*
 * This file is part of the nuldark/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Nuldark\XmlDSig\Crypto\Key;

use Nuldark\XmlDSig\Crypto\Encoding\PEM;

interface KeyInterface
{
    /**
     * Gets a string representation of this key.
     *
     * @return string
     */
    public function getMaterial(): string;

    /**
     * Gets a PEM instance of this key.
     *
     * @return \Nuldark\XmlDSig\Crypto\Encoding\PEM
     */
    public function getPEM(): PEM;
}
