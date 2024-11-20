# Djangourse
<img src="assets/img/django-logo.png" style="width: 300px; display: block; margin: 0 auto">
Djangourse adalah website pembelajaran online yang berfokus pada materi-materi berkaitan dengan teknologi informasi. Website ini dibangun menggunakan bahasa pemrograman PHP.

## Struktur Folder

### `/pages`
Folder ini menampung file halaman HTML/PHP, styling CSS, dan scripting JavaScript yang dikelompokkan berdasarkan `role`.

### `/assets`
Folder ini menampung file gambar, video, suara, dll.

### `/utils/database`
Folder ini berisi utilitas untuk melakukan operasi pada database MySQL.

Di dalamnya terdapat file `connection.php` yang berfungsi untuk membangun koneksi antara server dan MySQL.

Selain itu, terdapat file `helper.php`, yang di dalamnya berisi beberapa fungsi untuk menyederhanakan pemanggilan fungsi built-in `mysqli` menjadi satu baris saja.

Berikut ini adalah rincian dari setiap fungsi yang terdapat di dalam `helper.php`.

1. `fetch($query)`: fungsi ini mengambil baris-baris/records dari tabel. Hasil kembalian dari fungsi ini berupa `array numerik yang merepresentasikan setiap baris`.
    > Hanya untuk mengeksekusi query SELECT.

    Contoh Penggunaan:
    ```
    fetch("SELECT * FROM courses");
    ```

    Contoh Output:
    ```
    [
        [0] => [
            "id" => "1",
            "name" => "Tim Djangourse"
        ],
        [1] => [
            "id" => "2",
            "name" => "Tim Lain"
        ]
        ...
    ]
    ```

2. `execDML($query)`: fungsi ini dapat digunakan untuk mengeksekusi query DML (`INSERT`, `UPDATE`, `DELETE`). Hasil kembalian dari fungsi ini adalah `jumlah baris yang terpengaruh oleh operasi tersebut`.

    Contoh Penggunaan:
    ```
    $sql = execDML(
        "UPDATE courses
        SET name = 'Belajar PHP'
        WHERE id = 1"
    );

    if ($sql > 0) {
        echo "Eksekusi query berhasil";
    } else {
        echo "Eksekusi query gagal";
    }
    ```
> SELALU GUNAKAN KEDUA FUNGSI INI UNTUK OPERASI PADA DATABASE.

### `utils/date.php`
File ini mengandung fungsi `convert($epoch)` untuk mengubah Unix Epoch Time ke dalam bentuk string yang dapat dibaca.

## Petunjuk
Untuk mengunduh dan memulai pengembangan pada repositori ini, buka terminal VSCode, lalu jalankan perintah:
```
git clone https://github.com/abdalrizky/djangourse.git
```
Setelah selesai mengubah satu atau beberapa file, jalankan:
```
git add <path> atau git add . (akan menambahkan semua file yang berubah di repository local / git folder)
git commit -m "[masukkan deskripsi perubahan]"
git push
```
Jika ingin membuat branch/cabang di Github repository
```
git add <path> atau git add . (akan menambahkan semua file yang berubah di repository local / git folder)
git checkout -b <branch-name> 
git commit -m "[masukkan deskripsi perubahan]"
git push -u origin <branch-name>
```

Note :
```
git branch (mengecek anda di branch mana pada local repo, ditandai dengan *<branch-name>)
git switch <branch-name>  (untuk pindah branch di local repo)
```

## Tim Pengembang

1. [Muhammad Abdal Rizky](https://github.com/abdalrizky) - 2309106012
2. [Sanniyah Intan Salsabiila](https://github.com/SnyhIntan) - 2309106004
3. [Al Hajj Fauzan](https://github.com/alhajjfauzan) - 2309106019
4. [Christian Farrel Argya Putra](https://github.com/par3L) - 2309106032
5. [Siti Fauziah Wulandari](https://github.com/wulandarifauziah) - 2309106038
6. [Muhammad Rafif Hanif](https://github.com/RafifDX) - 2309106044
