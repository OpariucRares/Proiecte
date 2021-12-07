#include <unistd.h>
#include <string.h>
#include <stdlib.h>
#include <stdio.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <sys/wait.h>
#include <sys/uio.h>
#include<sys/utsname.h>
#include<utmp.h>
#include <unistd.h>
#include <sys/socket.h>
#include <time.h>
char raspuns[1024];
int existaFisier()
{
    //Configurarea fisierului: prima linie reprezinta numarul de utilizatori, iar dupa urmatoarele linii reprezinta utilizatorii separati printr-un enter
    int fd, contor; //deschidem fisierul
    fd = open("utilizatori.txt", O_RDONLY);
    if (fd == -1)
    {
        memset(raspuns, 0, 1024);
        strcpy(raspuns, "0Ne pare rau, dar inca nu avem o lista cu utilizatori!\n");
        return 0;
    }
    char aux_number[1024]; //cate cifre are numarul de utilizatori
    FILE* fis;
    fis = fdopen(fd, "r");
    fgets(aux_number, 1024, fis);
    //printf("Numarul de utilizatori este %s", aux_number);
    contor = atoi(aux_number);
    //printf("Numarul de utilizatori este %d\n", contor);
    if (contor == 0)
    {
        memset(raspuns, 0, 1024);
        strcpy(raspuns, "0Ne pare rau, avem o lista cu utilizatorii, dar este goala!\n");
        return 0;
    }
    close(fd);
    fclose(fis);
    return 1;
}
int ok_logat;
int main()
{
    //comanda1 : login
    //comanda2 : get-logged-users
    //comanda3 : get-proc-info
    //comanda4 : logout
    //comanda5 : quit

    int pfd[2], fd1, fd2, status, sockets[2];
    char sir[1024];
    pid_t proc;
    

    unlink("./fifo_1");
    unlink("./fifo_2");
    mkfifo("fifo_1", 0777);
    mkfifo("fifo_2", 0777);
    
    fd1 = open("fifo_1", O_RDONLY); //am deschis fifo_1 ca sa luam ce am primit de la server, acum sa scriem in fifo_2 raspunsul
    fd2 = open("fifo_2", O_WRONLY);
   
    if (fd1 == -1)
    {
        printf("Eroare la deschidere fifo_1!\n");
        exit(1);
    }
    if (fd2 == -1)
    {
        printf("Eroare la deschidere fifo_1!\n");
        exit(1);
    }
    
    while (1)
    {
        memset(sir, 0, 1024);
        read(fd1, sir, 1024);
        //printf("%s\n", sir);
        if (strstr(sir, "login : ") == sir)
        {
            if (pipe(pfd) == -1)         
            {
                printf("Eroare la pipe!\n");
                exit(1);
            }
            //printf("%d\n", ok_logat);
            proc = fork();
            if (proc == -1)
            {
                printf("Eroare la fork!\n");
                return 1;
            }
            if (proc == 0)
            {
                //copilul
                        
                close (pfd[0]); //inchidem capatul de citire
                char username[1024], aux[1024], aux_number[1024], copie[1024]; //input-ul, username-ul, sir auxiliar ca sa caut daca exista utilizaotrul, numarul de cifre de utilizatori
                int ok_Euser, contor; //ok = 1 daca logarea a fost executata cu succes, utilizatorul este deja conectat, numarul de utilizatori
                memset(username, 0, 1024);
                strcpy(username, sir + 8); //username-ul utilizatorului
                ok_Euser = 0;
                
                //cand deschid, inchid fisierul, trebuie sa citesc numarul ca pozitia in fisier sa fie corecta
                int fd; //deschidem fisierul
                fd = open("utilizatori.txt", O_RDWR);
                FILE* fis;
                fis = fdopen(fd, "r+w");
                fgets(aux_number, 1024, fis);
                //printf("Numarul de utilizatori este %s", aux_number);
                           
                contor = atoi(aux_number);
                int lg = strlen(username);
                for(int i = 0; i < contor; i++)
                {
                    memset(aux, 0, 1024);
                    fgets(aux, 1024, fis);
                    int j = 0;
                    while (aux[j] == username[j]) j++;
                    if (j + 1 == lg) 
                    {
                        
                        lg = strlen(username);
                        if (aux[lg] == '0')
                        {
                            memset(raspuns, 0, 1024);
                            strcpy(raspuns, "A reusit sa se logheze ");
                            strcat(raspuns, username);
                            raspuns[strlen(raspuns)]='\0';
                            write(pfd[1], raspuns, strlen(raspuns));
                            fseek(fis, -2, SEEK_CUR);
                            fputc('1', fis);
                            fseek(fis, 0, SEEK_CUR);
                            ok_Euser = 1;
                            exit(0);
                        }
                        else
                        {
                            if (aux[lg] == '1')
                            {
                                memset(raspuns, 0, 1024);
                                strcpy(raspuns, "Este deja logat utilizatorul ");
                                strcat(raspuns, username);
                                raspuns[strlen(raspuns)]='\0';
                                write(pfd[1], raspuns, strlen(raspuns));
                                exit(0);
                            }
                        }           
                     }
                }
                close(fd);
                fclose(fis);
                if (ok_Euser == 0)
                {
                    memset(raspuns, 0, 1024);
                    strcpy(raspuns, "Username-ul pe care l-ati introdus nu exista! Incercati inca o data!\n");
                    raspuns[strlen(raspuns)]='\0';
                    write(pfd[1], raspuns, strlen(raspuns));
                    exit(0);    
                }        
            }
            close(pfd[1]);
            wait(NULL);
            memset(raspuns, 0, 1024);
            read(pfd[0], raspuns, sizeof(raspuns));
            raspuns[strlen(raspuns)]='\0';
            write(fd2, raspuns, strlen(raspuns));        
        }
        else if (strstr(sir, "quit\n") == sir)
        {
            memset(raspuns, 0, 1024);
            if (strlen(sir) > 5)
            {
                char username[1024], aux_number[1024], aux[1024];
                memset(aux_number, 0, 1024);
                int fd; //deschidem fisierul
                fd = open("utilizatori.txt", O_RDWR);
                FILE* fis;
                fis = fdopen(fd, "r+w");
                fgets(aux_number, 1024, fis);
                int contor;
                //printf("Numarul de utilizatori este %s", aux_number);
                contor = atoi(aux_number);
                
                memset(username, 0, 1024);
                strcpy(username, sir + 5);
                for(int i = 0; i < contor; i++)
                {
                    memset(aux, 0, 1024);
                    fgets(aux, 1024, fis);
                    int lg = strlen(username);
                    int j;
                    for(j = 0; j < lg && aux[j] == username[j]; j++);
                    if (j + 1 == lg) 
                    {
                        lg = strlen(username);
                        if (aux[lg] == '1')
                        {
                            fseek(fis, -2, SEEK_CUR);
                            fputc('0', fis);
                            fseek(fis, 0, SEEK_CUR);
                            break;
                        }
                    }
                    
                }
                close(fd);
                fclose(fis);
            }
            write(fd2, "quit\n\0", strlen("quit\n\0"));
            break;
            exit(0);
        }
        else if (strstr(sir, "logout\n") == sir)
        {
            char username[1024], aux_number[1024], aux[1024];
            memset(aux_number, 0, 1024);
            int fd; //deschidem fisierul
            fd = open("utilizatori.txt", O_RDWR);
            FILE* fis;
            fis = fdopen(fd, "r+w");
            fgets(aux_number, 1024, fis);
            int contor;
            //printf("Numarul de utilizatori este %s", aux_number);
            contor = atoi(aux_number);
                
            memset(username, 0, 1024);
            strcpy(username, sir + 7);
            for(int i = 0; i < contor; i++)
            {
                memset(aux, 0, 1024);
                fgets(aux, 1024, fis);
                int lg = strlen(username);
                int j;
                for(j = 0; j < lg && aux[j] == username[j]; j++);
                if (j + 1 == lg) 
                {
                    lg = strlen(username);
                    if (aux[lg] == '1') //este un enter la final
                    {
                        fseek(fis, -2, SEEK_CUR);
                        fputc('0', fis);
                        fseek(fis, 0, SEEK_CUR);
                        break;
                    }
                }
            }
            write(fd2, "Delogare reusita!\n\0", strlen("Delogare reusita!\n\0"));
            close(fd);
            fclose(fis);
        }
        else if (strstr(sir, "get-logged-users\n") == sir)
        {
            time_t rawtime;
            struct tm *timeInfo;
            socketpair(AF_UNIX, SOCK_STREAM, 0, sockets);
            proc = fork();
            if (proc == -1)
            {
                printf("Eroare la fork!\n");
                return 1;
            }
            if (proc == 0)
            {
                close(sockets[0]);
                char ajutor[1024];
                char username_get_logged[1024];
                char str[1024];

                memset(str, 0, 1024);
                memset(username_get_logged, 0, 1024);
                memset(ajutor, 0, 1024);

                struct utmp* data;
                setutent();
                data = getutent();
                
                while(data != NULL )
                {
                    strncpy(username_get_logged, data->ut_user, 32);
                    username_get_logged[32] = ' ';

                    strcpy(ajutor, "username: ");
                    strcat(ajutor, username_get_logged);
                    strcat(ajutor, "\n");

                    strcat(ajutor, "host: ");

                    memset(username_get_logged, 0, 1024);

                    strncpy(username_get_logged, data->ut_host, 4);
                    username_get_logged[4] = ' ';

                    strcat(ajutor, username_get_logged);

                    strcat(ajutor, "\n");

                    rawtime = data->ut_time;
                    time(&rawtime);
                   
                    timeInfo=localtime(&rawtime);
                    
                    strcat(ajutor, "time_entry: ");
                    
                    strcat(ajutor, asctime(timeInfo));
                    data = getutent();
                }
                ajutor[strlen(ajutor)]='\0';
                write(sockets[1], ajutor, strlen(ajutor));
                exit(0);
            }
            close(sockets[1]);
            wait(NULL);
            //printf("aici sunt!\n");
            memset(raspuns, 0, 1024);

            read(sockets[0], raspuns, sizeof(raspuns));
            raspuns[strlen(raspuns)]='\0';
            write(fd2, raspuns, strlen(raspuns));    
        }
        else if (strstr(sir, "get-proc-info : ") == sir)
        {
            socketpair(AF_UNIX, SOCK_STREAM, 0, sockets);
            proc = fork();
            if (proc == -1)
            {
                printf("Eroare la fork!\n");
                return 1;
            }
            if (proc == 0)
            {
                close(sockets[0]);
                FILE *fis;
                int lg;
                lg = strlen(sir);
                sir[lg - 1] = '\0';
                lg--;
                char aux[1024];
                memset(aux, 0, 1024);
                //get-proc-info : 
                strcpy(aux, sir + 16);
                //printf("%s\n", aux);
                
                char fisier[101];
                memset(fisier, 0, 101);
                strcpy(fisier, "/proc/");
                strcat(fisier, aux);
                strcat(fisier, "/status");
                
                int fd;
                char informatii[1024];
                memset(informatii, 0, 1024);
                
                FILE *fis1;
                //printf("%s\n", fisier);
            
                fis1 = fopen(fisier, "r");
                if (!fis1)
                {
                    write(sockets[1], "Nu exista pid-ul acesta!\n\0", strlen("Nu exista pid-ul acesta!\n\0"));
                    exit(0);
                }
                int contor = 1;
                memset(sir, 0, 1024);

                fgets(sir, 1024, fis1);
                strcpy(informatii, sir);
                while (fgets(sir, 1024, fis1))
                {
                    if (contor == 2 || contor == 6 || contor == 8 || contor == 17)
                        strcat(informatii, sir);
                    if (contor == 18)
                        break;
                    contor++;
                }
                //fclose(fis);
                //printf("%s", informatii);
                //name, state, ppid, uid, vmsize
                informatii[strlen(informatii)]='\0';
                write(sockets[1], informatii, strlen(informatii));
                exit(0);       
            }
            close(sockets[1]);
            wait(NULL);
            //printf("aici sunt!\n");
            memset(raspuns, 0, 1024);

            read(sockets[0], raspuns, sizeof(raspuns));
            raspuns[strlen(raspuns)]='\0'; 
            write(fd2, raspuns, strlen(raspuns));
        }
        else
        {
            memset(raspuns, 0, 1024);
            strcpy(raspuns, "Comanda necunoscuta!\n\0");
            write(fd2, raspuns, strlen(raspuns));
            
        }
        
    }
    return 0;
}