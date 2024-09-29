# Documentação para Execução do Sistema

## Pré-requisitos

- **Docker**: Certifique-se de que o Docker esteja instalado em sua máquina. Você pode baixar e instalar o Docker através do [site oficial do Docker](https://www.docker.com/products/docker-desktop).

## Execução do Sistema

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/albertoaguiar/feegow.git
   cd feegow
   ```

2. **Construa e inicie os containers**:
   ```bash
   docker-compose up --build -d
   ```
   
3. **Execute as migrations**:
   ```bash
   docker-compose exec application php artisan migrate
   ```
   
4. **Execute as filas**:
- Para garantir que as filas sejam processadas e seja possível gerar o csv de funcionários não vacinados, é necessário executar o comando abaixo:
  ```bash
  docker-compose exec application php artisan queue:work
  ```

5. **Acesse o aplicativo**:
- Abra um navegador e acesse http://localhost (ou a porta especificada no seu docker-compose.yml).


## Relatórios
Para realizar a extração do relatório de não vacinados com nome e CPF é necessário realizar o dispatch acessando o link **http://localhost/reports/unvaccinated**
Quando bem sucedido, o arquivo se encontrará em **storage/app/reports**.

## Informações adicionais
- Para entender como utilizar o sistema [clique aqui](https://github.com/albertoaguiar/feegow/blob/main/documento_utilizacao_feegow.pdf).
- Para entender a estrutura de banco de dados (tabelas e colunas) [clique aqui](https://github.com/albertoaguiar/feegow/blob/main/database_model.pdf).
