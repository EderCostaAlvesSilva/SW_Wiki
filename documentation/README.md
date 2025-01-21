
# Guia de Configuração e Execução do Ambiente Docker

Este documento fornece as etapas necessárias para configurar e executar os serviços Docker listados no arquivo `docker-compose.yml`. 

---

## Pré-requisitos

**Docker**: Certifique-se de que o Docker está instalado na máquina.
   - [Guia de instalação do Docker](https://docs.docker.com/get-docker/)
   
**Docker Compose**: Verifique se o Docker Compose está instalado.
   - [Guia de instalação do Docker Compose](https://docs.docker.com/compose/install/)

---

## Serviços no Docker Compose

O arquivo `docker-compose.yml` configura os seguintes serviços:

- **Memcached**: Serviço de cache baseado em memória.
- **Redis**: Serviço de armazenamento de dados em memória.
- **MySQL**: Banco de dados relacional.
- **Apache (Webserver)**: Servidor web configurado com PHP.
- **PHP-FPM**: Gerenciador de processos PHP.
- **Documentation**: Serviço para documentação da API.

---

## Configuração Inicial

### Estrutura de Diretórios

Certifique-se de que a estrutura do projeto esteja configurada como segue:

```
├── documentation/
│   ├── Dockerfile
│   ├── Insomnia_2025-01-20.json
├── phpdocker/
│   ├── apache/
│   │   ├── Dockerfile
│   │   ├── 000-default.conf
│   ├── php-fpm/
│       ├── Dockerfile
│       ├── php-ini-overrides.ini
├── docker-compose.yml
```

### Permissões

Certifique-se de que todos os arquivos e diretórios tenham permissões adequadas para serem acessados pelo Docker.

---

## Passos para Execução

1. **Construir os Contêineres**

   Navegue até o diretório raiz do projeto e execute:

   ```bash
   docker-compose build
   ```

2. **Iniciar os Contêineres**

   Após a construção, execute os serviços:

   ```bash
   docker-compose up -d
   ```

3. **Verificar os Logs**

   Monitore os logs dos contêineres para verificar se tudo foi iniciado corretamente:

   ```bash
   docker-compose logs -f
   ```

4. **Acessar os Serviços**

   - **Banco de Dados MySQL**: `localhost:3502`
   - **Webserver Apache**: `localhost:3500`
   - **Documentação da API**: `localhost:3000`

---

## Scripts de Inicialização no MySQL

Os scripts localizados no diretório `docker-entrypoint-initdb.d` são executados automaticamente ao iniciar o serviço MySQL. Certifique-se de que os arquivos `.sql` necessários estão neste diretório.

---

## Parar os Contêineres

Para parar os serviços, use:

```bash
docker-compose down
```

---

## Resolução de Problemas

### 1. Erro: "Arquivo não encontrado"

- Verifique se todos os arquivos mencionados no `docker-compose.yml` e nos `Dockerfiles` estão no lugar correto.
- Caso use o Windows, valide os caminhos para evitar problemas de case sensitivity.

### 2. Erro: Conexão recusada

- Certifique-se de que as portas configuradas nos serviços estão livres no host.

### 3. Debug nos Contêineres

Acesse um contêiner para depuração:

```bash
docker exec -it <nome_do_container> bash
```

---

## Notas Adicionais

- **Credenciais MySQL**: 
  - Usuário: `user.app`
  - Senha: `vGbeAuu465Xd`
  - Banco de dados padrão: `sw_movies`
  - **Nota:** Altere as credenciais no `docker-compose.yml` caso necessário.
  
- **Configuração do PHP-FPM**: 
  Certifique-se de que os arquivos de configuração PHP estão corretamente montados.

---

## Features do Projeto

- **Filtro de Pesquisa**: 
    Permite ao usuário buscar itens de forma rápida e eficiente na API consumida, com opções de filtro por critérios como nome, categoria ou outros atributos relevantes.

- **Login e Cadastro de Usuário**: 
    Sistema de autenticação e gerenciamento de usuários com registro de novos usuários, login seguro e suporte para autenticação via token. Inclui permissões para acesso às funcionalidades personalizadas.

- **Favoritar Itens da API Consumida**:
    Os usuários podem adicionar itens da API consumida à sua lista de favoritos, com suporte para gerenciamento (criação, visualização e exclusão) dos itens favoritados.

- **Histórico dos Itens Mais Visualizados**:
    Exibe os itens mais populares da API consumida, com base em um histórico de interações armazenado no banco de dados. Atualizado dinamicamente com cada nova visualização.

- **Comentários nos Itens da API Consumida**:
    Possibilita aos usuários adicionar e visualizar comentários em itens da API consumida. Inclui funcionalidades como organização dos comentários em threads e possibilidade de respostas.

- **Visualização de Conteúdo Diversificado da API**:
    Além de exibir os filmes da API consumida, o projeto também permite a visualização detalhada de outras categorias, como:
    - Pessoas (People)
    - Planetas (Planets)    
    - Espécies (Species)
    - Veículos (Vehicles)
    - Naves Estelares (Starships)
    - Cada item é exibido com informações completas extraídas da API.

- **Implementação do Docker**: 
    Uso do Docker para criar um ambiente de desenvolvimento completo, com serviços configurados para banco de dados (MySQL) e execução da aplicação web (PHP, Apache). Tudo pré-configurado e documentado para fácil execução.

---