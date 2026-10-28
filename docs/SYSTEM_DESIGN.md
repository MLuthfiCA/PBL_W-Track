# Dokumentasi Perancangan Sistem W-Track

## 1. Arsitektur Sistem
Sistem W-Track mengintegrasikan perangkat pembaca RFID (*Gate*) dengan backend Laravel dan database MySQL untuk memantau keberadaan alat secara otomatis dan real-time.

## 2. Struktur & Relasi Database (ERD)
Sistem menggunakan 3 tabel utama:

- **`users`**: Menyimpan data pengguna/petugas sistem W-Track.
- **`equipments`**: Master data alat dan status keberadaan (`available` / `borrowed`).
  * `rfid_uid` (String, Unique) — Tag RFID pada alat.
  * `name` (String) — Nama alat.
  * `category` (String) — Kategori alat.
  * `status` (Enum: `available`, `borrowed`) — Status lokasi alat.
- **`transactions`**: Catatan riwayat pergerakan keluar/masuk alat.
  * `equipment_id` (Foreign Key -> `equipments.id`)
  * `type` (Enum: `in`, `out`) — Tipe pergerakan alat.
  * `created_at` (Timestamp) — Waktu transaksi dicatat.

## 3. Diagram Alur Transaksi (Sequence Diagram)

### A. Transaksi Keluar (Scan-Out - WTR-03)
```mermaid
sequenceDiagram
    autonumber
    actor Sensor as Gate RFID (Out)
    participant API as TransactionController
    participant DB as Database MySQL

    Sensor->>API: POST /scan-out { rfid_uid }
    API->>DB: Cari equipment berdasarkan rfid_uid
    alt RFID Tidak Ditemukan
        DB-->>API: Data Null
        API-->>Sensor: Response 404 (Not Found)
    else RFID Ditemukan & Status = 'borrowed'
        DB-->>API: Data Equipment
        API-->>Sensor: Response 400 (Already Borrowed)
    else RFID Ditemukan & Status = 'available'
        DB-->>API: Data Equipment
        API->>DB: Simpan Transaction (type: 'out')
        API->>DB: Update Equipment (status: 'borrowed')
        API-->>Sensor: Response 200 (Success)
    end

### B. Transaksi Masuk (Scan-In - WTR-04)
    sequenceDiagram
    autonumber
    actor Sensor as Gate RFID (In)
    participant API as TransactionController
    participant DB as Database MySQL

    Sensor->>API: POST /scan-in { rfid_uid }
    API->>DB: Cari equipment berdasarkan rfid_uid
    alt RFID Tidak Ditemukan
        DB-->>API: Data Null
        API-->>Sensor: Response 404 (Not Found)
    else RFID Ditemukan & Status = 'available'
        DB-->>API: Data Equipment
        API-->>Sensor: Response 400 (Already Inside)
    else RFID Ditemukan & Status = 'borrowed'
        DB-->>API: Data Equipment
        API->>DB: Simpan Transaction (type: 'in')
        API->>DB: Update Equipment (status: 'available')
        API-->>Sensor: Response 200 (Success)
    end

## 4. Spesifikasi API Endpoints
### 1. POST /scan-out
    {
        "success": true,
        "message": "Transaksi keluar berhasil dicatat.",
        "data": {
            "equipment_name": "Gerinda Tangan 4 Inch",
            "rfid_uid": "A3B8129F",
            "status": "borrowed",
            "time_out": "2026-10-27 10:14:00"
        }
    }

### 2. POST /scan-in
    {
        "success": true,
        "message": "Transaksi masuk (pengembalian) berhasil dicatat.",
        "data": {
            "equipment_name": "Gerinda Tangan 4 Inch",
            "rfid_uid": "A3B8129F",
            "status": "available",
            "time_in": "2026-10-27 10:15:00"
        }
    }
    