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

final class Transforms extends AbstractDsElement
{
    public function __construct(
        /** @var XmlDSig\XML\ds\Transform[] $transforms */
        private readonly array $transforms
    ) {
    }

    /**
     * Gets the list of transforms.
     *
     * @return XmlDSig\XML\ds\Transform[]
     */
    public function getTransforms(): array {
        return $this->transforms;
    }

    /**
     * @inheritDoc
     */
    public function toXML(\DOMElement $parent = null): \DOMElement {
        $e  = $this->createElement($parent);

        foreach ($this->getTransforms() as $transform) {
            $transform->toXML($e);
        }

        return $e;
    }
}
