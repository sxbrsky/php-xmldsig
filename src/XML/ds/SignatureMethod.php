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

final class SignatureMethod extends AbstractDsElement
{
    public function __construct(
        private readonly string $signatureMethod
    ) {
    }

    /**
     * Gets the signature method.q
     *
     * @return string
     */
    public function getSignatureMethod(): string {
        return $this->signatureMethod;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);
        $e->setAttribute('Algorithm', $this->getSignatureMethod());

        return $e;
    }
}
