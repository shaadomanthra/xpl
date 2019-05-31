#include <stdio.h>
#include <stdlib.h>	//to use system()
#include <string.h> //to use strcpy()

int main()
{
	char *command;
	
	//executing ls command
	strcpy(command, "ls");
	printf("ls command...\n");
	system(command);
	
	printf("\n\n");
	
	//executing date command 
	strcpy(command, "gcc c.c -o 2");
	printf("GCC command...\n");
	system(command);
	
	return 0;
}