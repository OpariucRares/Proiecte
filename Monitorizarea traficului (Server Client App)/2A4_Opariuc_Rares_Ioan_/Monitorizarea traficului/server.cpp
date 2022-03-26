#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <errno.h>
#include <unistd.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <signal.h>
#include <pthread.h>
#include <sqlite3.h>
#include <map>
#include <vector>
#include <iostream>
#include <utility>
#include <ctime>
#include <cstdlib>

#define PORT 2908 //portul serverului
extern int errno;

typedef struct thData{
	int idThread; //id-ul thread-ului tinut in evidenta de acest program
	int cl; //descriptorul intors de accept
	int esteLogat = 0; //daca este logat sau nu, va accesa restul de informatii
	int isWalking;
	int distantaParcursa;
	int distantaActuala;
	char* numeLogatClient; //numele utilizatorului
	std::string stradaActiva;
	std::string viteza;
}thData;

struct info{
	std::string numeDrum;
	int distanta = 0; //distanta
	int grad_aglomerare = 0; //daca este libera - 0, semi-libera - 1 sau aglomerata - 2
	int Epeco = 0; //are peco drumul respectiv
	std::string numePeco;
	int ora_1 = 0, minutul_1 = 0, ora_2 = 0, minutul_2 = 0, ora_3 = 0, minutul_3 = 0, ora_4 = 0, minutul_4 = 0;
};
struct drumZoneAux
{
	std::string zona1Aux;
	std::string zona2Aux;
};
struct vreme{
	std::string date;
	std::string tempMedie;
};
struct sport{
	std::string sport;
	std::string hourSport;
	std::string enemy1;
	std::string enemy2;
};
struct peco{
	std::string namePeco;
	std::string typeFuel;
	std::string price;
};
struct users
{
	std::string numeUser;
	std::string prenumeUser;
};
std::map<std::string, std::map<std::string, struct info>> drum; //numele drumului
std::map<std::string, struct drumZoneAux> drumZone;
std::vector<struct vreme> listaVreme;
std::vector<struct sport> listaSport;
std::vector<struct peco> listaPeco;
std::vector<struct users> listaUsers;

int threadFree[1001];

int lg_input;
char* input;

int lg_output;
char* output;

int sd;		//descriptorul de socket de la server
pthread_t th[1001];
pthread_t updateThread;
int countThread = 0; 

static void *treat(void *); //functia executa ce crea thread-uri
void trimiteMesaj(void *);
int verifyThread();


void takeInfoBD(); //functia care prelucreaza informatiile din BD
static int callback(void* data, int argc, char** argv, char** azColName); //sa iau informatia din BD
int getHour(char* sir);
int getMinute(char * sir);
void printInfo();

int cautaUser(char* sir);
int cautaStrada(char* sir);
static void *updateServer(void*);
std::string returnStradatRandom(char* sir);

