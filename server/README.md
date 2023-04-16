# Getting started
This project was built upon https://github.com/codenip-tech/symfony-base-repository .
Take the following steps to start from scratch:
1. Clone this repository;
2. You will notice this repository only contains a folder called docker. Run "Make build". 
Run "make ssh-start".
3. Run "make ssh-be".
4. Run "composer create-project symfony/skeleton project".
5. Run "exit".
6. You will notice a folder called "project" was created. 
Move the content of this folder "project" into the root of the current dir where you are now.
7. Overwrite all files and dirs.
8. Remove the "project" folder since it is unnecessary anymore.

We have reached the goal of this first stage.

Finally, follow https://www.youtube.com/watch?v=0knSjelOatE&list=PLWpsZlKx38t_GJg_Xc5Lwd-AMPenMH8Yt
 
# Modular Monolith Example

## Content
- PHP container running version 8.1.1
- MySQL container running version 8.0.26

## Instructions
- `make build` to build the containers
- `make start` to start the containers
- `make stop` to stop the containers
- `make restart` to restart the containers
- `make prepare` to install dependencies with composer (once the project has been created)
- `make run` to start a web server listening on port 1000 (8000 in the container)
- `make logs` to see application logs
- `make ssh-be` to SSH into the application container