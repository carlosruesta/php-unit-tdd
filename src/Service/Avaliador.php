<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;

class Avaliador
{
    private float $maiorLance = -INF;
    private float $menorLance = -(-INF);
    private array $maioresLances;

    public function avalia(Leilao $leilao): void
    {
        foreach ($leilao->getLances() as $lance) {
            if ($lance->getValor() > $this->maiorLance) {
                $this->maiorLance = $lance->getValor();
            }
            if ($lance->getValor() < $this->menorLance) {
                $this->menorLance = $lance->getValor();
            }
        }

        $lances = $leilao->getLances();
        usort($lances, function (Lance $lance1, Lance $lance2) {
            return $lance2->getValor() - $lance1->getValor();
        });

        $this->maioresLances = array_slice($lances, 0, 3);

    }

    public function getMaiorValor(): float
    {
        return $this->maiorLance;
    }

    public function getMenorValor(): float
    {
        return $this->menorLance;
    }

    public function getMaioresLances(): array
    {
        return $this->maioresLances;
    }
}