int main ()
{
	takeInfoBD();
	//printInfo();
  struct sockaddr_in server;	// structura folosita de server
  struct sockaddr_in from;	//structura folosita de client
  if ((sd = socket (AF_INET, SOCK_STREAM, 0)) == -1)
  {
    perror ("Eroare la primitiva socket() din server!");
    return errno;
  }
  int on=1; //utilizarea optiunii SO_REUSEADDR
  setsockopt(sd,SOL_SOCKET,SO_REUSEADDR,&on,sizeof(on));

  bzero (&server, sizeof (server));
  bzero (&from, sizeof (from));
  
  server.sin_family = AF_INET; //stabilirea familiei de socket-uri
  server.sin_addr.s_addr = htonl (INADDR_ANY); //acceptam orice adresa
  server.sin_port = htons (PORT); //utilizam portul de la utilizator
  
  if (bind (sd, (struct sockaddr *) &server, sizeof (struct sockaddr)) == -1)
  {
      perror ("Eroare la primitiva bind() din server!");
      return errno;
  }
  if (listen (sd, 10) == -1) //serverul asculta clientii
  {
    perror ("Eroare la primitiva listen() din server!");
    return errno;
  }
  pthread_create(&updateThread, NULL, &updateServer, NULL);
  while (1)
  {
    int client;
    thData * td; //parametru functia executata de thread     
    socklen_t length = sizeof (from);
    printf ("Asteptam la portul %d...\n",PORT);
    fflush (stdout);
		
		if ( (client = accept (sd, (struct sockaddr *) &from, &length)) < 0)
		{
			perror ("Eroare la primitiva accept() din server.\n");
			continue;
		}
		td = (struct thData*)malloc(sizeof(struct thData));
		td->idThread = countThread++;
		td->cl=client;
		threadFree[td->idThread] = client;
		pthread_create(&th[td->idThread], NULL, &treat, td);			
	}
	return 0;
}
static void *treat(void * arg)
{		
		struct thData tdL; 
		tdL= *((struct thData*)arg);		 
		pthread_detach(pthread_self());		
		trimiteMesaj((struct thData*)arg);
		close ((intptr_t)arg);
		return(NULL);	  		
};
void trimiteMesaj(void *arg)
{
		std::string zonaIncep;
    int okConnect = 1;
		struct thData tdL; 
		tdL= *((struct thData*)arg);
		while (1)
		{
			if (read (tdL.cl, &lg_input,sizeof(int)) <= 0)
			{
					  printf("Thread-ul %d ",tdL.idThread);
					  perror ("Eroare la citirea lungimii mesajului de la client!\n");
			}
			input = (char*)malloc((lg_input + 1) * sizeof(char));
			bzero(input, lg_input);
			if (read (tdL.cl, input, lg_input) <= 0)
			{
					  printf("Thread-ul %d ",tdL.idThread);
					  perror ("Eroare la citirea mesajului de la client!\n");
			}
			if (strstr(input, "Merg cu viteza ") != NULL)
			{
				char auxVitezachar[2];
				std::string vitezaMesajAux;
				std::string outputString;
				
				auxVitezachar[0] = input[15];
				if (input[16] != ' ')
					auxVitezachar[1] = input[16];
				vitezaMesajAux = auxVitezachar;

				//std::cout << "MERGE BINE AICI: " << vitezaMesajAux << '\n';
				outputString = "Tu mergi cu viteza ";
				outputString += vitezaMesajAux;
				outputString += " pe o strada cu limita de viteza ";
				outputString += tdL.viteza;
				
				if (vitezaMesajAux > tdL.viteza)
					outputString += " ! Incalci legea!\n";
				else
					outputString += " ! Respecti legea! Bravo!\n";
			
				lg_output = outputString.size();
				output = (char*)malloc((lg_output + 1) * sizeof(char));
				bzero(output, lg_output);
				strcpy(output, outputString.c_str());

				if (drum[drumZone[tdL.stradaActiva].zona1Aux][drumZone[tdL.stradaActiva].zona2Aux].grad_aglomerare == 0)
					tdL.distantaParcursa += 3;
				else if (drum[drumZone[tdL.stradaActiva].zona1Aux][drumZone[tdL.stradaActiva].zona2Aux].grad_aglomerare == 1)
					tdL.distantaParcursa += 2;
				else 
					tdL.distantaParcursa += 1;


				if (tdL.distantaParcursa >= tdL.distantaActuala)
				{
					std::string stradaAuxWalk, zonaAuxWalk;
					if (drumZone[tdL.stradaActiva].zona1Aux != zonaIncep)
						zonaAuxWalk = drumZone[tdL.stradaActiva].zona1Aux;
					else
						zonaAuxWalk = drumZone[tdL.stradaActiva].zona2Aux;

					std::map<std::string, std::map<std::string, struct info>>::iterator itr;
					std::map<std::string, struct info>::iterator ptr;
					std::vector<std::string> randomStrada;
					itr = drum.find(zonaAuxWalk);
					
					for (ptr = itr->second.begin(); ptr != itr->second.end(); ptr++) 
					{
						std::string zona2String;
						zona2String = ptr->first;
						randomStrada.push_back(drum[itr->first][ptr->first].numeDrum);
					}
					
					srand(time(0));
					int auxNumber = rand() % randomStrada.size();
					//printf("%d %s\n", auxNumber, randomStrada[auxNumber].c_str());
					while (randomStrada[auxNumber] == tdL.stradaActiva)
							 auxNumber = rand() % randomStrada.size();
					tdL.stradaActiva = randomStrada[auxNumber];

					std::string vitezaAici;

					if (drum[drumZone[tdL.stradaActiva].zona1Aux][drumZone[tdL.stradaActiva].zona2Aux].grad_aglomerare == 0)
							vitezaAici = "50";
						else if (drum[drumZone[tdL.stradaActiva].zona1Aux][drumZone[tdL.stradaActiva].zona2Aux].grad_aglomerare == 1)
							vitezaAici = "30";
						else
							vitezaAici = "10";
						
					lg_output = strlen("Ai ajuns intr-o zona noua! Zona este: ") + zonaAuxWalk.size() + strlen(" Mergi pe strada ") + 
											tdL.stradaActiva.size() + strlen(" Limita de viteza este ") + vitezaAici.size() + strlen(" !\n");

					output = (char*)malloc((lg_output + 1) * sizeof(char));
					bzero(output, lg_output);
					strcpy(output, "Ai ajuns intr-o zona noua! Zona este: ");
					strcat(output, zonaAuxWalk.c_str());
					strcat(output, " Mergi pe strada ");
					strcat(output, tdL.stradaActiva.c_str());
					strcat(output, " Limita de viteza este ");
					strcat(output, vitezaAici.c_str());
					strcat(output, " !\n");
					
				
					tdL.distantaParcursa = 0;
					tdL.distantaActuala = drum[drumZone[tdL.stradaActiva].zona1Aux][drumZone[tdL.stradaActiva].zona2Aux].distanta;
					zonaIncep = zonaAuxWalk;
					tdL.viteza = vitezaAici;
					//printf("Zona este %s: Noi suntem pe strada %s. Distanele sunt %d %d\n", zonaAuxWalk.c_str(), tdL.stradaActiva.c_str(), tdL.distantaParcursa, tdL.distantaActuala);
				}
				
			}
			else if (strstr(input, "-zona: ") != NULL)
			{
				if (tdL.isWalking == 1)
				{
					lg_output = strlen("Deja va plimbati!\n");
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Deja va plimbati!\n");
				}
				else
				{
					if (drum[input + 7].size() > 0)
					{
					
						std::string mere;
						mere = returnStradatRandom(input + 7);
						std::string viteza_aux;
						//printf("zona aici este: %s %s %s\n", input + 7, drumZone[input + 7].zona1Aux.c_str(), drumZone[input + 7].zona2Aux.c_str());
						//printf("grad aglomerare: %d", drum[drumZone[input + 7].zona1Aux][drumZone[input + 7].zona2Aux].grad_aglomerare);
						if (drum[drumZone[mere].zona1Aux][drumZone[mere].zona2Aux].grad_aglomerare == 0)
							viteza_aux = "50";
						else if (drum[drumZone[mere].zona1Aux][drumZone[mere].zona2Aux].grad_aglomerare == 1)
							viteza_aux = "30";
						else
							viteza_aux = "10";
						tdL.viteza = viteza_aux;
						//std::cout << "MERGE: " << tdL.viteza << '\n';
						lg_output = strlen("Mergi pe ") + mere.size() + strlen(" ! Limita de viteza este ") + 
						            viteza_aux.size() + strlen(" !\n");
						output = (char*)malloc((lg_output + 1) * sizeof(char));
						bzero(output, lg_output);
						
						strcpy(output, "Mergi pe ");
						strcat(output, mere.c_str());
						strcat(output, " ! Limita de viteza este ");
						strcat(output, viteza_aux.c_str());
						strcat(output, " !\n");

						tdL.isWalking = 1;
						tdL.distantaActuala = drum[drumZone[mere].zona1Aux][drumZone[mere].zona2Aux].distanta;
						tdL.distantaParcursa = 0;
						tdL.stradaActiva = mere;
						zonaIncep = input + 7;
					}
					else
					{
						lg_output = strlen("Zona nu exista!\n");
						output = (char*) malloc((lg_output + 1) * sizeof(char));
						bzero(output, (lg_output + 1));
						strcpy(output, "Zona nu exista!\n");
					}
				}
			}
			else if (strstr(input, "-login: ") != NULL)
			{
				if (tdL.esteLogat == 0)
				{
					if (cautaUser(input + 8) == 1)
					{
						//exista
						lg_output = strlen("V-ati conectat, ") + strlen(input + 8) + strlen(" !\n") + 1;
						tdL.numeLogatClient = (char*)malloc((strlen(input + 8) + 1) * sizeof(char));
						strcpy(tdL.numeLogatClient, input + 8);
						output = (char*) malloc((lg_output + 1) * sizeof(char));
						bzero(output, (lg_output + 1));
						strcpy(output, "V-ati conectat, ");
						strcat(output, input + 8);
						strcat(output, " !\n");
						tdL.esteLogat = 1;
					}
					else
					{
						lg_output = strlen("Nu exista acest user!\n");
						output = (char*) malloc((lg_output + 1) * sizeof(char));
						bzero(output, (lg_output + 1));
						strcpy(output, "Nu exista acest user!\n");
					}
				}
				else
				{
					lg_output = strlen("Sunteti deja logat, ") + strlen(tdL.numeLogatClient) + strlen(" !\n") + 1;
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Sunteti deja logat, ");
					strcat(output, tdL.numeLogatClient);
					strcat(output, " !\n");
				}
				
			}
			else if (strcmp(input, "-vreme") == 0)
			{
				if (tdL.esteLogat == 1)
				{
					lg_output = 0;
					for(int i = 0; i < listaVreme.size(); i++)
						lg_output += strlen("Ziua: ") + listaVreme[i].date.size() + strlen(" Temperatura medie: ") + listaVreme[i].tempMedie.size() + 1;
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Ziua: ");
					strcat(output, listaVreme[0].date.c_str());
					strcat(output, " Temperatura medie: ");
					strcat(output, listaVreme[0].tempMedie.c_str());
					strcat(output, "\n");
					for(int i = 1; i < listaVreme.size(); i++)
					{
						strcat(output, "Ziua: ");
						strcat(output, listaVreme[0].date.c_str());
						strcat(output, " Temperatura medie: ");
						strcat(output, listaVreme[0].tempMedie.c_str());
						strcat(output, "\n");
					}
				}
				else
				{
					lg_output = strlen("Nu sunteti logat!\n");
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Nu sunteti logat!\n");
				}
			}
			else if (strcmp(input, "-sport") == 0)
			{
				if (tdL.esteLogat == 1)
				{
					lg_output = 0;
					for(int i = 0; i < listaSport.size(); i++)
						lg_output += strlen("Sport: ") + listaSport[i].sport.size() + strlen(" Ora meci: ") + listaSport[i].hourSport.size() + 
									strlen(" Gazde: ") + listaSport[i].enemy1.size() + strlen(" Oaspeti: ") + listaSport[i].enemy2.size() + 1;
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Sport: ");
					strcat(output, listaSport[0].sport.c_str());
					strcat(output, " Ora meci: ");
					strcat(output, listaSport[0].hourSport.c_str());
					strcat(output, " Gazde: ");
					strcat(output, listaSport[0].enemy1.c_str());
					strcat(output, " Oaspeti: ");
					strcat(output, listaSport[0].enemy2.c_str());
					strcat(output, "\n");
					for(int i = 1; i < listaVreme.size(); i++)
					{
						strcat(output, "Sport: ");
						strcat(output, listaSport[i].sport.c_str());
						strcat(output, " Ora meci: ");
						strcat(output, listaSport[i].hourSport.c_str());
						strcat(output, " Gazde: ");
						strcat(output, listaSport[i].enemy1.c_str());
						strcat(output, " Oaspeti: ");
						strcat(output, listaSport[i].enemy2.c_str());
						strcat(output, "\n");
					}
				}
				else
				{
					lg_output = strlen("Nu sunteti logat!\n");
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Nu sunteti logat!\n");
				}
			}
			else if (strcmp(input, "-peco") == 0)
			{
				if (tdL.esteLogat == 1)
				{
					lg_output = 0;
					for(int i = 0; i < listaSport.size(); i++)
						lg_output += strlen("Nume peco: ") + listaPeco[i].namePeco.size() + strlen(" Tip benzina: ") + listaPeco[i].typeFuel.size() + 
									strlen(" Pretul: ") + listaPeco[i].price.size() + 1;
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Nume peco: ");
					strcat(output, listaPeco[0].namePeco.c_str());
					strcat(output, " Tip benzina: ");
					strcat(output, listaPeco[0].typeFuel.c_str());
					strcat(output, " Pretul: ");
					strcat(output, listaPeco[0].price.c_str());
					strcat(output, "\n");
					for(int i = 1; i < listaVreme.size(); i++)
					{
						strcpy(output, "Nume peco: ");
						strcat(output, listaPeco[i].namePeco.c_str());
						strcat(output, " Tip benzina: ");
						strcat(output, listaPeco[i].typeFuel.c_str());
						strcat(output, " Pretul: ");
						strcat(output, listaPeco[i].price.c_str());
						strcat(output, "\n");
					}
				}
				else
				{
					lg_output = strlen("Nu sunteti logat!\n");
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Nu sunteti logat!\n");
				}
			}
			else if (strstr(input, "-accident: ") != 0)
			{
				if(drumZone.find(input + 11) == drumZone.end())
				{
					lg_output = strlen("Nu exista strada asta!\n");
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Nu exista strada asta!\n");
				}
				else
				{
					lg_output = strlen("Accident pe strada ") + strlen(input + 11) + drumZone[input + 11].zona1Aux.size() + drumZone[input + 11].zona2Aux.size() + 3;
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Accident pe strada ");
					strcat(output, input + 11);
					strcat(output, " ");
					strcat(output, drumZone[input + 11].zona1Aux.c_str());
					strcat(output, " ");
					strcat(output, drumZone[input + 11].zona2Aux.c_str());
					strcat(output, "\n");
					for(int i = 0; i < countThread; i++)
					{
						if (threadFree[i] != 0)
						{
							if (write (threadFree[i], &lg_output, sizeof(int)) <= 0)
							{
								  printf("Thread-ul %d ",tdL.idThread);
									perror ("Eroare la scrierea lungimii mesajului pentru client!\n");
							}
							if (write (threadFree[i], output, lg_output) <= 0)
							{
								  printf("Thread-ul %d ",tdL.idThread);
									perror ("Eroare la scrierea mesajului pentru client!\n");
							}
						}
					}
				}
			}
			else if (strcmp(input, "-exit") == 0)
			{
				if (tdL.esteLogat == 1)
				{
					lg_output = strlen("V-ati deconectat, ") + strlen(tdL.numeLogatClient) + strlen("! O zi buna!\n");
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "V-ati deconectat, ");
					strcat(output, tdL.numeLogatClient);
					strcat(output, "! O zi buna!\n");
					tdL.esteLogat = 0;
					okConnect = 0;
				}
				else
				{
					lg_output = strlen("V-ati deconectat! O zi buna!\n");
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "V-ati deconectat! O zi buna!\n");
					okConnect = 0;
				}
			}
			else
			{
					lg_output = strlen("Comanda necunoscuta!\n");
					output = (char*) malloc((lg_output + 1) * sizeof(char));
					bzero(output, (lg_output + 1));
					strcpy(output, "Comanda necunoscuta!\n");
			}
			printf ("Thread %d Mesaj primit: %s Mesajul trimis: %s",tdL.idThread, input, output);
			if ((strstr(input, "-accident: ") != 0) && drumZone.find(input + 11) != drumZone.end()); //a scris la toti
			else
			{
				if (write (tdL.cl, &lg_output, sizeof(int)) <= 0)
				{
					  printf("Thread-ul %d ",tdL.idThread);
					  	printf("patru\n");
						perror ("Eroare la scrierea lungimii mesajului pentru client!\n");
				}
				if (write (tdL.cl, output, lg_output) <= 0)
				{
					  printf("Thread-ul %d ",tdL.idThread);
					  	printf("cinci\n");
						perror ("Eroare la scrierea mesajului pentru client!\n");
				}
			}
			if (okConnect == 0)
				break;
		}
		tdL.esteLogat = 0;
		threadFree[tdL.idThread] = 0;
}
int verifyThread()
{
	for(int i = 0; i < countThread; i++)
		if (threadFree[i] == 0)
			return i;
	return countThread;
}
void takeInfoBD()
{
	sqlite3* DB;
  int exit = 0;
  exit = sqlite3_open("BazaDeDate.db", &DB);
  std::string data("CALLBACK FUNCTION");
  
  std::string sql_drum("SELECT * FROM DRUM;");
 	int rc = sqlite3_exec(DB, sql_drum.c_str(), callback, (void*)data.c_str(), NULL);
	std::string sql_vreme("SELECT * FROM VREME;");
  rc = sqlite3_exec(DB, sql_vreme.c_str(), callback, (void*)data.c_str(), NULL);
	std::string sql_sport("SELECT * FROM EV_SPORT;");
 	rc = sqlite3_exec(DB, sql_sport.c_str(), callback, (void*)data.c_str(), NULL);
	std::string sql_peco("SELECT * FROM PECO;");
  rc = sqlite3_exec(DB, sql_peco.c_str(), callback, (void*)data.c_str(), NULL);
	std::string sql_utilizatori("SELECT * FROM UTILIZATORI;");
  rc = sqlite3_exec(DB, sql_utilizatori.c_str(), callback, (void*)data.c_str(), NULL);
	sqlite3_close(DB);
}
static int callback(void* data, int argc, char** argv, char** azColName)
{
	int i;
  char *nume_drum_aux, *zona1, *zona2;
  std::string aux1, aux2, aux3, aux4;
  int lg;
	for (i = 0; i < argc; i++) 
	{
		if (strcmp(azColName[i], "nume_drum") == 0)
		{
			lg = strlen(argv[i]);
			nume_drum_aux = (char*)malloc(sizeof(char) * (lg + 1));
			strcpy(nume_drum_aux, argv[i]);
		}
		else if (strcmp(azColName[i], "zona1") == 0)
		{
			lg = strlen(argv[i]);
			zona1 = (char*)malloc(sizeof(char) * (lg + 1));
			strcpy(zona1, argv[i]);
		}
		else if (strcmp(azColName[i], "zona2") == 0)
		{
			lg = strlen(argv[i]);
			zona2 = (char*)malloc(sizeof(char) * (lg + 1));
			strcpy(zona2, argv[i]);
		}
		else if (strcmp(azColName[i], "distanta") == 0)
		{
			drumZone[nume_drum_aux].zona1Aux = zona1;
			drumZone[nume_drum_aux].zona2Aux = zona2;

			drum[zona1][zona2].numeDrum = drum[zona2][zona1].numeDrum = nume_drum_aux;
			drum[zona1][zona2].distanta = drum[zona2][zona1].distanta = atoi(argv[i]);;
		}
		else if (strcmp(azColName[i], "nume_peco") == 0)
		{
			if (argv[i])
			{
				drum[zona1][zona2].Epeco = drum[zona2][zona1].Epeco = 1;
				drum[zona1][zona2].numePeco = drum[zona2][zona1].numePeco = argv[i];
			}
			else
			{
				drum[zona1][zona2].Epeco = drum[zona2][zona1].Epeco = 0;
				drum[zona1][zona2].numePeco = drum[zona2][zona1].numePeco = "NULL";
			}
		}
		else if (strcmp(azColName[i], "ora1") == 0)
		{
			drum[zona1][zona2].ora_1 = drum[zona2][zona1].ora_1 = getHour(argv[i]);
			drum[zona1][zona2].minutul_1 = drum[zona2][zona1].minutul_1 = getMinute(argv[i]);
		}
		else if (strcmp(azColName[i], "ora2") == 0)
		{
			drum[zona1][zona2].ora_2 = drum[zona2][zona1].ora_2 = getHour(argv[i]);
			drum[zona1][zona2].minutul_2 = drum[zona2][zona1].minutul_2 = getMinute(argv[i]);
		}
		else if (strcmp(azColName[i], "ora3") == 0)
		{
			drum[zona1][zona2].ora_3 = drum[zona2][zona1].ora_3 = getHour(argv[i]);
			drum[zona1][zona2].minutul_3 = drum[zona2][zona1].minutul_3 = getMinute(argv[i]);
		}
		else if (strcmp(azColName[i], "ora4") == 0)
		{
			drum[zona1][zona2].ora_4 = drum[zona2][zona1].ora_4 = getHour(argv[i]);
			drum[zona1][zona2].minutul_4 = drum[zona2][zona1].minutul_4 = getMinute(argv[i]);
		}
		else if (strcmp(azColName[i], "ziua") == 0)
			aux1 = argv[i];
		else if (strcmp(azColName[i], "temp_medie") == 0)
		{
			aux2 = argv[i];
			listaVreme.push_back({aux1, aux2});
		}
		else if (strcmp(azColName[i], "tip_sport") == 0)
			aux1 = argv[i];
		else if (strcmp(azColName[i], "ora") == 0)
			aux2 = argv[i];
		else if (strcmp(azColName[i], "adv1") == 0)
			aux3 = argv[i];
		else if (strcmp(azColName[i], "adv2") == 0)
		{
			aux4 = argv[i];
			listaSport.push_back({aux1, aux2, aux3, aux4});
		}
		else if (strcmp(azColName[i], "peco") == 0)
			aux1 = argv[i];
		else if (strcmp(azColName[i], "tip_benzina") == 0)
			aux2 = argv[i];
		else if (strcmp(azColName[i], "pret_benzina") == 0)
		{
			aux3 = argv[i];
			listaPeco.push_back({aux1, aux2, aux3});
		}
		else if (strcmp(azColName[i], "nume") == 0)
			aux1 = argv[i];
		else if (strcmp(azColName[i], "prenume") == 0)
		{
			aux2 = argv[i];
			listaUsers.push_back({aux1, aux2});
		}
  }
  return 0;
}
int getHour(char* sir)
{
	int aux;
	char ora_sir[2];
	if (sir[1] == ':')
	{
		ora_sir[0] = sir[0];
		ora_sir[1] = '\0';
	}
	else
	{
		ora_sir[0] = sir[0];
		ora_sir[1] = sir[1];
		ora_sir[2] = '\0';
	}
	aux = atoi(ora_sir);
	return aux;
}
int getMinute(char* sir)
{
	int aux;
	char minut_sir[2];
	if (sir[1] == ':') //9:00
	{
		minut_sir[0] = sir[2];
		minut_sir[1] = sir[3];
		minut_sir[2] = '\0';
	}
	else
	{
		minut_sir[0] = sir[3];
		minut_sir[1] = sir[4];
		minut_sir[2] = '\0';
	}
	aux = atoi(minut_sir);
	return aux;
}
int cautaUser(char* sir)
{
	int lg;
	//string numeCautaUser;
	std::string listaAux, sirAux;
	sirAux = sir;

	for(int i = 0; i < listaUsers.size(); i++)
	{
		listaAux = listaUsers[i].numeUser;
		listaAux += " ";
		listaAux += listaUsers[i].prenumeUser;
		if (sirAux == listaAux)
			return 1;
	}
	return 0;
}
static void *updateServer(void* arg)
{
	while(1)
	{
		for(std::map<std::string, struct drumZoneAux>::iterator it = drumZone.begin(); it != drumZone.end(); it++)
		{
			std::string auxServ;
			auxServ = it->first;
			int hour, minutes;
			time_t now;
			time(&now);
			struct tm* local = localtime(&now);
			hour = local->tm_hour;
			minutes = local->tm_min;
			int ora1drum, ora2drum, ora3drum, ora4drum;
			ora1drum = drum[drumZone[auxServ].zona1Aux][drumZone[auxServ].zona2Aux].ora_1;
			ora2drum = drum[drumZone[auxServ].zona1Aux][drumZone[auxServ].zona2Aux].ora_2;
			ora3drum = drum[drumZone[auxServ].zona1Aux][drumZone[auxServ].zona2Aux].ora_3;
			ora4drum = drum[drumZone[auxServ].zona1Aux][drumZone[auxServ].zona2Aux].ora_4;
			if (hour< ora1drum)
			{
				drum[drumZone[auxServ].zona1Aux][drumZone[auxServ].zona2Aux].grad_aglomerare = 
				drum[drumZone[auxServ].zona2Aux][drumZone[auxServ].zona1Aux].grad_aglomerare = 0;
			}
			else if  ((ora1drum <= hour && ora2drum >= hour) || (ora3drum <= hour && ora4drum >= hour))
			{
				drum[drumZone[auxServ].zona1Aux][drumZone[auxServ].zona2Aux].grad_aglomerare = 
				drum[drumZone[auxServ].zona2Aux][drumZone[auxServ].zona1Aux].grad_aglomerare = 2;
			}
			else if (ora2drum <= hour && ora3drum >= hour)
			{
				drum[drumZone[auxServ].zona1Aux][drumZone[auxServ].zona2Aux].grad_aglomerare = 
				drum[drumZone[auxServ].zona2Aux][drumZone[auxServ].zona1Aux].grad_aglomerare = 1;
			}
			else
			{
				drum[drumZone[auxServ].zona1Aux][drumZone[auxServ].zona2Aux].grad_aglomerare = 
				drum[drumZone[auxServ].zona2Aux][drumZone[auxServ].zona1Aux].grad_aglomerare = 0;
			}
		}
		sleep(60);
	}
}
std::string returnStradatRandom(char * sir)
{
	std::map<std::string, std::map<std::string, struct info>>::iterator itr;
	std::map<std::string, struct info>::iterator ptr;
	std::vector<std::string> randomStrada;
	itr = drum.find(sir);
	for (ptr = itr->second.begin(); ptr != itr->second.end(); ptr++) 
	{
		std::string zona2String;
		zona2String = ptr->first;
		randomStrada.push_back(drum[itr->first][ptr->first].numeDrum);
	}
	for(int i = 0; i < randomStrada.size(); i++)
		std::cout << randomStrada[i] << '\n';
	srand(time(0));
	int auxNumber = rand() % randomStrada.size();
	//printf("%d %s\n", auxNumber, randomStrada[auxNumber].c_str());
	return randomStrada[auxNumber];
}
void printInfo()
{
	printf("\n");
	for(int i = 0; i < listaVreme.size(); i++)
		printf("%s %s\n", listaVreme[i].date.c_str(), listaVreme[i].tempMedie.c_str());
	printf("\n");
	for(int i = 0; i < listaSport.size(); i++)
		printf("%s %s %s %s\n", listaSport[i].sport.c_str(), listaSport[i].hourSport.c_str(), listaSport[i].enemy1.c_str(), listaSport[i].enemy2.c_str());
	printf("\n");
	for(int i = 0; i < listaPeco.size(); i++)
		printf("%s %s %s \n", listaPeco[i].namePeco.c_str(), listaPeco[i].typeFuel.c_str(), listaPeco[i].price.c_str());
	printf("\n");
	for(int i = 0; i < listaUsers.size(); i++)
		printf("%s %s\n", listaUsers[i].numeUser.c_str(), listaUsers[i].prenumeUser.c_str());
	printf("\n");
}