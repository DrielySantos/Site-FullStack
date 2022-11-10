<?php

$error = $form_error = $feedback = $form_html = '';

$name = $email = $subject = $message = '';

if (isset($_POST['send'])) :

  $name = htmlspecialchars(trim($_POST['name']));

  if (strlen($name) < 3)
    $error .= '<li>Nome inválido.</li>';

  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);


  if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $error .= '<li>E-mail inválido.</li>';

  $subject = htmlspecialchars(trim($_POST['subject']));

  if (strlen($subject) < 5)
    $error .= '<li>O assunto está muito curto.</li>';

  $message = htmlspecialchars(trim($_POST['message']));

  if (strlen($message) < 5)
    $error .= '<li>A mensagem está muito curta.</li>';

  if ($error != '') :

    $form_error .= <<<HTML
<div class="form-error">
    <h3>Deu ruim!</h3>
    <p>Ocorreram erros no preenchimento do formulário:</p>
    <ul>{$error}</ul>
    <p>Por favor, verifique o preenchimento e tente novamente</p>
</div>
HTML;

  else :

    $sql = <<<SQL
INSERT INTO contacts (
    name,
    email,
    subject,
    message
) VALUES (
    '{$name}',
    '{$email}',
    '{$subject}',
    '{$message}'
);
SQL;

    $conn->query($sql);

    $first_name = explode(' ', $name)[0];

    $feedback = <<<HTML
<div class="feedback">
    <h3>Olá {$first_name}!Seja bem-vindo(a)!</h3>
    <p>Seu contato foi enviado com sucesso.</p>
    <p><em>Obrigado!</em></p>
</div>
HTML;

    $now = date('d/m/Y à\s H:i');

    $email_message = <<<TXT
Olá!
Um novo contato foi enviado para o site {$c['sitename']}.
 • Data: {$now}
 • Remetente: {$name}
 • E-mail: {$email}
 • Assunto: {$subject}
{$message}
TXT;

    @mail(
      $c['siteemail'],
      "Novo contato no site {$c['sitename']}.",
      $email_message
    );

  endif;

endif;

$form_html = <<<HTML
    <form action="/?contacts" method="post" name="contacts" id="contacts">
        <input type="hidden" name="send" value="true">
    
        <p>Preencha todos os campos abaixo para enviar um contato para a equipe do <strong>Blue Sky</strong>.</p>
    
        <p>
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" placeholder="Seu nome completo" required minlength="3" value="{$name}">
        </p>
    
        <p>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="Seu e-mail principal" required value="{$email}">
        </p>
    
        <p>
            <label for="subject">Assunto:</label>
            <input type="text" name="subject" id="subject" placeholder="Assunto do contato" required minlength="5" value="{$subject}">
        </p>
    
        <p>
            <label for="message">Mensagem:</label>
            <textarea name="message" id="message" placeholder="Sua mensagem" required minlength="5">{$message}</textarea>
        </p>
    
        <p>
            <button type="submit">Enviar</button>
        </p>
    
    </form>&nbsp;
    
HTML;

$page_title = "Faça contato";

$page_content = <<<HTML

<article>
  <h2>Faça contato</h2>
  
  {$form_error}
HTML;

if ($feedback != '')

  $page_content .= $feedback;

else

  $page_content .= $form_html;

$page_content .= <<<HTML
</article>

HTML;