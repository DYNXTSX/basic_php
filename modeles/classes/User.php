<?php
class User
{
    protected $id_user;
    protected $nom;
    protected $prenom;
    protected $email;

    public function __construct(int $id_user, string $nom, string $prenom, string $email) {
        $this->id_user=$id_user;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
    }

    public function getEmail(): string {
        return ($this->email);
    }

    public function getNomComplet(): string {
        $nc = $this->prenom." ".$this->nom;
        return ($nc);
    }

    public function getIdUser(): int
    {
        return $this->id_user;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }
}