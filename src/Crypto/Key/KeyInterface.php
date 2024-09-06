<?php

/*
 * This file is part of the sxbrsky/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\Crypto\Key;

use XmlDSig\Crypto\Encoding\PEM;

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
     * @return \XmlDSig\Crypto\Encoding\PEM
     */
    public function getPEM(): PEM;
}
