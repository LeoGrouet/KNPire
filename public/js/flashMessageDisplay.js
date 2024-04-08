const message = document.querySelector(".flash-message");
const container = document.querySelector(".flash-message-container");
if (message) {
  setTimeout(() => {
    message.classList.add("animate__animated", "animate__lightSpeedOutLeft");
    container.style.height = "0px";
  }, 2000);
  setTimeout(() => {
    message.style.display = "none";
  }, 4000);
}
