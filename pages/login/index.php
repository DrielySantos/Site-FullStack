<?php

if (isset($_COOKIE[$c['ucookie']]))

    header('Location: /?profile');

$page_title = "Login / Entrar";

$logged = false;
$error = $form_error = $feedback = '';
$email = 'costa@santos.com';
$password = 'Senha123';

if (isset($_POST['send'])) :

   
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $error .= '<li> E-mail inválido.</li>';

    $password = htmlspecialchars(trim($_POST['password']));

    if (!preg_match("/{$rgpass}/", $password))
        $error .= '<li>Senha inválida.</li>';

    if (isset($_POST['logged']))
        $logged = true;

    if ($error != '') :

        $form_error = <<<HTML
<div class="form-error">
    <h3>Deu ruim!</h3>
    <p>Ocorreram erros na tentativa de login:</p>
    <ul>{$error}</ul>
    <p>Por favor, verifique e tente novamente...</p>
</div>
 
HTML;

    else :

        $sql = <<<SQL
SELECT * FROM users
WHERE email = '{$email}'
    AND password = SHA1('{$password}')
    AND ustatus = 'online'
SQL;

        $res = $conn->query($sql);

        if ($res->num_rows != 1) :

            $form_error = <<<HTML
<div class="form-error">
    <h3>Deu ruim!</h3>
    <p>Ocorreram erros na tentativa de login:</p>
    <ul>
        <li>Usuário e/ou senha incorretos.</li>
    </ul>
    <p>Por favor, verifique e tente novamente...</p>
</div>
 
HTML;

        else :

            $user = $res->fetch_assoc();

            unset($user['password']);

            $sql = "UPDATE users SET last_login = NOW() WHERE uid = '{$user['uid']}'";
            $conn->query($sql);

            if ($logged)

                $cookie_expires = time() + (86400 * $c['ucookiedays']);

            else

                $cookie_expires = 0;

            setcookie($c['ucookie'], json_encode($user), $cookie_expires, '/');

            $first_name = explode(' ', $user['name'])[0];

            $feedback = <<<HTML
<div class="feedback">
    <h3>Olá {$first_name}!</h3>
    <p>Você já pode acessar nosso conteúdo restrito.</p>
    <p><em>Obrigado...</em></p>
</div>
HTML;

        endif;

    endif;

endif;

//  Formulário de login:
$form_login = <<<HTML
<form method="post" action="/?login" id="formLogin">
    <input type="hidden" name="send" value="true">
    <p>Logue-se para ter acesso aos conteúdos restritos:</p>
    <p>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="{$email}" required>
    </p>
    <p>
        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" autocomplete="off" value="{$password}" required pattern="{$rgpass}">
    </p>
    <p class="logged">
        <input type="checkbox" name="logged" id="logged" value="on">
        <label for="logged">Mantenha-me logado.</label>
    </p>
    <p>
        <button type="submit">Entrar</button>
    </p>
    <hr>
    <p class="loginlinks">
        <a href="/?signup">Cadastre-se</a>
        <a href="/?sendpass">Esqueci a senha</a>
    </p>
</form>
HTML;

// Definir o conteúdo desta página:
$page_content = <<<HTML
<article>
    <h2>Login / Entrar</h2>
    {$form_error}
HTML;

// Se o usuário logou com sucesso...
if ($feedback != '')

    // Exibe feecback no HTML:
    $page_content .= $feedback;

// Se não logou ainda...
else

    // Exibe o formulário de login:
    $page_content .= $form_login;

$page_content .= <<<HTML
</article>
HTML;