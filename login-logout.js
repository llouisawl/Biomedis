const loginButton = document.querySelector('.btn');
const isLoggedIn = true; // Ganti dengan kondisi login sebenarnya

if (isLoggedIn) {
  loginButton.textContent = 'Logout';
  loginButton.href = 'logout.html';
} else {
  loginButton.textContent = 'Login';
  loginButton.href = 'login.html';
}
