# ALURA: PHP e PDO - trabalhando com banco de dados

#### Aula-01:

* Que o PDO é uma abstração para acesso a diversos bancos de dados
* Que, para acessar cada um dos bancos, um *driver* específico é necessário
* Que os *drivers* são habilitados através da instalação de extensões no PHP
* Que **SQLite** é um gerenciador de banco de dados que não precisa de um servidor
* A criar a nossa primeira conexão com um banco de dados

#### Aula-02:

* A executar queries sem precisar conferir os seus resultados, como queries de INSERT, utilizando o método exec
* Que o método exec retorna apenas o número de linhas afetadas, e não o resultado de uma query em si
* A buscar dados no banco, utilizando o método query
* Os diversos métodos para recuperar dados utilizando o PDO:
  * fetch
  * fetchObject
  * fetchColumn
  * fetchAll
* Os diferentes Fetch Modes do PHP, ou seja, as diferentes formas de trazer dados do banco para o PHP

Ao tentar buscar dados do banco de dados, você pode informar como quer que os métodos do `PDO` formatem esses dados pra você. Os principais *fetch modes* ou *fetch styles* são:

* `PDO::FETCH_ASSOC`: Retorna cada linha como um *array* associativo, onde a chave é o nome da coluna, e o valor é o valor da coluna em si
* `PDO::FETCH_BOTH` (esse é o padrão): Retorna cada linha como um *array* com as chaves sendo tanto o índice da coluna (começando do 0) quanto o nome da coluna, ou seja, os valores acabam ficando duplicados nesse formato
* `PDO::FETCH_CLASS`: Cada linha do resultado é retornado como uma instância da classe especificada em outro parâmetro. A classe não pode ter parâmetros no construtor e cada coluna terá o seu valor atribuído a uma propriedade de mesmo nome no objeto criado
* `PDO::FETCH_INTO`: Funciona de forma muito semelhante ao `FETCH_CLASS`, mas ao invés de criar o objeto para você, ele preenche um objeto já criado com os valores buscados
* `PDO::FETCH_NUM`: Retorna cada linha como um  *array* , onde a chave é o índice numérico da coluna, começando do 0, e o valor é o valor da coluna em si

Para ver os demais modos de busca e ler com mais detalhes os explicados aqui, você pode conferir a documentação oficial do PHP: [**PDOStatement::fetch**](https://www.php.net/manual/en/pdostatement.fetch#refsect1-pdostatement.fetch-parameters).
