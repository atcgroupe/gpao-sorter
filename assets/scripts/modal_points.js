const modalPoints = document.querySelector(".modal-points");
const list = document.querySelector(".list");

list.addEventListener("click", (event) => {
  if (!event.target.classList.contains("number")) {
    return;
  }

  const listItem = event.target.closest(".list-item");
  console.log(listItem.dataset.prodDataId);
});

const setModalData = (idProdData) => {};
