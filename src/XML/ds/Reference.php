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
        private readonly DigestMethod $digestMethod,
        private readonly DigestValue  $digestValue,
        private readonly ?Transforms  $transforms = null,
        private readonly ?string $id = null,
        private readonly ?string $type = null,
        private readonly ?string $uri = null,
    ) {
    }

    /**
     * Gets the DigestMethod element.
     *
     * @return \Nuldark\XmlDSig\XML\ds\DigestMethod
     */
    public function getDigestMethod(): DigestMethod {
        return $this->digestMethod;
    }

    /**
     * Gets the DigestValue element.
     *
     * @return \Nuldark\XmlDSig\XML\ds\DigestValue
     */
    public function getDigestValue(): DigestValue {
        return $this->digestValue;
    }

    /**
     * Gets the Transforms element.
     *
     * @return \Nuldark\XmlDSig\XML\ds\Transforms|null
     */
    public function getTransforms(): ?Transforms {
        return $this->transforms;
    }

    /**
     * Gets the Id.
     *
     * @return string|null
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Gets the Type.
     *
     * @return string|null
     */
    public function getType(): ?string {
        return $this->type;
    }

    /**
     * Gets the URI.
     *
     * @return string|null
     */
    public function getURI(): ?string {
        return $this->uri;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e = $this->createElement($parent);

        if ($this->getId() !== null) {
            $e->setAttribute('Id', $this->getId());
        }

        if ($this->getURI() !== null) {
            $e->setAttribute('URI', $this->getUri());
        }

        if ($this->getType() !== null) {
            $e->setAttribute('Type', $this->getType());
        }

        $this->getTransforms()?->toXML($e);
        $this->getDigestMethod()->toXML($e);
        $this->getDigestValue()->toXML($e);

        return $e;
    }
}
