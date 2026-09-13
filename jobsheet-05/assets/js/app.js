// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.querySelector("header nav");
  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
  });
}

function updateCounter() {
    const table = document.querySelector(".table-responsive table");
    const counterEl = document.getElementById("table-counter");
    if (!table || !counterEl) return;

    const totalRows = table.querySelectorAll("tbody tr").length;
    const visibleRows = Array.from(table.querySelectorAll("tbody tr")).filter(
        (row) => row.style.display !== "none"
    ).length;

    counterEl.textContent = `Menampilkan ${visibleRows} dari ${totalRows} buku`;
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
  document.querySelectorAll(".btn-hapus").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const row = btn.closest("tr");
      const nama = row ? row.querySelector("td")?.textContent : "data ini";
      const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');
      if (yakin && row) {
        row.remove();
        updateCounter();
      }
    });
  });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
  const input = document.getElementById("search-input");
  const table = document.querySelector(".table-responsive table");
  if (!input || !table) return;

  input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase();
    const rows = table.querySelectorAll("tbody tr");
    rows.forEach(function (row) {
      const kolomJudul = row.querySelector("td");
      const teks = kolomJudul ? kolomJudul.textContent.toLowerCase() : "";

      row.style.display = teks.includes(keyword) ? "" : "none";
    });
    updateCounter();
  });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
  hapusError(input);
  const span = document.createElement("span");
  span.className = "error";
  span.textContent = pesan;
  input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
  const next = input.nextElementSibling;
  if (next && next.classList.contains("error")) {
    next.remove();
  }
}

function initValidasiForm() {
  const form = document.getElementById("form-tambah");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    let valid = true;

    const fieldWajib = [
            { name: "judul", pesan: "Field ini wajib diisi." },
            { name: "pengarang", pesan: "Pengarang wajib diisi." }
        ];

        // Loop untuk mengecek setiap field wajib
        fieldWajib.forEach(function (item) {
            const input = form.querySelector(`[name='${item.name}']`);
            if (input && input.value.trim() === "") {
                tampilkanError(input, item.pesan);
                valid = false;
            } else if (input) {
                hapusError(input);
            }
        });

    const tahun = form.querySelector("[name='tahun']");
    if (tahun) {
      const nilai = parseInt(tahun.value, 10);
      if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
        tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
        valid = false;
      } else {
        hapusError(tahun);
      }
    }

    const stok = form.querySelector("[name='stok']");
    if (stok) {
      const nilai = parseInt(stok.value, 10);
      if (isNaN(nilai) || nilai < 0) {
        tampilkanError(stok, "Stok tidak boleh negatif.");
        valid = false;
      } else {
        hapusError(stok);
      }
    }

    // Validasi ISBN (hanya angka dan tanda hubung)
    const isbn = form.querySelector("[name='isbn']");
    if (isbn && isbn.value.trim() !== "") {
      const polaISBN = /^[0-9-]+$/;
      if (!polaISBN.test(isbn.value.trim())) {
        tampilkanError(
          isbn,
          "ISBN hanya boleh berisi angka dan tanda hubung (-).",
        );
        valid = false;
      } else {
        hapusError(isbn);
      }
    }

    if (!valid) {
      e.preventDefault();
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initHapusConfirm();
  initTableFilter();
  initValidasiForm();
  updateCounter();
});
