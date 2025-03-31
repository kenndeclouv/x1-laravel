<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class SearchController extends Controller
{
    // public function getNavigation()
    // {
    //     $sidebarHtml = view('components.layouts.sections.sidebar')->render();
    //     $crawler = new Crawler($sidebarHtml);
    //     $navigation = [];

    //     // Ambil semua menu section (header)
    //     $crawler->filter('.menu-header-text')->each(function (Crawler $sectionNode) use (&$navigation, $crawler) {
    //         $sectionName = trim($sectionNode->text());

    //         // Cari semua menu-item setelah header ini
    //         $items = [];

    //         $liNode = $sectionNode->closest('li');

    //         if ($liNode->count() > 0) {
    //             $liNode->nextAll()->each(function (Crawler $node) use (&$items) {
    //                 if ($node->matches('.menu-header')) {
    //                     // Berhenti kalau ketemu header baru
    //                     return false;
    //                 }

    //                 if ($node->matches('.menu-item')) {
    //                     // pastiin elemen ada sebelum akses text()/attr()
    //                     $name = $node->filter('[data-i18n]')->count() > 0 ? trim($node->filter('[data-i18n]')->text()) : 'Unknown';
    //                     $icon = $node->filter('.menu-icon i')->count() > 0 ? $node->filter('.menu-icon i')->attr('class') : '';
    //                     $url = $node->filter('a')->count() > 0 ? $node->filter('a')->attr('href') : '#';
    //                     $iconNode = $node->filter('.menu-icon');
    //                     if ($iconNode->count() && $iconNode->filter('i')->count()) {
    //                         $icon = $iconNode->filter('i')->attr('class') ?? '';
    //                     } else {
    //                         $icon = 'not-found';
    //                     }

    //                     // Format icon ke bentuk tabler
    //                     preg_match('/tabler-(\w+)/', $icon, $matches);
    //                     $icon = isset($matches[1]) ? 'tabler-' . $matches[1] : '';

    //                     $items[] = [
    //                         'name' => $name,
    //                         'icon' => $icon,
    //                         'url' => $url
    //                     ];
    //                 }
    //             });
    //         }

    //         if (!empty($items)) {
    //             $navigation[$sectionName] = $items;
    //         }
    //     });

    //     return response()->json([
    //         'navigation' => $navigation,
    //         'suggestions' => $navigation // bisa diubah sesuai kebutuhan
    //     ]);
    // }
    public function getNavigation()
    {
        $sidebarHtml = view('components.layouts.sections.sidebar')->render();
        $crawler = new Crawler($sidebarHtml);

        $navigation = [];
        $currentCategory = null;

        // Ambil semua elemen dalam menu
        $crawler->filter('.menu-inner > *')->each(function ($node) use (&$navigation, &$currentCategory) {
            if ($node->nodeName() === 'li' && $node->attr('class') && str_contains($node->attr('class'), 'menu-header')) {
                // Ambil kategori (menu-header)
                $currentCategory = trim($node->text());
                $navigation[$currentCategory] = [];
            } elseif ($node->nodeName() === 'li' && $node->attr('class') && str_contains($node->attr('class'), 'menu-item')) {
                // Ambil link dalam menu-item
                if ($currentCategory) {
                    $link = $node->filter('.menu-link')->first();
                    $icon = $node->filter('.menu-icon')->first();
                    $name = trim($link->filter('div')->first()->text());
                    $url = $link->attr('href');
                    $iconClass = $icon->attr('class');

                    $navigation[$currentCategory][] = [
                        'name' => $name,
                        'icon' => $this->extractIcon($iconClass),
                        'url' => $url,
                    ];
                }
            }
        });

        // Acak key-nya buat ambil 2-3 section
        $sections = array_keys($navigation);
        // shuffle($sections);
        // $selectedSections = array_slice($sections, 0, rand(2, 3));
        $selectedSections = array_slice($sections, 0, 2);

        // Ambil menu dari section yang dipilih
        $suggestions = [];
        foreach ($selectedSections as $section) {
            $suggestions[$section] = $navigation[$section];
        }

        return response()->json([
            "navigation" => $navigation,
            "suggestions" => $suggestions
        ]);
    }

    // Fungsi buat ngambil icon terakhir
    private function extractIcon($iconClass)
    {
        $classes = explode(' ', $iconClass);
        return end($classes); // Ambil class terakhir (biasanya icon-nya)
    }
}
