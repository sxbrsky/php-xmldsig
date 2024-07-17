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

final class SignatureValue extends AbstractDsElement
{
    public function __construct(
        private readonly string $signatureValue
    ) {
    }

    /**
     * Gets the signature value.
     *
     * @return string
     */
    public function getSignatureValue(): string {
        return $this->signatureValue;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);
        $e->textContent = $this->getSignatureValue();

        return $e;
    }
}
