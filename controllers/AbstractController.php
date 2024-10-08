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
            'cache' => false,
            'debug' => true,
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->twig = $twig;
    }

    protected function render(string $template, array $data): void
    {

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

    protected function isAjaxRequest(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
