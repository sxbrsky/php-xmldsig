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

final class DigestValue extends AbstractDsElement
{
    public function __construct(
        private readonly string $digestValue
    ) {
    }

    /**
     * Gets the digest value.
     *
     * @return string
     */
    public function getDigestValue(): string {
        return $this->digestValue;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);
        $e->textContent = $this->getDigestValue();

        return $e;
    }
}
