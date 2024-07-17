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

final class Signature extends AbstractDsElement
{
    public function __construct(
        private readonly SignedInfo $signedInfo,
        private readonly SignatureValue $signatureValue,
        private readonly ?KeyInfo $keyInfo
    ) {
    }

    /**
     * Gets the SignedInfo element.
     *
     * @return XmlDSig\XML\ds\SignedInfo
     */
    public function getSignedInfo(): SignedInfo {
        return $this->signedInfo;
    }

    /**
     * Gets the SignatureValue element.
     *
     * @return XmlDSig\XML\ds\SignatureValue
     */
    public function getSignatureValue(): SignatureValue {
        return $this->signatureValue;
    }

    /**
     * Gets the KeyInfo element.
     *
     * @return ?XmlDSig\XML\ds\KeyInfo
     */
    public function getKeyInfo(): ?KeyInfo {
        return $this->keyInfo;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);

        $this->getSignedInfo()->toXML($e);
        $this->getSignatureValue()->toXML($e);
        $this->getKeyInfo()?->toXML($e);

        return $e;
    }
}
