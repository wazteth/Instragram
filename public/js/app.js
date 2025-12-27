// Password toggle
document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("togglePassword");
        const passwordField = document.getElementById("password");

        toggleBtn?.addEventListener("click", function () {
            const isPassword = passwordField.type === "password";
            passwordField.type = isPassword ? "text" : "password";
            toggleBtn.innerText = isPassword ? "Hide" : "Show";
        });
    });
// Image preview
document.addEventListener("DOMContentLoaded", function () {
        const inputs = document.getElementsByClassName("image-input");

        Array.from(inputs).forEach(input => {
            input.addEventListener("change", function (event) {
                const file = event.target.files[0];
                const form = event.target.closest("form");
                const preview = form.getElementsByClassName("image-preview")[0];

                if (file && preview) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = "block";
                    };

                    reader.readAsDataURL(file);
                }
            });
        });
    });
// prevent refresh and send to top page when Like-Unlike 

// Wait until DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("form.like-form").forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const postId = this.dataset.postId;
      const url = this.action;
      const token = this.querySelector('input[name="_token"]').value;
      const icon = document.getElementById(`heart-icon-${postId}`);
      const countP = document.getElementById(`like-count-${postId}`);

      fetch(url, {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": token,
          Accept: "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((res) => res.json())
        .then((json) => {
          if (json.liked) {
            icon.classList.replace("far", "fas");
            icon.classList.add("text-danger");
          } else {
            icon.classList.replace("fas", "far");
            icon.classList.remove("text-danger");
          }

          if (countP && countP.querySelector("strong")) {
            countP.querySelector("strong").innerText = `${json.like_count} likes`;
          }
        })
        .catch(console.error);
    });
  });
});


// disable automatic scroll-restoration
  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
  }

  // on full page load, make sure we start at the top
  window.addEventListener('load', function() {
    window.scrollTo(0, 0);
  });
// dark theme toggle
  document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('theme-toggle');
    const body = document.body;

    // Set theme from localStorage if exists
    if (localStorage.getItem('theme') === 'dark') {
      body.classList.add('dark-mode');
      toggleButton.textContent = '☀️';
    }

    toggleButton.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
      const isDark = body.classList.contains('dark-mode');
      localStorage.setItem('theme', isDark ? 'dark' : 'light');
      toggleButton.textContent = isDark ? '☀️' : '🌙';
    });
  });

  