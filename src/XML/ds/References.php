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

final class References
{
    /**
     * @param \Nuldark\XmlDSig\XML\ds\Reference[] $references
     */
    public function __construct(
        protected array $references = [],
    ) {
    }

    /**
     * Gets the reference.
     *
     * @return \Nuldark\XmlDSig\XML\ds\Reference[]
     */
    public function getReferences(): array {
        return $this->references;
    }
}
