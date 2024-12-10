document.getElementById("btn-dropdown").addEventListener("click", () => {
  console.log("click");
  document.getElementById("navbar-info-dropdown").classList.toggle("hide");
});

let currentCategory = null; // Kategori aktif
let offset = 0; // Posisi awal
const limit = 4; // Jumlah kursus per batch

// Fungsi untuk memuat kursus
function loadCourses(category, reset = true) {
  currentCategory = category; // Set kategori saat ini
  if (reset) offset = 0; // Reset offset jika kategori baru

  // Fetch data kursus berdasarkan kategori
  fetch(`course-list.php?kategori=${category}&offset=${offset}`)
    .then((response) => response.json())
    .then((data) => {
      const coursesContainer = document.getElementById("courses-container");

      // Reset kontainer jika memuat ulang kategori
      if (reset) coursesContainer.innerHTML = "";

      // Render kursus baru
      data.courses.forEach((course) => {
        const courseHTML = `
                    <div class="catalog" data-category="${
                      course.category_name
                    }">
                        <div class="catalog-header">
                            <a href="course-detail.php?id=${
                              course.id
                            }" class="catalog-link">
                                <div class="catalog-title">${course.name}</div>
                            </a>
                            <button class="heart"><i class="far fa-heart"></i></button>
                        </div>
                        <img class="course-image" src="${
                          course.thumbnail
                        }" alt="Thumbnail Kursus">
                        <div class="catalog-footer">
                            <div class="koin">${new Intl.NumberFormat(
                              "id-ID"
                            ).format(course.price)} Koin</div>
                            <button class="button-rental">Beli</button>
                        </div>
                    </div>`;
        coursesContainer.innerHTML += courseHTML;
      });

      // Atur tombol "Tampilkan Lebih Banyak"
      document.getElementById("loadMore").style.display = data.hasMore
        ? "block"
        : "none";
    });
}

// Tambahkan event listener untuk setiap tab kategori
document.querySelectorAll(".tab").forEach((tab) => {
  tab.addEventListener("click", (event) => {
    event.preventDefault();
    const category = event.target.textContent.trim();
    loadCourses(category);
  });
});

// Event listener untuk tombol "Tampilkan Lebih Banyak"
document.getElementById("loadMore").addEventListener("click", function () {
  const offset = parseInt(this.getAttribute("data-offset"));
  loadCourses(currentCategory, offset);
});

// Muat data awal saat halaman pertama kali dibuka
loadCourses();

const searchInput = document.getElementById("searchInput");
const items = document.querySelectorAll(".catalog");
const searchNotFoundMessage = document.getElementById(
  "search-not-found-message"
);

searchInput.addEventListener("input", (el) => {
  items.forEach((item) => {
    if (item.innerText.toLowerCase().includes(el.target.value.toLowerCase())) {
      item.classList.remove("hide");
    } else {
      item.classList.add("hide");
    }
  });
});
