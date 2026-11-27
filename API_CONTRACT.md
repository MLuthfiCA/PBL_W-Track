# W-Track API Contract — ESP32 / IoT Integration

> Dokumentasi endpoint API untuk integrasi perangkat RFID reader (ESP32) dengan sistem W-Track.

---

## Endpoint

| Method | URL          | Content-Type       | Auth | CSRF |
|--------|--------------|--------------------|------|------|
| POST   | `/api/scan`  | `application/json` | ❌    | ❌    |

> Endpoint ini **tidak memerlukan autentikasi** dan **dikecualikan dari verifikasi CSRF** agar ESP32 bisa langsung mengirim request.

---

## Request Body (JSON)

| Field  | Tipe   | Wajib | Keterangan                                      |
|--------|--------|-------|--------------------------------------------------|
| `uid`  | string | ✅     | RFID UID tag yang di-scan (contoh: `"A3B8129F"`) |
| `type` | string | ✅     | Tipe transaksi: `"out"` (keluar) atau `"in"` (masuk) |

---

## Contoh Request

### Scan Keluar (Equipment dipinjam)

```http
POST /api/scan HTTP/1.1
Host: 192.168.x.x:8000
Content-Type: application/json

{
    "uid": "A3B8129F",
    "type": "out"
}
```

### Scan Masuk (Equipment dikembalikan)

```http
POST /api/scan HTTP/1.1
Host: 192.168.x.x:8000
Content-Type: application/json

{
    "uid": "A3B8129F",
    "type": "in"
}
```

---

## Contoh Response

### ✅ Sukses — Equipment Keluar (200)

```json
{
    "success": true,
    "message": "Equipment berhasil dicatat KELUAR.",
    "data": {
        "equipment_name": "Bor Listrik Bosch",
        "rfid_uid": "A3B8129F",
        "status": "borrowed",
        "timestamp": "2026-11-27 14:30:00"
    }
}
```

### ✅ Sukses — Equipment Masuk (200)

```json
{
    "success": true,
    "message": "Equipment berhasil dicatat MASUK.",
    "data": {
        "equipment_name": "Bor Listrik Bosch",
        "rfid_uid": "A3B8129F",
        "status": "available",
        "timestamp": "2026-11-27 15:00:00"
    }
}
```

### ❌ Error — RFID UID Tidak Ditemukan (404)

```json
{
    "success": false,
    "message": "RFID UID tidak ditemukan dalam sistem."
}
```

### ❌ Error — Equipment Sudah Dipinjam (400)

```json
{
    "success": false,
    "message": "Equipment \"Bor Listrik Bosch\" sudah berstatus dipinjam."
}
```

### ❌ Error — Equipment Sedang Diperbaiki (400)

```json
{
    "success": false,
    "message": "Equipment \"Bor Listrik Bosch\" sedang dalam perbaikan, tidak bisa dipinjam."
}
```

### ❌ Error — Equipment Sudah Tersedia (400)

```json
{
    "success": false,
    "message": "Equipment \"Bor Listrik Bosch\" sudah berstatus tersedia."
}
```

### ❌ Error — Validasi Gagal (422)

```json
{
    "message": "The uid field is required.",
    "errors": {
        "uid": ["The uid field is required."],
        "type": ["The type field is required."]
    }
}
```

---

## Contoh Kode Arduino (ESP32)

```cpp
#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

const char* serverUrl = "http://192.168.x.x:8000/api/scan";

void sendScan(String uid, String type) {
    HTTPClient http;
    http.begin(serverUrl);
    http.addHeader("Content-Type", "application/json");

    // Buat JSON payload
    JsonDocument doc;
    doc["uid"]  = uid;
    doc["type"] = type;

    String payload;
    serializeJson(doc, payload);

    // Kirim POST request
    int httpCode = http.POST(payload);
    String response = http.getString();

    Serial.printf("HTTP Code: %d\n", httpCode);
    Serial.println("Response: " + response);

    http.end();
}
```

---

## Status Equipment

| Status        | Keterangan                          |
|---------------|-------------------------------------|
| `available`   | Tersedia di workshop                |
| `borrowed`    | Sedang dipinjam / di luar workshop  |
| `maintenance` | Sedang dalam perbaikan              |

---

## Catatan

- Ganti `192.168.x.x` dengan IP server Laravel yang menjalankan W-Track.
- Pastikan ESP32 dan server berada di jaringan yang sama.
- Port default Laravel dev server: `8000`. Jika menggunakan XAMPP/Apache, gunakan port `80`.
- Endpoint `/scan-out` (lama) tetap tersedia untuk backward compatibility.
