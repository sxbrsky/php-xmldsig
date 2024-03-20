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

use Nuldark\XmlDSig\Constants as C;
use Nuldark\XmlDSig\XML\ec\InclusiveNamespaces;

class Transform extends AbstractDsElement
{
    final public function __construct(
        protected string $algorithm,
        protected ?InclusiveNamespaces $inclusiveNamespaces = null
    ) {
    }

    /**
     * Get the algorithm.
     *
     * @return string
     */
    public function getAlgorithm(): string {
        return $this->algorithm;
    }

    /**
     * Gets the inclusive namespaces.
     *
     * @return \Nuldark\XmlDSig\XML\ec\InclusiveNamespaces|null
     */
    public function getInclusiveNamespaces(): ?InclusiveNamespaces {
        return $this->inclusiveNamespaces;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $algorithm = $this->getAlgorithm();

        $e = $this->createElement($parent);
        $e->setAttribute('Algorithm', $algorithm);

        match ($algorithm) {
            C::C14N_EXCLUSIVE_WITH_COMMENTS,
            C::C14N_EXCLUSIVE_WITHOUT_COMMENTS => $this->getInclusiveNamespaces()?->toXML($e)
        };

        return $e;
    }
}
