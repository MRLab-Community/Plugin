(function($) {
    $(document).ready(function() {
        function initializeCountdown(container) {
            const duration = parseInt(container.data('duration')); // Durata del countdown
            const button = container.find('.wpcd-start-button');
            const content = container.find('.wpcd-hidden-content');
            const timerDisplay = container.find('.wpcd-countdown-display');
            const circle = timerDisplay.find('.wpcd-countdown-timer .circle');
            const timeLeftDisplay = timerDisplay.find('.wpcd-countdown-timer .time-left');

            if (!button.length || !content.length || !circle.length || !timeLeftDisplay.length) {
                return; // Ignora se mancano elementi chiave
            }

            button.on('click', function() {
                // Resetta lo stato precedente
                resetCountdown(container, duration);

                // Nascondi il bottone e mostra il countdown
                button.hide();
                timerDisplay.show();

                let remainingTime = duration;

                const interval = setInterval(function() {
                    if (remainingTime <= 0) {
                        clearInterval(interval);

                        // Mostra il contenuto nascosto
                        content.show();
                        timerDisplay.hide();

                        // Nascondi il contenuto dopo 10 secondi e riattiva il countdown
                        setTimeout(function() {
                            content.hide();
                            button.show(); // Ricompare il pulsante
                        }, 10000); // Ricompare il pulsante dopo 10 secondi
                    } else {
                        // Aggiorna il tempo rimanente
                        timeLeftDisplay.text(remainingTime);

                        // Calcola l'offset del cerchio
                        const offset = 220 * ((remainingTime - 1) / duration); // Offset proporzionale

                        // Aggiorna l'animazione del cerchio
                        circle.css('stroke-dashoffset', 220 - offset);

                        remainingTime--;
                    }
                }, 1000);
            });
        }

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

        // Inizializza tutti i container con lo shortcode
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