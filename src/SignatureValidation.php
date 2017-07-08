<?php
/**
 * This file is part of ruogoo.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogoo\Signature;

use Ruogoo\Signature\Model\AppClient;

class SignatureValidation implements SignatureInterface
{
    /**
     * @var string
     */
    protected $appKey;

    public function validate($request): bool
    {
        // header 中取出签名字符串
        $signatureInHeader = $request->header('X-Signature');
        if (empty($signatureInHeader)) {
            return false;
        }
        if (! $request->has('app_key')) {
            return false;
        }
        $this->appKey = $request->get('app_key');
        // 比对重新计算的签名
        $calculateSignature = $this->signature($request->all(), null);

        return strtolower($calculateSignature) === strtolower($signatureInHeader);
    }

    private function signature(array $inputs, $body = null): string
    {
        // 字典按 key 排序
        ksort($inputs, SORT_STRING);
        $pieces = [$this->secretKey()];
        foreach ($inputs as $key => $value) {
            $pieces[] = $key . '=' . $value;
        }
        if (! empty($body)) {
            $pieces[] = sha1($body);
        }
        $joined = implode('&', $pieces);

        return hash('sha256', $joined);
    }

    private function secretKey(): string
    {
        $client = AppClient::findKey($this->appKey);
        if ($client) {
            return $client->secret;
        }

        return '__1234__';
    }
}
