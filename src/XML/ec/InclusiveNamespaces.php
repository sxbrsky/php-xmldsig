<?php

/*
 * This file is part of the sxbrsky/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\XML\ec;

final class InclusiveNamespaces extends AbstractEcElement
{
    /**
     * @param string[] $prefixes
     *  An array of prefixes.
     */
    public function __construct(
        public readonly array $prefixes = []
    ) {
    }

    /**
     * Gets the prefixes.
     *
     * @return string[]
     */
    public function getPrefixes(): array {
        return $this->prefixes;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);

        if (!empty($this->getPrefixes())) {
            $e->setAttribute('PrefixList', \implode(' ', $this->getPrefixes()));
        }

        return $e;
    }
}
