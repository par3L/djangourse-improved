
const withdrawalModal = document.getElementById("withdrawalModal");
const closeBtn = document.querySelector(".close-btn");
const withdrawalForm = document.getElementById("withdrawalForm");




closeBtn.addEventListener("click", () => {
  withdrawalModal.style.display = "none";
});

window.addEventListener("click", (event) => {
  if (event.target === withdrawalModal) {
    withdrawalModal.style.display = "none";
  }
});

withdrawalForm.addEventListener("submit", (event) => {

  const amount = parseInt(document.getElementById("amount").value, 10);

  if (amount < 50000) {
    event.preventDefault();
    alert("Jumlah minimal penarikan adalah Rp50.000");
    return;
  }

  alert("Penarikan berhasil!");
});

window.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    withdrawalModal.style.display = "none";
  }
});
