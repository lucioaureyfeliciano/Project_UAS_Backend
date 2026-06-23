<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Laravel Logo">
</p>

<h1 align="center">Project UAS Backend</h1>

<p align="center">
  Aplikasi media sosial bergaya Twitter/X — tweet, komunitas, dan direct message — dibangun dengan Laravel untuk Ujian Akhir Semester (UAS).
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-%5E8.2-777BB4?style=flat&logo=php" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Tailwind%20CSS-4.x-38B2AC?style=flat&logo=tailwindcss" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License MIT">
</p>

---

## Tentang Project

**Project UAS Backend** adalah aplikasi web full-stack yang meniru fungsionalitas inti platform media sosial seperti Twitter/X. Dibangun dengan Laravel 12 menggunakan server-rendered Blade templates yang dipadukan dengan JavaScript (AJAX/Axios) untuk interaksi dinamis tanpa reload halaman.

Aplikasi ini mencakup siklus penuh interaksi sosial: membuat tweet, berinteraksi (like, dislike, repost, comment, bookmark), mengelola relasi sosial (follow, block, mute), privasi akun, bergabung dengan komunitas, notifikasi, hingga mengirim pesan pribadi (direct message).

## Daftar Isi

- [Fitur Lengkap](#-fitur-lengkap)
- [Struktur Database](#-struktur-database)
- [Daftar Route](#-daftar-route)
- [Teknologi yang Digunakan](#️-teknologi-yang-digunakan)
- [Instalasi & Menjalankan Project](#-instalasi--menjalankan-project)
- [Kontributor](#-kontributor)
- [Lisensi](#-lisensi)

---

## Fitur Lengkap

### 1. Autentikasi (`AuthController`)
- **Register**: pendaftaran akun baru dengan `username`, `email`, `password` (validasi unik dan minimal 6 karakter password).
- **Login**: autentikasi berbasis session menggunakan email & password.
- **Logout**: invalidasi session dan regenerasi token.

### 2. Profil Pengguna (`ProfileController`)
- Melihat profil sendiri lengkap dengan daftar tweet, jumlah follower/following.
- Melihat profil pengguna lain berdasarkan `username`.
- Edit deskripsi/bio profil.
- Melihat daftar **followers** dan **following** dari suatu user.
- Pencarian pengguna berdasarkan `username`.
- Pencarian khusus untuk fitur **mention** (`@username`) saat menulis tweet/komentar.

### 3. Tweet (`TweetController`)
- Membuat tweet baru (judul + konten), otomatis mendeteksi dan menyimpan **hashtag** (`#topik`) yang ada di dalam konten.
- Menampilkan seluruh tweet.
- Menampilkan detail satu tweet beserta relasinya (user, like, dislike, repost, comment).
- Edit tweet (hanya oleh pemilik tweet).
- Hapus tweet (hanya oleh pemilik tweet).
- Menampilkan seluruh tweet berdasarkan hashtag tertentu.

### 4. Feed / Dashboard (`FeedController`)
- Tab **"For You"**: menampilkan seluruh tweet (tanpa user yang di-*block*/*mute*).
- Tab **"Following"**: menampilkan tweet hanya dari user yang di-follow (+ tweet sendiri).
- Menyertakan daftar **trending hashtag** (5 hashtag dengan jumlah tweet terbanyak).
- Otomatis menyaring tweet dari user yang sudah diblokir atau dibisukan.

### 5. Komentar (`CommentController`)
- Melihat seluruh komentar dari sebuah tweet (mendukung **nested reply** lewat `parent_id`).
- Membuat komentar baru pada tweet (termasuk balasan ke komentar lain).
- Edit dan hapus komentar milik sendiri.
- Melihat detail satu komentar.
- **Pin komentar**: menyematkan satu komentar agar tampil di atas pada sebuah tweet.

### 6. Like & Dislike (`LikeController`, `DislikeController`)
- Toggle like pada tweet (like ulang = batal like).
- Toggle dislike pada tweet (mutually exclusive dengan like, ditangani lewat `InteractionService`).
- Otomatis memicu notifikasi ke pemilik tweet saat di-*like*.

### 7. Repost (`RepostController`)
- Toggle repost (retweet) pada sebuah tweet.
- Otomatis memicu notifikasi ke pemilik tweet asli.

### 8. Bookmark (`BookmarkController`)
- Menyimpan tweet ke daftar bookmark pribadi.
- Melihat seluruh tweet yang di-bookmark.
- Melihat detail satu bookmark.
- Menghapus tweet dari bookmark.

### 9. Hashtag (`TweetController@showHashtag`)
- Setiap tweet otomatis di-parsing untuk mendeteksi hashtag (`#kata`).
- Halaman khusus untuk menampilkan seluruh tweet dengan hashtag tertentu.
- Hashtag trending ditampilkan di dashboard.

### 10. Follow System (`FollowController`)
- Toggle follow/unfollow ke user lain.
- Memicu notifikasi tipe `follow` ke user yang di-follow.

### 11. Block & 🔇 Mute (`BlockController`, `MuteController`)
- **Block**: memblokir user lain — tweet & interaksinya akan disembunyikan dari feed.
- **Mute**: membisukan user lain — tweetnya tetap ada tapi tidak ditonjolkan/notifikasi diredam.
- Toggle (block/unblock, mute/unmute) dengan satu endpoint yang sama.

### 12. Privasi (`PrivacyController`)
- Toggle status akun privat/publik (`is_private`).
- Melihat halaman pengaturan privasi.
- Melihat daftar user yang diblokir.
- Melihat daftar user yang dibisukan.

### 13. Komunitas (`CommunityController`)
- Membuat komunitas baru (nama unik, deskripsi, status privat/publik).
- Melihat daftar seluruh komunitas dan detail satu komunitas (anggota, deskripsi).
- Edit dan hapus komunitas (oleh pembuat komunitas).
- **Join langsung** ke komunitas publik.
- **Request to join** untuk komunitas privat — menunggu approval.
- Approve / reject permintaan bergabung oleh pemilik komunitas.
- Leave (keluar) dari komunitas.
- Pencatatan **aktivitas komunitas** (create, join, leave, dsb.) lewat `CommunityActivity`.

### 14. Notifikasi (`NotificationController`)
- Menampilkan seluruh notifikasi milik user (tipe: `like`, `comment`, `follow`, `repost`, `mention`).
- Melihat detail satu notifikasi.
- Menandai satu notifikasi sebagai sudah dibaca.
- Menandai **semua** notifikasi sebagai sudah dibaca.
- Menghapus satu notifikasi.
- Menghapus **semua** notifikasi sekaligus.

### 15. Direct Message / Chat (`MessageController`)
- **Inbox**: daftar percakapan, dikelompokkan per lawan bicara, menampilkan pesan terakhir dan jumlah pesan belum dibaca.
- **Chat per user**: melihat seluruh riwayat pesan dengan satu user tertentu, otomatis menandai pesan masuk sebagai *read* saat dibuka.
- Mengirim pesan baru (maks. 1000 karakter, otomatis trim whitespace).
- **Reply** ke pesan tertentu dalam chat (`reply_to_id`).
- Edit pesan — **hanya dalam rentang 5 menit** setelah dikirim; status `edited_at` tercatat dan status *read* di-reset.
- Hapus pesan milik sendiri.
- **Search**: mencari user untuk memulai chat baru, sekaligus mencari di antara percakapan yang ada.
- **Share to chat**: membagikan sebuah tweet langsung sebagai pesan ke kontak tertentu.

### 16. Usage / Statistik (`UsageController`)
- Dashboard ringkasan: total user, total tweet, total komunitas, total aktivitas follow, total aktivitas komunitas.
- Detail daftar seluruh user.
- Detail daftar seluruh tweet (dengan pemiliknya).
- Detail seluruh aktivitas follow (siapa follow siapa).
- Detail seluruh komunitas (dengan pembuatnya).
- Detail seluruh aktivitas komunitas.

---

## Struktur Database

### `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `username` | string | unik |
| `email` | string | unik |
| `email_verified_at` | timestamp | nullable |
| `password` | string | terenkripsi (hash) |
| `bio` | text | nullable |
| `profile_picture` | string | nullable |
| `is_private` | integer | default `0` — status akun privat/publik |
| `remember_token` | string | |
| `created_at`, `updated_at` | timestamp | |

### `tweets`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `title` | string | |
| `user_id` | FK → `users.id` | cascade on delete |
| `content` | text | |
| `created_at`, `updated_at` | timestamp | |

### `comments`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | string, PK | |
| `content` | text | |
| `user_id` | FK → `users.id` | cascade on delete |
| `tweet_id` | FK → `tweets.id` | cascade on delete |
| `parent_id` | string, nullable | FK → `comments.id` (nested reply), cascade on delete |
| `is_pinned` | boolean | default `false` |
| `created_at`, `updated_at` | timestamp | |

### `likes`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `user_id` | FK → `users.id` | cascade on delete |
| `tweet_id` | FK → `tweets.id` | cascade on delete |
| `created_at`, `updated_at` | timestamp | |

### `dislikes`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `user_id` | FK → `users.id` | cascade on delete |
| `tweet_id` | FK → `tweets.id` | cascade on delete |
| `created_at`, `updated_at` | timestamp | |
| — | unique | kombinasi `user_id` + `tweet_id` |

### `reposts`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `user_id` | FK → `users.id` | cascade on delete |
| `tweet_id` | FK → `tweets.id` | cascade on delete |
| `created_at`, `updated_at` | timestamp | |

### `bookmarks`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | string, PK | |
| `user_id` | FK → `users.id` | cascade on delete |
| `tweet_id` | FK → `tweets.id` | cascade on delete |
| `created_at`, `updated_at` | timestamp | |
| — | unique | kombinasi `user_id` + `tweet_id` |

### `hashtags`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `name` | string | unik |
| `created_at`, `updated_at` | timestamp | |

### `tweet_hashtags` (pivot)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `tweet_id` | FK → `tweets.id` | cascade on delete |
| `hashtag_id` | FK → `hashtags.id` | cascade on delete |
| `created_at`, `updated_at` | timestamp | |

### `follows`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `follower_id` | FK → `users.id` | user yang melakukan follow, cascade on delete |
| `following_id` | FK → `users.id` | user yang di-follow, cascade on delete |
| `created_at`, `updated_at` | timestamp | |
| — | unique | kombinasi `follower_id` + `following_id` |

### `blocks`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `user_id` | FK → `users.id` | yang memblokir, cascade on delete |
| `blocked_user_id` | FK → `users.id` | yang diblokir, cascade on delete |
| `created_at`, `updated_at` | timestamp | |
| — | unique | kombinasi `user_id` + `blocked_user_id` |

### `mutes`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `user_id` | FK → `users.id` | yang membisukan, cascade on delete |
| `muted_user_id` | FK → `users.id` | yang dibisukan, cascade on delete |
| `created_at`, `updated_at` | timestamp | |
| — | unique | kombinasi `user_id` + `muted_user_id` |

### `communities`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `name` | string | unik |
| `description` | text | |
| `is_private` | boolean | default `false` |
| `user_id` | FK → `users.id` | pembuat komunitas, cascade on delete |
| `created_at`, `updated_at` | timestamp | |

### `community_user` (pivot — anggota komunitas)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `community_id` | FK → `communities.id` | cascade on delete |
| `user_id` | FK → `users.id` | cascade on delete |
| `created_at`, `updated_at` | timestamp | |
| — | unique | kombinasi `community_id` + `user_id` |

### `community_join_requests`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `community_id` | FK → `communities.id` | cascade on delete |
| `user_id` | FK → `users.id` | cascade on delete |
| `status` | string | default `pending` (`pending`/`approved`/`rejected`) |
| `created_at`, `updated_at` | timestamp | |
| — | unique | kombinasi `community_id` + `user_id` |

### `community_activities`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `community_id` | FK → `communities.id` | cascade on delete |
| `user_id` | FK → `users.id` | cascade on delete |
| `action` | string | jenis aksi (create, join, leave, dll.) |
| `description` | text | |
| `created_at`, `updated_at` | timestamp | |

### `notifications`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | string, PK | |
| `user_id` | FK → `users.id` | penerima notifikasi, cascade on delete |
| `type` | enum | `like`, `comment`, `follow`, `repost`, `mention` |
| `message` | text | |
| `is_read` | boolean | default `false` |
| `related_user_id` | FK → `users.id`, nullable | user pemicu notifikasi, cascade on delete |
| `tweet_id` | FK → `tweets.id`, nullable | cascade on delete |
| `created_at`, `updated_at` | timestamp | |
| — | index | kombinasi `user_id` + `is_read` |

### `messages`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `sender_id` | FK → `users.id` | cascade on delete |
| `receiver_id` | FK → `users.id` | cascade on delete |
| `reply_to_id` | FK → `messages.id`, nullable | balasan ke pesan lain, null on delete |
| `message` | text | |
| `read_at` | timestamp, nullable | waktu pesan dibaca |
| `edited_at` | timestamp, nullable | waktu terakhir pesan diedit |
| `created_at`, `updated_at` | timestamp | |

### `feeds`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `user_id` | FK → `users.id` | cascade on delete |
| `feed_type` | string | jenis feed (misal `foryou` / `following`) |
| `created_at`, `updated_at` | timestamp | |

### `usages`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint, PK | |
| `created_at`, `updated_at` | timestamp | |

### Tabel bawaan Laravel
| Tabel | Keterangan |
|---|---|
| `password_reset_tokens` | `email` (PK), `token`, `created_at` |
| `sessions` | `id` (PK), `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity` |
| `cache` | `key` (PK), `value`, `expiration` |
| `cache_locks` | `key` (PK), `owner`, `expiration` |


---

## Daftar Route

Semua route didefinisikan di `routes/web.php`. Route yang ditandai 🔒 membutuhkan autentikasi (`middleware('auth')`).

### Autentikasi
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/` | redirect ke `/login` |
| GET | `/register` | `AuthController@showRegister` |
| POST | `/register` | `AuthController@register` |
| GET | `/login` | `AuthController@showLogin` |
| POST | `/login` | `AuthController@login` |
| POST | `/logout` | `AuthController@logout` |

### Dashboard / Feed 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/dashboard` | redirect ke `/dashboard/foryou` |
| GET | `/dashboard/foryou` | `FeedController@index` |
| GET | `/dashboard/following` | `FeedController@index` |

### Tweet 🔒
| Method | URI | Controller@Action |
|---|---|---|
| POST | `/tweets` | `TweetController@post_tweet` |
| GET | `/tweets` | `TweetController@show_tweets` |
| GET | `/tweets/{id}` | `TweetController@show` |
| PUT | `/tweets/{id}` | `TweetController@edit_tweet` |
| DELETE | `/tweets/{id}` | `TweetController@delete_tweet` |
| GET | `/hashtags/{name}` | `TweetController@showHashtag` |

### Komentar 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/tweets/{tweet_id}/comments` | `CommentController@index` |
| GET | `/tweets/{tweet_id}/comments/create` | `CommentController@create` |
| POST | `/tweets/{tweet_id}/comments` | `CommentController@store` |
| POST | `/tweets/{tweet_id}/comments/{comment_id}/pin` | `CommentController@pin` |
| GET | `/comments/{id}/edit` | `CommentController@edit` |
| PUT | `/comments/{id}` | `CommentController@update` |
| GET | `/comments/{id}` | `CommentController@show` |
| DELETE | `/comments/{id}` | `CommentController@destroy` |

### Like, Dislike, Repost 🔒
| Method | URI | Controller@Action |
|---|---|---|
| POST | `/tweets/{tweet}/like` | `LikeController@toggle` |
| POST | `/tweets/{tweet}/dislike` | `DislikeController@toggle` |
| POST | `/tweets/{tweet}/repost` | `RepostController@toggle` |

### Bookmark 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/bookmarks` | `BookmarkController@index` |
| POST | `/bookmarks` | `BookmarkController@store` |
| GET | `/bookmarks/{id}` | `BookmarkController@show` |
| DELETE | `/bookmarks/{tweet_id}` | `BookmarkController@destroy` |

### Profil & Pencarian 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/profile` | `ProfileController@index` |
| GET | `/user/{username}` | `ProfileController@show` |
| POST | `/profile/update-description` | `ProfileController@updateDescription` |
| GET | `/profile/{username}/followers` | `ProfileController@followers` |
| GET | `/profile/{username}/following` | `ProfileController@following` |
| GET | `/mentions/search` | `ProfileController@searchMentions` |
| GET | `/search/users` | `ProfileController@search` |

### Follow, Block, Mute 🔒
| Method | URI | Controller@Action |
|---|---|---|
| POST | `/follow/{following_id}` | `FollowController@toggle` |
| POST | `/block/{blocked_user_id}` | `BlockController@toggle` |
| POST | `/mute/{muted_user_id}` | `MuteController@toggle` |

### Privasi 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/privacy` | `PrivacyController@show_privacy` |
| POST | `/privacy/toggle` | `PrivacyController@togglePrivacy` |
| GET | `/privacy/blocked` | `PrivacyController@blocked_list` |
| GET | `/privacy/muted` | `PrivacyController@muted_list` |

### Komunitas 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/community` | `CommunityController@index` |
| POST | `/community` | `CommunityController@create` |
| GET | `/community/{id}` | `CommunityController@show` |
| PUT | `/community/{id}` | `CommunityController@edit` |
| DELETE | `/community/{id}` | `CommunityController@destroy` |
| POST | `/community/{id}/join` | `CommunityController@join` |
| POST | `/community/{id}/leave` | `CommunityController@leave` |
| POST | `/community/{id}/request-join` | `CommunityController@requestToJoin` |
| POST | `/community/{id}/requests/{requestId}/approve` | `CommunityController@approveRequest` |
| POST | `/community/{id}/requests/{requestId}/reject` | `CommunityController@rejectRequest` |

### Notifikasi 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/notifications` | `NotificationController@index` |
| GET | `/notifications/{id}` | `NotificationController@show` |
| PUT | `/notifications/{id}/read` | `NotificationController@markAsRead` |
| PUT | `/notifications/mark-all-read` | `NotificationController@markAllAsRead` |
| DELETE | `/notifications/{id}` | `NotificationController@destroy` |
| DELETE | `/notifications/delete-all` | `NotificationController@destroyAll` |

### Direct Message / Chat 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/messages/inbox` | `MessageController@inbox` |
| GET | `/messages/chat/{userId}` | `MessageController@chat` |
| GET | `/messages/search` | `MessageController@search` |
| POST | `/messages` | `MessageController@store` |
| POST | `/messages/share` | `MessageController@shareToChat` |
| PUT | `/messages/{messageId}` | `MessageController@update` |
| DELETE | `/messages/{messageId}` | `MessageController@destroy` |

### Usage / Statistik 🔒
| Method | URI | Controller@Action |
|---|---|---|
| GET | `/usage` | `UsageController@index` |
| GET | `/usage/users` | `UsageController@users` |
| GET | `/usage/tweets` | `UsageController@tweets` |
| GET | `/usage/communities` | `UsageController@communities` |
| GET | `/usage/follow-activities` | `UsageController@followActivities` |
| GET | `/usage/community-activities` | `UsageController@communityActivities` |

---

## Teknologi yang Digunakan

| Kategori | Teknologi |
|---|---|
| Backend Framework | Laravel 12 (PHP ^8.2) |
| Templating | Blade |
| Frontend Styling | Tailwind CSS 4 |
| Frontend Interaktivitas | JavaScript (Axios / AJAX) |
| Database | MySQL |
| Autentikasi | Session-based (native Laravel Auth) |

---

## Instalasi & Menjalankan Project

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone https://github.com/lucioaureyfeliciano/Project_UAS_Backend.git
   cd Project_UAS_Backend
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies frontend**
   ```bash
   npm install
   ```

4. **Salin file environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database**

   Buat database MySQL baru, lalu sesuaikan `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=project_uas_backend
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Jalankan migrasi database**
   ```bash
   php artisan migrate
   ```

7. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

8. **Akses aplikasi**

   Buka [http://localhost:8000](http://localhost:8000) di browser.

---

## Kontributor

Project ini dikembangkan secara kolaboratif sebagai tugas UAS oleh tim dengan beberapa kontributor (lihat riwayat branch dan commit di repository).

## Lisensi

Project ini dibuat untuk keperluan akademik (Ujian Akhir Semester) dan dibangun di atas framework [Laravel](https://laravel.com).
