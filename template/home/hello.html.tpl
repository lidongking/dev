<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$title}</title>
</head>
<body>
{foreach from=$data item=item key=key}
    <h2>{$item.title}</h2>
    <article>{$item.content}<span>[{$item.update_time}]</span></article>{/foreach}
</body>
</html>