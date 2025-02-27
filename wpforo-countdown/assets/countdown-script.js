   (function($) {
    $(document).ready(function() {
        // Gestione del pulsante [countdown-button]
        $(document).on('click', '.wpcd-countdown-trigger', function(e) {
            e.preventDefault();

            // Crea il popup per l'inserimento del contenuto
            const popupHtml = `
                <div class="wpcd-countdown-popup">
                    <label for="wpcd-content">Inserisci il link o lo shortcode:</label>
                    <input type="text" id="wpcd-content" placeholder="https://example.com/download" />
                    <button class="wpcd-insert-confirm" title="Conferma">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M247.9 105.9L370.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L247.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0c-6.4-18.7 9.9-37.4 9.9-24zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0L32 32c-17.7 0-32 14.3-32 32l0 256c0 53 43 96 96 96l128 0L256 32c18.7 0 33.9 15.2 33.9 33.9s-15.2 33.9-33.9 33.9z"/>
                        </svg>
                        Conferma
                    </button>
                </div>
            `;

            // Aggiungi il popup al body
            $('body').append(popupHtml);

            // Riferimento al popup
            const popup = $('.wpcd-countdown-popup');

            // Centra il popup
            popup.css({
                top: ($(window).height() - popup.outerHeight()) / 2 + 'px',
                left: ($(window).width() - popup.outerWidth()) / 2 + 'px',
            }).show();

            // Gestione del click sul pulsante di conferma
            popup.find('.wpcd-insert-confirm').on('click', function() {
                const content = popup.find('#wpcd-content').val().trim();
                if (!content) {
                    alert('Inserisci un contenuto valido.');
                    return;
                }

                // Rimuovi il popup
                popup.remove();

                // Genera lo shortcode [countdown] con il contenuto inserito
                const duration = wpcd_params.default_duration; // Durata predefinita
                const countdownShortcode = `[countdown duration="${duration}"]${content}[/countdown]`;

                // Sostituisci il pulsante con lo shortcode generato
                $(this).closest('.wpcd-countdown-trigger').replaceWith(countdownShortcode);
            });

            // Chiudi il popup cliccando fuori da esso
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.wpcd-countdown-popup').length && !$(event.target).hasClass('wpcd-countdown-trigger')) {
                    popup.remove(); // Rimuovi il popup
                }
            });
        });

        // Inizializza il countdown grafico circolare
        function initializeCountdown(container) {
            const duration = parseInt(container.data('duration')); // Durata del countdown
            const button = container.find('.wpcd-start-button'); // Pulsante "Mostra Contenuto"
            const content = container.find('.wpcd-hidden-content'); // Contenuto nascosto
            const timerDisplay = container.find('.wpcd-countdown-display'); // Display del countdown
            const circle = timerDisplay.find('.wpcd-countdown-timer .circle'); // Cerchio del countdown
            const timeLeftDisplay = timerDisplay.find('.wpcd-countdown-timer .time-left'); // Testo numerico del countdown

            if (!button.length || !content.length || !circle.length || !timeLeftDisplay.length) {
                return; // Ignora se mancano elementi chiave
            }

            button.on('click', function() {
                // Nascondi il pulsante e mostra il countdown
                $(this).hide();
                timerDisplay.show();

                let remainingTime = duration;

                const interval = setInterval(function() {
                    if (remainingTime <= 0) {
                        clearInterval(interval);

                        // Mostra il contenuto nascosto
                        content.show();
                        timerDisplay.hide();

                        // Ricompare il pulsante dopo 10 secondi
                        setTimeout(function() {
                            content.hide();
                            resetCountdown(container, duration);
                            $(this).show(); // Ricompare il pulsante
                        }.bind(button), 10000); // Ricompare il pulsante dopo 10 secondi
                    } else {
                        // Aggiorna il tempo rimanente
                        timeLeftDisplay.text(remainingTime);

                        // Calcola l'offset del cerchio
                        const offset = calculateCircleOffset(remainingTime, duration);

                        // Aggiorna l'animazione del cerchio
                        circle.css('stroke-dashoffset', offset);

                        remainingTime--;
                    }
                }, 1000);
            });
        }

        // Calcolo dell'offset del cerchio
        function calculateCircleOffset(remainingTime, duration) {
            const progress = remainingTime / duration; // Percentuale rimanente
            return 220 * (1 - progress); // Offset proporzionale
        }

        // Reimposta il countdown
        function resetCountdown(container, duration) {
            const circle = container.find('.wpcd-countdown-timer .circle');
            const timeLeftDisplay = container.find('.wpcd-countdown-timer .time-left');
            const content = container.find('.wpcd-hidden-content');

            // Reimposta lo stroke-dashoffset del cerchio
            circle.css('stroke-dashoffset', 0);

            // Reimposta il testo del countdown
            timeLeftDisplay.text(duration);

            // Nascondi il contenuto
            content.hide();
        }

        // Inizializza tutti i container con lo shortcode [countdown]
        $('.wpcd-countdown-container').each(function() {
            const duration = parseInt($(this).data('duration')); // Recupera la durata dal data-duration
            const circle = $(this).find('.wpcd-countdown-timer .circle');
            const timeLeftDisplay = $(this).find('.wpcd-countdown-timer .time-left');

            // Imposta il testo iniziale del countdown
            timeLeftDisplay.text(duration);

            // Imposta lo stroke-dashoffset iniziale del cerchio
            circle.css('stroke-dashoffset', 0);

            initializeCountdown($(this));
        });
    });
})(jQuery);                                             
