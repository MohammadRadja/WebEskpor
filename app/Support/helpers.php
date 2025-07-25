<?php

use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Arr;

if (!function_exists('asset_or_default')) {
    function asset_or_default(string $path, string $default = 'assets/img/default.png'): string
    {
        return File::exists(public_path($path))
            ? asset($path)
            : asset($default);
    }
}

if (!function_exists('format_tanggal')) {
    function format_tanggal($tanggal, $format = 'd M Y'): string
    {
        return Carbon::parse($tanggal)->translatedFormat($format);
    }
}


if (!function_exists('rupiah')) {
    function rupiah($angka, $prefix = 'Rp'): string
    {
        return $prefix . ' ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('limit_teks')) {
    function limit_teks($text, $limit = 100, $suffix = '...'): string
    {
        return Str::limit(strip_tags($text), $limit, $suffix);
    }
}

if (!function_exists('meta')) {
    function meta($model, $key = null, $default = '-') {
    $data = json_decode($model->meta, true) ?? [];

        if (!is_array($data)) {
            $data = [];
        }

        return $key ? ($data[$key] ?? $default) : $data;
    }
}
