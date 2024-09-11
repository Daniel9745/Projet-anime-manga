<?php

class UserManager extends AbstractManager
{
    public function __construct()
    {
        // J'appelle le constructeur de l'AbstractManager pour qu'il initialise la connexion à la DB
        parent::__construct();
    }

    public function createUser(User $user): User
    {
        $query = $this->db->prepare('INSERT INTO users (id,username, email, password, role) VALUES (NULL, :username,:email, :password, :role)');
        $parameters = [
            "username" =>$user->getUsername(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "role" => $user->getRole()
        ];
        $query->execute($parameters);
        $user->setId($this->db->lastInsertId());

        return $user;
    }

    public function findUserByEmail(string $email): ?User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $parameters = ["email" => $email];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $users = null;

        if ($user) {
            $users = new User($user["username"], $user["email"], $user["password"], $user["role"]);
            $users->setId($user['id']);
        }
        return $users;
    }

    public function findAllUsers(): array
    {
        $users = [];
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            $user = new User($item["username"], $item["email"], $item["password"], $item["role"]);
            $user->setId($item["id"]);
            $users[] = $user;
        }
        return $users;
    }

    public function findUserById(int $id): ?User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id=:id');
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User($result["username"], $result["email"], $result["password"], $result["role"]);
            $user->setId($result["id"]);
            return $user;
        }
        return null;
    }

    public function updateUser(User $user): User
    {
        $query = $this->db->prepare('UPDATE users SET email = :email, password = :password, role = :role WHERE id = :id');
        $parameters = [
            "id" => $user->getId(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "role" => $user->getRole()
        ];
        $query->execute($parameters);

        return $user;
    }

    public function deleteUser(int $id): void
    {
        $query = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $parameters = ["id" => $id];
        $query->execute($parameters);
    }
}
