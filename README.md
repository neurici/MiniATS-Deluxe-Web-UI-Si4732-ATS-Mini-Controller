# MiniATS Deluxe (Web UI) — Si4732 ATS-Mini Controller

Modern, responsive web interface for controlling **Si4732 ATS-Mini / MiniATS** devices via the built-in `/api/*` endpoints — with **desktop + mobile layouts**, **themes**, **RO/EN UI**, and a lightweight **PHP proxy** layer.

> UI name in project: **“MiniATS Deluxe By Gersiu”**.

---

## ⚠️ Firmware compatibility (IMPORTANT)

🚨 **Firmware requirement**

At this moment, this web interface is **compatible ONLY with the following firmware version**:

- **F/W v2.30d — Aug 22 2025**

The application relies on:
- the exact structure of `/api/status`,
- `/api/statusOptions`,
- and memory-related endpoints as implemented in **F/W v2.30d**.

❗ **Other firmware versions are NOT guaranteed to work**  
Older or newer firmware revisions may:
- expose different API fields,
- change endpoint behavior,
- or break features such as frequency control, memories, AGC, or RDS.

➡️ If you plan to use a different firmware version, code changes **will be required** in:
- `proxy.php`
- frontend status parsing logic (JS)

---

## ✨ Features

- **Desktop UI + Mobile UI**
  - Desktop layout includes a large main area with a **canvas waterfall (simulated)**.
  - Mobile layout includes a **fixed bottom control bar** for quick tuning/seek/mute/volume.
- **Automatic device detection / redirect**
  - `index.html` routes to `mobile.html` or `desktop.html` based on user-agent + screen size.
- **Multilingual UI (RO/EN)**
  - Language dropdown in header; texts are mapped via `data-i18n` + dictionary in JS.
- **Themes**
  - SDR++ Blue/Red, Carbon, HackRF Neon, WebSDR.
- **Direct frequency input**
  - Numeric-only input with mobile numeric keyboard.
  - Invalid frequency is highlighted in red.
- **Core controls**
  - Tune, Seek, Mute, Volume, Squelch, AGC/Att, Band/Step/BW.
- **RDS + Signal info**
  - RDS scrolling text, PI, station name, RSSI & SNR S-meter.
- **ATS-Mini Memories**
  - List, store, tune, and clear memory slots via API proxy.

---

## 🧱 Project structure


---

## 🚀 Quick start

1. Upload files to a PHP-enabled web server.
2. Edit `config.php` and set your ATS-Mini IP / hostname.
3. Open `index.html` in your browser.

---

## ⚙️ Configuration

### Firmware
Make sure your ATS-Mini is running: **F/W v2.30d Aug 22 2025**


Using any other firmware version may result in **undefined behavior**.

---

## 🛡️ Security notes

This project is intended for **local network usage only**.  
If exposed publicly, secure it with authentication, HTTPS, and IP restrictions.

---

## 📜 License

Specify your preferred license (MIT / GPL / Apache 2.0).

---

## 👤 Credits

- UI & concept: **MiniATS Deluxe By Gersiu**
- Author: **Cogian Sergiu**
