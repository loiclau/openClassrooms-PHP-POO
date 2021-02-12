<?php

class Personnage

{
    private $forcePerso;
    private $localisation;
    private $experience;
    private $degats;

    const FORCE_PETITE = 20;
    const FORCE_MOYENNE = 50;
    const FORCE_GRANDE = 80;

    private static $texteADire = 'Je vais tous vous tuer !';
    private static $compteur = 0;


    /**
     * Personnage constructor.
     * @param $donnees
     */
    public function __construct($donnees) // Constructeur demandant 2 paramètres
    {
        $this->hydrate($donnees);
        self::$compteur++;
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

    public static function combatants()
    {
        echo 'nb combattant :' . self::$compteur . '<br>';
    }


//Action

    public static function parler()
    {
        echo self::$texteADire;
    }

    public function afficherExperience()
    {
        echo 'j ai ' . $this->experience . ' exp  <br>';
    }

    public function deplacer() // Une méthode qui déplacera le personnage (modifiera sa localisation).
    {

    }

    public function frapper(Personnage $persoAFrapper)
    {
        $persoAFrapper->degats += $this->forcePerso;
    }

    public function gagnerExperience() // Une méthode augmentant l'attribut $experience du personnage.
    {
        $this->experience++;
        $this->afficherExperience();
    }


// Accesseur

    /**
     * @return int
     */
    public function id()
    {
        return (int)$this->id;
    }

    /**
     * @return mixed
     */
    public function nom()
    {
        return $this->nom;
    }

    /**
     * @return int
     */
    public function forcePerso()
    {
        return (int)$this->forcePerso;
    }

    /**
     * @return int
     */
    public function degats()
    {
        return (int)$this->degats;
    }

    /**
     * @return int
     */
    public function niveau()
    {
        return (int)$this->niveau;
    }

    /**
     * @return int
     */
    public function experience()
    {
        return (int)$this->experience;
    }


// Mutateur

    /**
     * @param $id
     */
    public function setId($id)
    {
        // On convertit l'argument en nombre entier.
        // Si c'en était déjà un, rien ne changera.
        // Sinon, la conversion donnera le nombre 0 (à quelques exceptions près, mais rien d'important ici).
        $id = (int)$id;
        // On vérifie ensuite si ce nombre est bien strictement positif.
        if ($id > 0) {
            // Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
            $this->id = $id;
        }
    }

    /**
     * @param $nom
     */
    public function setNom($nom)
    {
        // On vérifie qu'il s'agit bien d'une chaîne de caractères.
        if (is_string($nom)) {
            $this->nom = $nom;
        }
    }

    /**
     * @param $forcePerso
     */
    public function setForcePerso($forcePerso)
    {
        $forcePerso = (int)$forcePerso;
        if ($forcePerso >= 1 && $forcePerso <= 100) {
            $this->forcePerso = $forcePerso;
        }
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
     * @param $niveau
     */
    public function setNiveau($niveau)
    {
        $niveau = (int)$niveau;
        if ($niveau >= 1 && $niveau <= 100) {
            $this->niveau = $niveau;
        }
    }

    /**
     * @param $experience
     */
    public function setExperience($experience)
    {
        $experience = (int)$experience;
        if ($experience >= 1 && $experience <= 100) {
            $this->experience = $experience;
        }
    }
}
