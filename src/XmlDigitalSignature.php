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

use Nuldark\XmlDSig\Crypto\CryptoSigner;
use Nuldark\XmlDSig\XML\ds\CanonicalizationMethod;
use Nuldark\XmlDSig\XML\ds\DigestMethod;
use Nuldark\XmlDSig\XML\ds\DigestValue;
use Nuldark\XmlDSig\XML\ds\KeyInfo;
use Nuldark\XmlDSig\XML\ds\Reference;
use Nuldark\XmlDSig\XML\ds\Signature;
use Nuldark\XmlDSig\XML\ds\SignatureMethod;
use Nuldark\XmlDSig\XML\ds\SignatureValue;
use Nuldark\XmlDSig\XML\ds\SignedInfo;
use Nuldark\XmlDSig\XML\ds\Transform;
use Nuldark\XmlDSig\XML\ds\Transforms;
use Nuldark\XmlDSig\XML\ds\X509Certificate;
use Nuldark\XmlDSig\XML\ds\X509Data;
use Nuldark\XmlDSig\Constants as C;

class XmlDigitalSignature
{
    /** @var string $c14nAlg */
    protected string $c14nAlg = C::C14N_EXCLUSIVE_WITHOUT_COMMENTS;

    /** @var null|string $referenceUri */
    private ?string $referenceUri = null;

    /** @var \Nuldark\XmlDSig\XML\ds\X509Certificate[] $x509Certificates */
    private array $x509Certificates = [];

    public function __construct(
        protected CryptoSigner $signer,
    ) {
    }

    /**
     * Signs the given document.
     *
     * @param \DOMElement $element
     *  Document to be signed.
     *
     * @return \DOMDocument
     *  Returns signed document.
     *
     * @throws \DOMException
     */
    public function signDocument(\DOMElement $element): \DOMDocument {
        $canonicalDocument = $element->C14N(true, false);

        $transforms = new Transforms([
            new Transform(C::XMLDSIG_ENVELOPED),
            new Transform($this->c14nAlg),
        ]);

        $signedInfo = new SignedInfo(
            new CanonicalizationMethod($this->c14nAlg),
            new SignatureMethod($this->signer->getAlgorithm()),
            [
                $this->getReference($this->signer->getDigest(), $canonicalDocument, $transforms)
            ],
        );

        $signingData = $signedInfo->canonicalize();
        $signedData = \base64_encode($this->signer->sign($signingData));

        $signature = new Signature(
            $signedInfo,
            new SignatureValue($signedData),
            new KeyInfo(
                new X509Data(
                    $this->x509Certificates
                )
            )
        );

        return $signature->toXML($element)->ownerDocument;
    }

    public function getC14nAlg(): string {
        return $this->c14nAlg;
    }

    public function setC14nAlg(string $c14nAlg): void {
        $this->c14nAlg = $c14nAlg;
    }

    public function setReferenceUri(string $referenceUri): self {
        $this->referenceUri = $referenceUri;
        return $this;
    }

    public function getReferenceUri(): ?string {
        return $this->referenceUri;
    }

    public function addX509Certificate(string $pem): self {
        $this->x509Certificates[] = new X509Certificate($pem);
        return $this;
    }

    private function getReference(
        string $digestAlg,
        string $canonicalDocument,
        Transforms $transforms
    ): Reference {
        return new Reference(
            new DigestMethod($digestAlg),
            new DigestValue($this->signer->hash($canonicalDocument)),
            $transforms,
            $this->getReferenceUri()
        );
    }
}
