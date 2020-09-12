<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

// cria o cenário - Arrange - Given
$leilao = new Leilao('Fiat 147 0km');

$maria = new Usuario('Maria');
$joao = new Usuario('João');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

// executa o teste - Act - When
$leiloero1 = new Avaliador();
$leiloero1->avalia($leilao);

// verifica o resultado esperado - Assert - Then
$maiorValor = $leiloero1->getMaiorValor();
// Assert - Then
$valorEsperado = 2500;

if ($valorEsperado == $maiorValor) {
    echo "TESTE OK";
} else {
    echo "TESTE FALHOU";
}

$maria = new Usuario('Maria');
$joao = new Usuario('João');
$leilao = new Leilao('Sentra');
$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($joao, 1000));
$leilao->recebeLance(new Lance($joao, 2300));
$leilao->recebeLance(new Lance($maria, 2700));
$leilao->recebeLance(new Lance($joao, 2100));
$leilao->recebeLance(new Lance($maria, 1500));
$leilao->recebeLance(new Lance($joao, 3000));

//var_dump($leilao->getLances());
$leiloero2 = new Avaliador();
$leiloero2->avalia($leilao);
var_dump($leiloero2->getMaioresLances());
var_dump($leilao->getLances());