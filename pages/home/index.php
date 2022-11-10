<?php

$page_title = "";

$artlist = '';

$sql = <<<SQL

SELECT aid, title, thumbnail, resume
FROM articles
WHERE 
    
    astatus = 'online'
    
    AND adate <= NOW()
   
ORDER BY adate DESC;
SQL;

$res = $conn->query($sql);

if ($res->num_rows == 0) :  
    $artlist .= '<p>Não encontramos nenhum artigo por aqui</p>';

else :

    while ($art = $res->fetch_assoc()) :

        $artlist .= <<<HTML
 
<div class="artbox" data-link="/?view/{$art['aid']}">
    <div class="img" style="background-image: url('{$art['thumbnail']}');"></div>
    <div>
        <h3>{$art['title']}</h3>
        {$art['resume']}
    </div>
</div>
HTML;

    endwhile;

endif;

$page_content = <<<HTML
<article>
    <h2>Artigos recentes</h2>
    {$artlist}
</article>

HTML;