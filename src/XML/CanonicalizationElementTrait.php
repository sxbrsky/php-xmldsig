<?php

/*
 * This file is part of the nuldark/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Nuldark\XmlDSig\XML;

trait CanonicalizationElementTrait
{
    abstract protected function getOriginalXML(): \DOMElement;

    public function canonicalize(): string {
        return $this->getOriginalXML()->C14N(true, false);
    }
}
