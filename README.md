# Aplicação TODO (API)

Aplicação simples para gerenciar tarefas.

### Instruções de instalação

Clone este repositório:  
**`git clone git@github.com:diico/agenciabein-todo.git`**

Em seguida, acesse o diretório do projeto:  
**`cd agenciabein-todo`**  

Faça o build da imagem:  
**`docker-compose build`**  

Inicie os serviços:  
**`docker-compose up -d`**  

Instale as dependências do projeto:  
**`docker exec agenciabein-todo composer install`**  

Copie e renomeie o arquivo de configuração:  
**`.env.example para .env`**  

### Documentação  

Acesse a documentação da API que estará disponível no endereço:  
http://localhost:3000/doc  


#### Tecnologias utilizadas  

* Docker  
* PHP 7.2  
* Restler (http://restler3.luracast.com/)  
* RedBeanPHP (https://redbeanphp.com/)  


