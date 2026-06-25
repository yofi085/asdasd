export default async function handler(req, res) {
  const url_embed = "https://embed.rctiplus.com/live/gtv/inewsid";

  try {
    // 1. Bertingkah seperti browser untuk mengambil halaman embed
    const response = await fetch(url_embed, {
      headers: {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
        "Referer": "https://embed.rctiplus.com/"
      }
    });
    
    // 2. Baca isi HTML-nya
    const html = await response.text();

    // 3. Cari link .m3u8 menggunakan Regex
    const regex = /(https?:\/\/[^\s"\'<>]+m3u8[^\s"\'<>]*)/i;
    const match = html.match(regex);

    // 4. Jika ketemu, langsung redirect media playermu ke link tersebut
    if (match && match[1]) {
      res.redirect(302, match[1]);
    } else {
      res.status(404).send("Gagal menemukan link m3u8. Keamanan mungkin diubah.");
    }
    
  } catch (error) {
    res.status(500).send("Terjadi kesalahan pada server proxy.");
  }
}
