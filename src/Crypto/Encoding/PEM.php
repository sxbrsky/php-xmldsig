<?php

/*
 * This file is part of the sxbrsky/xmldsig.
 *
 * Copyright (C) 2023 Dominik Szamburski
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace XmlDSig\Crypto\Encoding;

use XmlDSig\Exception\InvalidKeyFormatException;

final class PEM
{
    public const PEM_REGEX = '/' .
        '(?:^|[\r\n])' .
        '-----BEGIN (.+?)-----[\r\n]+' .
        '(.+?)' .
        '[\r\n]+-----END \\1-----' .
        '/ms';

    public function __construct(
        private string $type,
        private string $data
    ) {
    }

    public static function fromString(string $data): self {
        if (!\preg_match(self::PEM_REGEX, $data, $match)) {
            throw new InvalidKeyFormatException('Not a valid PEM.');
        }

        $payload = \preg_replace('/\s+/', '', $match[2]);
        $base64payload = \base64_decode((string) $payload, true);

        if ($base64payload === false) {
            throw new InvalidKeyFormatException('Not a valid PEM.');
        }

        return new PEM($match[1], $base64payload);
    }

    /**
     * Gets key type.
     *
     * @return string
     */
    public function type(): string {
        return $this->type;
    }

    /**
     * Gets key data.
     *
     * @return string
     */
    public function data(): string {
        return $this->data;
    }

    /**
     * Gets encoded key.
     *
     * @return string
     */
    public function encode(): string {
        return \base64_encode($this->data);
    }

    /**
     * Gets a formatted key.
     *
     * @return string
     */
    public function string(): string {
        return
            "-----BEGIN $this->type-----" .
            "\n" . \trim(\chunk_split(\base64_encode($this->data), 64, "\n")) . "\n" .
            "-----END $this->type-----";
    }
}
