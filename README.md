# Personagens

Banco de dados utilizado MySQL
Para a conexão com o banco de dados foi utilizado a seguinte configuração:
DATABASE_URL="mysql://personagens:starwars@127.0.0.1:3306/personagens?serverVersion=mariadb-10.4.11"

O banco de dados e tabela necessária foram criados utilizando o doctrine.
Os comandos SQL para criação da tabela se encontram na pasta migrations (Caso queira rodar manualmente).

Para rodar a solução baixe os arquivos utilizando o comando git clone.

Dentro da pasta projeto execute o comando php ../composer.phar install. 
Apos tudo instalado, crie o banco de dados com o comando php bin/console doctrine:database:create 
e depois php bin/console doctrine:migrations:migrate para criar a tabela .

Excute o comando yarn install.
E depois execute yarn encore production 


Agora para rodar, va na pasta public e execute o comando php -S 127.0.0.1:8000 .
Após rodar o comando acima acesse o endereço http://127.0.0.1:8000 no navegador.



