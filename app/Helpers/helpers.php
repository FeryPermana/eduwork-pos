<?php

use App\Models\Tag;
use Illuminate\Support\Str;

function increment($data, $loop)
{
    return $data->firstItem() + $loop->index;
}

// format tanggal indo from datetime
function formatTanggalIndo($date, $type = null, $year = null)
{
    if ($date == null) {
        return '-';
    }

    if ($type == 'singkat') {
        $BulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    } else {
        $BulanIndo = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    }

    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl = substr($date, 8, 2);
    if ($year == "kosong") {
        $result = $tgl . ' ' . $BulanIndo[(int) $bulan - 1];
    } else if ($bulan == 0) {
        $result = 0;
    } else {
        $result = $tgl . ' ' . $BulanIndo[(int) $bulan - 1] . ' ' . $tahun;
    }
    return $result;
}

function formatTanggalIndoWithTime($datetime, $small = null)
{
    if ($datetime == null) {
        return '-';
    } else {
        $dt = new DateTime($datetime);
        $date = $dt->format('Y-m-d');
        $time = $dt->format('H:i:s');

        if ($small != null) {
            $BulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        } else {
            $BulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        }

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);

        $result = $tgl . ' ' . $BulanIndo[(int) $bulan - 1] . ' ' . $tahun . ', ' . substr($time, 0, 5);
        return $result;
    }
}

function formatTanggalIndoWithdays($date, $small = null)
{
    if ($date == null) {
        return '-';
    } else {
        $dt = new DateTime($date);
        $date = $dt->format('Y-m-d');

        if ($small != null) {
            $BulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        } else {
            $BulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        }

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);

        $arr = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $day = date('l', strtotime($date));

        $result = $arr[$day] . ', ' . $tgl . ' ' . $BulanIndo[(int) $bulan - 1] . ' ' . $tahun;
        return $result;
    }
}

function rupiahFormat($angka)
{
    if ($angka == null) {
        return 'Rp. ' . 0;
    }

    $rp = 'Rp. ' . number_format($angka, 0, ',', '.');
    return $rp;
}

function removeRupiah($angka)
{
    return str_replace("Rp ", "", str_replace(".", "", $angka));
}

function estimateReadingTime($text, $wpm = 200)
{
    $totalWords = str_word_count(strip_tags($text));
    $minutes = floor($totalWords / $wpm);
    $seconds = floor($totalWords % $wpm / ($wpm / 60));

    if ($minutes < 1) {
        return $seconds . " " . Str::of('sec');
    } else {
        return $minutes . " " . Str::of('min');
    }
}

function remove_query_params(array $params = [])
{
    $url = url()->current(); // get the base URL - everything to the left of the "?"
    $query = request()->query(); // get the query parameters (what follows the "?")

    foreach ($params as $param) {
        unset($query[$param]); // loop through the array of parameters we wish to remove and unset the parameter from the query array
    }

    return $query ? $url . '?' . http_build_query($query) : $url; // rebuild the URL with the remaining parameters, don't append the "?" if there aren't any query parameters left
}

function number_format_short($n, $precision = 1)
{
    if ($n < 1000) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 1000000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'k';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }

    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format . $suffix;
}

/**
 * @param string $url
 * @param $query string|array
 * @return string
 */
function appendQueryStringToURL($url, $query)
{
    // the query is empty, return the original url straightaway
    if (empty($query)) {
        return $url;
    }

    $parsedUrl = parse_url($url);
    if (empty($parsedUrl['path'])) {
        $url .= '/';
    }

    // if the query is array convert it to string
    $queryString = is_array($query) ? http_build_query($query) : $query;

    // check if there is already any query string in the URL
    if (empty($parsedUrl['query'])) {
        // remove duplications
        parse_str($queryString, $queryStringArray);
        $url .= '?' . http_build_query($queryStringArray);
    } else {
        $queryString = $parsedUrl['query'] . '&' . $queryString;

        // remove duplications
        parse_str($queryString, $queryStringArray);

        // place the updated query in the original query position
        $url = substr_replace($url, http_build_query($queryStringArray), strpos($url, $parsedUrl['query']), strlen($parsedUrl['query']));
    }

    return $url;
}

function waktu($time)
{
    return substr($time, 3, 5);
}

function greetings()
{
    $time = date('H');
    $timezone = date('e');
    if ($time < '12') {
        return 'Good Morning';
    } elseif ($time >= '12' && $time < '17') {
        return 'Good Afternoon';
    } elseif ($time >= '17' && $time < '19') {
        return 'Good Evening';
    } elseif ($time >= '19') {
        return 'Good Night';
    }
}

function greetingIndo()
{
    $time = date('H');
    $timezone = date('e');
    if ($time < '12') {
        return 'Selamat Pagi';
    } elseif ($time >= '12' && $time < '17') {
        return 'Selamat Siang';
    } elseif ($time >= '17' && $time < '19') {
        return 'Selamat Sore';
    } elseif ($time >= '19') {
        return 'Selamat Malam';
    }
}

// get tag ids
function get_tag_id_array($tagIds)
{
    $tagIdArray = [];
    foreach ($tagIds as $val) {
        $tag = Tag::firstOrCreate([
            'name' => $val
        ], [
            'name' => $val
        ]);

        $tagIdArray[] = $tag->id;
    }

    return $tagIdArray;
}

function hyphenate($str, $number)
{
    return implode("-", str_split($str, $number));
}

function minutes($time)
{
    if ($time != null) {
        $time = explode(':', $time);
        return round(($time[0] * 60) + ($time[1]) + ($time[2] / 60));
    }

    return 0;
}

function secondsToTime($inputSeconds)
{
    $inputS =  $inputSeconds != 0 ? $inputSeconds : 0;
    $jam = gmdate("i", $inputS);

    $arr = str_split($jam);
    if (count($arr) > 0 && $arr[0] === '0') {
        unset($arr[0]);
        return implode($arr);
    } else {
        return $jam;
    }
}

function detikKeWaktu($detik)
{
    $seconds =  $detik != 0 ? $detik : 0;

    $secs = $seconds % 60;
    $hrs = $seconds / 60;
    $mins = $hrs % 60;

    $hrs = $hrs / 60;

    if ((int)$secs == 0) {
        return "-";
    } else if ((int)$mins == 0) {
        return (int)$secs . " Detik ";
    } else if ((int)$hrs == 0) {
        return (int)$mins . " Menit " . (int)$secs . " Detik ";
    } else {
        return (int)$hrs . " Jam " . (int)$mins . " Menit " . (int)$secs . " Detik ";
    }
}

function indoPhone($phone)
{
    $arr = str_split($phone);
    if ($arr[0] === '0') {
        unset($arr[0]);
        return '62' . implode($arr);
    } else {
        return $phone;
    }
}

function formatLokalPhone($phone)
{
    $phone = str_replace("+", "", $phone);

    if (substr(trim($phone), 0, 2) == '62') {
        return substr_replace($phone, '0', 0, 2);
    } else {
        return $phone;
    }
}

// change format phone to 62
function formatPhoneId($value)
{
    $arr = str_split($value);

    if ($arr[0] === '0') {
        unset($arr[0]);
        $phone = '62' . implode($arr);
        return $phone;
    } else {
        $phone = '62' . $value;
        return $phone;
    }
}
