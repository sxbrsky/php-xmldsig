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

final class CanonicalizationMethod extends AbstractDsElement
{
    /**
     * Initializes a new CanonicalizationMethod.
     *
     * @param string $canonicalizationMethod
     */
    public function __construct(
        private readonly string $canonicalizationMethod
    ) {
    }

    /**
     * Gets the canonicalization method.
     *
     * @return string
     */
    public function getCanonicalizationMethod(): string {
        return $this->canonicalizationMethod;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);
        $e->setAttribute('Algorithm', $this->getCanonicalizationMethod());

        return $e;
    }
}
