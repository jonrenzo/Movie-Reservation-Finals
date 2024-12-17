import { themeChange } from 'theme-change'
themeChange()

const { element } = HSCollapse.getInstance('#collapse', true);
const showBtn = document.querySelector('#show-btn');

showBtn.addEventListener('click', () => {
  element.show();
});

function validateUsername() {
  const usernameInput = document.getElementById('username');
  const errorText = document.getElementById('username-error');

  fetch('validate-username.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ username: usernameInput.value }),
  })
  .then(response => response.json())
  .then(data => {
      if (data.exists) {
          errorText.classList.remove('hidden');
          usernameInput.classList.add('border-red-500');
      } else {

          errorText.classList.add('hidden');
          usernameInput.classList.remove('border-red-500');
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
}
function confirmDelete(movieId) {
    if (confirm('Are you sure you want to delete this movie?')) {
        window.location.href = 'view_movies.php?delete_id=' + movieId;
    }
}
