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

final class X509Data extends AbstractDsElement
{
    /**
     * @param \Nuldark\XmlDSig\XML\ds\X509Certificate[] $certificates
     */
    public function __construct(
        private readonly array $certificates
    ) {
    }

    /**
     * Get the certificates.
     *
     * @return \Nuldark\XmlDSig\XML\ds\X509Certificate[]
     */
    public function getCertificates(): array {
        return $this->certificates;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);

        foreach ($this->getCertificates() as $certificate) {
            $certificate->toXML($e);
        }

        return $e;
    }
}
