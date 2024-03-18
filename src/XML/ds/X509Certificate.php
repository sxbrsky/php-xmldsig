<?php

/*
 * This file is part of the nuldark/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Nuldark\XmlDSig\XML\ds;

final class X509Certificate extends AbstractDsElement
{
    public function __construct(
        private readonly string $x509Certificate,
    ) {
    }

    /**
     * Get X509Certificate.
     *
     * @return string
     */
    public function getX509Certificate(): string {
        return $this->x509Certificate;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);
        $e->textContent = $this->getX509Certificate();

        return $e;
    }
}
