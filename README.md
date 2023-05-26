# ProjectWorkITS
Repo per il lavoro di gruppo di creazione app web per banche

ToDo:
Gestione del Database
Creazione pagine PHP

Pagine da creare:
- Registrazione.php : inserire email password e conferma password etc..

- Registrazioneconfermata.php: viene visualizzata se la registrazione è andata a buon
fine il server manda una email all’utente con link per questa pagina. Una volta che
clicchi sul link viene settato il valore registrazione confermata a 1

- Login.php: inserire mail e password max 3 tentativi. Se vengono usati i 3 tentativi
l’utente deve aspettare 1 minuto per fare un altro tentativo. Quando fa l’accesso in
modo corretto o tenta di accedere vengono registrati l’indirizzo IP e la data e ora
dell’accesso. A partire dall’istante di tempo nel quale viene caricata la pagina login.php bisogna premere il pulsante “login”
prima di 30 secondi. Se si preme dopo 30 secondi-> vengono cancellati Email e
Password dal form. 1. Quando viene Effettuato illogin viene inviate una mail all’utente
con un codice numerico che deve essere inserito nel sito per completare il login.Se il
login è valido creare una variabile session (che permetterà la visualizzazione di ogni
pagina successivamente implementata) e si viene reinviati ad una index.php dove viene
visualizzato: Benvenuto Mario Rossi, data apertura del conto corrente, il saldo e una
table con gli ultimi 5 movimenti.

- Index.php: vieni reinderizzato in questa pagina quando fai l’accesso correttamente.
Viene messo il nome utente, data apertura del conto corrente, il saldo e una table con
gli ultimi 5 movimenti

- footer e header vanno messi su ogni pagina separatamente