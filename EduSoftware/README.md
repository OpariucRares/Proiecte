# Edu Software (Graph Edition)
---
Esti elev si vrei sa inveti notiuni noi despre capitolul Grafuri? Esti student care nu intelege materia Algoritmica Grafurilor si iti este frica ca o sa ai restanta? Atunci ai ajuns in locul potrivit! Edu Software (Graph Edition) prezinta algoritmii de nivel incepator sau mediu (in viitor ne vom extinde si la algoritmi mai avansati) si iti explica cum functioneaza pas cu pas.

### De ce sa ne alegi pe noi?
Dezvoltatorii acestei aplicatii au trecut cu bine la materia Algoritmica Grafurilor, reusind să desluseasca tainele ei. Cu experienta lor de student, au inteles pasii acestor algoritmi si pot transmite altor generatii.

### Cum este folosita aplicatia?
#### Crearea grafurilor

Utilizatorul are acces la interfata programului, ce va prelua comenzile lui. El are optiunea de a-si crea singur graful. El poate seta numarul de noduri iar apasand butonul de create, vor aparea nodurile fara muchii. Ca sa genereze muchiile, alege tipul grafului (orientat/neorientat), nodul de inceput, nodul de final si costul muchiei. Cand apasa pe butonul de add se genereaza muchia. ATENTIE: daca se seteaza orientarea grafului, nu mai poate fi modificata pe parcurs. Daca vrea sa schimbe orientarea grafului, trebuie sa genereze de la inceput in mod corespunzator.

Interfata goala
![Interfata goala](/tutorialImages/1.JPG)

Interfata cu noduri
![Generezi noduri](/tutorialImages/2.JPG)

Utilizatorul poate pune muchii
![Utilizatorul pune muchiile singur](/tutorialImages/3.JPG)


De asemenea, daca nu vrea sa genereze graful si vrea sa fie generat automat, are optiunea de a genera un graf conex, un graf neconex sau un graf bipartit. Unii algoritmi au nevoie de un nod de start, asa ca utilizatorul poate seta nodul de start in Start Node. Dupa ce a respectat toti pasii mentionati, poate apasa butonul de generate si algoritmul va fi aplicat.

Generare de grafuri cu proprietati
![Generare de grafuri automat cu proprietati speciale exemplu](/tutorialImages/4.JPG)

#### Executia algortimului

In functie de algoritm, tabelul din dreapta jos se modifica. In cazul de fata,dacă vorbim despre algoritmul lui Prim sau Dijkstra,atunci apar coloanele de cost, path (nodul parinte), visited si solutia finala. In cazul algoritmului BFS sau DFS vor aparea coloanele **Visited** si **Solution**. Dupa ce a apasat butonul de generate, utilizatorul poate apasa butonul de **Forward** ca sa vada ce noduri/muchii au fost modificate. Daca nu a inteles un pas, are optiunea de **Backward** ca sa se intoarca in starea precedenta. De asemenea, se modifica valorile tabelului respectiv in functie de modificarile actuale. La final, dupa ce s-a trecut prin toti pasii, se va afisa in coloana Solution solutia respectivului algoritm.

Executia unui algoritm la inceput
![Exemplu de executie unui algoritm inceput](/tutorialImages/5.JPG)

In timpul executiei algoritmului
![In timpul executiei algoritmului](/tutorialImages/6.JPG)

### Import/Export

Daca utilizatorul vrea sa salveze graful creat intr-un fisier, poate apasa butonul de **Export**. Graful va fi serializat si va fi salvat in format JSON cu toate informatiile necesare (noduri, noduri adiacente, muchiile si culorile acestora). De asemenea, daca are un graf preferat pe care sa aplice algoritmi, atunci poate folosi butonul de Import si astfel va fi incarcat graful dorit de utilizator.

### Crearea GIF-urilor

Cand utilizatorul apasa pe butonul de **Forward**, se salveaza imaginea grafului si va fi exportata in folderul **ImagesGenerated**. Daca ajunge la ultimul pas si se afiseaza in coloana **Solution**, se va genera un thread separat si se va crea gif-ul respectiv in ordinea buna.

### Link la prezentare video -> [aici](https://youtu.be/h5V5sgKnLek)
