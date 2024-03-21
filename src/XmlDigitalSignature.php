<?php

/*
 * This file is part of the nuldark/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Nuldark\XmlDSig;

use Nuldark\Stdlib\XML;
use Nuldark\XmlDSig\Crypto\CryptoSigner;
use Nuldark\XmlDSig\Exception\UnsupportedCanonicalizationAlgorithm;
use Nuldark\XmlDSig\XML\ds\CanonicalizationMethod;
use Nuldark\XmlDSig\XML\ds\DigestMethod;
use Nuldark\XmlDSig\XML\ds\DigestValue;
use Nuldark\XmlDSig\XML\ds\KeyInfo;
use Nuldark\XmlDSig\XML\ds\Reference;
use Nuldark\XmlDSig\XML\ds\References;
use Nuldark\XmlDSig\XML\ds\Signature;
use Nuldark\XmlDSig\XML\ds\SignatureMethod;
use Nuldark\XmlDSig\XML\ds\SignatureValue;
use Nuldark\XmlDSig\XML\ds\SignedInfo;
use Nuldark\XmlDSig\XML\ds\Transform;
use Nuldark\XmlDSig\XML\ds\Transforms;
use Nuldark\XmlDSig\Constants as C;

class XmlDigitalSignature
{
    /** @var string $canonicalizationMethod */
    protected string $canonicalizationMethod = C::C14N_EXCLUSIVE_WITHOUT_COMMENTS;

    /** @var \Nuldark\XmlDSig\XML\ds\Reference[] $references */
    protected array $references = [];

    /** @var \Nuldark\XmlDSig\XML\ds\KeyInfo|null $keyInfo */
    protected ?KeyInfo $keyInfo = null;

    /** @var \Nuldark\XmlDSig\XML\ds\Signature|null $signature */
    protected ?Signature $signature = null;

    public function __construct(
        protected CryptoSigner $signer,
    ) {
    }

    /**
     * Signs given document.
     *
     * @param \DOMElement $element
     *  The document to be signed.
     *
     * @return \DOMElement
     *
     * @throws \DOMException
     */
    public function sign(\DOMElement $element): \DOMElement {
        if (empty($this->references)) {
            throw new \LogicException('No references added');
        }

        $element->insertBefore($this->doSign()->toXML($element));
        return $element;
    }

    /**
     * Sets the canonicalization method.
     *
     * @param string $canonicalizationMethod
     *  The canonicalization method.
     *
     * @return self
     */
    public function setCanonicalizationMethod(string $canonicalizationMethod): self {
        $allowedCanonicalizationMethods = [
            C::C14N_EXCLUSIVE_WITHOUT_COMMENTS,
            C::C14N_EXCLUSIVE_WITH_COMMENTS,
            C::C14N_INCLUSIVE_WITHOUT_COMMENTS,
            C::C14N_INCLUSIVE_WITH_COMMENTS,
        ];

        if (!\in_array($canonicalizationMethod, $allowedCanonicalizationMethods)) {
            throw new UnsupportedCanonicalizationAlgorithm(
                'Unsupported canonicalization algorithm'
            );
        }

        $this->canonicalizationMethod = $canonicalizationMethod;
        return $this;
    }

    /**
     * Sets KeyInfo element.
     *
     * @param KeyInfo $keyInfo
     *  The key info instance.
     *
     * @return self
     */
    public function setKeyInfo(KeyInfo $keyInfo): self {
        $this->keyInfo = $keyInfo;
        return $this;
    }

    /**
     * Adds a new reference to signature.
     *
     * @param \DOMElement $doc
     *  The reference document.
     * @param string $c14nAlg
     *  The canonicalization method.
     * @param \Nuldark\XmlDSig\XML\ds\Transforms|null $transforms
     *  The transformation to be applied.
     * @param array $options
     *  An array of options.
     *
     * @return void
     */
    public function addReference(
        \DOMElement $doc,
        string $c14nAlg,
        Transforms $transforms = null,
        array $options = []
    ): void {
        if ($transforms === null) {
            $transforms = new Transforms([
                new Transform(C::XMLDSIG_ENVELOPED),
                new Transform($c14nAlg),
            ]);
        }

        $uri = $doc->getAttribute((string) ($options['idAttrName'] ?? 'ID'));

        $canonicalDocument = $this->processTransforms($transforms, $doc);
        $digestValue = $this->signer->hash($canonicalDocument);

        $this->references[] = new Reference(
            digestMethod: new DigestMethod($this->signer->getDigest()),
            digestValue: new DigestValue($digestValue),
            transforms: $transforms,
            uri: "#$uri"
        );
    }

    /**
     * Gets an signature element.
     *
     * @return \Nuldark\XmlDSig\XML\ds\Signature|null
     */
    public function getSignature(): ?Signature {
        return $this->signature;
    }

    /**
     * Generates a signature element.
     *
     * @return \Nuldark\XmlDSig\XML\ds\Signature
     */
    protected function doSign(): Signature {
        $algorithm = $this->signer->getAlgorithm();

        $signedInfo = new SignedInfo(
            new CanonicalizationMethod($this->canonicalizationMethod),
            new SignatureMethod($algorithm),
            new References($this->references)
        );

        $signingData = $signedInfo->canonicalize($this->canonicalizationMethod);
        $signedData = \base64_encode($this->signer->sign($signingData));

        return $this->signature = new Signature($signedInfo, new SignatureValue($signedData), $this->keyInfo);
    }

    /**
     * Process given transforms.
     *
     * @param \Nuldark\XmlDSig\XML\ds\Transforms $transforms
     *  A transforms to apply.
     * @param \DOMElement $doc
     *  The document to process.
     *
     * @return string
     */
    private function processTransforms(Transforms $transforms, \DOMElement $doc): string {
        $canonicalMethod = C::C14N_INCLUSIVE_WITHOUT_COMMENTS;
        $xpaths = null;
        $prefixes = null;

        foreach ($transforms->getTransforms() as $transform) {
            $canonicalMethod = $transform->getAlgorithm();

            //phpcs:disable
            if (
                $canonicalMethod == C::C14N_EXCLUSIVE_WITH_COMMENTS ||
                $canonicalMethod == C::C14N_EXCLUSIVE_WITHOUT_COMMENTS
            ) {
            //phpcs:enable
                $inclusiveNamespaces = $transform->getInclusiveNamespaces();
                if ($inclusiveNamespaces !== null) {
                    $prefixList = $inclusiveNamespaces->getPrefixes();
                    if (!empty($prefixList)) {
                        $prefixes = $prefixList;
                    }
                }
            }
        }

        return XML::canonicalizeData($doc, $canonicalMethod, $xpaths, $prefixes);
    }
}
