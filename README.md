# docker
Docker environment for projects

# .env
Create a .env file (or cp .env.dist .env) and make sure the ports do not conflict with any other running projects

# customisations
Create docker-compose.override.yml ad put any additional volumes etc in there

# running
Use 'docker-compose up' NOT 'docker compose up'! The latter will *not* read the override yaml file