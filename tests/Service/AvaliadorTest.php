<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    public function testAvaliadorDeveEncontrarOMaiorValorDeLancesEmOrdemCrescente()
    {
        // Arrange - Given / Preparamos o cenário do teste
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        $leiloeiro = new Avaliador();

        // Act - When / Executamos o código a ser testado
        $leiloeiro->avalia($leilao);

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(2500, $leiloeiro->getMaiorValor());

    }

    public function testAvaliadorDeveEncontrarOMaiorValorDeLancesEmOrdemDecrescente()
    {
        // Arrange - Given / Preparamos o cenário do teste
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');

        $leilao->recebeLance(new Lance($joao, 2500));
        $leilao->recebeLance(new Lance($maria, 2000));

        $leiloeiro = new Avaliador();

        // Act - When / Executamos o código a ser testado
        $leiloeiro->avalia($leilao);

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(2500, $leiloeiro->getMaiorValor());

    }

    public function testAvaliadorDeveEncontrarOMaiorValorDeLancesEmOrdemAleatoria()
    {
        // Arrange - Given / Preparamos o cenário do teste
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');

        $leilao->recebeLance(new Lance($joao, 2500));
        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($maria, 3000));
        $leilao->recebeLance(new Lance($maria, 1000));

        $leiloeiro = new Avaliador();

        // Act - When / Executamos o código a ser testado
        $leiloeiro->avalia($leilao);

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(3000, $leiloeiro->getMaiorValor());

    }

    public function testAvaliadorDeveEncontrarOMenorValorDeLancesEmOrdemAleatoria()
    {
        // Arrange - Given / Preparamos o cenário do teste
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');

        $leilao->recebeLance(new Lance($joao, 2500));
        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($maria, 3000));
        $leilao->recebeLance(new Lance($maria, 1000));

        $leiloeiro = new Avaliador();

        // Act - When / Executamos o código a ser testado
        $leiloeiro->avalia($leilao);

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(1000, $leiloeiro->getMenorValor());

    }

    public function testAvaliadorDeveRetornarOsTresMaioresValores()
    {
        // Arrange - Given / Preparamos o cenário do teste
        $leilao = new Leilao('Fiat 147 0km');
        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $luiz = new Usuario('Luiz');
        $jose = new Usuario('Jose');

        $leilao->recebeLance(new Lance($joao, 2500));
        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($luiz, 3000));
        $leilao->recebeLance(new Lance($jose, 1000));

        $avaliador = new Avaliador();

        $avaliador->avalia($leilao);

        $maiores = $avaliador->getMaioresLances();
        self::assertCount(3, $maiores);
        self::assertEquals(3000, $maiores[0]->getValor());
        self::assertEquals(2500, $maiores[1]->getValor());
        self::assertEquals(2000, $maiores[2]->getValor());


    }
}