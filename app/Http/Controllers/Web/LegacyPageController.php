<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;

class LegacyPageController extends Controller
{
    public function show(string $page): View
    {
        abort_unless(view()->exists("legacy.{$page}"), 404);

        $legacyDocument = view("legacy.{$page}")->render();

        return view('legacy.shell', [
            'legacyPage' => $page,
            'legacyTitle' => $this->title($legacyDocument, $page),
            'legacyHead' => new HtmlString($this->headAssets($legacyDocument)),
            'legacyContent' => new HtmlString($this->mainContent($legacyDocument)),
            'legacyScripts' => new HtmlString($this->scripts($legacyDocument)),
        ]);
    }

    private function title(string $document, string $page): string
    {
        if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $document, $matches)) {
            $title = trim(html_entity_decode(strip_tags($matches[1]), ENT_QUOTES | ENT_HTML5));
            $title = preg_replace('/^Medi[- ]track\s*\|\s*/i', '', $title) ?: $title;

            return $title;
        }

        return ucwords(str_replace(['-', '_'], ' ', $page));
    }

    private function headAssets(string $document): string
    {
        if (! preg_match('/<head[^>]*>(.*?)<\/head>/is', $document, $matches)) {
            return '';
        }

        preg_match_all(
            '/<(?:link|style)\b.*?(?:<\/style>|\/?>)|<script\b[^>]*\bsrc=["\'][^"\']+["\'][^>]*>\s*<\/script>/is',
            $matches[1],
            $assets
        );

        return preg_replace_callback(
            '/\b(href|src)=(["\'])style\.css\2/i',
            fn (array $match): string => $match[1] . '=' . $match[2] . asset('style.css') . $match[2],
            implode("\n", $assets[0])
        ) ?: '';
    }

    private function mainContent(string $document): string
    {
        if (preg_match('/<main\b[^>]*>(.*?)<\/main>/is', $document, $matches)) {
            return trim($matches[1]);
        }

        if (! preg_match('/<body[^>]*>(.*?)<\/body>/is', $document, $matches)) {
            return $document;
        }

        $content = $matches[1];
        $content = preg_replace(
            '/<aside\b(?=[^>]*(?:id|class)=["\'][^"\']*(?:sidebar|side-bar)[^"\']*["\'])[^>]*>.*?<\/aside>/is',
            '',
            $content,
            1
        ) ?: $content;

        return trim($content);
    }

    private function scripts(string $document): string
    {
        if (! preg_match('/<body[^>]*>(.*?)<\/body>/is', $document, $matches)) {
            return '';
        }

        preg_match_all('/<script\b.*?<\/script>/is', $matches[1], $scripts);

        return preg_replace(
            '/<script\b[^>]*\bsrc=["\'][^"\']*sidebar\.js[^"\']*["\'][^>]*>\s*<\/script>/is',
            '',
            implode("\n", $scripts[0])
        ) ?: '';
    }
}
