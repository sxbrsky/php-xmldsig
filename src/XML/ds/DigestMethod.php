<?php

/*
 * This file is part of the nulxrd/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\XML\ds;

final class DigestMethod extends AbstractDsElement
{
    public function __construct(
        private readonly string $digestMethod
    ) {
    }

    /**
     * Gets the digest method.
     *
     * @return string
     */
    public function getDigestMethod(): string {
        return $this->digestMethod;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);
        $e->setAttribute('Algorithm', $this->getDigestMethod());

        return $e;
    }
}
