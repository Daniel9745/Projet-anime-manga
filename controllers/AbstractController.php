<?php

abstract class AbstractController
{
    private CSRFTokenManager $tm;
    private \Twig\Environment $twig;
    public function __construct()
    {
        $this->tm = new CSRFTokenManager();
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader, [
            'debug' => true,
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->twig = $twig;
    }

    protected function render(string $template, array $data): void
    {

        // var_dump("Rendering template: " . $template);

        // Vérifie si l'utilisateur est connecté
        $isUserLoggedIn = isset($_SESSION['user']);
        $data['isUserLoggedIn'] = $isUserLoggedIn;

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = $this->tm->generateCSRFToken();
        }
        $data['csrf_token'] = $_SESSION['csrf_token'];
        echo $this->twig->render($template, $data);
    }

    protected function redirect(?string $route): void
    {
        if ($route !== null) {
            header("Location: index.php?route=$route");
        } else {
            header("Location: index.php");
        }
    }
}
