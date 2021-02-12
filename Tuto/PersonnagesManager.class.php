<?php

class PersonnagesManager
{
    private $db;

    /**
     * PersonnagesManager constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->setDb($db);
    }

    /**
     * @param Personnage $perso
     */
    public function add(Personnage $perso)
    {
        $query = 'INSERT INTO personnages(nom, forcePerso, degats, niveau, experience) VALUES ' .
            '(:nom, :forcePerso, :degats, :niveau, :experience)';
        $q = $this->db->prepare($query);
        $q->bindValue(':nom', $perso->nom(), PDO::PARAM_STR);
        $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
        $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
        $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
        $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);

        try {
            $q->execute();
        } catch (PDOException $e) {
            die('Erreur : boulette ' . $e->getMessage());
        }
    }

    /**
     * @param Personnage $perso
     */
    public function delete(Personnage $perso)
    {
        $this->db->exec('DELETE FROM personnages WHERE id = ' . $perso->id());
    }

    /**
     * @param $id
     * @return Personnage
     */
    public function get($id)
    {
        $id = (int)$id;
        $q = $this->db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnages WHERE id = ' . $id);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Personnage($donnees);
    }

    /**
     * @return array
     */
    public function getList()
    {
        $persos = [];
        $q = $this->db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnages ORDER BY nom');
        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $persos[] = new Personnage($donnees);
        }
        return $persos;
    }

    /**
     * @param Personnage $perso
     */
    public function update(Personnage $perso)
    {
        $query = 'UPDATE personnages SET forcePerso = :forcePerso, degats = :degats, niveau = :niveau, ' .
            'experience = :experience WHERE id = :id';
        $q = $this->db->prepare($query);
        $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
        $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
        $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
        $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);
        $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);

        $q->execute();
    }

    /**
     * @param PDO $db
     */
    public function setDb(PDO $db)
    {
        $this->db = $db;
    }
}
