<?php

class AuthController extends AbstractController
{
    private UserManager $um;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
    }

    public function register(): void
    {
        $this->render('front/register.html.twig', []);
    }

    public function checkRegister(): void
    {
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }
        // vérifier que tous les champs du formulaire sont là
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['csrf_token'])) {

            $tm = new CSRFTokenManager();

            if ($tm->validateCSRFToken($_POST['csrf_token'])) {

                $user = $this->um->findUserByEmail($_POST['email']);

                if ($user === null) {
                    if ($_POST['password'] === $_POST['confirm_password']) {
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $user = new User($_POST['username'], $_POST['email'], $password, "USER");

                        try {
                            $this->um->createUser($user);
                            $_SESSION['success_message'] = "Votre compte a bien été créé";
                            $this->redirect('connexion');
                        } catch (\Exception $e) {
                            $_SESSION['error_message'] = $e->getMessage();
                            $this->redirect('inscription');
                        }
                    } else {
                        $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                        $this->redirect('inscription');
                    }
                } else {
                    $_SESSION['error_message'] = "Un compte existe déjà avec cette adresse.";
                    $this->redirect('inscription');
                }
            } else {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('inscription');
            }
        } else {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect('inscription');
        }
    }

    public function login(): void
    {
        $this->render('front/login.html.twig', []);
    }

    public function checkLogin(): void
    {
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }

        if (isset($_SESSION['success_message'])) {
            unset($_SESSION['success_message']);
        }

        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csrf_token'])) {

            $tm = new CSRFTokenManager();

            if ($tm->validateCSRFToken($_POST['csrf_token'])) {

                $user = $this->um->findUserByEmail($_POST['email']);

                if ($user !== null) {
                    if (password_verify($_POST['password'], $user->getPassword())) {
                        
                        $_SESSION['user'] = $user;
                        // $this->redirect(null);
                       
                        $userRole = $_SESSION["user"]->getRole();

                        if ($userRole === "ADMIN") {
                            $this->redirect("admin");
                        } else {
                            $this->redirect(null);
                        }
                    } else {
                        $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                        $this->redirect('connexion');
                    }
                } else {
                    $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect.";
                    $this->redirect('connexion');
                }
            } else {
                $_SESSION['error_message'] = "Le jeton CSRF est invalide.";
                $this->redirect('connexion');
            }
        } else {
            $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
            $this->redirect('connexion');
        }
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect(null);
    }
}
