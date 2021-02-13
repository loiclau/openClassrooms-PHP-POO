<?php

class Magicien extends Personnage
{
    /**
     * @param Personnage $perso
     * @return int
     */
    public function ensorceler(Personnage $perso)
    {
        if ($perso->id == $this->id) {
            return self::CEST_MOI;
        }

        if (0 == $this->atout) {
            return self::PAS_DE_MAGIE;
        }

        if ($this->estEndormi()) {
            return self::PERSO_ENDORMI;
        }

        $perso->timeEndormi = time() * ($this->atout * 6) * 3600;
        $this->atout -= 1;

        return self::PERSONNAGE_ENSORCELE;
    }
}
