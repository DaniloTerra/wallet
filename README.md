# Wallet

POC de uma carteira virtual feita em PHP e utilizando alguns conceitos de DDD

# Para rodar os tests e ferramentas de análise de código:
```
make pre-push
```

Ou para executar de forma individual:
```
make php-stan
make php-cpd
make test-unit-coverage
make test-unit-mutation
```


# Para iniciar a API:
```
make dependencies-install
make api-up
```

Após executar esses comandos a API irá ficar disponível na em `http://localhost/`

# Para executar o comando de transferência entre contas:
```
curl -i -X POST "http://localhost/transaction" -H 'Content-Type: application/json' -d '{"value" : 500.00, "payer" : 1, "payee" : 2}'
```

O código HTTP 204 irá indicar sucesso para o comando. O código 400 irá indicar que a transferência entre contas não foi possível por falta de saldo do pagador ou quando a autorização não é feita. O código 500 irá ser retornado caso algum erro inesperado aconteça, como um problema de banco de dados.
