<script>
  document.addEventListener("DOMContentLoaded", function () {
    const apiKeyField = document.getElementById("elementor_openai_api_key");
    apiKeyField.addEventListener("input", clearClasses);
  });

  async function verifyOpenAIKey() {
    let apiKey = document.getElementById("elementor_openai_api_key").value;

    if (apiKey !== "") {
      const btnValid = document.getElementById("elementor_openai_api_key_verification_button");
      btnValid.classList.add("loading");

      if (btnValid.classList.contains("error")) {
        btnValid.classList.remove("error");
      }

      if (btnValid.classList.contains("success")) {
        btnValid.classList.remove("success");
      }

      await fetch("https://api.openai.com/v1/engines", {
        headers: {
          "Authorization": "Bearer " + apiKey,
        },
      })
        .then(async response => {
          if (response.ok) {
            btnValid.classList.remove("loading");
            btnValid.classList.add("success");

            await saveToDatabase(true);
          } else {
            btnValid.classList.remove("loading");
            btnValid.classList.add("error");

            await saveToDatabase(false);
          }
        })
        .catch(error => {
          btnValid.classList.remove("loading");
          btnValid.classList.add("error");
        });
    }
  }

  async function saveToDatabase(checkAPI) {
    try {
      const value = checkAPI ? "1" : "0";

      await fetch("/wp-admin/admin-ajax.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          action: "save_testimonials_option",
          value: value,
        }),
      });
    } catch (error) {
      console.error("An error occurred while saving value to the database:", error);
    }
  }

  function clearClasses() {
    const btnValid = document.getElementById("elementor_openai_api_key_verification_button");

    if (btnValid.classList.contains("error")) {
      btnValid.classList.remove("error");
    }

    if (btnValid.classList.contains("success")) {
      btnValid.classList.remove("success");
    }
  }
</script>