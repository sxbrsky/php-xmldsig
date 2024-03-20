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

enum Constants
{
    public const XMLDSIG_ENVELOPED = 'http://www.w3.org/2000/09/xmldsig#enveloped-signature';

    public const XMLDSIG_NS = 'http://www.w3.org/2000/09/xmldsig#';
    public const XMLDSIG_NS_PREFIX = 'ds';

    public const EC_NS = 'http://www.w3.org/2001/10/xml-exc-c14n#';
    public const EC_NS_PREFIX = 'ec';

    public const C14N_INCLUSIVE_WITH_COMMENTS = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments';
    public const C14N_INCLUSIVE_WITHOUT_COMMENTS = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';
    public const C14N_EXCLUSIVE_WITH_COMMENTS = 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments';
    public const C14N_EXCLUSIVE_WITHOUT_COMMENTS = 'http://www.w3.org/2001/10/xml-exc-c14n#';

    public const DIGEST_SHA1 = 'http://www.w3.org/2000/09/xmldsig#sha1';
    public const DIGEST_SHA224 = 'http://www.w3.org/2001/04/xmldsig-more#sha224';
    public const DIGEST_SHA256 = 'http://www.w3.org/2001/04/xmlenc#sha256';
    public const DIGEST_SHA384 = 'http://www.w3.org/2001/04/xmldsig-more#sha384';
    public const DIGEST_SHA512 = 'http://www.w3.org/2001/04/xmlenc#sha512';
    public const DIGEST_RIPEMD160 = 'http://www.w3.org/2001/04/xmlenc#ripemd160';

    public const SIG_RSA_SHA1 = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
    public const SIG_RSA_SHA224 = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha224';
    public const SIG_RSA_SHA256 = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';
    public const SIG_RSA_SHA384 = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384';
    public const SIG_RSA_SHA512 = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512';
    public const SIG_ECDSA_SHA256 = 'http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256';

    public static function getDigestAlgorithm(string $alg): string {
        return match ($alg) {
            self::DIGEST_SHA1 => 'sha1',
            self::DIGEST_SHA224 => 'sha224',
            self::DIGEST_SHA256 => 'sha256',
            self::DIGEST_SHA384 => 'sha384',
            self::DIGEST_SHA512 =>'sha512',
        };
    }
}
