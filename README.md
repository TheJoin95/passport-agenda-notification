# Agenda per appuntamenti passaporti - Italia

Questa repository è dedicata alla burocrazia italiana e ai vari sviluppatori del sito per prenotare l'appuntamento.

## Come funziona
Simula l'accesso e la navigazione del portale ricavando le informazioni.

E' necessario avere una versione di PHP >= 7.0.

Sarà sufficiente modificare il file environment/credential.json con le proprie credenziali affinché lo script funzioni.

Le credenziali non saranno condivise: sono utilizzate per accedere al portale della Polizia di Stato.

Se si vuole essere notificati tramite email sarà necessario aggiungere le credenziali del servizio "Sparkpost".
In alternativa, è possibile utilizzare la funzione mail().

## Casi d'uso
Potete utilizzare lo script piuttosto che loggarsi ogni volta, per varie settimane, e non riuscire a vedere o a prenotare un appuntamento, perdendo di conseguenza (in media) 10 minuti della vostra vita.

Prenotare è difficile, ma almeno ora potete sapere (davvero) quando e dove ci sono delle slot libere e prenotabili.

Prego.

## Contribute
Ogni contributo, anche solo per manutenerla nel caso in cui cambiassero qualcosa (improbabile), è ben accetto.