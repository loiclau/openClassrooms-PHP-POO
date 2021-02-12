<?php

class Personnage
{
    private $id, $degats, $nom, $exp, $lvl, $force;

    const CEST_MOI = 1;
    const PERSONNAGE_TUE = 2;
    const PERSONNAGE_FRAPPE = 3;

    const EXP_FRAPPE = 10;
    const EXP_TUE = 50;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    /**
     * @param array $donnees
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @param Personnage $perso
     * @return int
     */
    public function frapper(Personnage $perso)
    {
        if ($perso->getId() == $this->id) {
            return self::CEST_MOI;
        }

        // On indique au personnage qu'il doit recevoir des dégâts.
        // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
        $totalDegats = 5 + $this->getForce();
        if ($perso->recevoirDegats($totalDegats) == self::PERSONNAGE_TUE) {
            if ($perso->getLvl() == 0) {
                $exp = self::EXP_TUE;
            } else {
                $exp = self::EXP_TUE * $perso->getLvl();
            }
            $result = self::PERSONNAGE_TUE;
        } else {
            $exp = self::EXP_FRAPPE;
            $result = self::PERSONNAGE_FRAPPE;
        }
        $this->setExp($exp);
        return $result;
    }

    /**
     * @return int
     */
    public function recevoirDegats($degats)
    {
        $this->degats += $degats;
        // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
        if ($this->degats >= 100) {
            return self::PERSONNAGE_TUE;
        }
        // Sinon, on se contente de dire que le personnage a bien été frappé.
        return self::PERSONNAGE_FRAPPE;
    }

    /**
     * @return int
     */
    public function lvlUp()
    {
        $this->lvl += 1;
        $this->force += 1;
    }

    /**
     * @return bool
     */
    public function nomValide()
    {
        return !empty($this->nom);
    }

    /**
     * @return mixed
     */
    public function getDegats(): int
    {
        return (int)$this->degats;
    }

    /**
     * @param $degats
     */
    public function setDegats($degats)
    {
        $degats = (int)$degats;

        if ($degats >= 0 && $degats <= 100) {
            $this->degats = $degats;
        }
    }

    /**
     * @return mixed
     */
    public function getForce(): int
    {
        return (int)$this->force;
    }

    /**
     * @param $force
     */
    public function setForce($force)
    {
        $force = (int)$force;

        if ($force >= 0 && $force <= 100) {
            $this->force = $force;
        }
    }

    /**
     * @return mixed
     */
    public function getExp(): int
    {
        return (int)$this->exp;
    }

    /**
     * @param $exp
     */
    public function setExp($exp)
    {
        $exp = (int)$exp + (int)$this->exp;
        if ($exp >= 0 && $exp < 100) {
            $this->exp = $exp;
        } else {
            $this->exp = $exp - 100;
            $this->lvlUp();
        }
    }

    /**
     * @return mixed
     */
    public function getLvl(): int
    {
        return (int)$this->lvl;
    }

    /**
     * @param $lvl
     */
    public function setLvl($lvl)
    {
        $lvl = (int)$lvl;
        if ($lvl >= 0 && $lvl <= 100) {
            $this->lvl = $lvl;
        }
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return (int)$this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $id = (int)$id;

        if ($id > 0) {
            $this->id = $id;
        }
    }

    /**
     * @return mixed
     */
    public function getNom(): string
    {
        return (string)$this->nom;
    }

    /**
     * @param $nom
     */
    public function setNom($nom)
    {
        if (is_string($nom)) {
            $this->nom = $nom;
        }
    }
}
