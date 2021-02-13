<?php

class PersonnagesManager
{
    private $db; // Instance de PDO

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
        $q = $this->db->prepare('INSERT INTO personnagestp2(nom, type) VALUES(:nom, :type)');
        $q->bindValue(':nom', $perso->getNom());
        $q->bindValue(':type', $perso->getType());
        $q->execute();

        $perso->hydrate([
            'id' => $this->db->lastInsertId(),
            'degats' => 0,
            'lvl' => 0,
            'exp' => 0,
            'force' => 0,
            'atout' => 0
        ]);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM personnagestp2')->fetchColumn();
    }

    /**
     * @param Personnage $perso
     */
    public function delete(Personnage $perso)
    {
        $this->db->exec('DELETE FROM personnagestp2 WHERE id = ' . $perso->getId());
    }

    /**
     * @param $info
     * @return bool
     */
    public function exists($info)
    {
        if (is_int($info)) // On veut voir si tel personnage ayant pour id $info existe.
        {
            $query = 'SELECT COUNT(*) FROM `personnagestp2` WHERE `id` = ' . $info;
            return (bool)$this->db->query($query)->fetchColumn();
        }

        // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
        $q = $this->db->prepare('SELECT COUNT(*) FROM `personnagestp2` WHERE `nom` = :nom');
        $q->execute([':nom' => $info]);

        return (bool)$q->fetchColumn();
    }

    /**
     * @param $info
     * @return Personnage
     */
    public function get($info)
    {
        if (is_int($info)) {
            $query = 'SELECT `id`, `nom`, `degats`, `lvl`, `exp`, `force`, `type`, `timeEndormi`, `atout` ' .
                'FROM `personnagestp2` WHERE `id` = ' . $info;
            $q = $this->db->query($query);
        } else {
            $query = 'SELECT `id`, `nom`, `degats`, `lvl`, `exp`, `force`, `type`, `timeEndormi`, `atout` ' .
                'FROM `personnagestp2` WHERE `nom` = :nom';
            $q = $this->db->prepare($query);
            $q->execute([':nom' => $info]);
        }

        $perso = $q->fetch(PDO::FETCH_ASSOC);
        $class = ucfirst($perso['type']);
        return new $class($perso);
    }

    /**
     * @param $nom
     * @return array
     */
    public function getList($nom = '')
    {
        $persos = [];
        $query = 'SELECT `id`, `nom`, `degats`, `lvl`, `exp`, `force`, `type`, `timeEndormi`, `atout` ' .
            'FROM `personnagestp2` WHERE `nom` <> :nom ORDER BY `nom`';
        $q = $this->db->prepare($query);
        $q->execute([':nom' => $nom]);

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $class = ucfirst($donnees['type']);
            $persos[] = new $class($donnees);
        }

        return $persos;
    }

    /**
     * @param Personnage $perso
     */
    public function update(Personnage $perso)
    {

        $query = 'UPDATE `personnagestp2` SET `degats` = :degats, `lvl` = :lvl, `exp` = :exp, `force` = :force, ' .
            '`timeEndormi` = :timeEndormi, `atout` = :atout WHERE `id` = :id';
        $q = $this->db->prepare($query);

        $q->bindValue(':degats', $perso->getDegats(), PDO::PARAM_INT);
        $q->bindValue(':lvl', $perso->getLvl(), PDO::PARAM_INT);
        $q->bindValue(':exp', $perso->getExp(), PDO::PARAM_INT);
        $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
        $q->bindValue(':force', $perso->getForce(), PDO::PARAM_INT);
        $q->bindValue(':timeEndormi', $perso->getTimeEndormi(), PDO::PARAM_INT);
        $q->bindValue(':atout', $perso->getAtout(), PDO::PARAM_INT);

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
