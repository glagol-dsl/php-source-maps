<?php
declare(strict_types=1);

/**
 * Helper function for decoding base64 VLQ digits
 *
 * @codeCoverageIgnore
 * @param string $digit
 * @return int
 */
function base64vlq_decode(string $digit): int {
    return \Glagol\SourceMap\Base64VLQ::decode($digit);
}
