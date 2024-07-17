<?php

/*
 * This file is part of the nulxrd/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\XML\ec;

use Nuldark\Stdlib\XML\AbstractElement;
use XmlDSig\Constants as C;

abstract class AbstractEcElement extends AbstractElement
{
    /**
     * @inheritDoc
     */
    protected function getNamespacePrefix(): ?string {
        return C::EC_NS_PREFIX;
    }

    /**
     * @inheritDoc
     */
    protected function getNamespaceURI(): string {
        return C::EC_NS;
    }
}
