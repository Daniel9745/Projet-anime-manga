<?php



class MediaManager extends AbstractManager
{
    public function uploadOne(Media $media)
    {
        $query = $this->db->prepare('INSERT INTO media (id, name, url, alt) VALUES (NULL, :name, :url, :alt)');
        $parameters = [
            "name" => $media->getName(),
            "url" => $media->getUrl(),
            "alt" => $media->getAlt()
        ];
        $query->execute($parameters);
        // $result = $query->fetch(PDO::FETCH_ASSOC);

        $media->setId($this->db->lastInsertId());
    }

    public function findOne(int $id): ?Media
    {
        $query = $this->db->prepare('SELECT * FROM media WHERE id=:id');

        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $media = new Media($result["name"], $result["url"], $result["alt"]);
            $media->setId($result["id"]);

            return $media;
        }
    }
}
