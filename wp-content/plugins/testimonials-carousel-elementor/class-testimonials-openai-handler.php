<script>
  async function handleEditableControlChange(event) {
    if (event.target.attributes['data-event']) {
      if (event.type === 'click' && event.target.attributes['data-event'].nodeValue === 'send_prompt') {
        const repeaterRowControls = event.target.closest('.elementor-repeater-row-controls');

        if (repeaterRowControls && repeaterRowControls.classList.contains('editable')) {
          const slideContentField = repeaterRowControls.querySelector('.elementor-control-slide_content');
          const iframe = slideContentField.querySelector('iframe');
          const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

          if (iframe) {
            iframe.style.pointerEvents = 'none';
            iframeDocument.body.innerHTML = 'Loading...';
          }

          const slideContentFieldAI = repeaterRowControls.querySelector('[data-setting="slide_ai_content"]');

          if (slideContentField) {
            const apiKey = '<?php echo get_option("elementor_openai_api_key"); ?>';

            const testimonialsNotification = document.getElementById('testimonials-notifications');

            const prompt = document.getElementById(slideContentFieldAI.getAttribute('id')).value;

            if (apiKey) {
              try {
                const response = await fetch('https://api.openai.com/v1/engines/text-davinci-003/completions', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${apiKey}`
                  },
                  body: JSON.stringify({
                    prompt: prompt,
                    max_tokens: 2048,
                  })
                });

                if (response.ok) {
                  const data = await response.json();

                  if (iframe) {
                    iframeDocument.body.innerHTML = data.choices[0].text.trim();
                  }

                  const keyPressEvent = new KeyboardEvent('keydown', {key: 'Enter'});
                  iframeDocument.body.dispatchEvent(keyPressEvent);
                } else {
                  const textNotification = testimonialsNotification.querySelector('.testimonials-notifications');

                  if (response.statusText !== '') {
                    textNotification.textContent = 'Error: ' + response.status + " " + (response.type).charAt(0).toUpperCase() + (response.type).slice(1) + " - " + (response.statusText).trim();
                  } else {
                    textNotification.textContent = 'Error: ' + response.status + " " + (response.type).charAt(0).toUpperCase() + (response.type).slice(1);
                  }

                  testimonialsNotification.style.display = 'flex';
                  testimonialsNotification.style.transition = 'opacity 0.5s';
                  testimonialsNotification.style.top = '850px';
                  testimonialsNotification.style.opacity = '1';

                  setTimeout(() => {
                    testimonialsNotification.style.transition = 'opacity 0.5s';
                    testimonialsNotification.style.opacity = '0';

                    testimonialsNotification.addEventListener('transitionend', () => {
                      testimonialsNotification.style.display = 'none';
                      testimonialsNotification.style.top = 'auto';
                    });
                  }, 3000);

                  if (iframe) {
                    iframeDocument.body.innerHTML = '';
                  }
                }
                iframe.style.pointerEvents = 'unset';
              } catch (error) {
                if (iframe) {
                  iframeDocument.body.innerHTML = '';
                }

                const keyPressEvent = new KeyboardEvent('keydown', {key: 'Enter'});
                iframeDocument.body.dispatchEvent(keyPressEvent);
                iframe.style.pointerEvents = 'unset';
              }
            }
          }
        }
      }
    }
  }

  document.addEventListener('click', handleEditableControlChange);

  document.addEventListener('DOMContentLoaded', function () {
    const panelContainer = document.querySelector("body");

    const wrapper = document.createElement("div");
    wrapper.setAttribute("aria-modal", "true");
    wrapper.setAttribute("id", "testimonials-notifications");
    wrapper.classList.add("dialog-widget");
    wrapper.classList.add("dialog-buttons-widget");
    wrapper.classList.add("dialog-type-buttons");
    wrapper.style.transition = 'opacity 0.5s';
    wrapper.style.opacity = '0';

    const message = document.createElement("div");
    message.classList.add("testimonials-notifications");

    wrapper.appendChild(message);
    panelContainer.appendChild(wrapper);
  });
</script>
