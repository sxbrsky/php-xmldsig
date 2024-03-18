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

final class Reference extends AbstractDsElement
{
    public function __construct(
        private readonly ?DigestMethod $digestMethod = null,
        private readonly ?DigestValue  $digestValue = null,
        private readonly ?Transforms   $transforms = null,
        private readonly ?string $id = null
    ) {
    }

    /**
     * Gets the digest method.
     *
     * @return \Nuldark\XmlDSig\XML\ds\DigestMethod|null
     */
    public function getDigestMethod(): ?DigestMethod {
        return $this->digestMethod;
    }

    /**
     * Gets the digest value.
     *
     * @return \Nuldark\XmlDSig\XML\ds\DigestValue|null
     */
    public function getDigestValue(): ?DigestValue {
        return $this->digestValue;
    }

    /**
     * Gets the array of transforms.
     *
     * @return \Nuldark\XmlDSig\XML\ds\Transforms|null
     */
    public function getTransforms(): ?Transforms {
        return $this->transforms;
    }

    /**
     * Gets the ID.
     *
     * @return string|null
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);

        if ($this->getId() !== null) {
            $e->setAttribute('URI', '#' . $this->getId());
        }

        $this->getTransforms()?->toXML($e);
        $this->getDigestMethod()?->toXML($e);
        $this->getDigestValue()?->toXML($e);

        return $e;
    }
}
