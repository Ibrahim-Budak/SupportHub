# SupportHub — Gerçek Zamanlı Müşteri Destek (Ticket) Sistemi

SupportHub, müşterilerin destek talebi oluşturabildiği, destek temsilcilerinin bu talepleri yönetebildiği ve mesajlaşmanın **gerçek zamanlı** olarak gerçekleştiği bir ticket yönetim sistemidir. Laravel 10 ve Laravel Reverb kullanılarak geliştirilmiştir.

## 🚀 Özellikler

- **Talep Oluşturma:** Müşteriler başlık, kategori ve öncelik (Düşük/Orta/Yüksek) belirterek destek talebi açabilir.
- **Destek Temsilcisi Paneli:** Temsilciler talepleri "Açık", "İşleniyor", "Yanıtlandı" veya "Kapatıldı" olarak güncelleyebilir.
- **Gerçek Zamanlı Mesajlaşma:** Laravel Reverb ile WebSocket üzerinden, sayfa yenilenmeden mesajlaşma.
- **Yetkilendirme (Policy):** Müşteriler yalnızca kendi taleplerini görebilir; temsilciler ve adminler tüm talepleri yönetebilir.
- **SLA Takibi:** Yüksek öncelikli bir talebe 2 saat içinde yanıt verilmezse, zamanlanmış bir komut talebi otomatik olarak "gecikmiş" işaretler.

## 🛠️ Kullanılan Teknolojiler

- **Backend:** Laravel 10, PHP 8.2+
- **Gerçek Zamanlı İletişim:** Laravel Reverb (WebSocket)
- **Kimlik Doğrulama:** Laravel Breeze
- **Veritabanı:** SQLite (geliştirme ortamı için)
- **Frontend:** Blade, Tailwind CSS

## 📦 Kurulum

Projeyi yerel makinenizde çalıştırmak için:

```bash
git clone https://github.com/Ibrahim-Budak/SupportHub.git
cd SupportHub

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate

npm run build
```

## ▶️ Çalıştırma

Proje üç ayrı terminalde çalıştırılmalıdır:

**1. Web sunucusu:**
```bash
php artisan serve
```

**2. WebSocket sunucusu (gerçek zamanlı mesajlaşma için):**
```bash
php artisan reverb:start
```

**3. (Opsiyonel) Zamanlanmış görevler (SLA kontrolü):**
```bash
php artisan schedule:work
```

Ardından tarayıcıdan `http://127.0.0.1:8000` adresine gidin.

## 🔐 Roller

Sistemde üç kullanıcı rolü bulunur: `customer`, `agent`, `admin`. Yeni kayıt olan kullanıcılar varsayılan olarak `customer` rolüyle oluşturulur. Bir kullanıcıyı temsilci yapmak için:

```bash
php artisan tinker
```
```php
$user = App\Models\User::find(1);
$user->role = 'agent';
$user->save();
```

## 📋 Manuel SLA Kontrolü

SLA kontrolünü zamanlamayı beklemeden manuel çalıştırmak için:

```bash
php artisan tickets:check-sla
```

## 📄 Lisans

Bu proje eğitim/portföy amaçlı geliştirilmiştir.