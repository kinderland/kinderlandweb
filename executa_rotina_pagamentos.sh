#!/bin/bash

echo "Iniciando execucao da rotina de atualizacao dos pagamentos Cielo"

php /var/www/html/kinderlandweb/index.php payments/rotinaPagamentos

echo "Execucao finalizada"
