
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

window.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    withdrawalModal.style.display = "none";
  }
});
