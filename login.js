const container = document.querySelector('.container-fluid-md');
const staffBtn = document.getElementById('staff-account');
const adminBtn = document.getElementById('admin-account');

staffBtn.addEventListener('click', () => {
  container.classList.add("active");
});

adminBtn.addEventListener('click', () => {
  container.classList.remove("active");
});
