<?php

/*
 * This file is part of the sxbrsky/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\XML\ds;

final class KeyInfo extends AbstractDsElement
{
    public function __construct(
        private readonly X509Data $x509Data
    ) {
    }

    /**
     * Gets the X509Data.
     *
     * @return \XmlDSig\XML\ds\X509Data
     */
    public function getX509Data(): X509Data {
        return $this->x509Data;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);
        $this->x509Data->toXML($e);

        return $e;
    }
}
