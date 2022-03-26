#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <errno.h>
#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <netdb.h>
#include <string.h>
#include <arpa/inet.h>
#include <pthread.h>
#include <string>

extern int errno; //codul de eroare
int port; //portul de conectare la server

pthread_t th[2];
int lg_input;
char input[1001];
int sd;
int isWalking = 0;

int lg_output;
char* output;
static void *trimitViteza(void *); //thread in care clientul trimite viteza cu care merge la un minut
static void *trimiteMesajul(void*); //thread in care clientul primeste mesajele

int main (int argc, char *argv[])
{
  struct sockaddr_in server;  // structura folosita pentru conectare 
  if (argc != 3)
  {
    printf ("Sintaxa: %s <adresa_server> <port>\n", argv[0]);
    return -1;
  }
  port = atoi (argv[2]);
  if ((sd = socket (AF_INET, SOCK_STREAM, 0)) == -1)
  {
    perror ("Eroare la primitiva socket() din client.\n");
    return errno;
  }
  server.sin_family = AF_INET; //familia socket-ului
  server.sin_addr.s_addr = inet_addr(argv[1]); //adresa IP a serverului 
  server.sin_port = htons (port); //portul de conectare
  
  /* ne conectam la server */
  if (connect (sd, (struct sockaddr *) &server,sizeof (struct sockaddr)) == -1) //
  {
      perror ("Eroare la primitiva connect() din client.\n");
      return errno;
  }
  pthread_create(&th[0], NULL, &trimitViteza, NULL);
  pthread_create(&th[1], NULL, &trimiteMesajul, NULL);  

  printf("Bine ati venit pe iMap - Monitorizarea traficului. Comenzile sunt:\n");
  printf("-login: nume prenume (sa va logati cu contul vostru)\n");
  printf("-vreme (accesati informatiile despre vreme daca sunteti logat)\n");
  printf("-peco (accesati informatiile despre preturile de la statiile peco daca sunteti logat)\n");
  printf("-sport (accesati informatiile despre evenimente sportive daca sunteti logat)\n");
  printf("-zona: ZonaInceput (daca zonaInceput exista, clientul va parcurge orasul)\n");
  printf("-accident: strada (daca exista strada, va trimite accidentul la toti clientii)\n");
  printf("-exit (v-ati deconectat)\n\n");
  
  while(1)
  {
      if (read (sd, &lg_output, sizeof(int)) <= 0)
      {
          perror ("Eroare la citirea lungimii din output din client!");
          return errno;
      }
      output = (char*)malloc(sizeof(char) * (lg_output + 1));
      bzero(output, lg_output);
      if (read (sd, output, lg_output) <= 0)
      {
        perror ("Eroare la citirea mesajului din output din client!");
        return errno;
      }
      printf("%s", output);
      if (strstr(output, "V-ati deconectat, ") != 0 || strstr(output, "V-ati deconectat! ") != 0)
        break;
      if (strstr(output, "Mergi pe ") != 0)
        isWalking = 1;
  }
  free(output);
  close (sd);
}
static void *trimitViteza(void *arg)
{
    int okConnect = 1;
    while(1)
    {
        if (isWalking)
        {
          srand(time(0));
          int auxNumber = rand() % 60 + 1;
          std::string sirAuxNumber = std::to_string(auxNumber);
          lg_input = strlen("Merg cu viteza ") + sirAuxNumber.size() + strlen(" !\n");

          bzero(input, 1001);
          
          strcpy(input, "Merg cu viteza ");
          strcat(input, sirAuxNumber.c_str());
        
          strcat(input, " !\n");

          write(sd, &lg_input, sizeof(int));
          write(sd, input, lg_input);
          sleep(60);
        }
    }
    return NULL;
}
static void* trimiteMesajul(void* arg)
{
    while(1)
    {
      fgets(input, 1001, stdin);
      lg_input = strlen(input);
      input[lg_input - 1] = '\0';
      lg_input--;
      write(sd, &lg_input, sizeof(int));
      input[lg_input] = '\0';
      write(sd, input, lg_input);
    }
    return NULL;
}