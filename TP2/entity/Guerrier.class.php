<?php

class Guerrier extends Personnage
{
    /**
     * @return bool
     */
    public function esquive()
    {
        if ($this->estEndormi()) {
            return false;
        }
        $esquive = rand(0, 50) + $this->atout;
        if ($esquive > self::ESQUIVE_REUSSI) {
            if ($this->atout > 0) {
                $this->atout -= 1;
            }
            return true;
        }
    }

    /**
     * @param $degats
     * @return int
     */
    public function recevoirDegats($degats)
    {
        if ($this->esquive()) {
            return self::ESQUIVE_REUSSI;
        } else {
            return parent::recevoirDegats($degats);
        }
    }
}
