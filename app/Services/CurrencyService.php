<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class CurrencyService
{
    private const CACHE_KEY = 'meditrack.settings.default_currency';

    public function code(): string
    {
        $fallback = strtoupper((string) config('app.currency', 'UGX'));

        return Cache::rememberForever(self::CACHE_KEY, function () use ($fallback): string {
            try {
                if (! Schema::hasTable('settings')) {
                    return $this->normalise($fallback);
                }

                return $this->normalise((string) Setting::value('default_currency', $fallback));
            } catch (\Throwable) {
                return $this->normalise($fallback);
            }
        });
    }

    public function definition(): array
    {
        return config('currencies.' . $this->code(), config('currencies.UGX'));
    }

    public function options(): array
    {
        return config('currencies', []);
    }

    public function format(int|float|string|null $amount): string
    {
        $definition = $this->definition();

        return $definition['prefix'] . ' ' . number_format(
            (float) ($amount ?? 0),
            (int) $definition['decimals']
        );
    }

    public function setCode(string $code): void
    {
        $code = $this->normalise($code);

        if (! array_key_exists($code, $this->options())) {
            throw new \InvalidArgumentException('Unsupported currency code.');
        }

        Setting::put('default_currency', $code);
        Cache::forever(self::CACHE_KEY, $code);
    }

    private function normalise(string $code): string
    {
        $code = strtoupper(trim($code));

        return array_key_exists($code, $this->options()) ? $code : 'UGX';
    }
}
