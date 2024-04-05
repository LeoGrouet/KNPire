const message = document.querySelector(".flash-message");

if (message) {
  setTimeout(() => {
    message.style.display = "none";
  }, 2000);
}
