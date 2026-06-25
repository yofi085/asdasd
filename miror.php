<?php
// 1. Link embed yang kamu punya
$url_embed = "https://embed.rctiplus.com/live/gtv/inewsid";

// 2. Buka halaman embed tersebut (berpura-pura jadi browser)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url_embed);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
$hasil_html = curl_exec($ch);
curl_close($ch);

// 3. Cari link m3u8 di dalam tumpukan kode HTML menggunakan Regex (Pencocokan Teks)
// Kita mencari teks yang diawali "http" dan diakhiri ".m3u8" beserta token-tokennya
preg_match('/(https?:\/\/[^\s"\'<>]+m3u8[^\s"\'<>]*)/i', $hasil_html, $cocok);

if (isset($cocok[1])) {
    // Jika link m3u8 ketemu!
    $link_m3u8_asli = $cocok[1];
    
    // 4. Arahkan media player kamu ke link m3u8 yang berhasil didapat
    header("Location: " . $link_m3u8_asli);
    exit;
} else {
    // Jika sistem RCTI+ menyembunyikan linknya lebih dalam (misal pakai JavaScript)
    echo "Gagal menemukan link m3u8. RCTI+ mungkin mengubah sistem keamanannya.";
}
?>