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

use Nuldark\Stdlib\XML\CanonicalizableElementTrait;

final class SignedInfo extends AbstractDsElement
{
    use CanonicalizableElementTrait;

    protected ?\DOMElement $xml = null;

    /**
     * @param XmlDSig\XML\ds\CanonicalizationMethod $canonicalizationMethod
     * @param XmlDSig\XML\ds\SignatureMethod $signatureMethod
     * @param XmlDSig\XML\ds\References $references
     */
    public function __construct(
        private readonly CanonicalizationMethod $canonicalizationMethod,
        private readonly SignatureMethod $signatureMethod,
        private readonly References $references
    ) {
    }

    /**
     * Gets the signature method.
     *
     * @return XmlDSig\XML\ds\SignatureMethod
     */
    public function getSignatureMethod(): SignatureMethod {
        return $this->signatureMethod;
    }

    /**
     * Gets the canonicalization method.
     *
     * @return XmlDSig\XML\ds\CanonicalizationMethod
     */
    public function getCanonicalizationMethod(): CanonicalizationMethod {
        return $this->canonicalizationMethod;
    }

    /**
     * Gets a references.
     *
     * @return XmlDSig\XML\ds\Reference[]
     */
    public function getReferences(): array {
        return $this->references->getReferences();
    }

    /**
     * @inheritDoc
     */
    public function getXML(): \DOMElement {
        if ($this->xml !== null) {
            return $this->xml;
        }

        return $this->toXML();
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);

        $this->getCanonicalizationMethod()->toXML($e);
        $this->getSignatureMethod()->toXML($e);

        foreach ($this->getReferences() as $reference) {
            $reference->toXML($e);
        }

        return $e;
    }
}
