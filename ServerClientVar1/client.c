#include <unistd.h>
#include <string.h>
#include <stdlib.h>
#include <stdio.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>


char username_logat[1024];
int ok_logat = 0;

int main()
{
    printf("Bine ati venit la serverul meu! Pentru a va loga, introduceti username-ul cu urmatorul format\nlogin : prenume.nume (Ex: login : rares.opariuc)\n\n");
    //comanda1 : login
    //comanda2 : get-logged-users
    //comanda3 : get-proc-info
    //comanda4 : logout
    //comanda5 : quit

    int comanda_ok = 0;
    int fd1, fd2;
    fd1 = open("fifo_1", O_WRONLY);  
    fd2 = open("fifo_2", O_RDONLY);
   
    if (fd1 == -1)
    {
        printf("Eroare la deschidere fifo_1!\n");
        exit(1);
    }
    if (fd2 == -1)
    {
        printf("Eroare la deschidere fifo_2!\n");
        exit(1);
    }
    //fifo_1 -> scriem informatii pt server, serverul le citeste
    //fifo_2 -> serverul scrie, client-ul afiseaza raspunsul

    char sir[1024], comanda[1024], aux[1024];
    while(1)
    {
        memset(sir, 0, 1024);
        fgets(sir, 1024, stdin);
        //printf("Comanda este %s\n", sir);
        if ((strstr(sir, "logout\n") == sir || strstr(sir, "quit\n") == sir) && ok_logat == 1)
        {
            char ajutor[1024];
            memset(ajutor, 0, 1024);
            strcpy(ajutor, sir);
            strcat(ajutor, username_logat);
            ajutor[strlen(ajutor)]='\0';
            write(fd1, ajutor, strlen(ajutor));
        }
        else 
        {
            sir[strlen(sir)] = '\0';
            write(fd1, sir, strlen(sir)); //scriem pentru server
            
        }
        memset(aux, 0, 1024);
        read(fd2, aux, 1024);
        if (strstr(sir, "login : ") == sir && ok_logat == 1)
        {
            char rb[2048];
            memset(rb, 0, 2048);
            strcpy(rb, "\nSunteti deja logat ");
            strcat(rb, username_logat);
            strcat(rb, "Incercati alta comanda!\n\n");
            int lg = strlen(rb);
            memset(rb, 0, 1024);
            sprintf(rb, "\n%dSunteti deja logat %sIncercati alta comanda!\n\n", lg, username_logat);
            printf("%s", rb);
        }
        else  if (strstr(sir, "get-logged-users") == sir || strstr(sir, "get-proc-info : ") == sir)
        {
            if (ok_logat == 1)
            {
                char rb[2048];
                memset(rb, 0, 2048);
                int lg = strlen(aux);
                sprintf(rb, "%d%s\n", lg, aux);
                printf(rb, aux);
            }
            else
            {
                char rb[2048];
                memset(rb, 0, 2048);
                int lg = strlen("Trebuie sa fiti logati ca sa folositi comanda!\n\n");
                sprintf(rb, "%dTrebuie sa fiti logati ca sa folositi comanda!\n\n", lg);
                printf("%s", rb);
            }
        } 
        else
        {
            if (strstr(aux, "quit\n") == aux)
            {
                char rb[2048];
                memset(rb, 0, 2048);
                int lg = strlen("Ati inchis aplicatia! O zi buna!\n");
                sprintf(rb, "%dAti inchis aplicatia! O zi buna!\n", lg);
                if (ok_logat == 1)
                {
                    ok_logat = 0;
                    memset(rb, 0, 2048);

                    lg += strlen("S-a deconectat ");
                    lg += strlen(username_logat) + 1;
                    sprintf(rb, "%dAti inchis aplicatia! O zi buna!\nS-a deconectat %s\n", lg, username_logat);
                }
                printf("%s", rb);
                break;
            }
            else if (strstr(aux, "A reusit sa se logheze ") == aux && strstr(sir, "login : ") == sir)
            {
                char rb[2048];
                memset(rb, 0, 2048);
                int lg = strlen(aux);
                sprintf(rb, "%d%s\n", lg, aux);
                printf("%s", rb);
                memset(username_logat, 0, 1024);
                strcpy(username_logat, aux + 23);
                ok_logat = 1;
               // printf("%s\n", "aici sunt");
            }
            else if (strstr(sir, "logout\n") == sir)
            {
                if (ok_logat == 0)
                {
                    char rb[2048];
                    memset(rb, 0, 2048);
                    int lg = strlen("Nu va puteti deloga pentru ca nu sunteti conectat!\n\n");
                    sprintf(rb, "%dNu va puteti deloga pentru ca nu sunteti conectat!\n\n", lg);
                    printf("%s", rb);
                }
                else
                {
                    char rb[2048];
                    memset(rb, 0, 2048);
                    int lg = strlen("S-a reusit delogarea!\n\n");
                    sprintf(rb, "%dS-a reusit delogarea!\n\n", lg);
                    printf("%s", rb);
                    ok_logat = 0;
                    memset(username_logat, 0, 1024);
                }
            }
            else
            {
                //comanda nu este buna
                char rb[2048];
                memset(rb, 0, 2048);
                int lg = strlen(aux);
                sprintf(rb, "%d%s\n", lg, aux);
                printf("%s", rb);
                //printf("%s\n", aux);
            }
        }
    }
    close(fd1);
    close(fd2);
    return 0;
}