#Tietokantasovelluksen esittelysivu

##Työn aihe

Tarkoituksena on luoda järjestelmä erilaisten hauskojen internetistä löytyvien kuvien, tekstien ja videoiden varastoimiseen, jakamiseen ja kommentointiin. Kuvista säilytetään vain
linkit palvelimen muistin säästämiseksi. Tarkoituksena ei ole perustaa sivustoa kuvien hostaamiseen.

Sivuston sisältöä pystyy selailemaan anonyyminä ja kirjautumisen jälkeen voi sivustolle tuoda lisää sisältöä sekä kommentoida muiden lisäämää sisältöä. Kirjautuneet käyttäjät voivat myös muodostaa oman suosikkilistansa, sekä editoida aimemmin lisäämäänsä sisältöä.

Toimintoja:
- Meemien ja niihin liittyvien kommentien selailu (sekä hakeminen)
- Kirjautuminen
- Uusien meemien ja kommenttien lisäys, poistaminen ja muokkaus
- Suosikiksi merkitseminen

##Testaamiseen

###Yleisiä linkkejä:

- [Linkki sovellukseeni](http://sobackr.users.cs.helsinki.fi/memeDB/)
- [Linkki dokumentaatiooni](doc/dokumentaatio.pdf)

###Pikalinkkejä:

- [Etusivu](http://sobackr.users.cs.helsinki.fi/memeDB/)
- [Kirjautumissivu](http://sobackr.users.cs.helsinki.fi/memeDB/login)
- [Rekisteröitymissivu](http://sobackr.users.cs.helsinki.fi/memeDB/register)
- [Meemien listaussivu](http://sobackr.users.cs.helsinki.fi/memeDB/memes)
- [Meemin esittelysivu](http://sobackr.users.cs.helsinki.fi/memeDB/memes/1)

####Vaatii kirjautumisen:
- [Meemien luontisivu](http://sobackr.users.cs.helsinki.fi/memeDB/memes/create)

####Vaatii kirjautumisen käyttäjällä "User":
- [Meemin muokkaussivu](http://sobackr.users.cs.helsinki.fi/memeDB/memes/1/edit)
- [Viestin muokkaussivu](http://sobackr.users.cs.helsinki.fi/memeDB/comment/1/edit)

###Käyttäjätunnuksia testaukseen (username, password):
- User, User
- User2, User2
- User3, User3
- User4, User4

###Huomioita:
- Viestien listaus tapahtuu meemikohtaisesti kyseisen meemin esittelysivulla
- Myös viestien luonti tapahtuu meemikohtaisesti kuten yllä 

##Lisenssi

<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons Licence" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a></br><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">memeDB</span> by <span xmlns:cc="http://creativecommons.org/ns#" property="cc:attributionName">Sxvz</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.