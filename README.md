# Agilize Boilerplate

## 📋 Pré-requisitos
* Docker
* Docker-compose

## 🔩 Começando
Clone o repositório
```sh
git clone git@bitbucket.org:apimenti/agilize-backend-boilerplate.git
```
Copie o conteúdo de agilize-backend-boilerplate para o diretório do novo projeto. Abra o projeto na IDE de sua prefência e ajuste as configurações para o novo projeto. Os arquivos possuem marcações iniciadas com '<' e finalizadas com '>' para ajudar na localização do que deve ser ajustado em cada arquivo.

Lista dos arquivos que precisam ser ajustados:

* .env.example
* docker-compose.yaml
* Dockerfile
* Makefile

## 🔧 Instalação
Clone o projeto e entre em seu diretório

### Iniciando o container pela primeira vez
```sh
make build-and-serve
```

### Levante o container
```sh
make serve
```
Em outro terminal abra o diretório do projeto e execute

```sh
make db_update
```

## 🚀 Implantação


## ⚙️ Executando os testes
```sh
make all-unit-tests
```

## 🛠️ Construído com
Esse repo foi construído com as seguintes ferramentas:

* [AmazonLinux](https://hub.docker.com/_/amazonlinux/)
* [Laravel](https://laravel.com/)
* [PHP 8.0.20](https://hub.docker.com/_/php?tab=tags)
## ✒️ Autores

* **Thiago Oliveira** - *Trabalho Inicial*
* **Erivaldo Jr** - *Trabalho Inicial*
